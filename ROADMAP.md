# Roadmap Penyelesaian Web Katalog – RavaaWeb

## Fase 1 : Penyusunan Basis Data & Model

1. **Migrasi & Tabel**
   - Buat tabel `categories`, `products`, `product_images`, `product_variants`, `tags` serta tabel pivot `product_tag`.
2. **Model Eloquent**
   - `Product belongsTo Category`
   - `Product hasMany ProductImage`
   - `Product hasMany ProductVariant`
   - `Product belongsToMany Tag`
3. **Factory & Seeder**
   - Factory untuk masing‑masing tabel.
   - Seeder menghasilkan minimal 30 produk, 5 kategori, 3 varian per produk.
4. **Verifikasi**
   - Jalankan `php artisan migrate:fresh --seed` dan pastikan data ter‑seed dengan benar.

## Fase 2 : Integrasi Backend ke Frontend

1. **Query Dinamis**
   - Ganti data statis di `FrontendController` dengan:
     ```php
     Product::with(['category','images','variants','tags'])
            ->when(request('category'), fn($q,$c)=>$q->whereHas('category',fn($q2)=>$q2->where('slug',$c)))
            ->paginate(12);
     ```
2. **Routing**
   - Tambahkan route RESTful untuk katalog (`/catalog`) dan detail produk (`/product/{slug}`).
   - Opsional: endpoint API JSON untuk penggunaan di SPA.
3. **Blade Update**
   - Loop produk, tampilkan gambar utama, varian warna/ukuran, badge warna.
   - Fallback gambar & varian dengan placeholder bila tidak ada.

## Fase 3 : Admin CRUD & Otorisasi

1. **Resource Controller** `Admin\ProductController` (index, create, store, edit, update, destroy).
2. **Middleware & Policy**
   - `auth` + `admin` guard.
   - `ProductPolicy` untuk otorisasi.
3. **Form & Komponen Blade**
   - Input teks, select kategori, upload multiple gambar, tabel varian (warna, ukuran, stok, harga tambahan).
4. **Validasi & Penyimpanan**
   - Request `StoreProductRequest`/`UpdateProductRequest` dengan aturan validasi lengkap.
   - Simpan file ke `storage/app/public/products` dan link via `php artisan storage:link`.
5. **Routing Admin**
   - Prefix `/admin/products` dengan grup middleware `admin`.

## Fase 4 : Penyempurnaan UI/UX & Responsif

1. **CSS (`public/frontend/css/app.css`)**
   - Media query pada breakpoint 900 px, 768 px, 640 px, 480 px untuk grid kartu (2 kolom → 1 kolom).
   - Efek glass‑morphism pada modal gambar dan tab deskripsi.
2. **Lazy‑load & `srcset`**
   - Tambahkan `loading="lazy"` dan `srcset` pada gambar produk.
3. **Pagination UI**
   - Tombol prev/next & nomor halaman dengan styling glass.
4. **Filter Pill**
   - Highlight pilihan aktif, tombol reset filter.
5. **CTA WhatsApp**
   - Tautan `https://wa.me/<nomor>?text=Halo%2C%20saya%20tertarik%20pada%20{product_name}`.
6. **Uji Responsif**
   - Desktop Chrome, Safari iOS, Chrome Android. Periksa overflow, kontras, dan ukuran font.

## Fase 5 : Pengujian Otomatis & CI

1. **Test Unit**
   - Pastikan relasi model (`Product->category`, `Product->variants`, `Product->tags`).
2. **Test Feature**
   - Route katalog & detail mengembalikan 200, pagination berfungsi, filter mengubah query.
3. **Test Browser** (Laravel Dusk / Cypress)
   - Klik thumbnail galeri → gambar utama berubah.
   - Pilih varian → harga & stok terupdate.
   - Klik tombol WhatsApp → URL dengan teks benar.
4. **CI Pipeline** (GitHub Actions)
   - `phpstan` lint, `phpunit` run, lint CSS/JS.
   - Pastikan pipeline gagal bila coverage < 80 % atau ada lint error.

## Fase 6 : Optimasi Performa & Keamanan

1. **Asset Build**
   - Laravel Mix/Vite: minify, versioning, extract CSS kritikal.
2. **Cache Header** pada static assets via Nginx.
3. **Query Caching** pada katalog (`Cache::remember('catalog_page_'.$page, 300, ...)`).
4. **Audit Keamanan**
   - Sanitasi input pencarian.
   - CSRF protection pada semua form admin.
   - Validasi file upload (mime, max 2 MB).

## Fase 7 : SEO, Analitik & Dokumentasi

1. **Meta Tag Dinamis** (`title`, `description`, `og:*`) pada halaman produk.
2. **Sitemap XML** otomatis (`spatie/laravel-sitemap`).
3. **Integrasi Analitik** (Google Analytics / Plausible) di layout utama.
4. **Update Dokumentasi `.opencode`**
   - Ringkasan arsitektur data, instruksi setup lokal (seed, storage link), catatan deployment Docker.

## Fase 8 : Deployment & Monitoring

1. **Docker Image Produksi**
   - `php artisan config:cache`, `php artisan route:cache`.
2. **Staging Deploy**
   - Smoke test semua route, admin login, CRUD.
3. **Supervisor/PM2** untuk queue worker bila dibutuhkan.
4. **Monitoring**
   - Log (`Logflare`/`Sentry`), alert error rate.
5. **Production Release**
   - Backup DB, tag image, rollback plan siap.

## Fase 9 : Pasca‑Launch & Iterasi

1. **Feedback Pengguna**
   - Form feedback, heatmap analytics.
2. **Bugfix Minor & Feature Tambahan**
   - Wishlist, rating, review.
3. **Sprint Berikutnya**
   - Berdasarkan backlog yang terbentuk.

---

*Setiap fase di‑commit terpisah (mis. `feat: migrate & seed`, `feat: admin CRUD`, `chore: UI polishing`). Pull‑request harus melewati review code, CI, dan testing sebelum digabung ke `main`.*