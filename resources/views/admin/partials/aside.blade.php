@php
    $routeName = Route::currentRouteName();
@endphp

<div id="kt_aside"
    class="aside aside-dark aside-hoverable"
    data-kt-drawer="true"
    data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    {{-- Logo --}}
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('admin/assets/media/logos/logo-1-dark.svg') }}"
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
                    <a class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-box-seam fs-2"></i>
                        </span>
                        <span class="menu-title">Semua Produk</span>
                    </a>
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

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}"
                        href="{{ route('admin.media.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-images fs-2"></i>
                        </span>
                        <span class="menu-title">Media Library</span>
                    </a>
                </div>

                {{-- LAYANAN & PORTFOLIO --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Layanan & Portfolio</span>
                    </div>
                </div>

                <div class="menu-item menu-accordion {{ request()->routeIs('admin.services.*') || request()->routeIs('admin.service-categories.*') ? 'show' : '' }}" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-briefcase fs-2"></i>
                        </span>
                        <span class="menu-title">Layanan</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                                href="{{ route('admin.services.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Semua Layanan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.service-categories.*') ? 'active' : '' }}"
                                href="{{ route('admin.service-categories.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Kategori Layanan</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.portfolio-items.*') ? 'active' : '' }}"
                        href="{{ route('admin.portfolio-items.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-collection fs-2"></i>
                        </span>
                        <span class="menu-title">Portfolio Items</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"
                        href="{{ route('admin.testimonials.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-chat-square-text fs-2"></i>
                        </span>
                        <span class="menu-title">Testimonial</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}"
                        href="{{ route('admin.faq.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-patch-question fs-2"></i>
                        </span>
                        <span class="menu-title">FAQ</span>
                    </a>
                </div>

                {{-- KONTEN WEBSITE (CMS) --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Konten Website</span>
                    </div>
                </div>

                @php
                    $cmsActive = request()->routeIs('admin.cms.*') || request()->routeIs('admin.home.*') || request()->routeIs('admin.software.*');
                @endphp
                <div class="menu-item menu-accordion {{ $cmsActive ? 'show' : '' }}" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-window-sidebar fs-2"></i>
                        </span>
                        <span class="menu-title">Manajemen Halaman</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.home.banner') ? 'active' : '' }}"
                                href="{{ route('admin.home.banner') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Home Page</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.software.hero') ? 'active' : '' }}"
                                href="{{ route('admin.software.hero') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Software House</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.contact.index') ? 'active' : '' }}"
                                href="{{ route('admin.contact.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Contact Page</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- INTERAKSI --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Interaksi</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.form-submissions.*') ? 'active' : '' }}"
                        href="{{ route('admin.form-submissions.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-envelope-open fs-2"></i>
                        </span>
                        <span class="menu-title">Pesan Masuk</span>
                        <span class="menu-badge">
                            <span class="badge badge-light-danger">3</span>
                        </span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}"
                        href="{{ route('admin.statistics.traffic') }}">
                        <span class="menu-icon">
                            <i class="bi bi-graph-up-arrow fs-2"></i>
                        </span>
                        <span class="menu-title">Statistik</span>
                    </a>
                </div>

                {{-- SISTEM --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Sistem</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-sliders fs-2"></i>
                        </span>
                        <span class="menu-title">Pengaturan Web</span>
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