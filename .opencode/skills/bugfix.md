
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

### Langkah 2: Lacak Penyebab
Gunakan informasi dari stack trace untuk menemukan lokasi error:
- Cari class/method yang disebut
- Baca file yang relevan untuk memahami konteks

### Langkah 3: Analisis Root Cause

| Jenis Bug | Ciri-ciri | Fix Umum |
|-----------|-----------|----------|
| **Syntax Error** | Parse error, unexpected token | Typo, `;` hilang, bracket tidak seimbang |
| **Undefined variable** | `Undefined variable: x` | Inisialisasi variable / passing data ke view |
| **Method not found** | `Call to undefined method` | Method belum ada / typo nama method |
| **Query error** | SQLSTATE, column not found | Cek nama kolom di migration vs query |
| **Relation error** | `Call to undefined relationship` | Relasi belum didefinisikan di Model |
| **MassAssignment** | `Add [field] to fillable` | Tambah field ke `$fillable` |
| **View/Blade** | `View [x] not found` | Cek path & nama file blade |
| **N+1 Query** | Slow queries, memory leak | Tambah `->with()` eager loading |
| **JS Error** | `Unexpected end of input` | Bracket/brace tidak seimbang di JS |
| **Null path** | `must be of type string, null` | Tambah null check sebelum akses property |

### Langkah 4: Implementasi Fix
- Edit **minimal hanya baris yang diperlukan**.
- Jangan mengubah kode yang tidak terkait dengan bug.

### Langkah 5: Bersihkan Cache
```bash
docker exec RavaaWeb php artisan view:clear
docker exec RavaaWeb php artisan config:clear
```

### Langkah 6: Validasi
- Coba akses ulang halaman / fitur yang sebelumnya error.
- Cek tidak ada error baru di log.

### Langkah 7: Commit (jika diminta)
```bash
git add -A
git commit -m "fix: deskripsi singkat"
```

---

## 🛠️ Tools & Commands Penting

```bash
# Log error
docker exec RavaaWeb tail -100 storage/logs/laravel.log

# Clear cache
docker exec RavaaWeb php artisan view:clear
docker exec RavaaWeb php artisan config:clear

# Tinker (debug cepat)
docker exec RavaaWeb php artisan tinker

# Route list
docker exec RavaaWeb php artisan route:list
```

---

## 🔍 Debug Cepat dengan Tinker

```bash
docker exec RavaaWeb php artisan tinker
```

```php
App\Models\Product::count();
App\Models\Product::with('category')->first();
App\Models\Media::whereNull('path')->pluck('id');
auth()->guard('admin')->user();
```

---

*Panggil skill ini dengan `bugfix` melalui tool skill.*
