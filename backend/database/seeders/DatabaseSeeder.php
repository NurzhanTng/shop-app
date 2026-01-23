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

    public function run(): void
    {
        // 1. Пользователи
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@shop.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user1@shop.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'user2@shop.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Категории
        $electronics = Category::create(['name' => 'Электроника']);
        $fashion = Category::create(['name' => 'Мода']);
        $accessories = Category::create(['name' => 'Аксессуары']);

        // 3. Товары с конкретными названиями и изображениями
        $products = [
            // Электроника
            [
                'name' => 'Wireless Headphones Sony WH-1000XM4',
                'description' => 'Premium noise-cancelling wireless headphones with exceptional sound quality',
                'price' => 349.99,
                'category_id' => $electronics->id,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'MacBook Pro 14" M3',
                'description' => 'Powerful laptop with M3 chip for creative professionals',
                'price' => 1999.99,
                'category_id' => $electronics->id,
                'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Sony Alpha A7 IV Camera',
                'description' => 'Full-frame mirrorless camera with 33MP sensor',
                'price' => 2499.99,
                'category_id' => $electronics->id,
                'image_url' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest flagship smartphone with titanium design',
                'price' => 1199.99,
                'category_id' => $electronics->id,
                'image_url' => 'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=500&h=500&fit=crop',
            ],
            
            // Мода
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with Air cushioning technology',
                'price' => 149.99,
                'category_id' => $fashion->id,
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Adidas Ultraboost 23',
                'description' => 'Premium running shoes with Boost technology',
                'price' => 189.99,
                'category_id' => $fashion->id,
                'image_url' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Levi\'s 501 Original Jeans',
                'description' => 'Classic straight-fit denim jeans',
                'price' => 89.99,
                'category_id' => $fashion->id,
                'image_url' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'North Face Winter Jacket',
                'description' => 'Warm waterproof jacket for cold weather',
                'price' => 299.99,
                'category_id' => $fashion->id,
                'image_url' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=500&h=500&fit=crop',
            ],
            
            // Аксессуары
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'Smart watch with health tracking and GPS',
                'price' => 399.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Ray-Ban Aviator Sunglasses',
                'description' => 'Classic aviator sunglasses with UV protection',
                'price' => 159.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Fjällräven Kånken Backpack',
                'description' => 'Durable and stylish everyday backpack',
                'price' => 79.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Leather Messenger Bag',
                'description' => 'Premium leather bag for work and travel',
                'price' => 199.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Casio G-Shock Watch',
                'description' => 'Durable sports watch with multiple functions',
                'price' => 129.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Bose QuietComfort Earbuds',
                'description' => 'Wireless earbuds with active noise cancellation',
                'price' => 279.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Dior Sauvage Perfume',
                'description' => 'Premium mens fragrance 100ml',
                'price' => 119.99,
                'category_id' => $accessories->id,
                'image_url' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=500&h=500&fit=crop',
            ],
        ];

        $createdProducts = collect();
        foreach ($products as $productData) {
            $createdProducts->push(Product::create($productData));
        }

        // 4. Заказы
        $orders = collect();

        // 2 заказа от user1
        for ($i = 0; $i < 2; $i++) {
            $orders->push(Order::factory()->create([
                'user_id' => $user1->id,
                'status' => $i === 0 ? 'completed' : 'processing',
            ]));
        }

        // 3 заказа от user2
        for ($i = 0; $i < 3; $i++) {
            $orders->push(Order::factory()->create([
                'user_id' => $user2->id,
                'status' => $i === 0 ? 'pending' : ($i === 1 ? 'processing' : 'completed'),
            ]));
        }

        // 5. Позиции заказов
        foreach ($orders as $order) {
            $items = $createdProducts->random(rand(1, 4));
            foreach ($items as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }

            // Пересчёт total
            $order->total = $order->items->sum(fn($item) => $item->price * $item->quantity);
            $order->save();
        }
    }
}