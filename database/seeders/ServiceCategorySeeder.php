<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Pembangunan website dan aplikasi web',
                'icon' => 'fas fa-code',
                'color' => '#3B82F6',
                'order' => 1
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Pengembangan aplikasi mobile',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#10B981',
                'order' => 2
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Desain antarmuka dan pengalaman pengguna',
                'icon' => 'fas fa-palette',
                'color' => '#8B5CF6',
                'order' => 3
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Pemasaran digital dan media sosial',
                'icon' => 'fas fa-bullhorn',
                'color' => '#F59E0B',
                'order' => 4
            ],
            [
                'name' => 'SEO Services',
                'description' => 'Optimasi mesin pencari',
                'icon' => 'fas fa-search',
                'color' => '#EF4444',
                'order' => 5
            ]
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
