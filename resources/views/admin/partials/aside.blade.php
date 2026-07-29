@php
    // All menu items — flat, no groups
    $menus = [
        ['icon' => 'bi-grid-1x2', 'label' => 'Dashboard', 'route' => 'admin.dashboard', 'section' => ''],

        // Katalog
        ['icon' => 'bi-folder2-open', 'label' => 'Kategori Produk', 'route' => 'admin.categories.index', 'section' => 'Katalog'],
        ['icon' => 'bi-tags', 'label' => 'Tag Produk', 'route' => 'admin.tags.index', 'section' => ''],
        ['icon' => 'bi-box', 'label' => 'Produk', 'route' => 'admin.products.index', 'section' => ''],

        // Konten Website
        ['icon' => 'bi-headset', 'label' => 'Layanan', 'route' => 'admin.services.index', 'section' => 'Konten Website'],
        ['icon' => 'bi-briefcase', 'label' => 'Portfolio', 'route' => 'admin.portfolio.index', 'section' => ''],
        ['icon' => 'bi-chat-quote', 'label' => 'Testimoni', 'route' => 'admin.testimonials.index', 'section' => ''],
        ['icon' => 'bi-images', 'label' => 'Banner / Hero', 'route' => 'admin.banners.index', 'section' => ''],
        ['icon' => 'bi-envelope', 'label' => 'Pesan Masuk', 'route' => 'admin.contact-submissions.index', 'section' => ''],
        ['icon' => 'bi-cart-check', 'label' => 'Pesanan', 'route' => 'admin.orders.index', 'section' => ''],
        ['icon' => 'bi-layout-three-columns', 'label' => 'Home Builder', 'route' => 'admin.home.index', 'section' => ''],
        ['icon' => 'bi-laptop', 'label' => 'Software House', 'route' => 'admin.software-house.index', 'section' => ''],

        // Pengaturan
        ['icon' => 'bi-gear', 'label' => 'Pengaturan Umum', 'route' => 'admin.settings.index', 'section' => 'Pengaturan'],
        ['icon' => 'bi-list-nested', 'label' => 'Navbar Links', 'route' => 'admin.nav-links.index', 'section' => ''],
        ['icon' => 'bi-link-45deg', 'label' => 'Footer Links', 'route' => 'admin.footer-links.index', 'section' => ''],
        ['icon' => 'bi-people', 'label' => 'Users', 'route' => 'admin.users.index', 'section' => ''],
        ['icon' => 'bi-shield-check', 'label' => 'Role & Permission', 'route' => 'admin.roles.index', 'section' => ''],

        // Tools
        ['icon' => 'bi-folder', 'label' => 'Media Library', 'route' => 'admin.media.index', 'section' => 'Tools'],
        ['icon' => 'bi-graph-up', 'label' => 'Laporan & Analytics', 'route' => 'admin.reports.index', 'section' => ''],
        ['icon' => 'bi-journal-text', 'label' => 'System Logs', 'route' => 'admin.logs.index', 'section' => ''],
    ];
@endphp

<div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        @php
            $logoMediaId = \App\Models\Setting::get('logo_media_id');
            $sidebarLogoUrl = asset('images/logo.svg');
            if ($logoMediaId) {
                $sidebarLogoUrl = \Illuminate\Support\Facades\Cache::remember('logo_url_' . $logoMediaId, 3600, function () use ($logoMediaId) {
                    return \App\Models\Media::find($logoMediaId)?->url ?? asset('images/logo.svg');
                });
            }
        @endphp
        <img src="{{ $sidebarLogoUrl }}" alt="RavaaWeb" style="height: 32px; width: auto; object-fit: contain;">
        <span>RavaaWeb</span>
    </a>
</div>

<nav class="sidebar-nav">
    <ul class="nav-item">
        @foreach($menus as $item)
            @if($item['section'])
                <li class="nav-section">{{ $item['section'] }}</li>
            @endif
            <li>
                <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach

        <li style="margin-top: 4px;">
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Website</span>
            </a>
        </li>
    </ul>
</nav>
