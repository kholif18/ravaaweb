# Roadmap Penyelesaian Web Katalog – RavaaWeb

## Fase 1: Penyusunan Basis Data & Model ✅ SELESAI

1. **Migrasi & Tabel** ✅
   - `categories` (name, slug, icon, color, order, status, SEO fields)
   - `tags` (name, slug, color)
   - `media` (name, file_name, mime_type, size, path, disk, uploaded_by)
   - `products` (name, slug, description, price, price_discount, stock, category_id, status, is_featured, sku, weight, SEO fields, thumbnail_id)
   - `product_variants` (product_id, color, size, sku, stock, price_addition, status)
   - Pivot: `product_media` (product_id, media_id, sort_order, is_primary)
   - Pivot: `product_tag` (product_id, tag_id)
2. **Model Eloquent** ✅
   - `Category` — has children, products
   - `Tag` — belongsToMany products
   - `Media` — belongsToMany products, uploader
   - `Product` — belongsTo category, belongsToMany tags, belongsToMany media, hasMany variants
   - `ProductVariant` — belongsTo product
3. **Factory & Seeder** ✅
   - `CategorySeeder` — 20 kategori (5 utama + 15 tambahan)
   - `TagSeeder` — 6 tag
   - `ProductSeeder` — 5 produk sample
4. **Verifikasi** ✅
   - `php artisan migrate:fresh --seed` berhasil

## Fase 2: Admin CRUD & Otorisasi ✅ SELESAI

1. **Auth & Middleware** ✅
   - `Admin/AuthController` — login/logout
   - Middleware: `admin.auth` + `role:admin,admin`
   - Guard: `admin` (Spatie Laravel-Permission)
2. **Dashboard** ✅
   - `admin/dashboard/index.blade.php` — placeholder

## Fase 3: Manajemen Katalog ✅ SELESAI

1. **Kategori** ✅
   - `CategoryController` — full CRUD + bulk delete + status toggle
   - Views: `admin/categories/` — index, create modal, edit modal, _table
2. **Tag** ✅
   - `TagController` — full CRUD + bulk delete
   - Views: `admin/tags/` — index, create, edit, _table

## Fase 4: Media Library ✅ SELESAI

1. **Media Library** ✅
   - `MediaController` — CRUD, bulk delete, bulk upload, picker API
   - Views: `admin/media/index.blade.php` — grid + list view toggle
   - Features: drag-drop upload, search, type filter, fullscreen gallery, copy URL
   - `<x-media-picker>` — reusable Blade component (modal-based, WordPress-style)

## Fase 5: Produk (Dalam Proses) 🔄 IN PROGRESS

1. **Backend** ✅
   - `ProductController` — full CRUD + bulk delete + media order
   - Routes: resource + bulk-delete + media-order
2. **Views** 🔄
   - `admin/products/index.blade.php` — compact table ✅
   - `admin/products/_table.blade.php` — compact layout ✅
   - `admin/products/create.blade.php` — form with media picker ✅
   - `admin/products/edit.blade.php` — form with media picker ✅
   - **Belum**: variant management dynamic, product gallery reorder

## Fase 6: Integrasi Backend ke Frontend ⏳ BELUM

1. **Query Dinamis**
   - Ganti data statis di `FrontendController` dengan query Eloquent
   - Filter by category, search, paginate
2. **Routing**
   - `/catalog` — daftar produk dengan filter
   - `/product/{slug}` — detail produk
3. **Blade Update**
   - Loop produk, tampilkan gambar utama, varian, badge
   - Fallback gambar placeholder

## Fase 7: Penyempurnaan UI/UX & Responsif ⏳ BELUM

1. **CSS Responsive**
   - Media query breakpoints: 900px, 768px, 640px, 480px
   - Grid kartu: 4 kolom → 2 → 1
2. **Lazy-load & srcset**
3. **Pagination UI** — glass style
4. **Filter Pill** — highlight aktif
5. **CTA WhatsApp**
6. **Uji Responsif** — Chrome, Safari iOS, Chrome Android

## Fase 8: Halaman Admin Lainnya ⏳ BELUM

1. **Banner / Hero** — CRUD carousel
2. **Home Builder** — CMS section builder
3. **Settings** — Umum, Kontak, Sosial, SEO, Integrasi
4. **Users** — CRUD admin users
5. **Role & Permission** — UI management
6. **Reports & Analytics**
7. **System Logs**

## Fase 9: Pengujian & CI ⏳ BELUM

1. **Test Unit** — relasi model
2. **Test Feature** — route, pagination, filter
3. **Test Browser** — Laravel Dusk / Cypress
4. **CI Pipeline** — GitHub Actions

## Fase 10: Optimasi & Deployment ⏳ BELUM

1. **Asset Build** — minify, versioning
2. **Cache Header** — static assets
3. **Query Caching**
4. **SEO** — meta tags, sitemap, analytics
5. **Docker Production** — config cache, route cache
6. **Monitoring** — logs, alerts

---

*Terakhir diperbarui: 29 Juni 2026*
