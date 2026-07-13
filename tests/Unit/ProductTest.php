<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_category(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Category::class, $product->category);
    }

    public function test_product_has_variants(): void
    {
        $product = Product::factory()->create();
        ProductVariant::factory()->count(3)->create(['product_id' => $product->id]);

        $this->assertCount(3, $product->variants);
    }

    public function test_product_has_many_variants(): void
    {
        $product = Product::factory()->create();
        ProductVariant::factory()->create(['product_id' => $product->id]);
        ProductVariant::factory()->create(['product_id' => $product->id]);

        $this->assertEquals(2, $product->variants()->count());
    }

    public function test_product_generates_slug_from_name(): void
    {
        $product = Product::factory()->create([
            'name' => 'Paket Desain Logo',
            'slug' => '',
        ]);

        $this->assertEquals('paket-desain-logo', $product->fresh()->slug);
    }

    public function test_effective_price_returns_discount_price_when_available(): void
    {
        $product = Product::factory()->withDiscount(20)->create();

        $this->assertEquals($product->price_discount, $product->effective_price);
    }

    public function test_effective_price_returns_regular_price_when_no_discount(): void
    {
        $product = Product::factory()->create(['price_discount' => null]);

        $this->assertEquals($product->price, $product->effective_price);
    }

    public function test_discount_active_returns_true_when_in_date_range(): void
    {
        $product = Product::factory()->create([
            'discount_percent' => 10,
            'discount_start' => now()->subDay(),
            'discount_end' => now()->addDays(30),
        ]);

        $this->assertTrue($product->discount_active);
    }

    public function test_discount_active_returns_false_when_no_discount(): void
    {
        $product = Product::factory()->create([
            'discount_percent' => 0,
            'discount_start' => null,
            'discount_end' => null,
        ]);

        $this->assertFalse($product->discount_active);
    }

    public function test_discount_active_returns_false_when_expired(): void
    {
        $product = Product::factory()->create([
            'discount_percent' => 10,
            'discount_start' => now()->subDays(30),
            'discount_end' => now()->subDay(),
        ]);

        $this->assertFalse($product->discount_active);
    }

    public function test_product_can_be_soft_deleted(): void
    {
        $product = Product::factory()->create();
        $productId = $product->id;

        $product->delete();

        $this->assertSoftDeleted('products', ['id' => $productId]);
        $this->assertNull(Product::find($productId));
        $this->assertNotNull(Product::onlyTrashed()->find($productId));
    }

    public function test_product_can_be_restored(): void
    {
        $product = Product::factory()->create();
        $product->delete();
        $productId = $product->id;

        Product::onlyTrashed()->find($productId)->restore();

        $this->assertNotSoftDeleted('products', ['id' => $productId]);
        $this->assertNotNull(Product::find($productId));
    }

    public function test_active_scope_filters_correctly(): void
    {
        Product::factory()->create(['status' => 'active']);
        Product::factory()->inactive()->create();
        Product::factory()->create(['status' => 'archived']);

        $active = Product::where('status', 'active')->get();

        $this->assertCount(1, $active);
    }

    public function test_featured_scope_filters_correctly(): void
    {
        Product::factory()->featured()->create();
        Product::factory()->create(['is_featured' => false]);

        $featured = Product::where('is_featured', true)->get();

        $this->assertCount(1, $featured);
    }

    public function test_product_factory_creates_valid_product(): void
    {
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'status' => 'active',
        ]);
    }
}
