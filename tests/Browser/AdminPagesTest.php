<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminPagesTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'email' => 'admin@ravaa.test',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_admin_can_manage_products(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin, 'admin')
                ->visit('/admin/products')
                ->assertSee('Produk')
                ->assertPresent('a[href*="/admin/products/create"]');
        });
    }

    public function test_admin_can_access_media_library(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin, 'admin')
                ->visit('/admin/media')
                ->assertSee('Media')
                ->assertSee('Upload');
        });
    }

    public function test_admin_can_access_settings(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin, 'admin')
                ->visit('/admin/settings')
                ->assertSee('Pengaturan');
        });
    }

    public function test_admin_can_access_reports(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin, 'admin')
                ->visit('/admin/reports')
                ->assertSee('Laporan');
        });
    }

    public function test_admin_unauthenticated_redirect_to_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/dashboard')
                ->assertPathIs('/admin/login');
        });
    }
}
