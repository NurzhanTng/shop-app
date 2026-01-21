<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index(Request $request)
    {
        // Администратор видит все заказы, пользователь - только свои
        if ($request->user()->role === 'admin') {
            $orders = $this->orderService->getAllOrders();
        } else {
            $orders = $this->orderService->getUserOrders($request->user());
        }

        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder(
            $request->user(),
            $request->validated('items')
        );

        return response()->json($order, 201);
    }

    public function show(Request $request, Order $order)
    {
        // Проверка прав: админ может видеть все, пользователь - только свои
        if ($request->user()->role !== 'admin' && $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('items.product'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $order = $this->orderService->updateOrderStatus(
            $order,
            $request->validated('status')
        );

        return response()->json($order);
    }
}