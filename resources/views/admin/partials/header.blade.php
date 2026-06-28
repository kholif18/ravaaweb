@php
    $routeName = Route::currentRouteName();
@endphp

<header class="navbar navbar-expand-md navbar-light d-print-none glass-header">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('favicon.ico') }}" height="30" alt="RavaaWeb">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#admin-topbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="admin-topbar-menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex align-items-center" data-bs-toggle="dropdown">
                        <span class="avatar avatar-sm" style="background-image: url('{{ asset('images/default-image.png') }}')"></span>
                        <span class="ms-2 d-none d-lg-block">User Name</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</header>
