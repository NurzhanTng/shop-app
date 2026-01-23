<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    // Массив красивых изображений товаров (Unsplash)
    private static $images = [
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop', // Headphones
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', // Watch
        'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&h=500&fit=crop', // Sunglasses
        'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&h=500&fit=crop', // Watch 2
        'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=500&h=500&fit=crop', // Laptop
        'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=500&h=500&fit=crop', // Camera
        'https://images.unsplash.com/photo-1572635196184-84e35138cf62?w=500&h=500&fit=crop', // Sneakers
        'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=500&h=500&fit=crop', // Backpack
        'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=500&h=500&fit=crop', // Perfume
        'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=500&h=500&fit=crop', // Jacket
        'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=500&h=500&fit=crop', // Shoes
        'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=500&h=500&fit=crop', // Bag
        'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=500&h=500&fit=crop', // Headphones 2
        'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500&h=500&fit=crop', // Sneakers 2
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', // Sneakers 3
    ];

    private static $imageIndex = 0;

    public function definition(): array
    {
        // Получаем следующее изображение по кругу
        $image = self::$images[self::$imageIndex % count(self::$images)];
        self::$imageIndex++;

        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 5, 200),
            'category_id' => Category::factory(),
            'image_url' => $image,
        ];
    }
}