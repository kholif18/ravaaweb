@php
    $routeName = Route::currentRouteName();
@endphp

<div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <img src="{{ asset('admin/images/logo.png') }}" alt="RavaaWeb">
        <span>RavaaWeb</span>
    </a>
</div>

<nav class="sidebar-nav">
    {{-- Dashboard --}}
    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    {{-- ===== Katalog Produk ===== --}}
    <div class="nav-section">Katalog Produk</div>

    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-folder2-open"></i>
                <span>Kategori Produk</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                <i class="bi bi-tags"></i>
                <span>Tag Produk</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box"></i>
                <span>Produk</span>
            </a>
        </li>
    </ul>

    {{-- ===== Konten Website ===== --}}
    <div class="nav-section">Konten Website</div>

    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                <i class="bi bi-headset"></i>
                <span>Layanan</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}" href="{{ route('admin.portfolio.index') }}">
                <i class="bi bi-briefcase"></i>
                <span>Portfolio</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                <i class="bi bi-images"></i>
                <span>Banner / Hero</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->is('admin/home*') ? 'active' : '' }}" href="#">
                <i class="bi bi-layout-three-columns"></i>
                <span>Home Builder</span>
            </a>
        </li>
    </ul>

    {{-- ===== Pengaturan ===== --}}
    <div class="nav-section">Pengaturan</div>

    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan Umum</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="#">
                <i class="bi bi-people"></i>
                <span>Pengguna Admin</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'active' : '' }}" href="#">
                <i class="bi bi-shield-check"></i>
                <span>Role & Permission</span>
            </a>
        </li>
    </ul>

    {{-- ===== Lainnya ===== --}}
    <div class="nav-section">Lainnya</div>

    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}">
                <i class="bi bi-folder"></i>
                <span>Media Library</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}" href="#">
                <i class="bi bi-bar-chart"></i>
                <span>Laporan</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->is('admin/logs*') ? 'active' : '' }}" href="#">
                <i class="bi bi-journal-text"></i>
                <span>System Logs</span>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Website</span>
            </a>
        </li>
    </ul>
</nav>

<div class="sidebar-footer">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--accent-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="bi bi-person-fill" style="color: var(--accent); font-size: 0.9rem;"></i>
        </div>
        <div style="flex: 1; min-width: 0;">
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ auth()->guard('admin')->user()->name ?? 'Admin' }}
            </div>
            <div style="font-size: 0.68rem; color: var(--text-muted);">admin@ravaa.com</div>
        </div>
    </div>
</div>
