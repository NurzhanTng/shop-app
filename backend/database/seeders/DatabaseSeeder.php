<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Пользователи
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin', // если есть колонка role
        ]);

        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Категории
        $categories = Category::factory()->count(3)
            ->sequence(
                ['name' => 'Category 1'],
                ['name' => 'Category 2'],
                ['name' => 'Category 3'],
            )
            ->create();

        // 3. Товары
        $products = Product::factory()->count(12)
            ->create()
            ->each(function ($product) use ($categories) {
                $product->category_id = $categories->random()->id;
                $product->save();
            });

        // 4. Заказы
        $orders = collect();

        // 2 заказа от user1
        for ($i = 0; $i < 2; $i++) {
            $orders->push(Order::factory()->create([
                'user_id' => $user1->id,
            ]));
        }

        // 3 заказа от user2
        for ($i = 0; $i < 3; $i++) {
            $orders->push(Order::factory()->create([
                'user_id' => $user2->id,
            ]));
        }

        // 5. Позиции заказов
        foreach ($orders as $order) {
            $items = $products->random(rand(1, 4)); // случайные 1-4 товара
            foreach ($items as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 5),
                    'price' => $product->price,
                ]);
            }
        
            // Пересчёт total
            $order->total = $order->items->sum(fn($item) => $item->price * $item->quantity);
            $order->save();
        }        
    }
}
