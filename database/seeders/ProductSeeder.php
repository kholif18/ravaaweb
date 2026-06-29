<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $tags = Tag::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Run CategorySeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'Kaos Custom Premium',
                'description' => 'Kaos custom dengan bahan premium cotton combed 30s. Nyaman dipakai sehari-hari.',
                'price' => 150000,
                'price_discount' => 120000,
                'stock' => 50,
                'category_id' => $categories->where('name', 'Kaos')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => true,
                'sku' => 'KAO-001',
                'weight' => '250g',
            ],
            [
                'name' => 'Hoodie Custom Distro',
                'description' => 'Hoodie custom dengan bahan fleece premium. Cocok untuk cuaca dingin.',
                'price' => 250000,
                'price_discount' => null,
                'stock' => 30,
                'category_id' => $categories->where('name', 'Hoodie')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => true,
                'sku' => 'HOO-001',
                'weight' => '400g',
            ],
            [
                'name' => 'Tas Custom Backpack',
                'description' => 'Tas ransel custom dengan desain eksklusif. Bahananvas tebal.',
                'price' => 350000,
                'price_discount' => 300000,
                'stock' => 20,
                'category_id' => $categories->where('name', 'Aksesoris')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'sku' => 'TAS-001',
                'weight' => '600g',
            ],
            [
                'name' => 'Mug Custom Premium',
                'description' => 'Mug keramik custom dengan cetakan tahan lama.',
                'price' => 75000,
                'price_discount' => null,
                'stock' => 100,
                'category_id' => $categories->where('name', 'Aksesoris')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'sku' => 'MUG-001',
                'weight' => '350g',
            ],
            [
                'name' => 'Stiker Custom Vinyl',
                'description' => 'Stiker vinyl custom tahan air. Cocok untuk laptop, botol, dll.',
                'price' => 25000,
                'price_discount' => null,
                'stock' => 200,
                'category_id' => $categories->where('name', 'Aksesoris')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'sku' => 'STK-001',
                'weight' => '10g',
            ],
        ];

        foreach ($products as $data) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                $data
            );

            // Attach random tags
            if ($tags->isNotEmpty()) {
                $product->tags()->sync($tags->random(min(2, $tags->count()))->pluck('id'));
            }
        }

        $this->command->info('Products seeded successfully.');
    }
}
