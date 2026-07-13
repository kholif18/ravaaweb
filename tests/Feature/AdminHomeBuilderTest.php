<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminHomeBuilderTest extends TestCase
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

    public function test_admin_can_view_home_builder(): void
    {
        $this->loginAsAdmin();

        $response = $this->get(route('admin.home.index'));

        $response->assertStatus(200);
        $response->assertSee('Home Builder');
    }

    public function test_admin_can_save_home_builder_config(): void
    {
        $this->loginAsAdmin();

        $banner = Banner::create([
            'title' => 'Banner Test',
            'is_active' => true,
        ]);

        $category = Category::factory()->create([
            'name' => 'Category Test',
            'status' => 'active',
        ]);

        $product = Product::factory()->create([
            'name' => 'Product Test',
            'status' => 'active',
        ]);

        $response = $this->post(route('admin.home.store'), [
            'hero' => [
                'banner_ids' => [$banner->id],
            ],
            'categories' => [
                'title' => 'Custom Category Title',
                'subtitle' => 'Custom Category Subtitle',
                'category_ids' => [$category->id],
            ],
            'products' => [
                'title' => 'Custom Product Title',
                'subtitle' => 'Custom Product Subtitle',
                'type' => 'selected',
                'limit' => 4,
                'product_ids' => [$product->id],
            ],
            'rich_text' => [
                'title' => 'Custom Rich Text Title',
                'content' => 'Custom Rich Text Content',
                'is_visible' => '1',
            ],
        ]);

        $response->assertRedirect(route('admin.home.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pages', [
            'slug' => 'home',
        ]);

        $page = Page::where('slug', 'home')->first();
        $this->assertNotNull($page);
        
        $content = $page->content;
        $this->assertEquals('Custom Category Title', $content['categories']['title']);
        $this->assertEquals('Custom Rich Text Title', $content['rich_text']['title']);
        $this->assertTrue($content['rich_text']['is_visible']);
    }

    public function test_home_page_shows_custom_cms_content(): void
    {
        $banner = Banner::create([
            'title' => 'Banner Test',
            'is_active' => true,
        ]);

        Page::create([
            'slug' => 'home',
            'content' => [
                'hero' => [
                    'banner_ids' => [$banner->id],
                ],
                'categories' => [
                    'title' => 'Custom Category Title',
                    'subtitle' => 'Custom Category Subtitle',
                    'category_ids' => [],
                ],
                'products' => [
                    'title' => 'Custom Product Title',
                    'subtitle' => 'Custom Product Subtitle',
                    'type' => 'featured',
                    'limit' => 8,
                    'product_ids' => [],
                ],
                'rich_text' => [
                    'title' => 'Custom Rich Text Title',
                    'content' => 'Custom Rich Text Content Inside Glass Card',
                    'is_visible' => true,
                ],
            ]
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Custom Category Title');
        $response->assertSee('Custom Category Subtitle');
        $response->assertSee('Custom Product Title');
        $response->assertSee('Custom Rich Text Title');
        $response->assertSee('Custom Rich Text Content Inside Glass Card');
    }
}
