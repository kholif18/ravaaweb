@php
    $routeName = Route::currentRouteName();
@endphp

<div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <img src="{{ asset('favicon.ico') }}" alt="RavaaWeb">
        <span>RavaaWeb</span>
    </a>
</div>

<nav class="sidebar-nav">
    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <div class="nav-section">Katalog Produk</div>

    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tags"></i>
                <span>Kategori Produk</span>
            </a>
        </li>
    </ul>

    <div class="nav-section">Lainnya</div>

    <ul class="nav-item">
        <li>
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Website</span>
            </a>
        </li>
    </ul>
</nav>

<div class="sidebar-footer">
    <small class="text-muted">&copy; {{ date('Y') }} Ravaa Creative</small>
</div>
