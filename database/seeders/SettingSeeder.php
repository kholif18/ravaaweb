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
            'whatsapp'         => '082233377661',
            'whatsapp_message' => 'Halo, saya tertarik dengan produk/layanan Anda.',
            'email'            => 'ravaacreative@gmail.com',
            'phone'            => '082233377661',
            'address'          => 'Gedong, Ds. Ngluyu Kec. Ngluyu, Kab. Nganjuk, Jawa Timur 64452',
            'operating_hours'  => 'Senin-Jumat 15:00-21:00, Sabtu-Minggu 07:00-21:00',

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
