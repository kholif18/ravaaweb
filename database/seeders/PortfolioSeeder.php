<?php

namespace Database\Seeders;

use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Sistem Informasi Sekolah',
                'category' => 'Web App',
                'client' => 'SMK Nusantara',
                'description' => 'Sistem informasi manajemen sekolah berbasis web yang mencakup manajemen siswa, jadwal, nilai, dan rapor online.',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80',
                'tech' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind'],
                'order' => 1,
            ],
            [
                'title' => 'E-Commerce Dekranasda',
                'category' => 'Web App',
                'client' => 'Dekranasda Jogja',
                'description' => 'Platform e-commerce untuk produk UMKM dengan fitur marketplace, payment gateway, dan dashboard penjual.',
                'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80',
                'tech' => ['React', 'Node.js', 'MongoDB', 'Redis'],
                'order' => 2,
            ],
            [
                'title' => 'Brand Identity Ravaa',
                'category' => 'Desain Grafis',
                'client' => 'Internal',
                'description' => 'Perancangan brand identity lengkap termasuk logo, stationery set, dan brand guidelines.',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&q=80',
                'tech' => ['Figma', 'Illustrator', 'Photoshop'],
                'order' => 3,
            ],
            [
                'title' => 'Aplikasi Mobile Laundry',
                'category' => 'Mobile App',
                'client' => 'CleanPro',
                'description' => 'Aplikasi mobile pemesanan laundry dengan fitur tracking real-time, payment digital, dan manajemen outlet.',
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80',
                'tech' => ['Flutter', 'Firebase', 'Laravel'],
                'order' => 4,
            ],
            [
                'title' => 'Company Profile PT Maju',
                'category' => 'Web Design',
                'client' => 'PT Maju Jaya',
                'description' => 'Website company profile modern dengan animasi interaktif, galeri portofolio, dan form inquiry terintegrasi.',
                'image' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&q=80',
                'tech' => ['WordPress', 'Elementor', 'Custom CSS'],
                'order' => 5,
            ],
            [
                'title' => 'IoT Smart Farming',
                'category' => 'IoT & Embedded',
                'client' => 'AgriTech Corp',
                'description' => 'Sistem monitoring pertanian pintar berbasis IoT dengan sensor suhu, kelembaban, dan kontrol irigasi otomatis.',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80',
                'tech' => ['ESP32', 'Python', 'React', 'MongoDB'],
                'order' => 6,
            ],
        ];

        foreach ($items as $data) {
            PortfolioItem::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'status' => 'active',
                    'is_featured' => $data['is_featured'] ?? false,
                ])
            );
        }
    }
}
