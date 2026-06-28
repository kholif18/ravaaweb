
# Skill: Frontend Designer untuk RavaaWeb

Gunakan skill ini ketika pengguna meminta **membuat/mengubah tampilan UI**, **mendesain halaman**, **mengatur layout Blade**, **styling CSS**, **merapikan template**, atau **membuat komponen frontend**.

---

## 🎯 Tujuan

- Membuat dan memodifikasi **tampilan halaman publik** (frontend) dan **panel admin**.
- Menerapkan **macOS Glassmorphism** design system (custom CSS).
- Mengelola **Blade layout, component, partial, dan slot**.
- Memastikan **responsive design** (mobile-first).
- Menjaga **konsistensi UI/UX** di seluruh aplikasi.

---

## 🏗️ Arsitektur Frontend RavaaWeb

### 📁 Struktur View

```
resources/views/
├── frontend/                   # Halaman publik (customer-facing)
│   ├── layouts/
│   │   └── master.blade.php    # Layout utama frontend
│   ├── partials/
│   │   ├── navbar.blade.php    # Navbar / header
│   │   └── footer.blade.php    # Footer
│   ├── home.blade.php          # Beranda
│   ├── product.blade.php       # Daftar produk (grid + filter pills)
│   ├── detail-product.blade.php# Detail produk (gallery, tabs, variants)
│   ├── layanan.blade.php       # Halaman layanan
│   ├── portofolio.blade.php    # Portofolio
│   ├── software-house.blade.php# Software house page (dark glass)
│   └── contact.blade.php       # Halaman kontak
├── admin/                      # Panel admin (Metronic compact)
│   ├── layouts/
│   ├── partials/
│   ├── auth/
│   ├── dashboard/
│   └── categories/
├── components/                 # Blade components reusable
│   └── pagination.blade.php
└── vendor/
```

### 📁 Asset CSS/JS

```
public/frontend/
├── css/
│   └── app.css                 # Design system (macOS Glassmorphism, ~1350 baris)
└── js/
    └── app.js                  # JS utama (mobile menu, gallery, tabs, filter pills)
```

### 🛠️ Tech Stack Frontend

| Teknologi | Kegunaan |
|-----------|----------|
| **Blade** | Templating engine (Laravel) |
| **Custom CSS** | macOS Glassmorphism design system (`public/frontend/css/app.css`) |
| **Font Awesome 6** | Ikon via CDN |
| **Google Fonts (Inter)** | Tipografi via CDN |
| **No framework CSS** | Murni custom CSS, tanpa Bootstrap/Tailwind |

---

## 📐 Aturan & Pola Desain

### 1. Halaman Publik (Frontend)

**Layout utama:** `resources/views/frontend/layouts/master.blade.php`
- Custom CSS dari `public/frontend/css/app.css` via `<link>`.
- Font Awesome + Google Fonts via CDN.
- Struktur: `@yield('content')` atau section.
- Include partials: `@include('frontend.partials.navbar')` dan `footer`.
- **Responsive**: breakpoint 900px, 768px, 640px, 480px via CSS media queries.

**Layout:**
```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Ravaa Creative</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
    @stack('styles')
</head>
<body>
    @include('frontend.partials.navbar')
    <main>@yield('content')</main>
    @include('frontend.partials.footer')
    <script src="{{ asset('frontend/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
```

### 2. Halaman Admin

**Layout utama:** `resources/views/admin/layouts/app.blade.php`
- Gunakan **Metronic compact** (custom).
- Login: `login-standalone.blade.php`.
- Data via dummy di controller atau model.

### 3. Design System (macOS Glassmorphism)

Semua styling via `public/frontend/css/app.css`. Variable di root:

```css
:root {
  --glass-bg: rgba(255, 255, 255, 0.45);
  --glass-border: rgba(255, 255, 255, 0.5);
  --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
  --glass-blur: blur(20px);
  --accent: #0071E3;
  --radius-lg: 20px;
  --radius-full: 9999px;
  --font: -apple-system, 'Inter', system-ui, sans-serif;
}
```

**Key classes:**
- `.glass-card` — frosted glass container
- `.glass-card-dark` — dark mode glass (Software House)
- `.btn`, `.btn-primary`, `.btn-whatsapp`, `.btn-outline` — premium pill buttons
- `.navbar` — sticky glass nav
- `.prod-card` — product grid cards
- `.port-card` — portfolio cards
- `.svc-card` — service cards
- `.filter-pill` — category/type filter pills
- `.badge-baru`, `.badge-diskon`, `.badge-terlaris`, `.badge-popular` — color badges
- `.detail-gallery`, `.detail-panel`, `.detail-tabs` — detail page components

### 4. JavaScript

Semua JS di `public/frontend/js/app.js`:
- Mobile menu (toggle drawer)
- IntersectionObserver fade-up animations
- Hero parallax
- Navbar blur on scroll
- Gallery thumb switcher (click → ganti src)
- Tab switching (Deskripsi / Fitur)
- Variant selector (warna/ukuran)
- Catalog filter pills (click → submit form)

### 5. Responsive Breakpoints

| Max Width | Target |
|-----------|--------|
| 900px | Tablet landscape |
| 768px | Tablet portrait |
| 640px | Mobile |
| 480px | Small mobile |

**Aturan:**
- Product grid: `repeat(auto-fill, minmax(270px, 1fr))` — di <640px jadi `repeat(2, 1fr)`
- Detail layout: 2 kolom di desktop → 1 kolom di <900px
- Navbar links: sembunyi di <900px, hamburger muncul
- Hero: grid `1fr 1fr` → `1fr` di mobile, image di atas

---

## 📱 Komponen Halaman

### Home (`home.blade.php`)
- Hero (judul, CTA, image, floating badge)
- Category grid (3 kolom → 2 → 1)
- Featured products (max 4)
- CTA glass card

### Katalog (`product.blade.php`)
- No page hero — langsung konten
- Search bar (glass, icon)
- Type pills [Semua|Produk|Layanan]
- Category pills (horizontal scroll)
- Product grid (4 kolom desktop, 2 mobile)

### Detail Product (`detail-product.blade.php`)
- Breadcrumb
- Image gallery (main + thumbs, klik ganti)
- Info panel (price, stock, highlight, chips, variants, info grid, CTAs, share)
- Tabs: Deskripsi & Fitur
- Related products

### Software House (`software-house.blade.php`)
- Dark glass gradient (`sh-section` / `sh-card`)
- Service cards with premium icons
- 4-step process
- Filtered portfolio

---

## 🚀 Commands

```bash
# Run inside Docker container
docker exec f3dd6e5d80bd php artisan view:clear

# Check route list
docker exec f3dd6e5d80bd php artisan route:list

# Run migrations
docker exec f3dd6e5d80bd php artisan migrate

# Seed database
docker exec f3dd6e5d80bd php artisan db:seed
```

---

## ⚠️ Aturan Penting untuk AI

1. **Halaman publik** → gunakan custom CSS glassmorphism (`public/frontend/css/app.css`).
2. **Halaman admin** → Metronic compact.
3. **Semua variabel design** di CSS root variable — jangan hardcode.
4. **Tidak ada Bootstrap/Tailwind** di frontend — murni custom CSS.
5. **WhatsApp CTA** — semua tombol WA pakai `https://wa.me/6282233377661?text=...`.
6. **Gallery JS** — pakai `data-src` di thumb, update `src` main image via JS.
7. **Responsive** — gunakan media queries di CSS, bukan framework.
8. **Animasi** — `fade-up` via IntersectionObserver, parallax via scroll event.
