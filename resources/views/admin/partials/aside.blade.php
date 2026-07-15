@php
    $routeName = Route::currentRouteName();

    // Helper: check if current route matches any in the group
    if (!function_exists('isGroupActive')) {
        function isGroupActive($patterns) {
            foreach ($patterns as $p) {
                if (request()->routeIs($p) || request()->is($p)) return true;
            }
            return false;
        }
    }

    $groups = [
        'katalog' => [
            'icon' => 'bi-box-seam',
            'label' => 'Katalog',
            'routes' => ['admin.categories.*', 'admin.tags.*', 'admin.products.*'],
            'children' => [
                ['icon' => 'bi-folder2-open', 'label' => 'Kategori Produk', 'route' => 'admin.categories.index'],
                ['icon' => 'bi-tags', 'label' => 'Tag Produk', 'route' => 'admin.tags.index'],
                ['icon' => 'bi-box', 'label' => 'Produk', 'route' => 'admin.products.index'],
            ],
        ],
        'konten' => [
            'icon' => 'bi-layout-text-window',
            'label' => 'Konten Website',
            'routes' => ['admin.services.*', 'admin.portfolio.*', 'admin.testimonials.*', 'admin.banners.*', 'admin.contact-submissions.*', 'admin/home*', 'admin/software-house*'],
            'children' => [
                ['icon' => 'bi-headset', 'label' => 'Layanan', 'route' => 'admin.services.index'],
                ['icon' => 'bi-briefcase', 'label' => 'Portfolio', 'route' => 'admin.portfolio.index'],
                ['icon' => 'bi-chat-quote', 'label' => 'Testimoni', 'route' => 'admin.testimonials.index'],
                ['icon' => 'bi-images', 'label' => 'Banner / Hero', 'route' => 'admin.banners.index'],
                ['icon' => 'bi-envelope', 'label' => 'Pesan Masuk', 'route' => 'admin.contact-submissions.index'],
                ['icon' => 'bi-layout-three-columns', 'label' => 'Home Builder', 'route' => 'admin.home.index'],
                ['icon' => 'bi-laptop', 'label' => 'Software House', 'route' => 'admin.software-house.index'],
            ],
        ],
        'pengaturan' => [
            'icon' => 'bi-gear-wide-connected',
            'label' => 'Pengaturan',
            'routes' => ['admin.settings.*', 'admin.footer-links.*', 'admin.users.*', 'admin.roles.*'],
            'children' => [
                ['icon' => 'bi-gear', 'label' => 'Pengaturan Umum', 'route' => 'admin.settings.index'],
                ['icon' => 'bi-link-45deg', 'label' => 'Footer Links', 'route' => 'admin.footer-links.index'],
                ['icon' => 'bi-people', 'label' => 'Users', 'route' => 'admin.users.index'],
                ['icon' => 'bi-shield-check', 'label' => 'Role & Permission', 'route' => 'admin.roles.index'],
            ],
        ],
        'tools' => [
            'icon' => 'bi-tools',
            'label' => 'Tools',
            'routes' => ['admin.media.*', 'admin.reports.*', 'admin/logs*'],
            'children' => [
                ['icon' => 'bi-folder', 'label' => 'Media Library', 'route' => 'admin.media.index'],
                ['icon' => 'bi-graph-up', 'label' => 'Laporan & Analytics', 'route' => 'admin.reports.index'],
                ['icon' => 'bi-journal-text', 'label' => 'System Logs', 'route' => 'admin.logs.index'],
            ],
        ],
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
    {{-- Dashboard --}}
    <ul class="nav-item">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    {{-- Menu Groups --}}
    @foreach($groups as $key => $group)
    @php
        $isActive = isGroupActive($group['routes']);
        $hasChildActive = false;
        foreach ($group['children'] as $child) {
            if (request()->routeIs($child['route'])) { $hasChildActive = true; break; }
        }
    @endphp
    <ul class="nav-item nav-group">
        <li>
            <a class="nav-link nav-group-toggle {{ $isActive ? 'active' : '' }} {{ $isActive && !$hasChildActive ? 'expanded-open' : '' }}" href="#" data-group="{{ $key }}">
                <i class="{{ $group['icon'] }}"></i>
                <span>{{ $group['label'] }}</span>
                <i class="bi bi-chevron-down nav-group-arrow {{ $isActive ? 'rotated' : '' }}"></i>
            </a>
            <div class="nav-group-children {{ $isActive ? 'expanded' : '' }}" id="group-{{ $key }}">
                @foreach($group['children'] as $child)
                <a class="nav-link nav-child-link {{ request()->routeIs($child['route']) ? 'active' : '' }}" href="{{ route($child['route']) }}">
                    <i class="{{ $child['icon'] }}"></i>
                    <span>{{ $child['label'] }}</span>
                </a>
                @endforeach
            </div>
        </li>
    </ul>
    @endforeach

    {{-- Lihat Website --}}
    <ul class="nav-item" style="margin-top:4px;">
        <li>
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Website</span>
            </a>
        </li>
    </ul>
</nav>


