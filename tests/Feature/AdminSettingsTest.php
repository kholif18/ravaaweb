<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_settings()
    {
        $response = $this->get(route('admin.settings.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_update_settings_including_logo()
    {
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole($role);

        // Upload media logo
        $media = \App\Models\Media::create([
            'name' => 'logo.png',
            'file_name' => 'logo.png',
            'mime_type' => 'image/png',
            'size' => 1024,
            'disk' => 'public',
            'path' => 'media/logo.png',
        ]);

        $response = $this->actingAs($admin, 'admin')->put(route('admin.settings.update'), [
            'site_name' => 'My Brand',
            'logo_media_id' => $media->id,
            'whatsapp' => '628123456789',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('My Brand', Setting::get('site_name'));
        $this->assertEquals($media->id, Setting::get('logo_media_id'));
        $this->assertEquals('628123456789', Setting::get('whatsapp'));
    }
}
