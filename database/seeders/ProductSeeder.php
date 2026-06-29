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
                'short_description' => 'Kaos custom dengan bahan premium cotton combed 30s.',
                'description' => 'Kaos custom dengan bahan premium cotton combed 30s. Nyaman dipakai sehari-hari.',
                'price' => 150000,
                'price_discount' => 120000,
                'discount_percent' => 20,
                'discount_start' => now(),
                'discount_end' => now()->addDays(30),
                'stock' => 50,
                'category_id' => $categories->where('name', 'Kaos')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => true,
                'sku' => 'KAO-001',
                'weight' => '250g',
                'variant_types' => [
                    ['name' => 'Ukuran', 'values' => ['S', 'M', 'L', 'XL']],
                    ['name' => 'Warna', 'values' => ['Hitam', 'Putih', 'Abu-abu']],
                ],
            ],
            [
                'name' => 'Hoodie Custom Distro',
                'short_description' => 'Hoodie custom dengan bahan fleece premium.',
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
                'short_description' => 'Tas ransel custom dengan desain eksklusif.',
                'description' => 'Tas ransel custom dengan desain eksklusif. Bahan canvas tebal.',
                'price' => 350000,
                'price_discount' => 300000,
                'discount_percent' => 14,
                'discount_start' => now(),
                'discount_end' => now()->addDays(14),
                'stock' => 20,
                'category_id' => $categories->where('name', 'Aksesoris')->first()?->id ?? $categories->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'sku' => 'TAS-001',
                'weight' => '600g',
            ],
            [
                'name' => 'Mug Custom Premium',
                'short_description' => 'Mug keramik custom dengan cetakan tahan lama.',
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
                'short_description' => 'Stiker vinyl custom tahan air.',
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

            // Create variants for products with variant_types
            if (!empty($data['variant_types']) && $product->variants()->count() === 0) {
                $combinations = $this->generateCombinations($data['variant_types']);
                foreach ($combinations as $combo) {
                    $product->variants()->create([
                        'attributes' => $combo,
                        'sku' => $data['sku'] . '-' . strtoupper(str_replace(' ', '-', implode('-', $combo))),
                        'price' => $data['price'],
                        'price_discount' => $data['price_discount'] ?? null,
                        'is_active' => true,
                    ]);
                }
            }
        }

        $this->command->info('Products seeded successfully.');
    }

    private function generateCombinations(array $types): array
    {
        if (empty($types)) {
            return [[]];
        }

        $first = array_shift($types);
        $rest = $this->generateCombinations($types);

        $result = [];
        foreach ($first['values'] as $value) {
            foreach ($rest as $combo) {
                $result[] = array_merge([$first['name'] => $value], $combo);
            }
        }

        return $result;
    }
}
