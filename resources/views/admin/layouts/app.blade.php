<!DOCTYPE html>
<html lang="en">
@include('admin.partials.head')

<body class="admin-body">

<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">

        {{-- Sidebar --}}
        @include('admin.partials.aside')

        {{-- Wrapper --}}
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

            {{-- Header --}}
            @include('admin.partials.header')

            {{-- Content --}}
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('admin.partials.footer')

        </div>
    </div>
</div>



{{-- Scripts harus di-load SEBELUM custom script --}}
@include('admin.partials.scripts')





@stack('scripts')
</body>
</html>