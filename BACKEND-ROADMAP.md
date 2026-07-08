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

1. Maksud field "Urutan/Order" di halaman admin
Di ketiga modul (Banner, Layanan/Service, Portofolio/PortfolioItem) ada kolom order dengan definisi yang sama:
- Skema (semua tiga migration sama): $table->integer('order')->default(0);
- Validasi backend (semua tiga controller sama): 'order' => 'required|integer|min:0'
- Cara dipakai untuk menampilkan (lihat scope ordered() dan controller index):
- Banner: orderBy('order')->orderBy('id') — sortir berdasarkan order ASC, lalu tie-break dengan id ASC.
- Service: orderBy('order')->orderBy('name') — tie-break dengan name ASC (alfabetis).
- Portfolio: orderBy('order')->orderBy('title') — tie-break dengan title ASC (alfabetis).
Intinya: order adalah angka urutan tampil manual. Angka lebih kecil tampil lebih dulu. Sistem tidak mencegah nilai ganda — ini by design.
2. Apa yang terjadi kalau nomornya sama?
Backend tidak menolak, karena:
- ❌ Tidak ada unique constraint di database. Saya cek SHOW INDEX:
- banners: hanya PRIMARY + FK image_media_id — tidak ada index di order.
- services: PRIMARY + slug unique + FK — tidak ada index di order.
- portfolio_items: PRIMARY + slug unique + FK — tidak ada index di order.
- ❌ Tidak ada rule unique:order di $request->validate([...]) di ketiga controller. Hanya required|integer|min:0.
- ✅ Yang ada hanyalah tie-break di query: kalau order sama, urutan akhir di‑sort oleh kolom kedua (id/name/title).
Jadi jawaban langsung untuk: "apakah backend dan front tidak di desain agar menyimpan nilai agar tidak bisa sama?" — Benar, keduanya memang TIDAK didesain mencegah duplikat. Sekarang ada 3 svc/banner/portfolio dengan order = 0 pun akan tetap tersimpan. Urutannya fallback ke id/name/title.
3. Apakah ini masalah / apa rekomendasinya?
Tergantung strategi yang Anda inginkan. Ada 3 pendekatan umum, dan saya butuh keputusan Anda sebelum menulis kode:
Pendekatan	Perilaku	Cocok untuk
A. Biarkan duplikat (status quo)	order hanya sort hint, tie-break by id/name. Admin bisa isi bebas.	Kasus sederhana, item statis.
B. Unique per-tabel	Tambah unique('order') di DB + 'unique:banners,order' di validasi. Tolak duplikat dengan error.	Mode "slot" — tiap item punya 1 posisi unik.
C. Auto-renumber (float/list)&	Frontend pakai drag-drop, backend simpan array [id => new_order] dan re-urut semua baris (padah seragam, lalu tiap kali simpan, semua record di bawahnya di-shift +1). Lanjut pakai tie-break sebagai jaring-jaring.	UX paling nyata — admin cukup drag drop, tidak perlu mikir angka.
Rekomendasi saya
Pilih C (Auto-renumber + tie-break), karena:
1. Paling user friendly — admin tidak perlu pusing hitung angka unik.
2. Tetap kompatibel dgn kode sekarang (scope ordered masih bekerja).
3. Menghilangkan edge case "dua item sama-sama order=1, urutan jadi non-deterministik" tanpa memaksa admin menghafal slot kosong.
Implementasi yang saya sarankan (nanti, setelah Anda setuju):
1. Tambah endpoint berjalan POST /admin/{banners,services,portfolio}/reorder yang menerima array {ids: [3, 1, 2]}, lalu di dalam DB transaction update order = index untuk masing-masing id.
2. Tambah index index('order') (non-unique) di 3 tabel untuk optimasi query sort. Index non-unik cukup — unique justru melarang renumber yang sah.
3. Jangan tambahkan unique:... validasi di create/update form — itu akan menyulitkan workflow isi manual.
4. Frontend (Blade) pakai SortableJS pada baris tabel, setelah drop panggil endpoint /reorder.
5. Sisakan input order di form create/edit sebagai override manual (advanced), tapi default-nya next-number (= max(order)+1).
Sebelum saya menulis kode apa pun, mohon konfirmasi:
- Pilih pendekatan A, B, atau C?
- Kalau C: boleh saya tambahkan library SortableJS secara lokal (CDN sudah ada di project? Saya review layout admin dulu sebelum appliance), serta route baru + test feature?
- Apakah perubahan ini untuk Banner + Service + Portfolio sekaligus, atau per-modul saja?