<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
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
        // Buat admin user (gunakan updateOrCreate agar idempotent)
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('secret'),
            ]
        );

        // Buat role admin dengan guard 'admin' dan assign ke user
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $adminUser->assignRole($adminRole);

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
