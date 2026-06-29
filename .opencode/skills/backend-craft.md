
# Skill: Backend Craft untuk RavaaWeb

Gunakan skill ini ketika pengguna meminta **membuat fitur backend baru**, **controller**, **model**, **migration**, **Eloquent query**, **form request**, **service class**, **route**, **Artisan command**, **event/listener**, **job/queue**, **authorization logic**, atau **database schema**.

> ⛔ Jangan gunakan untuk code review (→ `review-code`), fix bug (→ `bugfix`), atau desain UI (→ `frontend-design`).

---

## 🎯 Tujuan

- Mengembangkan fitur backend **Laravel** dengan mengikuti best practice.
- Membuat **CRUD lengkap** (Controller + Model + Migration + Request + Route).
- Merancang **database schema** dan **Eloquent relationships** yang efisien.
- Menambahkan **validasi**, **authorization** (Policy/Gate), dan **event-driven logic**.

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
│   │       ├── CategoryController.php
│   │       ├── TagController.php
│   │       ├── MediaController.php
│   │       └── ProductController.php
│   ├── Requests/                       # Form request validation
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Tag.php
│   ├── Media.php
│   ├── Product.php
│   └── ProductVariant.php
├── Services/                           # Business logic layer (opsional)
├── Policies/                           # Authorization
└── Providers/
```

### 📁 Database Tables

```
├── categories          # name, slug, icon, color, order, status, parent_id, SEO
├── tags                # name, slug, color
├── media               # name, file_name, mime_type, size, path, disk, uploaded_by
├── products            # name, slug, description, price, price_discount, stock,
│                       # category_id, status, is_featured, sku, weight, SEO, thumbnail_id
├── product_variants    # product_id, color, size, sku, stock, price_addition, status
├── product_media       # product_id, media_id, sort_order, is_primary (pivot)
├── product_tag         # product_id, tag_id (pivot)
├── roles               # Spatie Permission
├── permissions         # Spatie Permission
├── model_has_roles     # Spatie Permission
├── model_has_permissions # Spatie Permission
└── role_has_permissions  # Spatie Permission
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
- Selalu tambah `timestamps()`
- Jika perlu soft delete: `softDeletes()`
- Gunakan `foreignId()->constrained()` untuk foreign key

#### b. Model
```bash
docker exec RavaaWeb php artisan make:model Models/NamaModel -m
```

**Aturan Model:**
```php
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'price',
        'category_id', 'status', 'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    // Auto-generate slug
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tag')->withTimestamps();
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'product_media')
            ->withPivot('sort_order', 'is_primary')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
```

#### c. Controller
```bash
docker exec RavaaWeb php artisan make:controller Admin/NamaController --resource
```

**Aturan Controller:**
- Letakkan di `App\Http\Controllers\Admin\` untuk admin.
- Method resource: `index()`, `create()`, `store()`, `edit()`, `update()`, `destroy()`.
- Gunakan `DB::transaction()` untuk operasi kompleks (create + attach media + variants).

```php
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'thumbnail', 'media'])->withCount('variants');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate($request->input('per_page', 15));
        $products->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([...]);

        $product = DB::transaction(function () use ($validated, $request) {
            $product = Product::create($validated);

            // Attach tags
            if ($request->filled('tag_ids')) {
                $product->tags()->sync($request->input('tag_ids'));
            }

            // Attach media from library
            if ($request->filled('media_ids')) {
                foreach ($request->input('media_ids') as $index => $mediaId) {
                    $product->media()->attach($mediaId, [
                        'sort_order' => $index,
                        'is_primary' => $mediaId == $request->input('primary_media_id'),
                    ]);
                }
            }

            // Create variants
            if ($request->filled('variants')) {
                foreach ($request->input('variants') as $variantData) {
                    $product->variants()->create($variantData);
                }
            }

            return $product;
        });

        return redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil dibuat.");
    }
}
```

#### d. Route
```php
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin.auth', 'role:admin,admin'])
    ->group(function () {
        // Resource routes
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('products', ProductController::class);

        // Custom routes
        Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk.destroy');
        Route::put('categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('categories.status.update');
        Route::delete('tags/bulk-delete', [TagController::class, 'bulkDestroy'])->name('tags.bulk.destroy');
        Route::delete('media/bulk-delete', [MediaController::class, 'destroyMultiple'])->name('media.bulk.destroy');
        Route::post('media/upload-multiple', [MediaController::class, 'storeMultiple'])->name('media.store.multiple');
        Route::get('media/picker', [MediaController::class, 'picker'])->name('media.picker');
        Route::resource('media', MediaController::class)->except(['show', 'edit', 'update']);
        Route::delete('products/bulk-delete', [ProductController::class, 'destroyMultiple'])->name('products.bulk.destroy');
        Route::put('products/{product}/media-order', [ProductController::class, 'updateMediaOrder'])->name('products.media.order');
    });
```

---

## 🔑 Project Context

| Item | Value |
|------|-------|
| **Laravel version** | 13.x |
| **PHP version** | 8.3 |
| **Docker container** | `RavaaWeb` |
| **Database** | MariaDB (`mariadb-db-1`) |
| **Admin guard** | `admin` |
| **Admin middleware** | `admin.auth` + `role:admin,admin` |
| **Login URL** | `/admin/login` |
| **Auth scaffolding** | Spatie Laravel-Permission |

---

## 🚀 Commands Penting

```bash
# Buat file
docker exec RavaaWeb php artisan make:model Models/Nama -m
docker exec RavaaWeb php artisan make:controller Admin/NamaController --resource
docker exec RavaaWeb php artisan make:request StoreNamaRequest
docker exec RavaaWeb php artisan make:seeder NamaSeeder

# Migrasi
docker exec RavaaWeb php artisan migrate
docker exec RavaaWeb php artisan migrate:fresh --seed

# Route
docker exec RavaaWeb php artisan route:list

# View cache
docker exec RavaaWeb php artisan view:clear

# Config cache
docker exec RavaaWeb php artisan config:clear

# Tinker (debug)
docker exec RavaaWeb php artisan tinker
```

---

## 📋 Checklist Pembuatan Fitur Baru

1. **Migration** — buat tabel dengan kolom tepat + foreign key + index
2. **Model** — fillable, casts, relationships, booted (auto-slug)
3. **Controller** — method resource + DB::transaction untuk operasi kompleks
4. **Route** — daftarkan di `routes/web.php`
5. **View** — buat Blade template (index, create, edit, _table)
6. **Seeder** — data dummy (jika perlu)
7. **Clear cache** — `docker exec RavaaWeb php artisan view:clear`

---

*Panggil skill ini dengan `backend-craft` melalui tool skill.*
