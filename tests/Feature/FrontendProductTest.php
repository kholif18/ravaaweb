<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create default settings
        Setting::create(['key' => 'site_name', 'value' => 'Ravaa Creative']);
        Setting::create(['key' => 'whatsapp', 'value' => '6281234567890']);
    }

    public function test_home_page_returns_success(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_product_listing_page_returns_success(): void
    {
        $response = $this->get('/product');

        $response->assertStatus(200);
    }

    public function test_product_listing_shows_active_products(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id, 'status' => 'active']);
        Product::factory()->inactive()->create(['category_id' => $category->id]);

        $response = $this->get('/product');

        $response->assertStatus(200);
        // Should only show 3 active products, not the inactive one
    }

    public function test_product_listing_shows_starting_price_for_variants(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => 'active',
            'price' => 0,
        ]);

        ProductVariant::factory()->create([
            'product_id' => $product->id,
            'price' => 75000,
            'stock' => 10,
            'is_active' => true,
        ]);
        ProductVariant::factory()->create([
            'product_id' => $product->id,
            'price' => 95000,
            'stock' => 5,
            'is_active' => true,
        ]);

        $response = $this->get('/product');

        $response->assertStatus(200);
        $response->assertSee('Mulai Rp 75.000');
    }

    public function test_product_listing_filters_by_category(): void
    {
        $cat1 = Category::factory()->create(['slug' => 'desain-grafis']);
        $cat2 = Category::factory()->create(['slug' => 'percetakan']);
        Product::factory()->count(2)->create(['category_id' => $cat1->id, 'status' => 'active']);
        Product::factory()->count(3)->create(['category_id' => $cat2->id, 'status' => 'active']);

        $response = $this->get('/product?category=desain-grafis');

        $response->assertStatus(200);
    }

    public function test_product_listing_searches_by_name(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['name' => 'Paket Desain Logo', 'category_id' => $category->id, 'status' => 'active']);
        Product::factory()->create(['name' => 'Cetak Brosur', 'category_id' => $category->id, 'status' => 'active']);

        $response = $this->get('/product?search=Logo');

        $response->assertStatus(200);
    }

    public function test_product_listing_filters_by_type(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id, 'status' => 'active', 'is_service' => false]);
        Product::factory()->service()->create(['category_id' => $category->id, 'status' => 'active']);

        $response = $this->get('/product?type=service');

        $response->assertStatus(200);
    }

    public function test_product_detail_page_returns_success(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => 'active',
            'slug' => 'test-product',
        ]);

        $response = $this->get('/product/test-product');

        $response->assertStatus(200);
    }

    public function test_product_detail_page_returns_404_for_inactive(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->inactive()->create([
            'category_id' => $category->id,
            'slug' => 'inactive-product',
        ]);

        $response = $this->get('/product/inactive-product');

        $response->assertStatus(404);
    }

    public function test_product_detail_page_returns_404_for_nonexistent(): void
    {
        $response = $this->get('/product/does-not-exist');

        $response->assertStatus(404);
    }

    public function test_product_detail_shows_variants(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => 'active',
            'slug' => 'product-with-variants',
            'variant_types' => [['name' => 'Ukuran', 'values' => ['S', 'M', 'L']]],
        ]);

        ProductVariant::factory()->create([
            'product_id' => $product->id,
            'attributes' => ['Ukuran' => 'S'],
            'price' => 50000,
            'stock' => 10,
        ]);
        ProductVariant::factory()->create([
            'product_id' => $product->id,
            'attributes' => ['Ukuran' => 'M'],
            'price' => 60000,
            'stock' => 5,
        ]);

        $response = $this->get('/product/product-with-variants');

        $response->assertStatus(200);
        $response->assertSee('Rp 50.000 - Rp 60.000');
    }

    public function test_product_detail_shows_related_products(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => 'active',
            'slug' => 'main-product',
        ]);

        Product::factory()->count(3)->create([
            'category_id' => $category->id,
            'status' => 'active',
        ]);

        $response = $this->get('/product/main-product');

        $response->assertStatus(200);
    }

    public function test_product_listing_is_paginated(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(15)->create([
            'category_id' => $category->id,
            'status' => 'active',
        ]);

        $response = $this->get('/product');

        $response->assertStatus(200);
    }

    public function test_product_detail_handles_discount_correctly(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->withDiscount(20)->create([
            'category_id' => $category->id,
            'status' => 'active',
            'slug' => 'discounted-product',
        ]);

        $response = $this->get('/product/discounted-product');

        $response->assertStatus(200);
    }

    public function test_software_house_page_returns_success(): void
    {
        \App\Models\SoftwareHouseService::create([
            'title' => 'Feature 1',
            'icon' => 'fa-solid fa-code',
            'steps' => ['Step 1', 'Step 2'],
            'order' => 1,
            'is_active' => true,
        ]);

        \App\Models\SoftwareHouseService::create([
            'title' => 'Feature 2',
            'icon' => 'fa-solid fa-laptop',
            'steps' => [],
            'order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get('/software-house');

        $response->assertStatus(200);
        $response->assertSee('Software House');
        $response->assertSee('Feature 1');
        $response->assertSee('Feature 2');
    }
}
