<!DOCTYPE html>
<html lang="id">
@include('admin.partials.head')
<body>

<div id="toastContainer" style="position:fixed;top:1rem;right:1rem;z-index:2000;display:flex;flex-direction:column;gap:0.5rem;"></div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="admin-sidebar" id="adminSidebar">
    @include('admin.partials.aside')
</aside>

<div class="admin-wrapper">
    <header class="admin-header">
        @include('admin.partials.header')
    </header>

    <main class="admin-content">
        @yield('content')
    </main>

    <footer class="admin-footer">
        @include('admin.partials.footer')
    </footer>
</div>

@include('admin.partials.scripts')

</body>
</html>
