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
        <!-- PERBAIKAN DI SINI: Tambahkan ID pada wrapper -->
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

                {{-- Dashboard --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">
                            <i class="bi bi-speedometer2 fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                {{-- Konten Halaman --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Konten Halaman</span>
                    </div>
                </div>

                {{-- Home Page Accordion --}}
                <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-house fs-2"></i>
                        </span>
                        <span class="menu-title">Home Page</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.home.banner') ? 'active' : '' }}"
                                href="{{ route('admin.home.banner') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Banner Hero</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.home.categories') ? 'active' : '' }}"
                                href="{{ route('admin.home.categories') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Service Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.home.promo') ? 'active' : '' }}"
                                href="{{ route('admin.home.promo') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Promo Banner</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.home.featured') ? 'active' : '' }}"
                                href="{{ route('admin.home.featured') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Featured Products</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Layanan Page Accordion --}}
                <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-gear fs-2"></i>
                        </span>
                        <span class="menu-title">Layanan Page</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.services.categories') ? 'active' : '' }}"
                                href="{{ route('admin.services.categories') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Service Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.services.content') ? 'active' : '' }}"
                                href="{{ route('admin.services.content') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Service Content</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.services.faq') ? 'active' : '' }}"
                                href="{{ route('admin.services.faq') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">FAQ Section</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.services.process') ? 'active' : '' }}"
                                href="{{ route('admin.services.process') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Process Section</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Produk Page Accordion --}}
                <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-box-seam fs-2"></i>
                        </span>
                        <span class="menu-title">Produk Page</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.products.categories') ? 'active' : '' }}"
                                href="{{ route('admin.products-page.categories') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Product Categories</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.products.grid') ? 'active' : '' }}"
                                href="{{ route('admin.products-page.grid') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Product Grid/List</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.products.promo') ? 'active' : '' }}"
                                href="{{ route('admin.products-page.promo') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Promo Banner</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Portfolio Page Accordion --}}
                <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-images fs-2"></i>
                        </span>
                        <span class="menu-title">Portfolio Page</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.portfolio-page.items') ? 'active' : '' }}"
                                href="{{ route('admin.portfolio-page.items') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Portfolio Items</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.portfolio-page.filter') ? 'active' : '' }}"
                                href="{{ route('admin.portfolio-page.filter') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Portfolio Filter</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.portfolio-page.testimonials') ? 'active' : '' }}"
                                href="{{ route('admin.portfolio-page.testimonials') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Testimonials Slider</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.portfolio-page.stats') ? 'active' : '' }}"
                                href="{{ route('admin.portfolio-page.stats') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Stats Counter</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Software House Page Accordion --}}
                <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-code-slash fs-2"></i>
                        </span>
                        <span class="menu-title">Software House</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.software.services') ? 'active' : '' }}"
                                href="{{ route('admin.software.services') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tech Services</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.software.stack') ? 'active' : '' }}"
                                href="{{ route('admin.software.stack') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tech Stack</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.software.portfolio') ? 'active' : '' }}"
                                href="{{ route('admin.software.portfolio') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tech Portfolio</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.software.pricing') ? 'active' : '' }}"
                                href="{{ route('admin.software.pricing') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pricing Plans</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Contact Page (Single Item) --}}
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}"
                        href="{{ route('admin.contact.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-telephone fs-2"></i>
                        </span>
                        <span class="menu-title">Contact Page</span>
                    </a>
                </div>

                {{-- Manajemen Produk --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Manajemen Produk</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-boxes fs-2"></i>
                        </span>
                        <span class="menu-title">Semua Produk</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                        href="{{ route('admin.products.create') }}">
                        <span class="menu-icon">
                            <i class="bi bi-plus-circle fs-2"></i>
                        </span>
                        <span class="menu-title">Tambah Produk</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-tags fs-2"></i>
                        </span>
                        <span class="menu-title">Kategori Produk</span>
                    </a>
                </div>

                {{-- Manajemen Konten --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Manajemen Konten</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.portfolio-items.index') ? 'active' : '' }}"
                        href="{{ route('admin.portfolio-items.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-card-image fs-2"></i>
                        </span>
                        <span class="menu-title">Portfolio Items</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.testimonials.index') ? 'active' : '' }}"
                        href="{{ route('admin.testimonials.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-chat-left-text fs-2"></i>
                        </span>
                        <span class="menu-title">Testimonials</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.faq.index') ? 'active' : '' }}"
                        href="{{ route('admin.faq.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-question-circle fs-2"></i>
                        </span>
                        <span class="menu-title">FAQ Management</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.form-submissions.index') ? 'active' : '' }}"
                        href="{{ route('admin.form-submissions.index') }}">
                        <span class="menu-icon">
                            <i class="bi bi-inbox fs-2"></i>
                        </span>
                        <span class="menu-title">Form Submissions</span>
                        <span class="menu-badge">
                            <span class="badge badge-light-danger">3</span>
                        </span>
                    </a>
                </div>

                {{-- Pengaturan --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Pengaturan</span>
                    </div>
                </div>

                <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-gear fs-2"></i>
                        </span>
                        <span class="menu-title">Website Settings</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}"
                                href="{{ route('admin.settings.general') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">General Settings</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.settings.contact') ? 'active' : '' }}"
                                href="{{ route('admin.settings.contact') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Contact Info</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.settings.social') ? 'active' : '' }}"
                                href="{{ route('admin.settings.social') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Social Media</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.settings.promo') ? 'active' : '' }}"
                                href="{{ route('admin.settings.promo') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Promo & Diskon</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('admin.settings.email') ? 'active' : '' }}"
                                href="{{ route('admin.settings.email') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Email Settings</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Statistik</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.statistics.traffic') ? 'active' : '' }}"
                        href="{{ route('admin.statistics.traffic') }}">
                        <span class="menu-icon">
                            <i class="bi bi-bar-chart fs-2"></i>
                        </span>
                        <span class="menu-title">Website Traffic</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.statistics.analytics') ? 'active' : '' }}"
                        href="#">
                        <span class="menu-icon">
                            <i class="bi bi-eye fs-2"></i>
                        </span>
                        <span class="menu-title">Page Views</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a href="{{ url('/') }}" class="btn btn-custom btn-primary w-100" target="_blank" 
            data-bs-toggle="tooltip" 
            data-bs-trigger="hover" 
            data-bs-dismiss="click" 
            title="View Ravaa Creative Website">
            <span class="btn-label">Ravaa Creative</span>
            <span class="svg-icon btn-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"/>
                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                </svg>
            </span>
        </a>
    </div>
    <!--end::Footer-->
</div>