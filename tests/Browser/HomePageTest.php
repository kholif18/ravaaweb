<?php

namespace Tests\Browser;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Setting::create(['key' => 'site_name', 'value' => 'Ravaa Creative']);
        Setting::create(['key' => 'whatsapp', 'value' => '6281234567890']);
    }

    public function test_home_page_loads_with_all_sections(): void
    {
        $category = Category::factory()->create(['name' => 'ATK', 'status' => 'active']);
        Product::factory()->count(4)->create([
            'category_id' => $category->id,
            'status' => 'active',
            'is_featured' => true,
        ]);
        Banner::factory()->create(['is_active' => true]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Ravaa Creative')
                ->assertSee('ATK')
                ->assertSee('Katalog')
                ->assertSee('Hubungi Kami')
                ->assertPresent('.hero')
                ->assertPresent('.product-grid')
                ->assertPresent('.category-grid')
                ->assertPresent('.float-wa');
        });
    }

    public function test_navigation_links_work(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Katalog')
                ->assertPathIs('/product')
                ->back()
                ->clickLink('Kontak')
                ->assertPathIs('/contact');
        });
    }

    public function test_mobile_navigation_toggle(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->resize(375, 812)
                ->assertMissing('.mobile-drawer.open')
                ->click('.navbar-toggle')
                ->waitFor('.mobile-drawer.open')
                ->assertPresent('.mobile-drawer.open');
        });
    }
}
