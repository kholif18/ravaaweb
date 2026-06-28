<!DOCTYPE html>
<html lang="en">
@include('admin.partials.head')

<body class="layout-navbars-fixed layout-sidebar-fixed admin-body">

<div class="page">
    {{-- Vertical sidebar --}}
    @include('admin.partials.aside')

    {{-- Main page wrapper --}}
    <div class="page-wrapper">
        {{-- Top header --}}
        @include('admin.partials.header')

        {{-- Page content --}}
        <div class="page-body">
            <div class="container-xl">
                @yield('content')
            </div>
        </div>

        {{-- Footer --}}
        @include('admin.partials.footer')
    </div>
</div>

@include('admin.partials.scripts')
@stack('scripts')
</body>
</html>