<?php

namespace Database\Seeders;

use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Brand Identity Ravaa',
                'category' => 'Desain Grafis',
                'client' => 'Internal',
                'description' => 'Perancangan brand identity lengkap termasuk logo, stationery set, dan brand guidelines.',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&q=80',
                'tech' => ['Figma', 'Illustrator', 'Photoshop'],
                'order' => 3,
            ],
        ];

        foreach ($items as $data) {
            PortfolioItem::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'slug' => Str::slug($data['title']),
                    'status' => 'active',
                    'is_featured' => $data['is_featured'] ?? false,
                ])
            );
        }
    }
}
