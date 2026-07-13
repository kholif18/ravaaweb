<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'attributes' => ['Ukuran' => 'M'],
            'sku' => strtoupper(fake()->bothify('???-####')),
            'price' => fake()->numberBetween(10000, 5000000),
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'is_service' => false,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn() => ['stock' => 0]);
    }
}
