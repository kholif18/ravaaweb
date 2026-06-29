# BACKEND-ROADMAP.md – Catatan Rancangan Halaman Admin

Berikut adalah **catatan lengkap** mengenai halaman‑halaman admin yang direkomendasikan untuk proyek RavaaWeb.  Setiap halaman dilengkapi dengan tujuan, komponen UI utama, serta detail fungsionalitas yang sebaiknya di‑implementasikan.

---

## 1. Dashboard
- **URL**: `GET /admin/dashboard`
- **Tujuan**: Ringkasan statistik (total produk, kategori, order hari ini, visitor) serta shortcut ke modul utama.
- **Komponen UI**:
  - Kartu statistik bergaya glass‑morphism.
  - Grafik line (traffic 7 hari) & bar (penjualan per kategori).
  - List aktivitas terbaru (produk baru, review pending).

## 2. Manajemen Kategori
- **URL**: `resource: /admin/categories`
- **Fungsi**: CRUD kategori (nama, slug, urutan, status, ikon).
- **List view**: Tabel dengan kolom Nama, Slug, Urutan, Status (badge), aksi (edit, hapus).
- **Form**: Input teks, nomor, switch status, upload ikon (media‑picker).

## 3. Manajemen Tag
- **URL**: `resource: /admin/tags`
- **Fungsi**: CRUD tag (nama, slug, warna badge).
- **List view**: Tabel sederhana + filter nama.

## 4. Manajemen Produk
- **URL**: `resource: /admin/products`
- **Fungsi**: CRUD lengkap produk termasuk varian, galeri, tag, SEO.
- **List view**: 
  - Kolom Thumbnail, Nama, SKU, Kategori, Harga, Stok, Status, aksi.
  - Filter: kategori, status, rentang harga, pencarian.
  - Bulk‑action: aktifkan, non‑aktifkan, hapus massal.
- **Form Produk (tabbed UI)**:
  1. **Info Utama** – Nama, slug, SKU, deskripsi (WYSIWYG), harga, diskon, status.
  2. **Kategori & Tag** – Dropdown kategori, multiselect tag.
  3. **Variasi** – Tabel dinamis “Add Variant” (warna, ukuran, tambahan harga, stok).
  4. **Galeri** – Drag‑drop upload multiple, urutan sortable.
  5. **SEO** – Meta title, meta description, OG data.
- **Preview**: tombol “Lihat di Frontend”.

## 5. Manajemen Banner / Hero Section
- **URL**: `resource: /admin/banners`
- **Fungsi**: CRUD carousel/banner (gambar, judul, CTA, urutan, jadwal tampilan).
- **Fitur tambahan**: Scheduler (start‑date/end‑date) + status aktif.

## 6. Home‑Page Builder (CMS Sederhana)
- **URL**: `GET /admin/home`
- **Komponen**:
  - Section Hero (pilih banner).
  - Section Kategori Terpopuler (pilih kategori).
  - Section Produk Terbaru / Promo.
  - Rich Text Block (WYSIWYG).
- **Penyimpanan**: tabel `pages` dengan kolom `slug` dan `content` (JSON).

## 7. Settings (Pengaturan Umum)
- **URL**: `GET /admin/settings` & `POST /admin/settings`
- **Kelompok**:
  - **Umum** – Nama situs, logo, favicon.
  - **Kontak** – Email, telepon, alamat, jam operasional.
  - **Sosial Media** – URL FB, IG, WA (nomor WA otomatis dipakai pada CTA).
  - **SEO Global** – Meta default, toggle sitemap.
  - **Integrasi** – API key payment, Google Analytics ID.

## 8. Manajemen Pengguna Admin
- **URL**: `resource: /admin/users`
- **Fungsi**: CRUD user admin (nama, email, password, role).
- **Role‑Permission**: Menggunakan **Spatie Laravel‑Permission** (`admin`, `editor`, `viewer`).

## 9. Role & Permission
- **URL**: `GET /admin/roles` & `GET /admin/permissions`
- **UI**: Daftar role dengan checklist permission; tombol “Add Role”, “Edit”.

## 10. Order Management (Jika ada e‑commerce)
- **URL**: `resource: /admin/orders`
- **Kolom**: No Order, Pelanggan, Total, Status, Tanggal, aksi (view, ubah status).
- **Detail Order**: Ringkasan produk, alamat, histori status.

## 11. Review / Rating (Jika dipertahankan)
- **URL**: `resource: /admin/reviews`
- **Fungsi**: Moderasi review – approve / reject, bulk‑action.

## 12. Reports & Analytics
- **URL**: `GET /admin/reports`
- **Laporan**: Penjualan per periode, produk ter‑laku, traffic per halaman.  (Bisa pakai Google Analytics API atau data internal.)

## 13. Media Library (Opsional)
- **URL**: `GET /admin/media`
- **Fungsi**: Kelola semua file upload (gambar, PDF).  Drag‑drop, rename, delete, folder.

## 14. System Log Viewer
- **URL**: `GET /admin/logs`
- **Fungsi**: Tampilkan `storage/logs/laravel.log` dengan pagination, filter level (error, warning, info).

---

### Implementasi Teknis (Ringkas)
```php
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:admin','role:admin|editor'])
    ->group(function(){
        Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('products', ProductController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('users', UserController::class);
        Route::resource('orders', OrderController::class)->only(['index','show','update']);
        Route::resource('reviews', ReviewController::class)->only(['index','show','destroy']);
        Route::get('home', [HomeBuilderController::class,'index'])->name('home.index');
        Route::post('home', [HomeBuilderController::class,'store'])->name('home.store');
        Route::get('settings', [SettingController::class,'edit'])->name('settings.edit');
        Route::post('settings', [SettingController::class,'update'])->name('settings.update');
        Route::get('roles', [RoleController::class,'index'])->name('roles.index');
        Route::post('roles', [RoleController::class,'store'])->name('roles.store');
        Route::get('permissions', [PermissionController::class,'index'])->name('permissions.index');
        Route::get('reports', [ReportController::class,'index'])->name('reports.index');
        Route::get('media', [MediaController::class,'index'])->name('media.index');
        Route::get('logs', [LogController::class,'index'])->name('logs.index');
});
```

### Tips UI/UX
- **Glass‑morphism** untuk semua card, modal, dan badge.
- **DataTables‑lite** atau **Livewire‑datatable** untuk list view (pencarian, sortir, paging).
- **Tab‑bed form** di halaman produk (Info, Variants, Galeri, SEO).
- **Drag‑drop upload & sortable** pada galeri (gunakan SortableJS).
- **Toast / SweetAlert** untuk notifikasi aksi (simpan, hapus).
- **Responsive**: Sidebar menjadi drawer pada ≤ 640 px; tabel berubah menjadi list‑card pada mobile.

---

*Catatan*: Semua halaman harus dilindungi middleware `auth:admin` serta pengecekan permission melalui Spatie.  Pastikan setiap perubahan diuji dengan unit & feature test, lalu jalankan pipeline CI sebelum merge.


frontend-design buat halaman admin create product, buat 2 kolom 80% kiri, 20% kanan. form utama kanan Nama produk, form slug kecil (autogenerate dari nama) jika tidak di isi. selanjutnya deskripsi singkat text editor. bawahnya tombol varian produk yang akan di generate oleh js, tombol ini menampilkan form di bawahnya jenis misalnya ukuran atau warna, bisa di tambah bisa di hapus kemudian ada tombol untuk menambah detail misal ada 1 tipe misal ukuran memunculkan modal untuk memasukkan ukuran di pisah dengan | contoh S | M | L dll. kalau ada warna berrti dalam modal juga ada warna di bawahnya misal Hijau | Coklat | Biru dll kemudian ada tombol generate, untuk membuat form di bawah vrian, perpaduan warna dan ukuran, form SKU, form Harga, misal mau diskon berikan tombol switch button untuk mengaktifkan form diskon di lengkapi form percent untuk kalkulasi berapa persen diskonnya, form tanggal start dan end diskon, Berat dan dimensi (opsional) picker gmbar untuk tiap varian produk ada preview gambarnya. jika tidak ada varian maka hanya ada from SKU, Harga, switch tombol dikon jika on maka munculkan percent dan harga diskon, form tanggal start dan end diskon, berat dan diimensi opsional, tombol stock (hanya menampilkan ready stok tanpa input jumlah stok) tambah tombol switch untuk service karena service tidak perlu stok buat juga ini di form generate variant. di bawahnya deskripsi lengkap teks editor dan feature (opsional). bagian kolom kanan tombol publish dan draft/archieve gambar kalau tidak bisa di kanan berarti taruh di kolom kiri di atas deskripsi dengan gambar utama dan gallery, jika di kanan bisa taruh di bawah tombol publish ini. kemudian pemilihan kategory, tag dan beberapa pengaturan lainnya jika perlu