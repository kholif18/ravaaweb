<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ReorderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role and user
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    /**
     * Helper: bypass admin.auth middleware by logging in via session
     * and setting the user on the admin guard.
     */
    protected function loginAsAdmin(): void
    {
        Auth()->guard('admin')->login($this->admin);
    }

    public function test_it_can_reorder_banners(): void
    {
        $banner1 = Banner::create(['title' => 'Banner 1', 'order' => 0]);
        $banner2 = Banner::create(['title' => 'Banner 2', 'order' => 1]);
        $banner3 = Banner::create(['title' => 'Banner 3', 'order' => 2]);

        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.banners.reorder'), [
            'ids' => [$banner3->id, $banner1->id, $banner2->id],
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals(0, $banner3->fresh()->order);
        $this->assertEquals(1, $banner1->fresh()->order);
        $this->assertEquals(2, $banner2->fresh()->order);
    }

    public function test_it_can_reorder_services(): void
    {
        $service1 = Service::create(['name' => 'Service 1', 'slug' => 'service-1', 'order' => 0]);
        $service2 = Service::create(['name' => 'Service 2', 'slug' => 'service-2', 'order' => 1]);
        $service3 = Service::create(['name' => 'Service 3', 'slug' => 'service-3', 'order' => 2]);

        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.services.reorder'), [
            'ids' => [$service2->id, $service3->id, $service1->id],
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals(0, $service2->fresh()->order);
        $this->assertEquals(1, $service3->fresh()->order);
        $this->assertEquals(2, $service1->fresh()->order);
    }

    public function test_it_can_reorder_portfolio_items(): void
    {
        $item1 = PortfolioItem::create(['title' => 'Portfolio 1', 'slug' => 'portfolio-1', 'category' => 'Web', 'order' => 0]);
        $item2 = PortfolioItem::create(['title' => 'Portfolio 2', 'slug' => 'portfolio-2', 'category' => 'Web', 'order' => 1]);
        $item3 = PortfolioItem::create(['title' => 'Portfolio 3', 'slug' => 'portfolio-3', 'category' => 'Web', 'order' => 2]);

        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.portfolio.reorder'), [
            'ids' => [$item3->id, $item2->id, $item1->id],
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals(0, $item3->fresh()->order);
        $this->assertEquals(1, $item2->fresh()->order);
        $this->assertEquals(2, $item1->fresh()->order);
    }

    public function test_it_rejects_invalid_ids_in_reorder(): void
    {
        Banner::create(['title' => 'Banner 1', 'order' => 0]);

        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.banners.reorder'), [
            'ids' => [99999],
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('ids.0');
    }

    public function test_it_rejects_empty_ids_array(): void
    {
        $this->loginAsAdmin();

        $response = $this->postJson(route('admin.banners.reorder'), [
            'ids' => [],
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('ids');
    }

    public function test_it_requires_authentication(): void
    {
        $response = $this->postJson(route('admin.banners.reorder'), [
            'ids' => [1],
        ]);

        $response->assertUnauthorized();
    }
}
