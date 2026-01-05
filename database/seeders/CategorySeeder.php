<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Main Categories
            [
                'name' => 'Percetakan',
                'slug' => 'percetakan',
                'description' => 'Layanan percetakan digital dan offset untuk berbagai kebutuhan',
                'icon' => 'fas fa-print',
                'order' => 1,
                'status' => 'active',
                'meta_title' => 'Jasa Percetakan Jakarta - Cetak Digital & Offset',
                'meta_description' => 'Jasa percetakan digital dan offset terbaik di Jakarta. Cetak banner, brosur, kartu nama, dan berbagai kebutuhan percetakan lainnya.',
                'meta_keywords' => 'percetakan, cetak digital, cetak offset, printing, jasa cetak',
            ],
            [
                'name' => 'Desain Grafis',
                'slug' => 'desain-grafis',
                'description' => 'Jasa desain grafis profesional untuk branding dan marketing',
                'icon' => 'fas fa-paint-brush',
                'order' => 2,
                'status' => 'active',
                'meta_title' => 'Jasa Desain Grafis Profesional - Logo, Banner, Brosur',
                'meta_description' => 'Jasa desain grafis profesional untuk kebutuhan branding, marketing, dan promosi. Desain logo, banner, brosur, dan media promosi lainnya.',
                'meta_keywords' => 'desain grafis, jasa desain, logo, banner, brosur, branding',
            ],
            [
                'name' => 'ATK & Perlengkapan Kantor',
                'slug' => 'atk-perlengkapan-kantor',
                'description' => 'Alat tulis kantor dan perlengkapan kantor lengkap',
                'icon' => 'fas fa-paperclip',
                'order' => 3,
                'status' => 'active',
                'meta_title' => 'ATK & Perlengkapan Kantor Lengkap - Jakarta',
                'meta_description' => 'Supplier ATK dan perlengkapan kantor terlengkap di Jakarta. Kebutuhan alat tulis kantor, printer, kertas, dan perlengkapan kantor lainnya.',
                'meta_keywords' => 'ATK, alat tulis kantor, perlengkapan kantor, supplier ATK, kertas, printer',
            ],
            [
                'name' => 'Merchandise',
                'slug' => 'merchandise',
                'description' => 'Produk merchandise dan promosi perusahaan',
                'icon' => 'fas fa-gift',
                'order' => 4,
                'status' => 'active',
                'meta_title' => 'Merchandise & Souvenir Perusahaan - Custom & Berkualitas',
                'meta_description' => 'Jasa pembuatan merchandise dan souvenir perusahaan custom berkualitas. Mug, kaos, tas, payung, dan berbagai produk promosi lainnya.',
                'meta_keywords' => 'merchandise, souvenir, produk promosi, custom, mug, kaos, tas',
            ],
            [
                'name' => 'Digital Printing',
                'slug' => 'digital-printing',
                'description' => 'Layanan digital printing cepat dan berkualitas',
                'icon' => 'fas fa-desktop',
                'order' => 5,
                'status' => 'active',
                'meta_title' => 'Digital Printing Jakarta - Cetak Cepat & Berkualitas',
                'meta_description' => 'Layanan digital printing cepat dan berkualitas di Jakarta. Cetak banner, spanduk, sticker, flyer, dan berbagai kebutuhan printing lainnya.',
                'meta_keywords' => 'digital printing, cetak cepat, banner, spanduk, sticker, flyer',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Sub-categories for Percetakan
        $percetakan = Category::where('slug', 'percetakan')->first();
        
        $subCategories = [
            [
                'name' => 'Brosur & Flyer',
                'parent_id' => $percetakan->id,
                'icon' => 'fas fa-newspaper',
                'order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Kartu Nama',
                'parent_id' => $percetakan->id,
                'icon' => 'fas fa-address-card',
                'order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Kalender',
                'parent_id' => $percetakan->id,
                'icon' => 'fas fa-calendar-alt',
                'order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Undangan',
                'parent_id' => $percetakan->id,
                'icon' => 'fas fa-envelope-open-text',
                'order' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Buku & Nota',
                'parent_id' => $percetakan->id,
                'icon' => 'fas fa-book',
                'order' => 5,
                'status' => 'active',
            ],
        ];

        foreach ($subCategories as $subCategoryData) {
            $subCategoryData['slug'] = Str::slug($subCategoryData['name']);
            $subCategoryData['description'] = 'Produk ' . $subCategoryData['name'] . ' berkualitas tinggi';
            Category::create($subCategoryData);
        }

        // Sub-categories for Desain Grafis
        $desain = Category::where('slug', 'desain-grafis')->first();
        
        $designCategories = [
            [
                'name' => 'Logo & Branding',
                'parent_id' => $desain->id,
                'icon' => 'fas fa-palette',
                'order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Banner & Spanduk',
                'parent_id' => $desain->id,
                'icon' => 'fas fa-flag',
                'order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Social Media Design',
                'parent_id' => $desain->id,
                'icon' => 'fas fa-hashtag',
                'order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Packaging Design',
                'parent_id' => $desain->id,
                'icon' => 'fas fa-box-open',
                'order' => 4,
                'status' => 'active',
            ],
        ];

        foreach ($designCategories as $designCategoryData) {
            $designCategoryData['slug'] = Str::slug($designCategoryData['name']);
            $designCategoryData['description'] = 'Jasa desain ' . $designCategoryData['name'] . ' profesional';
            Category::create($designCategoryData);
        }

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('Total Categories: ' . Category::count());
        $this->command->info('Main Categories: ' . Category::whereNull('parent_id')->count());
        $this->command->info('Sub Categories: ' . Category::whereNotNull('parent_id')->count());
    }
}