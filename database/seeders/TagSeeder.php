<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Premium',    'color' => 'warning'],
            ['name' => 'Best Seller','color' => 'danger'],
            ['name' => 'Terbaru',    'color' => 'success'],
            ['name' => 'Promo',      'color' => 'info'],
            ['name' => 'Limited',    'color' => 'dark'],
            ['name' => 'Ekonomis',   'color' => 'primary'],
        ];

        foreach ($tags as $data) {
            Tag::firstOrCreate(
                ['slug' => str($data['name'])->slug()],
                $data
            );
        }

        $this->command->info('✓ TagSeeder: ' . count($tags) . ' tag berhasil dibuat.');
    }
}
