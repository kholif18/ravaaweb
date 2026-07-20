<?php

namespace Database\Seeders;

use App\Models\SoftwareHouseService;
use Illuminate\Database\Seeder;

class SoftwareHouseServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Website Company Profile',
                'icon' => 'fa-solid fa-globe',
                'steps' => ['Analisis Kebutuhan', 'UI/UX Design', 'Frontend Development', 'Backend Development', 'Testing', 'Deployment', 'Maintenance'],
                'order' => 1,
            ],
            [
                'title' => 'Aplikasi Web Custom',
                'icon' => 'fa-solid fa-laptop-code',
                'steps' => ['Consultation & Planning', 'UI/UX Design', 'Development', 'Integration', 'Testing', 'Deployment', 'Support'],
                'order' => 2,
            ],
            [
                'title' => 'Mobile App (Android/iOS)',
                'icon' => 'fa-solid fa-mobile-screen',
                'steps' => ['Market Research', 'UI/UX Design', 'Prototyping', 'Development', 'Testing', 'App Store Deployment', 'Maintenance'],
                'order' => 3,
            ],
            [
                'title' => 'Sistem Informasi',
                'icon' => 'fa-solid fa-database',
                'steps' => ['Analisis Kebutuhan Sistem', 'Perancangan Database', 'Backend Development', 'Frontend Development', 'Integration', 'Testing', 'Deployment'],
                'order' => 4,
            ],
            [
                'title' => 'API Integration',
                'icon' => 'fa-solid fa-plug',
                'steps' => ['Analisis API', 'Desain Arsitektur', 'Development', 'Security Testing', 'Dokumentasi', 'Deployment'],
                'order' => 5,
            ],
            [
                'title' => 'Maintenance & Support',
                'icon' => 'fa-solid fa-headset',
                'steps' => ['Monitoring', 'Bug Fixing', 'Update & Upgrade', 'Performance Optimization', 'Backup & Recovery', 'Technical Support'],
                'order' => 6,
            ],
        ];

        foreach ($services as $data) {
            SoftwareHouseService::updateOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
