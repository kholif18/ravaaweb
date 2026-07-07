<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Solusi Kreatif untuk Bisnis Anda',
                'subtitle' => 'Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap.',
                'image' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'cta_text' => 'Lihat Katalog',
                'cta_url' => '/product',
                'badge' => '',
                'order' => 0,
            ],
            [
                'title' => 'Custom Invitations Eksklusif',
                'subtitle' => 'Undangan pernikahan dan event custom dengan desain personalized.',
                'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'cta_text' => 'Pesan Sekarang',
                'cta_url' => '/product?category=Custom+Invitations',
                'badge' => 'Popular',
                'order' => 1,
            ],
            [
                'title' => 'Software House & Development',
                'subtitle' => 'Jasa pembuatan website, aplikasi mobile, dan sistem informasi custom.',
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'cta_text' => 'Konsultasi Gratis',
                'cta_url' => '/software-house',
                'badge' => '',
                'order' => 2,
            ],
        ];

        foreach ($banners as $data) {
            Banner::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'is_active' => true,
                ])
            );
        }
    }
}
