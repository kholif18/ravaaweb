<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Info Bisnis
            'site_name'        => 'Ravaa Creative',
            'site_tagline'     => 'Solusi Kreatif untuk Bisnis & Kebutuhan Anda',
            'site_description' => 'Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap untuk kebutuhan bisnis Anda.',

            // Kontak
            'whatsapp'         => '6282233377661',
            'whatsapp_message' => 'Halo, saya tertarik dengan produk/layanan Anda.',
            'email'            => 'info@ravaacreative.com',
            'phone'            => '(022) 3456-789',
            'address'          => 'Jl. Kreatif No. 123, Bandung',
            'operating_hours'  => 'Senin-Jumat 08:00-17:00, Sabtu 08:00-14:00',

            // Social Media
            'instagram'        => '',
            'facebook'         => '',
            'linkedin'         => '',
            'tiktok'           => '',
            'youtube'          => '',

            // Hero
            'hero_title'       => 'Solusi Kreatif untuk Bisnis & Kebutuhan Anda',
            'hero_subtitle'    => 'Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap untuk kebutuhan bisnis Anda.',
            'hero_badge'       => 'Paket Desain Logo + Stationery mulai Rp399k',
            'hero_image'       => '',
            'hero_cta_text'    => 'Lihat Produk',
            'hero_cta_url'     => '/product',

            // Footer
            'footer_text'      => '© 2026 Ravaa Creative. All rights reserved.',
            'copyright'        => '© 2026 Ravaa Creative',

            // SEO
            'meta_title'       => 'Ravaa Creative - Solusi Kreatif untuk Bisnis',
            'meta_description' => 'Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap.',
            'meta_keywords'    => 'desain grafis, cetak, ATK, Bandung, branding',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
