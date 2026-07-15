@php $adminUser = auth()->guard('admin')->user(); @endphp

<div class="header-left">
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    @hasSection('breadcrumb')
    <nav>
        <ol class="header-breadcrumb">
            @yield('breadcrumb')
        </ol>
    </nav>
    @else
    <span class="brand-text">@yield('title', 'Dashboard')</span>
    @endif
</div>

<div class="header-right">
    {{-- Search with slide input --}}
    <div class="header-search-wrapper">
        <input type="text" class="header-search-input" id="headerSearchInput" placeholder="Cari produk..." autocomplete="off">
        <button class="header-btn" id="headerSearchBtn" title="Pencarian">
            <i class="bi bi-search" style="font-size: 0.9rem;"></i>
        </button>
    </div>

    {{-- Notification Dropdown --}}
    <div class="dropdown" id="notificationDropdown">
        <button class="header-btn" id="notificationBtn" title="Notifikasi">
            <i class="bi bi-bell" style="font-size: 0.9rem;"></i>
            <span class="notification-dot" id="notificationDot" style="{{ $unreadSubmissionsCount ?? 0 > 0 ? '' : 'display:none;' }}"></span>
        </button>
        <div class="notif-dropdown-menu" id="notifMenu">
            <div class="notif-header">
                <span class="notif-title">Notifikasi</span>
                @if(($unreadSubmissionsCount ?? 0) > 0)
                    <span class="notif-badge">{{ $unreadSubmissionsCount }} baru</span>
                @endif
            </div>
            <div class="notif-body">
                @if(($unreadSubmissionsCount ?? 0) > 0)
                    <a href="{{ route('admin.contact-submissions.index') }}" class="notif-item">
                        <div class="notif-item-icon unread">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="notif-item-content">
                            <span class="notif-item-text">{{ $unreadSubmissionsCount }} pesan kontak belum dibaca</span>
                            <span class="notif-item-time">Lihat pesan masuk</span>
                        </div>
                    </a>
                @else
                    <div class="notif-empty">
                        <i class="bi bi-check-circle"></i>
                        <span>Tidak ada notifikasi</span>
                    </div>
                @endif
            </div>
            <div class="notif-footer">
                <a href="{{ route('admin.contact-submissions.index') }}">Lihat semua notifikasi</a>
            </div>
        </div>
    </div>

    {{-- User Dropdown --}}
    <div class="dropdown" id="userDropdown">
        <div class="user-dropdown" id="userDropdownToggle">
            <div class="avatar" style="background-image: url('{{ $adminUser->avatar_url }}')"></div>
            <div class="user-info d-none d-md-flex">
                <span class="user-name">{{ $adminUser->name ?? 'Admin' }}</span>
                <span class="user-role">Administrator</span>
            </div>
            <i class="bi bi-chevron-down d-none d-md-inline" style="font-size: 0.65rem; color: var(--text-muted);"></i>
        </div>
        <div class="user-dropdown-menu" id="userMenu">
            <div class="user-menu-header">
                <div class="avatar-sm" style="background-image: url('{{ $adminUser->avatar_url }}')"></div>
                <div class="user-menu-info">
                    <span class="user-menu-name">{{ $adminUser->name ?? 'Admin' }}</span>
                    <span class="user-menu-role">{{ $adminUser->email ?? 'admin@ravaa.test' }}</span>
                </div>
            </div>
            <div class="user-menu-divider"></div>
            <a class="user-menu-item" href="{{ route('admin.profile.edit') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Saya</span>
            </a>
            <a class="user-menu-item" href="{{ route('admin.settings.index') }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
            <a class="user-menu-item" href="{{ url('/') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Website</span>
            </a>
            <div class="user-menu-divider"></div>
            <a class="user-menu-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>
