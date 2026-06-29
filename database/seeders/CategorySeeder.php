<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan semua kategori (termasuk soft-deleted) agar seed fresh
        Category::withTrashed()->forceDelete();

        $categories = [
            // ===== 5 KATEGORI UTAMA =====
            [
                'name' => 'Desain Grafis',
                'description' => 'Layanan desain grafis profesional untuk kebutuhan branding dan promosi.',
                'icon' => 'fas fa-paint-brush',
                'color' => 'primary',
                'order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Percetakan',
                'description' => 'Layanan percetakan digital dan offset berkualitas tinggi.',
                'icon' => 'fas fa-print',
                'color' => 'success',
                'order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Web Development',
                'description' => 'Pengembangan website profesional menggunakan teknologi terkini.',
                'icon' => 'fas fa-desktop',
                'color' => 'info',
                'order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Souvenir & Merchandise',
                'description' => 'Berbagai macam souvenir dan merchandise custom untuk acara dan promosi.',
                'icon' => 'fas fa-gift',
                'color' => 'warning',
                'order' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Fotografi & Videografi',
                'description' => 'Layanan fotografi dan videografi profesional untuk berbagai keperluan.',
                'icon' => 'fas fa-camera',
                'color' => 'danger',
                'order' => 5,
                'status' => 'active',
            ],

            // ===== 15 KATEGORI TAMBAHAN =====
            [
                'name' => 'Branding & Logo',
                'description' => 'Jasa pembuatan identitas merek dan logo profesional untuk bisnis Anda.',
                'icon' => 'fas fa-star',
                'color' => 'danger',
                'order' => 6,
                'status' => 'active',
            ],
            [
                'name' => 'Spanduk & Banner',
                'description' => 'Cetak spanduk dan banner berbagai ukuran untuk promosi dan acara.',
                'icon' => 'fas fa-image',
                'color' => 'primary',
                'order' => 7,
                'status' => 'active',
            ],
            [
                'name' => 'Stiker & Label',
                'description' => 'Cetak stiker dan label custom dengan berbagai bahan dan ukuran.',
                'icon' => 'fas fa-tags',
                'color' => 'warning',
                'order' => 8,
                'status' => 'active',
            ],
            [
                'name' => 'Brosur & Flyer',
                'description' => 'Desain dan cetak brosur serta flyer untuk promosi produk dan acara.',
                'icon' => 'fas fa-paperclip',
                'color' => 'info',
                'order' => 9,
                'status' => 'active',
            ],
            [
                'name' => 'Kartu Nama',
                'description' => 'Cetak kartu nama premium dengan berbagai pilihan bahan dan finishing.',
                'icon' => 'fas fa-box',
                'color' => 'success',
                'order' => 10,
                'status' => 'active',
            ],
            [
                'name' => 'Kemasan Produk',
                'description' => 'Desain dan produksi kemasan produk custom yang menarik dan fungsional.',
                'icon' => 'fas fa-shopping-bag',
                'color' => 'dark',
                'order' => 11,
                'status' => 'active',
            ],
            [
                'name' => 'Kaos & Apparel',
                'description' => 'Sablon dan bordir kaos, jersey, seragam, dan berbagai apparel custom.',
                'icon' => 'fas fa-tshirt',
                'color' => 'primary',
                'order' => 12,
                'status' => 'active',
            ],
            [
                'name' => 'Akrilik & PVC',
                'description' => 'Pembuatan berbagai produk akrilik dan PVC untuk kebutuhan display dan signage.',
                'icon' => 'fas fa-tools',
                'color' => 'info',
                'order' => 13,
                'status' => 'active',
            ],
            [
                'name' => 'Neon Box',
                'description' => 'Pembuatan neon box custom untuk papan nama toko dan iklan luar ruang.',
                'icon' => 'fas fa-cog',
                'color' => 'danger',
                'order' => 14,
                'status' => 'active',
            ],
            [
                'name' => 'Buku & Majalah',
                'description' => 'Jasa desain layout dan cetak buku, majalah, serta publikasi lainnya.',
                'icon' => 'fas fa-book',
                'color' => 'warning',
                'order' => 15,
                'status' => 'active',
            ],
            [
                'name' => 'Kalender & Agenda',
                'description' => 'Cetak kalender meja, dinding, dan agenda tahunan dengan desain eksklusif.',
                'icon' => 'fas fa-palette',
                'color' => 'success',
                'order' => 16,
                'status' => 'active',
            ],
            [
                'name' => 'Undangan',
                'description' => 'Desain dan cetak undangan pernikahan, acara, dan meeting perusahaan.',
                'icon' => 'fas fa-envelope-open-text',
                'color' => 'danger',
                'order' => 17,
                'status' => 'active',
            ],
            [
                'name' => 'Company Profile',
                'description' => 'Pembuatan company profile cetak dan digital untuk branding perusahaan.',
                'icon' => 'fas fa-laptop',
                'color' => 'primary',
                'order' => 18,
                'status' => 'inactive',
            ],
            [
                'name' => 'Aplikasi Mobile',
                'description' => 'Pengembangan aplikasi mobile Android dan iOS untuk berbagai kebutuhan.',
                'icon' => 'fas fa-mobile-alt',
                'color' => 'info',
                'order' => 19,
                'status' => 'inactive',
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Layanan pemasaran digital, SEO, media sosial, dan iklan online.',
                'icon' => 'fas fa-heart',
                'color' => 'success',
                'order' => 20,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $data) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            Category::create($data);
        }

        $total = Category::count();
        $this->command->info("✓ CategorySeeder: {$total} kategori berhasil dibuat.");
    }
}
