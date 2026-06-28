<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Desain Grafis',
                'slug' => 'desain-grafis',
                'description' => 'Layanan desain grafis profesional untuk kebutuhan branding dan promosi.',
                'icon' => 'fas fa-paint-brush',
                'color' => 'primary',
                'order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Percetakan',
                'slug' => 'percetakan',
                'description' => 'Layanan percetakan digital dan offset berkualitas tinggi.',
                'icon' => 'fas fa-print',
                'color' => 'success',
                'order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Pengembangan website profesional menggunakan teknologi terkini.',
                'icon' => 'fas fa-desktop',
                'color' => 'info',
                'order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Souvenir & Merchandise',
                'slug' => 'souvenir-merchandise',
                'description' => 'Berbagai macam souvenir dan merchandise custom untuk acara dan promosi.',
                'icon' => 'fas fa-gift',
                'color' => 'warning',
                'order' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Fotografi & Videografi',
                'slug' => 'fotografi-videografi',
                'description' => 'Layanan fotografi dan videografi profesional untuk berbagai keperluan.',
                'icon' => 'fas fa-camera',
                'color' => 'danger',
                'order' => 5,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $this->command->info('✓ CategorySeeder: ' . count($categories) . ' kategori berhasil dibuat.');
    }
}
