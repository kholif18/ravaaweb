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

        // Seed kategori produk
        $this->call(CategorySeeder::class);
    }
}
