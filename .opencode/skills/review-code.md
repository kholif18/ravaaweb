
# Skill: Code Reviewer untuk RavaaWeb

Gunakan skill ini ketika pengguna meminta **review kode**, **analisis kode**, **cek kualitas kode**, atau **saran perbaikan** di project RavaaWeb.

> ⛔ Jangan gunakan skill ini untuk **memperbaiki bug** — gunakan skill **bugfix**.

---

## 🎯 Tujuan

- Melakukan **code review** pada file PHP (Laravel), Blade, JavaScript, CSS.
- Mengidentifikasi **security issue, performance bottleneck, code smell, pelanggaran best practice**.
- Memberikan **rekomendasi perbaikan** tanpa mengubah kode (kecuali diminta).

---

## 📋 Aturan Review Kode

### 1. Keamanan (Security)
- SQL Injection? → Pastikan pakai Eloquent / Query Builder binding, bukan raw `DB::statement()` dengan concatenation.
- XSS? → Blade sudah auto-escape (`{{ }}`), tapi pastikan tidak ada `{!! !!}` tanpa sanitasi.
- CSRF? → Setiap form POST harus `@csrf`.
- Mass Assignment? → Cek `$fillable` / `$guarded` di Model.
- Authorization? → Pastikan resource `Policy` atau `Gate` digunakan, jangan hanya `if(Auth::id() == ...)`.
- File Upload? → Validasi ekstensi, ukuran, path traversal.

### 2. Kinerja (Performance)
- N+1 Query? → Pastikan `->with()` untuk eager loading.
- Query besar tanpa pagination? → Gunakan `->paginate()` / `->cursor()`.
- Loop DB query? → Jangan query di dalam Blade atau loop; push ke controller / service.
- Cache? → Data statis (kategori, produk) sebaiknya di-cache.

### 3. Best Practice Laravel
- Controller tebal? → Pindahkan logic ke **Service** / **Action** class.
- Route menggunakan Closure? → Pindahkan ke Controller.
- Blade panjang >200 baris? → Pecah menjadi component (`<x-...>`).
- JavaScript inline di Blade? → Pindahkan ke `resources/js/` module.
- Model tanpa scope / accessor? → Gunakan `scopePublished()`, `getFormattedPriceAttribute()`.

### 4. Clean Code & SOLID
- Fungsi/method terlalu panjang (>30 baris)? → Refactor.
- Naming buruk? → Gunakan nama yang deskriptif.
- Duplikasi kode? → Ekstrak ke method/trait/component.
- Dead code / komentar tidak berguna? → Hapus.

### 5. Konsistensi
- Ikuti **PSR-12** (PHP), **ESLint** (JS), **Tailwind** / **Bootstrap** (CSS).
- Kolom tabel migration harus sesuai standar (singular table, timestamps, softDeletes).
- Route resource → ikuti `{resource}` singular naming.

---

## 🛠️ Project Context

- **Laravel version**: 13.x
- **Container**: `docker exec RavaaWeb <command>`
- **Admin middleware**: `admin.auth` + `role:admin,admin`
- **Guard admin**: guard `admin`
- **Cache/Redis**: sudah dinonaktifkan (`file` / `sync`)
- **Database**: MariaDB via `mariadb-db-1`
- **Login admin**: `/admin/login` — view `admin.auth.login-standalone`

---

## 📂 Struktur File Penting

| Path | Kegunaan |
|------|----------|
| `routes/web.php` | Frontend + Admin routes |
| `app/Http/Controllers/Admin/` | Controller admin |
| `app/Models/` | Eloquent models |
| `resources/views/frontend/` | Halaman publik |
| `resources/views/admin/` | Halaman admin |
| `app/Http/Middleware/` | Custom middleware |
| `config/auth.php` | Guard & provider auth |
| `bootstrap/app.php` | Middleware alias & config |
| `database/migrations/` | Semua migration |
| `database/seeders/` | Seeder data |

---

## 📝 Format Output Review

Gunakan format berikut untuk respons ke pengguna:

```
## 🔍 Code Review: `path/file`

### ✅ Bagus
- ...

### ⚠️ Masalah
1. **[Kategori]** Deskripsi masalah
   **Saran:** ...
2. ...

### ✨ Rekomendasi tambahan
- ...
```

> **Catatan:** Skill ini hanya **menganalisis & merekomendasikan**. Jangan mengubah kode kecuali pengguna meminta untuk implementasi.

---

*Panggil skill ini dengan `review-code` melalui tool skill.*
