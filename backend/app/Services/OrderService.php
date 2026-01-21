<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Jobs\SendOrderNotification;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(User $user, array $items): Order
    {
        return DB::transaction(function () use ($user, $items) {
            // Вычисляем общую стоимость
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Создаем заказ
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Создаем позиции заказа
            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Отправляем уведомление через очередь
            SendOrderNotification::dispatch($order);

            return $order->load('items.product');
        });
    }

    public function getUserOrders(User $user)
    {
        return Order::where('user_id', $user->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getAllOrders()
    {
        return Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function updateOrderStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);
        return $order->fresh();
    }
}