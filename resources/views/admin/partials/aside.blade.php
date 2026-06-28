@php
    $routeName = Route::currentRouteName();
@endphp

<aside class="navbar navbar-vertical navbar-expand-lg navbar-light bg-white glass-sidebar">
    <div class="container-fluid">
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('favicon.ico') }}" height="36" alt="RavaaWeb">
            </a>
        </h1>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#admin-sidebar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="admin-sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-speedometer2"></i></span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <span class="nav-header">Katalog Produk</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-tags"></i></span>
                        <span class="nav-link-title">Kategori Produk</span>
                    </a>
                </li>
                <!-- Add more menu items here -->
                <li class="nav-item mt-3">
                    <a class="nav-link" href="{{ url('/') }}" target="_blank">
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-box-arrow-up-right"></i></span>
                        <span class="nav-link-title">Lihat Website</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
