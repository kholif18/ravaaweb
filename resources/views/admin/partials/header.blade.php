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
        <input type="text" class="header-search-input" id="headerSearchInput" placeholder="Cari sesuatu..." autocomplete="off">
        <button class="header-btn" id="headerSearchBtn" title="Pencarian">
            <i class="bi bi-search" style="font-size: 0.9rem;"></i>
        </button>
    </div>

    {{-- Notification --}}
    <button class="header-btn" title="Notifikasi">
        <i class="bi bi-bell" style="font-size: 0.9rem;"></i>
        <span class="notification-dot"></span>
    </button>

    {{-- User Dropdown --}}
    <div class="dropdown">
        <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar" style="background-image: url('{{ asset('images/default-image.png') }}')"></div>
            <div class="user-info d-none d-md-flex">
                <span class="user-name">{{ auth()->guard('admin')->user()->name ?? 'Admin' }}</span>
                <span class="user-role">Administrator</span>
            </div>
            <i class="bi bi-chevron-down d-none d-md-inline" style="font-size: 0.65rem; color: var(--text-muted);"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="#">
                    <i class="bi bi-person"></i> <span class="dropdown-item-text">Profil Saya</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="bi bi-gear"></i> <span class="dropdown-item-text">Pengaturan</span>
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> <span class="dropdown-item-text">Keluar</span>
                </a>
            </li>
        </ul>
    </div>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>
