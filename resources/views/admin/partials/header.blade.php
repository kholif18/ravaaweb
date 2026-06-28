<div class="header-left">
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <span class="brand-text">@yield('title', 'Dashboard')</span>
</div>

<div class="header-right">
    <div class="user-dropdown" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <div class="avatar" style="background-image: url('{{ asset('images/default-image.png') }}')"></div>
        <span class="d-none d-md-inline">User Name</span>
    </div>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>
