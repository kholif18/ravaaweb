<!DOCTYPE html>
<html lang="en">
@include('admin.partials.head')

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed
            aside-enabled aside-fixed">

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

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>
</div>

{{-- Scripts harus di-load SEBELUM custom script --}}
@include('admin.partials.scripts')

{{-- Custom Script untuk handle error --}}
<script>
    // Fix untuk error snakeToCamel
    if (typeof KTUtil !== 'undefined' && typeof KTUtil.snakeToCamel === 'function') {
        var originalSnakeToCamel = KTUtil.snakeToCamel;
        KTUtil.snakeToCamel = function(s) {
            if (!s || typeof s !== 'string') {
                return '';
            }
            return originalSnakeToCamel.call(this, s);
        };
    }
    
    // Safe initialization function
    function safeMetronicInit() {
        try {
            // Initialize Theme Mode
            if (typeof KTThemeMode !== 'undefined') {
                KTThemeMode.init();
            }
            
            // Initialize Drawer
            if (typeof KTDrawer !== 'undefined') {
                const drawerElement = document.querySelector("#kt_aside");
                if (drawerElement) {
                    KTDrawer.createInstances();
                }
            }
            
            // Initialize Menu
            if (typeof KTMenu !== 'undefined') {
                const menuElement = document.querySelector("#kt_aside_menu");
                if (menuElement) {
                    KTMenu.createInstances();
                }
            }
            
            // Initialize Scroll - dengan error handling
            if (typeof KTScroll !== 'undefined') {
                const scrollElements = document.querySelectorAll('[data-kt-scroll="true"]');
                scrollElements.forEach(function(el) {
                    try {
                        // Periksa elemen yang valid
                        if (el && el.parentNode) {
                            const instance = KTScroll.getInstance(el);
                            if (!instance) {
                                new KTScroll(el);
                            }
                        }
                    } catch (err) {
                        console.warn('KTScroll init error for element:', el, err);
                        // Nonaktifkan scroll untuk elemen ini
                        el.removeAttribute('data-kt-scroll');
                    }
                });
            }
            
            // Initialize Tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
            
        } catch (error) {
            console.error('Metronic initialization error:', error);
        }
    }
    
    // Wait for everything to load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(safeMetronicInit, 500);
        });
    } else {
        setTimeout(safeMetronicInit, 500);
    }
</script>

{{-- Alternative: Nonaktifkan scroll jika masih error --}}
<script>
    // Fallback: Jika masih error, nonaktifkan scroll plugin
    setTimeout(function() {
        const errorElement = document.querySelector('[data-kt-scroll="true"]');
        if (errorElement && typeof KTScroll === 'undefined') {
            errorElement.removeAttribute('data-kt-scroll');
            console.log('Disabled KTScroll plugin due to initialization error');
        }
    }, 1000);
</script>

@stack('scripts')
</body>
</html>