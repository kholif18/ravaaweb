<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'short_description' => fake()->sentence(),
            'description' => '<p>' . fake()->paragraphs(3, true) . '</p>',
            'price' => fake()->numberBetween(10000, 5000000),
            'stock' => fake()->numberBetween(0, 100),
            'is_service' => false,
            'category_id' => Category::factory(),
            'status' => 'active',
            'is_featured' => fake()->boolean(20),
            'sku' => strtoupper(fake()->bothify('???-####')),
            'weight' => fake()->numberBetween(100, 5000) . 'g',
        ];
    }

    public function featured(): static
    {
        return $this->state(fn() => ['is_featured' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn() => ['status' => 'inactive']);
    }

    public function service(): static
    {
        return $this->state(fn() => ['is_service' => true, 'stock' => 0]);
    }

    public function withDiscount(float $percent = 10): static
    {
        return $this->state(function () use ($percent) {
            $price = $this->faker->numberBetween(100000, 5000000);
            return [
                'price' => $price,
                'discount_percent' => $percent,
                'price_discount' => round($price * (1 - $percent / 100)),
                'discount_start' => now()->subDay(),
                'discount_end' => now()->addDays(30),
            ];
        });
    }

    public function trashed(): static
    {
        return $this->state(fn() => ['deleted_at' => now()]);
    }
}
