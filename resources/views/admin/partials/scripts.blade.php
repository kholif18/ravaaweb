<!--begin::Javascript-->
<script>
    // Define global variable untuk asset path
    var hostUrl = "{{ asset('admin/assets/') }}";
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('admin/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

<!-- Fix untuk Metronic JS error -->
<script>
    // Patch untuk error di scripts.bundle.js
    (function() {
        // Backup original function
        var originalInit = null;
        
        // Monkey patch untuk handle error
        if (typeof KTScroll !== 'undefined' && KTScroll.init) {
            originalInit = KTScroll.init;
            KTScroll.init = function() {
                try {
                    return originalInit.apply(this, arguments);
                } catch (error) {
                    console.warn('KTScroll init failed, disabling...', error);
                    // Coba nonaktifkan elemen yang bermasalah
                    var scrollElements = document.querySelectorAll('[data-kt-scroll="true"]');
                    scrollElements.forEach(function(el) {
                        el.removeAttribute('data-kt-scroll');
                    });
                    return null;
                }
            };
        }
        
        // Patch untuk snakeToCamel error
        if (typeof KTUtil !== 'undefined' && KTUtil.snakeToCamel) {
            var originalSnakeToCamel = KTUtil.snakeToCamel;
            KTUtil.snakeToCamel = function(s) {
                if (s === undefined || s === null || typeof s !== 'string') {
                    return '';
                }
                return originalSnakeToCamel.call(this, String(s));
            };
        }
    })();
</script>