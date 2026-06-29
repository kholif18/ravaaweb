
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
- SQL Injection? → Pastikan pakai Eloquent / Query Builder binding.
- XSS? → Blade auto-escape (`{{ }}`), pastikan tidak ada `{!! !!}` tanpa sanitasi.
- CSRF? → Setiap form POST harus `@csrf`.
- Mass Assignment? → Cek `$fillable` / `$guarded` di Model.
- Authorization? → Pastikan resource `Policy` atau `Gate` digunakan.
- File Upload? → Validasi ekstensi, ukuran, path traversal.

### 2. Kinerja (Performance)
- N+1 Query? → Pastikan `->with()` untuk eager loading.
- Query besar tanpa pagination? → Gunakan `->paginate()`.
- Loop DB query? → Jangan query di dalam Blade atau loop.
- Cache? → Data statis sebaiknya di-cache.

### 3. Best Practice Laravel
- Controller tebal? → Pindahkan logic ke **Service** / **Action** class.
- Route menggunakan Closure? → Pindahkan ke Controller.
- Blade panjang >200 baris? → Pecah menjadi component (`<x-...>`).
- Model tanpa scope / accessor? → Gunakan scope & accessor.

### 4. Clean Code
- Fungsi/method terlalu panjang (>30 baris)? → Refactor.
- Naming buruk? → Gunakan nama yang deskriptif.
- Duplikasi kode? → Ekstrak ke method/trait/component.

---

## 🛠️ Project Context

| Item | Value |
|------|-------|
| **Laravel version** | 13.x |
| **PHP version** | 8.3 |
| **Docker container** | `RavaaWeb` |
| **Database** | MariaDB (`mariadb-db-1`) |
| **Admin guard** | `admin` |
| **Admin middleware** | `admin.auth` + `role:admin,admin` |
| **CSS system** | Custom CSS Glassmorphism (NO Bootstrap/Tailwind) |
| **Admin CSS** | `public/admin/css/admin-glass.css` |
| **Frontend CSS** | `public/frontend/css/app.css` |
| **JS functions** | `Ravaa.toast()`, `Ravaa.confirm()`, `Ravaa.alert()` |

---

## 📂 Struktur File Penting

| Path | Kegunaan |
|------|----------|
| `routes/web.php` | Frontend + Admin routes |
| `app/Http/Controllers/Admin/` | Controller admin |
| `app/Models/` | Eloquent models |
| `resources/views/frontend/` | Halaman publik |
| `resources/views/admin/` | Halaman admin |
| `resources/views/components/` | Blade components (pagination, media-picker) |
| `public/admin/css/admin-glass.css` | Admin design system |
| `public/admin/js/app.js` | Admin JS (Ravaa.toast, Ravaa.confirm) |
| `database/migrations/` | Semua migration |
| `database/seeders/` | Seeder data |

---

## 📝 Format Output Review

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
