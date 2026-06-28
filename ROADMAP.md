# RavaaWeb – Roadmap Singkat

Roadmap ini merangkum tahapan utama yang diperlukan untuk mengubah admin‑side menjadi **CMS penuh** untuk katalog produk.

| Fase | Tujuan | Estimasi Waktu |
|------|--------|----------------|
| **0️⃣ Persiapan** | Pastikan environment bersih, migrasi data ke DB, ubah .env (tanpa Redis). | 1 hari |
| **1️⃣ Data‑First Migration** | Seed kategori, produk, banner, pages ke DB. | 2‑3 hari |
| **2️⃣ UI‑Skeleton Admin** | Layout, komponen tabel/modal, pemisahan JS ke Vite. | 3‑4 hari |
| **3️⃣ Refactor Core (Category & Product)** | Livewire table, komponen Blade, media‑picker drag‑drop. | 5‑7 hari |
| **4️⃣ Banner & Home‑Page CMS** | Model `banners`, manager admin, homepage builder. | 3‑4 hari |
| **5️⃣ Settings & Static Pages** | Grouped settings UI, `pages` table + editor WYSIWYG. | 2‑3 hari |
| **6️⃣ Dashboard & Analytics** | Widget statistik, activity log, visitor counter. | 3 hari |
| **7️⃣ Auth & Permissions** | Guard `admin`, `spatie/laravel-permission`. | 2 hari |
| **8️⃣ Testing & QA** | Feature tests untuk CRUD, permission, regression. | 3‑4 hari |
| **9️⃣ UI Upgrade (Optional)** | Tailwind/Filament, dark‑mode, responsive. | 3‑5 hari |

> **Catatan**: Estimasi bersifat perkiraan dan dapat berubah tergantung kompleksitas dan prioritas tim.
