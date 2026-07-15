<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_admin_login_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->assertSee('Login')
                ->assertPresent('input[type=email]')
                ->assertPresent('input[type=password]')
                ->assertPresent('button[type=submit]');
        });
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        User::factory()->create([
            'email' => 'admin@ravaa.test',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->type('email', 'admin@ravaa.test')
                ->type('password', 'password')
                ->press('button[type=submit]')
                ->assertPathIs('/admin/dashboard')
                ->assertSee('Dashboard');
        });
    }

    public function test_admin_login_with_invalid_credentials(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->type('email', 'wrong@email.com')
                ->type('password', 'wrongpassword')
                ->press('button[type=submit]')
                ->assertPathIs('/admin/login');
        });
    }
}
