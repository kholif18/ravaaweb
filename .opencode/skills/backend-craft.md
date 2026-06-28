
# Skill: Backend Craft untuk RavaaWeb

Gunakan skill ini ketika pengguna meminta **membuat fitur backend baru**, **controller**, **model**, **migration**, **Eloquent query**, **form request**, **service class**, **route**, **Artisan command**, **event/listener**, **job/queue**, **authorization logic**, atau **database schema**.

> ⛔ Jangan gunakan untuk code review (→ `review-code`), fix bug (→ `bugfix`), atau desain UI (→ `frontend-design`).

---

## 🎯 Tujuan

- Mengembangkan fitur backend **Laravel** dengan mengikuti best practice.
- Membuat **CRUD lengkap** (Controller + Model + Migration + Request + Route).
- Merancang **database schema** dan **Eloquent relationships** yang efisien.
- Membangun **service layer** untuk memisahkan business logic dari Controller.
- Menambahkan **validasi**, **authorization** (Policy/Gate), dan **event-driven logic**.
- Membuat **Artisan command** untuk task rutin.
- Mengatur **queue & job** untuk proses background.

---

## 🏗️ Arsitektur Backend RavaaWeb

### 📁 Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php              # Base controller
│   │   ├── FrontendController.php      # Controller halaman publik
│   │   └── Admin/                      # Controller untuk panel admin
│   │       ├── AuthController.php
│   │       ├── ProductController.php
│   │       ├── CategoryController.php
│   │       ├── MediaController.php
│   │       └── ...
│   ├── Requests/                       # Form request validation
│   │   ├── StoreProductRequest.php
│   │   └── UpdateProductRequest.php
│   └── Middleware/
│       ├── AdminAuthenticate.php       # Auth guard admin
│       └── AdminDummyAuth.php
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Category.php
│   ├── Media.php
│   └── ... (model lainnya)
├── Services/                           # Business logic layer
│   ├── ProductService.php
│   ├── MediaService.php
│   └── ...
├── Policies/                           # Authorization
├── Events/                             # Event classes
├── Listeners/                          # Listener classes
├── Jobs/                               # Queue jobs
├── Console/
│   └── Commands/                       # Artisan commands
└── Providers/                          # Service providers
```

---

## ⚙️ Pola Pembuatan Fitur Backend

### 1. CRUD Lengkap (Best Practice)

#### a. Migration
```bash
docker exec RavaaWeb php artisan make:migration create_xxxxx_table
```

**Aturan:**
- Nama tabel: **plural** (`products`, `categories`, `media`)
- Kolom `id` otomatis (bigIncrements)
- Selalu tambah `timestamps()` (created_at, updated_at)
- Jika perlu soft delete: `softDeletes()`
- Jika perlu user stamp: `foreignId('created_by')->nullable()->constrained('users')`
- Gunakan `foreignId()->constrained()` untuk foreign key

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->decimal('price', 12, 2)->default(0);
    $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});
```

#### b. Model
```bash
docker exec RavaaWeb php artisan make:model Models/NamaModel -m
# Flag: -m = migration, -c = controller, -r = resource, -s = seeder, -f = factory
```

**Aturan Model:**
```php
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'price',
        'category_id', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
```

#### c. Form Request (Validation)
```bash
docker exec RavaaWeb php artisan make:request StoreNamaRequest
```

```php
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // atau return Gate::allows('create', Product::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'media_ids' => 'nullable|array',
            'media_ids.*' => 'exists:media,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
        ];
    }
}
```

#### d. Controller
```bash
docker exec RavaaWeb php artisan make:controller Admin/NamaController --resource --model=NamaModel
```

**Aturan Controller:**
- Letakkan di `App\Http\Controllers\Admin\` untuk admin, atau root untuk public.
- Method resource: `index()`, `create()`, `store(Request)`, `show($id)`, `edit($id)`, `update(Request, $id)`, `destroy($id)`.
- Jaga controller tetap **tipis** — pindahkan logika ke Service class jika > 30 baris.

```php
class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(): View
    {
        $products = $this->productService->getPaginated();
        return view('admin.products.index', compact('products'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->productService->create($request->validated());
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
}
```

#### e. Route
```php
// Route resource penuh (index, create, store, show, edit, update, destroy)
Route::resource('products', ProductController::class);

// Route khusus
Route::put('products/{product}/status', [ProductController::class, 'updateStatus'])->name('products.status.update');
Route::delete('products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk.destroy');

// Route untuk admin (dalam grup middleware admin)
Route::prefix('admin')->name('admin.')->middleware(['admin.auth', 'role:admin,admin'])->group(function () {
    Route::resource('products', ProductController::class);
});
```

---

### 2. Service Layer

Gunakan **Service class** untuk logic bisnis yang kompleks:

```bash
docker exec RavaaWeb php artisan make:class Services/NamaService
```

```php
class ProductService
{
    public function __construct(
        protected MediaService $mediaService
    ) {}

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Product::with(['category', 'media'])
            ->active()
            ->orderBy('sort_order')
            ->paginate($perPage);
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);

        if (!empty($data['media_ids'])) {
            $this->mediaService->attachToProduct($product, $data['media_ids']);
        }

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
```

---

### 3. Hubungkan ke Frontend (View)

Controller → Pass data ke view:

```php
public function index(): View
{
    $products = Product::with('category')
        ->active()
        ->paginate(12);

    $categories = Category::active()->get();

    return view('frontend.product', compact('products', 'categories'));
}
```

---

### 4. Authorization (Policies)

```bash
docker exec RavaaWeb php artisan make:policy ProductPolicy --model=Product
```

```php
class ProductPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Product $product): bool { return true; }
    public function create(User $user): bool { return $user->hasRole('admin'); }
    public function update(User $user, Product $product): bool { return $user->hasRole('admin'); }
    public function delete(User $user, Product $product): bool { return $user->hasRole('admin'); }
}
```

Daftarkan di `App\Providers\AuthServiceProvider`:
```php
protected $policies = [
    Product::class => ProductPolicy::class,
];
```

---

### 5. Queue & Job

```bash
docker exec RavaaWeb php artisan make:job ProsesGambar
```

```php
class ProsesGambar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Product $product
    ) {}

    public function handle(ImageService $imageService): void
    {
        $imageService->optimize($this->product->gambar);
    }
}
```

Dispatch:
```php
ProsesGambar::dispatch($product)
    ->delay(now()->addSeconds(5));
```

---

### 6. Artisan Command

```bash
docker exec RavaaWeb php artisan make:command BersihkanData --command=app:bersihkan-data
```

```php
class BersihkanData extends Command
{
    protected $signature = 'app:bersihkan-data
                          {--days=30 : Hapus data lebih dari N hari}
                          {--force : Jalankan tanpa konfirmasi}';

    protected $description = 'Bersihkan data lama dari database';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $force = $this->option('force');

        if (!$force && !$this->confirm("Hapus data lebih dari {$days} hari?")) {
            return self::FAILURE;
        }

        $deleted = Product::where('created_at', '<', now()->subDays($days))->delete();
        $this->info("Berhasil menghapus {$deleted} produk lama.");

        return self::SUCCESS;
    }
}
```

---

### 7. Event & Listener

```bash
docker exec RavaaWeb php artisan make:event ProductCreated
docker exec RavaaWeb php artisan make:listener SendProductNotification --event=ProductCreated
```

```php
class ProductCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Product $product) {}
}

class SendProductNotification implements ShouldQueue
{
    public function handle(ProductCreated $event): void
    {
        // Kirim notifikasi...
        Log::info('Produk baru: ' . $event->product->name);
    }
}
```

Daftarkan di `EventServiceProvider` atau via `AppServiceProvider`:
```php
Event::listen(ProductCreated::class, SendProductNotification::class);
```

---

## 🗄️ Eloquent Relationship Patterns

| Relasi | Method | Contoh |
|--------|--------|--------|
| 1:1 | `hasOne()` / `belongsTo()` | User → Profile |
| 1:M | `hasMany()` / `belongsTo()` | Category → Products |
| M:M | `belongsToMany()` | Product → Tags |
| Morph | `morphMany()` / `morphedByMany()` | Media → (Products, Categories) |
| Has-Many-Through | `hasManyThrough()` | Country → Posts via Users |

**Eager loading** untuk hindari N+1:
```php
// ❌ Buruk (N+1)
$products = Product::all();
foreach ($products as $p) { echo $p->category->name; }

// ✅ Baik
$products = Product::with('category', 'media')->get();
```

---

## 🧪 Testing (Backend)

```bash
docker exec RavaaWeb php artisan make:test ProductTest
# atau untuk feature test:
docker exec RavaaWeb php artisan make:test ProductTest --unit
```

```php
class ProductTest extends TestCase
{
    public function test_product_can_be_created(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    public function test_product_list_page_returns_ok(): void
    {
        $response = $this->get(route('product'));
        $response->assertStatus(200);
    }
}
```

```bash
# Run test spesifik
docker exec RavaaWeb php artisan test --filter=ProductTest
```

---

## 📋 Checklist Pembuatan Fitur Baru

1. **Migration** — buat tabel dengan kolom tepat + foreign key + index
2. **Model** — fillable, casts, relationships, scopes, accessors
3. **Form Request** — validasi + authorize
4. **Service** — business logic (opsional jika sederhana)
5. **Controller** — method resource + dependency injection
6. **Route** — daftarkan di web.php
7. **View** — buat Blade template (via frontend-design skill)
8. **Policy** — authorization (jika perlu)
9. **Test** — unit/feature test
10. **Seeder** — data dummy (jika perlu)

---

## 🚀 Commands Penting

```bash
# Buat file
docker exec RavaaWeb php artisan make:model Models/Nama -m
docker exec RavaaWeb php artisan make:controller Admin/NamaController --resource
docker exec RavaaWeb php artisan make:request StoreNamaRequest
docker exec RavaaWeb php artisan make:policy NamaPolicy --model=Nama
docker exec RavaaWeb php artisan make:service Services/NamaService
docker exec RavaaWeb php artisan make:command NamaCommand
docker exec RavaaWeb php artisan make:event NamaEvent
docker exec RavaaWeb php artisan make:listener NamaListener --event=NamaEvent
docker exec RavaaWeb php artisan make:job NamaJob
docker exec RavaaWeb php artisan make:test NamaTest
docker exec RavaaWeb php artisan make:factory NamaFactory --model=Nama
docker exec RavaaWeb php artisan make:seeder NamaSeeder

# Migrasi
docker exec RavaaWeb php artisan migrate
docker exec RavaaWeb php artisan migrate:fresh --seed

# Route
docker exec RavaaWeb php artisan route:list

# Test
docker exec RavaaWeb php artisan test --filter=NamaTest

# Tinker (debug)
docker exec RavaaWeb php artisan tinker
```

---

*Panggil skill ini dengan `backend-craft` melalui tool skill.*
