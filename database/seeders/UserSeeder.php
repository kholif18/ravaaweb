<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@ravaa.my.id'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin-r4v44'),
            ]
        );

        // Assign admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $adminUser->assignRole($adminRole);
    }
}
