<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromoBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promo_banners')->updateOrInsert(
            ['id' => 1],
            [
                'title' => 'Diskon Spesial 20% Bulan Ini!',
                'subtitle' => 'Untuk semua layanan desain & percetakan',
                'benefits' => json_encode([
                    'Gratis konsultasi desain',
                    'Free revisi 3x',
                    'Gratis pengiriman area Ngluyu'
                ]),
                'cta_text' => 'Hubungi kami sekarang untuk dapatkan penawaran!',
                'whatsapp_number' => '628xxxxxxxxx',
                'phone_number' => null,
                'color' => 'primary',
                'image_url' => null,
                'status' => true,
                'start_date' => Carbon::now()->toDateString(),
                'expiry_date' => Carbon::now()->addDays(30)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
