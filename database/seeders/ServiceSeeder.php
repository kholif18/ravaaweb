<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Desain Grafis',
                'icon' => 'fa-solid fa-paint-brush',
                'description' => 'Layanan desain grafis profesional untuk kebutuhan branding dan promosi bisnis Anda.',
                'features' => ['Logo & Brand Identity', 'Brosur & Flyer', 'Banner & Billboard', 'Kartu Nama & Stationery', 'Social Media Design', 'Packaging Design'],
                'order' => 1,
            ],
            [
                'name' => 'Percetakan',
                'icon' => 'fa-solid fa-print',
                'description' => 'Layanan percetakan digital dan offset dengan kualitas premium dan harga kompetitif.',
                'features' => ['Cetak Brosur & Flyer', 'Cetak Banner & Spanduk', 'Cetak Buku & Majalah', 'Cetak Stiker & Label', 'Cetak Kardus & Packaging', 'Cetak Foto & Kanvas'],
                'order' => 2,
            ],
            [
                'name' => 'Custom Invitations',
                'icon' => 'fa-solid fa-envelope-open-text',
                'description' => 'Undangan custom eksklusif untuk momen spesial Anda dengan desain personalized.',
                'features' => ['Undangan Pernikahan', 'Undangan Khitanan', 'Undangan Akikah', 'Undangan Event Corporate', 'Cetak Amplop & Kartu', 'Desain Custom Eksklusif'],
                'order' => 3,
            ],
            [
                'name' => 'ATK & Stationery',
                'icon' => 'fa-solid fa-pen-fancy',
                'description' => 'Perlengkapan ATK dan stationery estetik untuk menunjang produktivitas kantor Anda.',
                'features' => ['Notebook Custom', 'Pulpen & Pensil', 'Map & Amplop', 'Stempel & Name Tag', 'Meja & Kursi Kantor', 'Perlengkapan Meeting'],
                'order' => 4,
            ],
            [
                'name' => 'Sablon & Merchandise',
                'icon' => 'fa-solid fa-tshirt',
                'description' => 'Layanan sablon dan pembuatan merchandise custom untuk branding perusahaan dan komunitas.',
                'features' => ['Sablon Kaos & Polo', 'Sablon Mug & Tumbler', 'Topi & Tas Custom', 'Gantungan Kunci', 'PIN & Lanyard', 'Goodie Bag'],
                'order' => 5,
            ],
            [
                'name' => 'Software House',
                'icon' => 'fa-solid fa-laptop-code',
                'description' => 'Jasa pengembangan software custom untuk solusi digital bisnis Anda.',
                'features' => ['Website Company Profile', 'Aplikasi Web Custom', 'Mobile App (Android/iOS)', 'Sistem Informasi', 'API Integration', 'Maintenance & Support'],
                'order' => 6,
                'is_featured' => true,
            ],
        ];

        foreach ($services as $index => $data) {
            Service::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, [
                    'status' => 'active',
                    'is_featured' => $data['is_featured'] ?? false,
                ])
            );
        }
    }
}
