<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavLink;

class NavLinkOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Parent link "Form Pemesanan"
        $parent = NavLink::create([
            'label' => 'Form Pemesanan',
            'url' => '#',
            'position' => 'both',
            'target' => '_self',
            'sort_order' => 50,
            'is_active' => true,
        ]);

        // Child links
        $forms = [
            ['label' => 'Undangan Pernikahan', 'url' => '/order/wedding', 'sort_order' => 1],
            ['label' => 'Undangan Khitan', 'url' => '/order/khitan', 'sort_order' => 2],
            ['label' => 'Nama Bayi', 'url' => '/order/baby-name', 'sort_order' => 3],
            ['label' => 'Undangan Ulang Tahun', 'url' => '/order/birthday', 'sort_order' => 4],
        ];

        foreach ($forms as $form) {
            NavLink::create(array_merge($form, [
                'parent_id' => $parent->id,
                'position' => 'both',
                'target' => '_self',
                'is_active' => true,
            ]));
        }
    }
}
