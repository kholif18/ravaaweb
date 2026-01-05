<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            // Printing Products
            [
                'name' => 'Cetak Banner 3x6 Meter',
                'slug' => 'cetak-banner-3x6-meter',
                'category_id' => $categories->where('slug', 'brosur-flyer')->first()->id ?? null,
                'description' => 'Cetak banner ukuran 3x6 meter dengan bahan vinyl mesh, tahan cuaca, cocok untuk promosi outdoor.',
                'short_description' => 'Banner vinyl mesh 3x6m, tahan cuaca',
                'price' => 450000,
                'discount_price' => 400000,
                'cost_price' => 250000,
                'stock_quantity' => 50,
                'minimum_stock' => 10,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'is_featured' => true,
                'is_best_seller' => true,
                'weight' => 2.5,
                'unit' => 'pcs',
                'tags' => json_encode(['banner', 'vinyl', 'outdoor', 'promosi']),
                'colors' => json_encode(['Merah', 'Biru', 'Kuning', 'Hijau']),
                'status' => 'published',
                'meta_title' => 'Cetak Banner 3x6 Meter - Ravaa Creative',
                'meta_description' => 'Jasa cetak banner ukuran 3x6 meter dengan bahan vinyl mesh berkualitas, tahan cuaca, harga terjangkau.',
            ],
            [
                'name' => 'Kartu Nama Premium',
                'slug' => 'kartu-nama-premium',
                'category_id' => $categories->where('slug', 'kartu-nama')->first()->id ?? null,
                'description' => 'Kartu nama premium dengan bahan art paper 310gsm, finishing doff/glossy, cetak full color dua sisi.',
                'short_description' => 'Kartu nama art paper 310gsm, full color',
                'price' => 150000,
                'discount_price' => null,
                'cost_price' => 75000,
                'stock_quantity' => 200,
                'minimum_stock' => 50,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'is_featured' => true,
                'is_new_arrival' => true,
                'weight' => 0.1,
                'unit' => 'pack',
                'tags' => json_encode(['kartu nama', 'premium', 'business card']),
                'colors' => json_encode(['Putih', 'Ivory', 'Abu-abu']),
                'status' => 'published',
            ],
            // Add more products as needed...
        ];

        foreach ($products as $productData) {
            // Generate SKU if not exists
            if (!isset($productData['sku'])) {
                $productData['sku'] = 'PRD-' . strtoupper(Str::random(8)) . '-' . time();
            }

            Product::create($productData);
        }

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info('Total Products: ' . Product::count());
    }
}