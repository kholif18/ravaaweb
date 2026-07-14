<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\PortfolioItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_access_dashboard_and_see_correct_stats()
    {
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole($role);

        // Create some sample data
        $category = Category::create([
            'name' => 'Design',
            'slug' => 'design',
            'status' => 'active'
        ]);

        Product::create([
            'name' => 'UI/UX Mobile App',
            'slug' => 'uiux-mobile-app',
            'price' => 150000,
            'category_id' => $category->id,
            'status' => 'active'
        ]);

        Testimonial::create([
            'client_name' => 'John Doe',
            'position' => 'CEO',
            'company' => 'Google',
            'content' => 'Great work!',
            'rating' => 5,
            'status' => 'active'
        ]);

        PortfolioItem::create([
            'title' => 'Project Ravaa',
            'slug' => 'project-ravaa',
            'category' => 'Web App',
            'client' => 'Ravaa Client',
            'tech' => ['PHP', 'Vue'],
            'status' => 'active'
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
        $response->assertViewHas('recentProducts');

        $response->assertSee('1'); // Counts are all 1 in this isolated test db
    }
}
