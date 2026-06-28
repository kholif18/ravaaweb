
# Skill: Bug Fixer untuk RavaaWeb

Gunakan skill ini ketika pengguna melaporkan **error**, **bug**, **exception**, **halaman error**, **fitur tidak berfungsi**, atau **hasil tidak sesuai**.

> ⛔ Jangan gunakan skill ini untuk **review kode** umum — gunakan skill **review-code**.

---

## 🎯 Tujuan

- Mendiagnosis **penyebab root** (root cause) dari error atau bug.
- **Memperbaiki bug** dengan mengubah kode secara langsung.
- **Memvalidasi** bahwa fix berhasil tanpa menimbulkan regression.

---

## 🐛 Alur Fix Bug (Wajib Diikuti)

### Langkah 1: Reproduce & Kumpulkan Informasi
Baca log error terbaru:
```bash
docker exec RavaaWeb tail -50 storage/logs/laravel.log
```

Tanyakan ke pengguna (jika perlu):
- URL / halaman apa yang error?
- Langkah apa yang dilakukan sebelum error?
- Pesan error yang muncul?

### Langkah 2: Lacak Penyebab
Gunakan informasi dari stack trace untuk menemukan lokasi error:
- Cari class/method yang disebut: `grep -rn 'ClassName' app/`
- Cari string error unik: `grep -rn 'unique error message' resources/ views/ config/`
- Baca file yang relevan untuk memahami konteks.

### Langkah 3: Analisis Root Cause
Kategorikan bug:

| Jenis Bug | Ciri-ciri | Fix Umum |
|-----------|-----------|----------|
| **Syntax Error** | Parse error, unexpected token | Typo, `;` hilang, bracket tidak seimbang |
| **Missing import/use** | Class "X" not found | Tambah `use` statement |
| **Namespace salah** | Class "X" not found di path Y | Cek namespace & folder |
| **Undefined variable** | `Undefined variable: x` | Inisialisasi variable / passing data ke view |
| **Method not found** | `Call to undefined method` | Method belum ada / typo nama method |
| **Query error** | SQLSTATE, column not found | Cek nama kolom di migration vs query |
| **Relation error** | `Call to undefined relationship` | Relasi belum didefinisikan di Model |
| **MassAssignment** | `Add [field] to fillable property` | Tambah field ke `$fillable` |
| **Authorization** | `403`, `This action is unauthorized` | Cek Policy / Gate |
| **Middleware** | Redirect loop, 500 | Cek urutan middleware, guard name |
| **View/Blade** | `View [x] not found` | Cek path & nama file blade |
| **Asset/JS/CSS** | 404 asset, broken layout | Cek path Vite/mix manifest |
| **Environment** | Config tidak生效 | `config:clear`, `.env` typo |

### Langkah 4: Implementasi Fix
- Edit **minimal hanya baris yang diperlukan**.
- Jangan mengubah kode yang tidak terkait dengan bug.
- Ikuti standar koding project (PSR-12, naming convention).

### Langkah 5: Bersihkan Cache
Selalu jalankan setelah fix:
```bash
docker exec RavaaWeb php artisan config:clear
docker exec RavaaWeb php artisan cache:clear
docker exec RavaaWeb php artisan route:clear
docker exec RavaaWeb php artisan view:clear
```

### Langkah 6: Validasi
- Coba akses ulang halaman / fitur yang sebelumnya error.
- Jika ada test terkait, jalankan:
  ```bash
  docker exec RavaaWeb php artisan test --filter=NamaTest
  ```

- Jika test tidak ada, lakukan pengecekan manual:
  - Halaman tidak 500/404
  - Data muncul sesuai
  - Tidak ada error baru di log

### Langkah 7: Laporkan ke Pengguna
Beri laporan singkat:
```
## 🐛 Bug Fix Laporan

**File:** `app/Http/Controllers/X.php`
**Masalah:** [jelaskan root cause]
**Fix:** [jelaskan apa yang diubah]
**Status:** ✅ Fixed / ❌ Perlu bantuan lanjutan
```

### Langkah 8: Commit (jika diminta)
```bash
git add -A
git commit -m "fix: deskripsi singkat"
```

---

## 🛠️ Tools & Commands Penting

```bash
# Melihat log error
docker exec RavaaWeb tail -100 storage/logs/laravel.log

# Clear cache
docker exec RavaaWeb php artisan config:clear
docker exec RavaaWeb php artisan cache:clear
docker exec RavaaWeb php artisan route:clear
docker exec RavaaWeb php artisan view:clear

# Tinker (debug cepat)
docker exec RavaaWeb php artisan tinker

# Test
docker exec RavaaWeb php artisan test

# Migrate fresh
docker exec RavaaWeb php artisan migrate:fresh --seed
```

---

## 🧪 Debug Cepat dengan Tinker

Gunakan `tinker` untuk cek data / logic tanpa browser:

```bash
docker exec RavaaWeb php artisan tinker
```

Contoh perintah tinker:
```php
App\Models\Product::count();
App\Models\Product::with('category')->first();
auth()->guard('admin')->user();
app()->make('App\Services\ProductService')->getAll();
```

---

## ⚠️ Hal yang Perlu Diperhatikan

- **Jangan hapus data** production tanpa backup.
- **Jangan ubah `.env`** secara langsung jika tidak yakin.
- Jika fix tidak jelas, tanyakan lebih detail ke pengguna.
- Jika bug kompleks (melibatkan banyak file), buat **branch terpisah**.
- Jika perubahan membutuhkan migration baru, informasikan ke pengguna.

---

*Panggil skill ini dengan `bugfix` melalui tool skill.*
