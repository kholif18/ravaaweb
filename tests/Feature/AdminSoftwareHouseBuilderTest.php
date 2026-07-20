<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Page;
use App\Models\SoftwareHouseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminSoftwareHouseBuilderTest extends TestCase
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
     * Test admin can save software house configuration (CMS only, no service dependency).
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

        // Verify no service record was modified (Software House is now independent)
        $this->assertDatabaseMissing('services', ['name' => 'Software House']);
    }

    /**
     * Test admin can create a new software house service (independent from general services).
     */
    public function test_admin_can_store_software_house_service(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.software-house.services.store'), [
            'title' => 'New Web App Layanan',
            'icon' => 'fa-solid fa-laptop',
            'steps_text' => "Design\nBuild\nLaunch",
        ]);

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'layanan']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('software_house_services', [
            'title' => 'New Web App Layanan',
            'icon' => 'fa-solid fa-laptop',
        ]);

        $svc = SoftwareHouseService::where('title', 'New Web App Layanan')->first();
        $this->assertNotNull($svc);
        $this->assertEquals(['Design', 'Build', 'Launch'], $svc->steps);
    }

    /**
     * Test admin can update an existing software house service.
     */
    public function test_admin_can_update_software_house_service(): void
    {
        $this->loginAsAdmin();

        $shService = SoftwareHouseService::create([
            'title' => 'Old Layanan',
            'icon' => 'fa-solid fa-code',
            'steps' => ['Old Step'],
            'order' => 1,
        ]);

        $response = $this->put(route('admin.software-house.services.update', $shService->id), [
            'title' => 'Updated Layanan Title',
            'icon' => 'fa-solid fa-cogs',
            'steps_text' => "New Step 1\nNew Step 2",
        ]);

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'layanan']));
        $response->assertSessionHas('success');

        $updated = SoftwareHouseService::find($shService->id);
        $this->assertEquals('Updated Layanan Title', $updated->title);
        $this->assertEquals(['New Step 1', 'New Step 2'], $updated->steps);
    }

    /**
     * Test admin can delete a software house service.
     */
    public function test_admin_can_delete_software_house_service(): void
    {
        $this->loginAsAdmin();

        $shService = SoftwareHouseService::create([
            'title' => 'Service to Delete',
            'icon' => 'fa-solid fa-code',
            'steps' => [],
            'order' => 1,
        ]);

        $response = $this->delete(route('admin.software-house.services.destroy', $shService->id));

        $response->assertRedirect(route('admin.software-house.index', ['tab' => 'layanan']));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('software_house_services', ['id' => $shService->id]);
    }

    /**
     * Test admin can reorder software house services.
     */
    public function test_admin_can_reorder_software_house_services(): void
    {
        $this->loginAsAdmin();

        $first = SoftwareHouseService::create(['title' => 'First', 'icon' => 'fa-1', 'steps' => [], 'order' => 0]);
        $second = SoftwareHouseService::create(['title' => 'Second', 'icon' => 'fa-2', 'steps' => [], 'order' => 1]);

        $response = $this->post(route('admin.software-house.services.reorder'), [
            'ids' => [$second->id, $first->id]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals(0, SoftwareHouseService::find($second->id)->order);
        $this->assertEquals(1, SoftwareHouseService::find($first->id)->order);
    }
}
