
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
├── admin/                      # Panel admin (macOS Glassmorphism)
│   ├── layouts/
│   │   └── app.blade.php       # Layout utama admin
│   ├── partials/
│   │   ├── aside.blade.php     # Sidebar navigation
│   │   ├── header.blade.php    # Top header
│   │   ├── footer.blade.php    # Footer
│   │   ├── head.blade.php      # Meta, CSS includes
│   │   └── scripts.blade.php   # JS includes
│   ├── auth/
│   │   └── login-standalone.blade.php
│   ├── dashboard/
│   │   └── index.blade.php
│   ├── categories/
│   │   ├── index.blade.php     # Category list + modals
│   │   └── _table.blade.php    # Table partial
│   ├── tags/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── _table.blade.php
│   ├── media/
│   │   └── index.blade.php     # Media library (grid + list)
│   └── products/
│       ├── index.blade.php     # Product list
│       ├── _table.blade.php    # Compact table
│       ├── create.blade.php    # Create form + media picker
│       └── edit.blade.php      # Edit form + media picker
├── components/                 # Blade components reusable
│   ├── pagination.blade.php    # Pagination with per-page selector
│   └── media-picker.blade.php  # WordPress-style media picker modal
└── vendor/
```

### 📁 Asset CSS/JS

```
public/
├── frontend/
│   ├── css/
│   │   └── app.css             # Design system frontend (macOS Glassmorphism)
│   └── js/
│       └── app.js              # JS frontend (mobile menu, gallery, tabs)
├── admin/
│   ├── css/
│   │   └── admin-glass.css     # Design system admin (macOS Glassmorphism)
│   └── js/
│       └── app.js              # JS admin (dropdowns, Ravaa.toast, Ravaa.confirm)
└── storage/                    # Uploaded files (symlinked)
```

### 🛠️ Tech Stack Frontend

| Teknologi | Kegunaan |
|-----------|----------|
| **Blade** | Templating engine (Laravel) |
| **Custom CSS** | macOS Glassmorphism (frontend: `app.css`, admin: `admin-glass.css`) |
| **Bootstrap Icons** | Ikon via CDN (`bootstrap-icons@1.11.3`) |
| **Font Awesome 6** | Ikon legacy via CDN |
| **Google Fonts (Inter)** | Tipografi via CDN |
| **No CSS framework** | Murni custom CSS, tanpa Bootstrap/Tailwind |
| **jQuery 3.7.1** | Legacy JS (admin) |
| **Bootstrap 5.3.3 JS** | Modal, dropdown (admin only) |
| **ApexCharts** | Dashboard charts (admin) |

---

## 📐 Aturan & Pola Desain

### 1. Halaman Publik (Frontend)

**Layout utama:** `resources/views/frontend/layouts/master.blade.php`
- Custom CSS dari `public/frontend/css/app.css` via `<link>`.
- Font Awesome + Google Fonts via CDN.
- Struktur: `@yield('content')` atau section.
- Include partials: `@include('frontend.partials.navbar')` dan `footer`.
- **Responsive**: breakpoint 900px, 768px, 640px, 480px via CSS media queries.

### 2. Halaman Admin

**Layout utama:** `resources/views/admin/layouts/app.blade.php`
- Custom CSS dari `public/admin/css/admin-glass.css`.
- Include partials: `head`, `aside`, `header`, `footer`, `scripts`.
- **Sidebar**: `admin/partials/aside.blade.php` — navigation menu.
- **Toast**: gunakan `Ravaa.toast(message, type)` — jangan buat custom toast.
- **Confirm**: gunakan `Ravaa.confirm(title, text, icon)` — jangan pakai `confirm()` native.
- **Dropdown**: gunakan Bootstrap 5 Dropdown API (`bootstrap.Dropdown.getInstance().hide()`).

### 3. Design System (macOS Glassmorphism)

#### Frontend (`public/frontend/css/app.css`)

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

**Key classes frontend:**
- `.glass-card` — frosted glass container
- `.glass-card-dark` — dark mode glass (Software House)
- `.btn`, `.btn-primary`, `.btn-whatsapp`, `.btn-outline` — premium pill buttons
- `.navbar` — sticky glass nav
- `.prod-card` — product grid cards
- `.port-card` — portfolio cards
- `.svc-card` — service cards
- `.filter-pill` — category/type filter pills
- `.badge-baru`, `.badge-diskon`, `.badge-terlaris`, `.badge-popular` — color badges

#### Admin (`public/admin/css/admin-glass.css`)

```css
:root {
  --accent: #4f6ef7;
  --accent-light: rgba(79, 110, 247, 0.12);
  --bg-surface: #ffffff;
  --bg-surface-alt: #f8f9fc;
  --bg-surface-hover: rgba(79, 110, 247, 0.04);
  --text-primary: #1a1d2b;
  --text-muted: #7e8299;
  --border-color: rgba(0, 0, 0, 0.06);
  --danger: #ef4444;
  --success: #22c55e;
  --warning: #f59e0b;
  --radius: 12px;
  --font: 'Inter', -apple-system, system-ui, sans-serif;
}
```

**Key classes admin:**
- `.glass-card` — card container dengan glass effect
- `.card-header` / `.card-body` — card sections
- `.admin-sidebar` — sidebar navigation
- `.admin-header` — top header bar
- `.btn-primary`, `.btn-light`, `.btn-icon` — button styles
- `.form-control`, `.form-select` — input styles
- `.table` — table styles
- `.badge` — status badges
- `.ravaa-dialog` — confirm/alert dialog (macOS style)
- `.toast` — notification toast

### 4. JavaScript

#### Frontend (`public/frontend/js/app.js`)
- Mobile menu (toggle drawer)
- IntersectionObserver fade-up animations
- Hero parallax
- Navbar blur on scroll
- Gallery thumb switcher
- Tab switching (Deskripsi / Fitur)
- Variant selector (warna/ukuran)
- Catalog filter pills

#### Admin (`public/admin/js/app.js`)
- `closeAllDropdowns()` — close all Bootstrap dropdowns
- `Ravaa.toast(message, type)` — macOS-style toast notification
- `Ravaa.confirm(title, text, icon)` — macOS-style confirm dialog (returns Promise)
- `Ravaa.alert(title, text, icon)` — macOS-style alert dialog
- Bootstrap 5 Dropdown API integration

### 5. Responsive Breakpoints

| Max Width | Target |
|-----------|--------|
| 900px | Tablet landscape |
| 768px | Tablet portrait |
| 640px | Mobile |
| 480px | Small mobile |

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

### Admin Media Library (`admin/media/index.blade.php`)
- Grid view: thumbnail cards dengan actions
- List view: compact rows (thumbnail, name, size, actions)
- View toggle button (grid/list) dengan localStorage persistence
- Drag-drop upload zone
- Fullscreen gallery overlay (prev/next, keyboard navigation)
- `<x-media-picker>` component untuk form produk

### Admin Products (`admin/products/`)
- Compact table: 32x32 thumbnails, small text, tight padding
- Inline badge colors (matching categories style)
- Media picker integration (WordPress-style)
- Variant management (dynamic add/remove)
- Tag selection (checkboxes)

---

## ⚠️ Aturan Penting untuk AI

1. **Halaman publik** → gunakan custom CSS glassmorphism (`public/frontend/css/app.css`).
2. **Halaman admin** → gunakan custom CSS glassmorphism (`public/admin/css/admin-glass.css`).
3. **Semua variabel design** di CSS root variable — jangan hardcode.
4. **Tidak ada Bootstrap/Tailwind CSS** — murni custom CSS.
5. **Bootstrap JS** hanya untuk modal/dropdown di admin.
6. **Toast** → gunakan `Ravaa.toast()` — jangan buat custom.
7. **Confirm** → gunakan `Ravaa.confirm()` — jangan pakai `confirm()` native.
8. **WhatsApp CTA** — `https://wa.me/6282233377661?text=...`.
9. **Responsive** — gunakan media queries di CSS.
10. **Docker command** → `docker exec RavaaWeb <command>`.
11. **View cache** → `docker exec RavaaWeb php artisan view:clear`.
