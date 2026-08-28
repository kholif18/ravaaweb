<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        $this->call(UserSeeder::class);

        // Seed pengaturan umum
        $this->call(SettingSeeder::class);

        // Seed layanan (general, excludes Software House)
        $this->call(ServiceSeeder::class);

        // Seed Software House services (independent from general services)
        $this->call(SoftwareHouseServiceSeeder::class);

        // Seed portfolio
        $this->call(PortfolioSeeder::class);

        // Seed banner
        $this->call(BannerSeeder::class);

        // Seed nav links for order forms
        $this->call(NavLinkOrderSeeder::class);
    }
}
