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
                'specifications' => 'Bahan: Vinyl Mesh, Ukuran: 3x6 Meter, Tahan Cuaca: Ya',
                'price' => 450000,
                'discount_price' => 400000,
                'stock_status' => 'in_stock',
                'is_featured' => true,
                'is_best_seller' => true,
                'weight' => 2.5,
                'unit' => 'pcs',
                'tags' => ['banner', 'vinyl', 'outdoor', 'promosi'],
                'status' => 'published',
                'meta_title' => 'Cetak Banner 3x6 Meter - Ravaa Creative',
                'meta_description' => 'Jasa cetak banner ukuran 3x6 meter dengan bahan vinyl mesh berkualitas, tahan cuaca, harga terjangkau.',
                'quick_infos' => ['Gratis Konsultasi', 'Pengerjaan 3-7 hari', 'Revisi tanpa batas']
            ],
            [
                'name' => 'Kartu Nama Premium',
                'slug' => 'kartu-nama-premium',
                'category_id' => $categories->where('slug', 'kartu-nama')->first()->id ?? null,
                'description' => 'Kartu nama premium dengan bahan art paper 310gsm, finishing doff/glossy, cetak full color dua sisi.',
                'specifications' => 'Bahan: Art Paper 310gsm, Finishing: Doff/Glossy, Sisi: Dua Sisi',
                'price' => 150000,
                'discount_price' => null,
                'stock_status' => 'in_stock',
                'is_featured' => true,
                'is_new_arrival' => true,
                'weight' => 0.1,
                'unit' => 'pack',
                'tags' => ['kartu nama', 'premium', 'business card'],
                'status' => 'published',
                'quick_infos' => ['Gratis Desain', 'Cetak 1 Hari Jadi', 'Kualitas High-End']
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info('Total Products: ' . Product::count());
    }
}