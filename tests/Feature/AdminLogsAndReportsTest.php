<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminLogsAndReportsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    protected function loginAsAdmin(): void
    {
        auth()->guard('admin')->login($this->admin);
    }

    /**
     * Test admin can view reports & analytics page.
     */
    public function test_admin_can_view_reports(): void
    {
        $this->loginAsAdmin();

        $response = $this->get(route('admin.reports.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan');
        $response->assertSee('Total Produk');
        $response->assertSee('Total Kategori');
    }

    /**
     * Test guest/non-admin cannot view reports page.
     */
    public function test_guest_cannot_view_reports(): void
    {
        $response = $this->get(route('admin.reports.index'));

        // Should be redirected or unauthorized (depending on middleware redirect to login)
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test admin can view system logs page.
     */
    public function test_admin_can_view_logs(): void
    {
        $this->loginAsAdmin();

        // Create a dummy log entry if it doesn't exist
        $logPath = storage_path('logs/laravel.log');
        File::ensureDirectoryExists(dirname($logPath));
        File::put($logPath, "[2026-07-14 12:00:00] local.INFO: Test log message entry\n");

        $response = $this->get(route('admin.logs.index'));

        $response->assertStatus(200);
        $response->assertSee('System Logs');
        $response->assertSee('Test log message entry');
    }

    /**
     * Test guest/non-admin cannot view system logs page.
     */
    public function test_guest_cannot_view_logs(): void
    {
        $response = $this->get(route('admin.logs.index'));

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test admin can clear system logs.
     */
    public function test_admin_can_clear_logs(): void
    {
        $this->loginAsAdmin();

        $logPath = storage_path('logs/laravel.log');
        File::ensureDirectoryExists(dirname($logPath));
        File::put($logPath, "[2026-07-14 12:00:00] local.INFO: Message to be cleared\n");

        $response = $this->delete(route('admin.logs.clear'));

        $response->assertRedirect(route('admin.logs.index'));
        $response->assertSessionHas('success');
        
        $this->assertEquals('', File::get($logPath));
    }
}
