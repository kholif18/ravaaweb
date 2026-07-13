<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminProductTest extends TestCase
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
        Auth()->guard('admin')->login($this->admin);
    }

    public function test_admin_can_view_product_index(): void
    {
        $this->loginAsAdmin();

        $response = $this->get(route('admin.products.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_view_product_create_form(): void
    {
        $this->loginAsAdmin();

        $response = $this->get(route('admin.products.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_store_product(): void
    {
        $this->loginAsAdmin();
        $category = Category::factory()->create();

        $response = $this->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $category->id,
            'status' => 'active',
            'sku' => 'TST-001',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 100000,
        ]);
    }

    public function test_admin_can_update_product(): void
    {
        $this->loginAsAdmin();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->put(route('admin.products.update', $product), [
            'name' => 'Updated Product',
            'price' => 200000,
            'stock' => 20,
            'category_id' => $category->id,
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 200000,
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        $this->loginAsAdmin();
        $product = Product::factory()->create();

        $response = $this->delete(route('admin.products.destroy', $product));

        $response->assertRedirect();
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_admin_can_bulk_delete_products(): void
    {
        $this->loginAsAdmin();
        $products = Product::factory()->count(3)->create();

        $response = $this->delete(route('admin.products.bulk.destroy'), [
            'ids' => $products->pluck('id')->toArray(),
        ]);

        $response->assertRedirect();
        foreach ($products as $product) {
            $this->assertSoftDeleted('products', ['id' => $product->id]);
        }
    }

    public function test_admin_can_restore_product(): void
    {
        $this->loginAsAdmin();
        $product = Product::factory()->create();
        $product->delete();

        $response = $this->put(route('admin.products.restore', $product->id));

        $response->assertRedirect();
        $this->assertNotSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_admin_can_force_delete_product(): void
    {
        $this->loginAsAdmin();
        $product = Product::factory()->create();
        $product->delete();

        $response = $this->delete(route('admin.products.force', $product->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_can_store_product_with_variants(): void
    {
        $this->loginAsAdmin();
        $category = Category::factory()->create();

        $response = $this->post(route('admin.products.store'), [
            'name' => 'Product with Variants',
            'category_id' => $category->id,
            'status' => 'active',
            'variant_types' => [
                ['name' => 'Ukuran', 'values' => ['S', 'M']],
            ],
            'variants' => [
                ['attributes' => ['Ukuran' => 'S'], 'price' => 50000, 'stock' => 10],
                ['attributes' => ['Ukuran' => 'M'], 'price' => 60000, 'stock' => 5],
            ],
        ]);

        $response->assertRedirect();
        $product = Product::where('slug', 'product-with-variants')->first();
        $this->assertNotNull($product);
        $this->assertCount(2, $product->variants);
    }

    public function test_admin_can_update_product_variant(): void
    {
        $this->loginAsAdmin();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $variant = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'price' => 50000,
        ]);

        $response = $this->put(route('admin.products.update', $product), [
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'category_id' => $category->id,
            'status' => 'active',
            'variants' => [
                ['id' => $variant->id, 'attributes' => $variant->attributes, 'price' => 75000, 'stock' => 20],
            ],
        ]);

        $response->assertRedirect();
        $this->assertEquals(75000, $variant->fresh()->price);
    }

    public function test_admin_requires_authentication(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect();
    }

    public function test_product_store_validates_required_fields(): void
    {
        $this->loginAsAdmin();

        $response = $this->post(route('admin.products.store'), []);

        $response->assertSessionHasErrors(['name', 'category_id']);
    }
}
