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

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(2, true),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 5, 200),
            'category_id' => Category::factory(),
        ];
    }
}
