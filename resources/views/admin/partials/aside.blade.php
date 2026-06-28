@php
    $routeName = Route::currentRouteName();
@endphp

<div class="admin-sidebar">

    {{-- Logo --}}
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('favicon.ico') }}"
                class="h-25px logo"
                alt="RavaaWeb">
        </a>
    </div>

    {{-- Menu --}}
    <div class="aside-menu flex-column-fluid">
        <div id="kt_aside_menu_wrapper"
            class="hover-scroll-overlay-y my-5 my-lg-5"
            data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">

            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" 
                id="kt_aside_menu" 
                data-kt-menu="true">

                {{-- DASHBOARD --}}
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">
                            <i class="bi bi-grid-fill fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                {{-- KATALOG PRODUK --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Katalog Produk</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-tags fs-2"></i>
                        </span>
                        <span class="menu-title">Kategori Produk</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a href="{{ url('/') }}" class="btn btn-custom btn-primary w-100" target="_blank">
            <span class="btn-label">Lihat Website</span>
            <span class="svg-icon btn-icon svg-icon-2">
                <i class="bi bi-arrow-up-right-square"></i>
            </span>
        </a>
    </div>
</div>
