<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavLink;

class NavLinkOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Parent link "Form Pemesanan" - gunakan updateOrCreate agar idempotent
        $parent = NavLink::updateOrCreate(
            ['label' => 'Form Pemesanan', 'parent_id' => null],
            [
                'url' => '#',
                'position' => 'both',
                'target' => '_self',
                'sort_order' => 50,
                'is_active' => true,
            ]
        );

        // Child links - updateOrCreate berdasarkan label + parent_id
        $forms = [
            ['label' => 'Undangan Pernikahan', 'url' => '/order/wedding', 'sort_order' => 1],
            ['label' => 'Undangan Khitan', 'url' => '/order/khitan', 'sort_order' => 2],
            ['label' => 'Nama Bayi', 'url' => '/order/baby-name', 'sort_order' => 3],
            ['label' => 'Undangan Ulang Tahun', 'url' => '/order/birthday', 'sort_order' => 4],
        ];

        foreach ($forms as $form) {
            NavLink::updateOrCreate(
                ['label' => $form['label'], 'parent_id' => $parent->id],
                [
                    'url' => $form['url'],
                    'position' => 'both',
                    'target' => '_self',
                    'sort_order' => $form['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
