<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminSoftwareHouseBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Service $softwareHouseService;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        // Always create Software House Service for all tests to match real environment
        $this->softwareHouseService = Service::create([
            'name' => 'Software House',
            'icon' => 'fa-solid fa-laptop-code',
            'description' => 'Default Software House Service Description',
            'features' => [],
            'status' => 'active',
            'order' => 1,
        ]);
    }

    protected function loginAsAdmin(): void
    {
        auth()->guard('admin')->login($this->admin);
    }

    /**
     * Test admin can view software house page builder form.
     */
    public function test_admin_can_view_software_house_builder(): void
    {
        $this->loginAsAdmin();

        $response = $this->get(route('admin.software-house.index'));

        $response->assertStatus(200);
        $response->assertSee('Software House Hub');
        $response->assertSee('Aksi CMS');
    }

    /**
     * Test admin can update software house configuration (including the main service).
     */
    public function test_admin_can_save_software_house_config(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.software-house.store'), [
            'hero' => [
                'title' => 'Custom Software House Title',
                'description' => 'Custom description here.',
            ],
            'layanan' => [
                'title' => 'Custom Services Title',
                'subtitle' => 'Custom services description.',
            ],
            'proses' => [
                'title' => 'Custom Process Title',
                'subtitle' => 'Custom process subtitle.',
                'steps' => [
                    ['title' => 'Step 1 Title', 'description' => 'Step 1 description.'],
                    ['title' => 'Step 2 Title', 'description' => 'Step 2 description.'],
                    ['title' => 'Step 3 Title', 'description' => 'Step 3 description.'],
                    ['title' => 'Step 4 Title', 'description' => 'Step 4 description.'],
                ]
            ],
            'portfolio' => [
                'title' => 'Custom Portfolio Title',
                'subtitle' => 'Custom portfolio subtitle.',
                'categories' => ['Web App', 'Mobile App'],
            ],
            'service' => [
                'icon' => 'fa-solid fa-code-branch',
                'description' => 'Updated from Tab 1 description',
                'status' => 'inactive',
            ]
        ]);

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'settings']));
        $response->assertSessionHas('success');

        // Check page CMS was saved
        $this->assertDatabaseHas('pages', [
            'slug' => 'software-house',
        ]);

        $page = Page::where('slug', 'software-house')->first();
        $this->assertNotNull($page);
        
        $content = $page->content;
        $this->assertEquals('Custom Software House Title', $content['hero']['title']);
        $this->assertEquals('Custom Services Title', $content['layanan']['title']);
        $this->assertEquals('Step 1 Title', $content['proses']['steps'][0]['title']);
        $this->assertEquals(['Web App', 'Mobile App'], $content['portfolio']['categories']);

        // Check service model was updated
        $this->assertDatabaseHas('services', [
            'name' => 'Software House',
            'icon' => 'fa-solid fa-code-branch',
            'description' => 'Updated from Tab 1 description',
            'status' => 'inactive',
        ]);
    }

    /**
     * Test updateService action redirects to settings (Tab 1) as it is integrated now.
     */
    public function test_admin_update_service_redirects(): void
    {
        $this->loginAsAdmin();

        $response = $this->put(route('admin.software-house.service.update', $this->softwareHouseService->id), [
            'icon' => 'fa-solid fa-code',
            'description' => 'Updated service description',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'settings']));
    }

    /**
     * Test admin can add a new sub-feature to Software House service.
     */
    public function test_admin_can_store_software_house_feature(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.software-house.features.store'), [
            'title' => 'New Web App Layanan',
            'icon' => 'fa-solid fa-laptop',
            'steps_text' => "Design\nBuild\nLaunch",
        ]);

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'layanan']));
        $response->assertSessionHas('success');

        $updated = Service::find($this->softwareHouseService->id);
        $this->assertCount(1, $updated->features);
        $this->assertEquals('New Web App Layanan', $updated->features[0]['title']);
        $this->assertEquals(['Design', 'Build', 'Launch'], $updated->features[0]['steps']);
    }

    /**
     * Test admin can update an existing sub-feature.
     */
    public function test_admin_can_update_software_house_feature(): void
    {
        $this->loginAsAdmin();

        $this->softwareHouseService->update([
            'features' => [
                [
                    'title' => 'Old Layanan',
                    'icon' => 'fa-solid fa-code',
                    'steps' => ['Old Step'],
                ]
            ]
        ]);

        $response = $this->put(route('admin.software-house.features.update', 0), [
            'title' => 'Updated Layanan Title',
            'icon' => 'fa-solid fa-cogs',
            'steps_text' => "New Step 1\nNew Step 2",
        ]);

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'layanan']));
        $response->assertSessionHas('success');

        $updated = Service::find($this->softwareHouseService->id);
        $this->assertEquals('Updated Layanan Title', $updated->features[0]['title']);
        $this->assertEquals(['New Step 1', 'New Step 2'], $updated->features[0]['steps']);
    }

    /**
     * Test admin can delete a sub-feature.
     */
    public function test_admin_can_delete_software_house_feature(): void
    {
        $this->loginAsAdmin();

        $this->softwareHouseService->update([
            'features' => [
                [
                    'title' => 'Feature to Delete',
                    'icon' => 'fa-solid fa-code',
                    'steps' => [],
                ]
            ]
        ]);

        $response = $this->delete(route('admin.software-house.features.destroy', 0));

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'layanan']));
        $response->assertSessionHas('success');

        $updated = Service::find($this->softwareHouseService->id);
        $this->assertCount(0, $updated->features);
    }

    /**
     * Test admin can reorder sub-features.
     */
    public function test_admin_can_reorder_software_house_features(): void
    {
        $this->loginAsAdmin();

        $this->softwareHouseService->update([
            'features' => [
                ['title' => 'First', 'icon' => 'fa-1', 'steps' => []],
                ['title' => 'Second', 'icon' => 'fa-2', 'steps' => []],
            ]
        ]);

        $response = $this->post(route('admin.software-house.features.reorder'), [
            'indexes' => [1, 0]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $updated = Service::find($this->softwareHouseService->id);
        $this->assertEquals('Second', $updated->features[0]['title']);
        $this->assertEquals('First', $updated->features[1]['title']);
    }
}
