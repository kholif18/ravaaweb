<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductCatalogTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Setting::create(['key' => 'site_name', 'value' => 'Ravaa Creative']);
        Setting::create(['key' => 'whatsapp', 'value' => '6281234567890']);
    }

    public function test_catalog_page_shows_products(): void
    {
        $category = Category::factory()->create(['name' => 'ATK', 'status' => 'active']);
        Product::factory()->count(3)->create([
            'category_id' => $category->id,
            'status' => 'active',
            'name' => 'Produk Test',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                ->assertSee('Produk Test')
                ->assertPresent('.prod-card');
        });
    }

    public function test_catalog_category_filter(): void
    {
        $cat1 = Category::factory()->create(['name' => 'ATK', 'slug' => 'atk', 'status' => 'active']);
        $cat2 = Category::factory()->create(['name' => 'Percetakan', 'slug' => 'percetakan', 'status' => 'active']);
        Product::factory()->create(['category_id' => $cat1->id, 'status' => 'active', 'name' => 'Pensil']);
        Product::factory()->create(['category_id' => $cat2->id, 'status' => 'active', 'name' => 'Brosur']);

        $this->browse(function (Browser $browser) use ($cat1) {
            $browser->visit('/product')
                ->assertSee('Pensil')
                ->assertSee('Brosur')
                ->visit('/product?category=' . $cat1->slug)
                ->assertSee('Pensil')
                ->assertDontSee('Brosur');
        });
    }

    public function test_product_detail_page(): void
    {
        $category = Category::factory()->create(['status' => 'active']);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => 'active',
            'name' => 'Produk Detail Test',
            'description' => 'Deskripsi produk detail',
        ]);
        ProductVariant::factory()->create([
            'product_id' => $product->id,
            'color' => 'Merah',
            'price_addition' => 5000,
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/product/' . $product->slug)
                ->assertSee('Produk Detail Test')
                ->assertSee('Deskripsi produk detail')
                ->assertSee('Merah')
                ->assertPresent('.detail-gallery')
                ->assertPresent('.detail-ctas');
        });
    }

    public function test_product_search(): void
    {
        $category = Category::factory()->create(['status' => 'active']);
        Product::factory()->create(['category_id' => $category->id, 'status' => 'active', 'name' => 'Buku Tulis']);
        Product::factory()->create(['category_id' => $category->id, 'status' => 'active', 'name' => 'Pulpen']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/product?search=Buku')
                ->assertSee('Buku Tulis')
                ->assertDontSee('Pulpen');
        });
    }

    public function test_inactive_product_returns_404(): void
    {
        $category = Category::factory()->create(['status' => 'active']);
        $product = Product::factory()->inactive()->create([
            'category_id' => $category->id,
            'name' => 'Produk Nonaktif',
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/product/' . $product->slug)
                ->assertStatus(404);
        });
    }
}
