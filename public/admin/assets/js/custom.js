// Custom error handling untuk Metronic
(function () {
    'use strict';

    // Override snakeToCamel untuk handle undefined
    if (typeof KTUtil !== 'undefined' && typeof KTUtil.snakeToCamel === 'function') {
        var originalSnakeToCamel = KTUtil.snakeToCamel;
        KTUtil.snakeToCamel = function (s) {
            if (!s || typeof s !== 'string') {
                return '';
            }
            return originalSnakeToCamel.call(this, s);
        };
    }

    // Safe scroll initialization
    function initSafeScroll() {
        try {
            if (typeof KTScroll !== 'undefined') {
                KTScroll.init();
            }
        } catch (error) {
            console.warn('KTScroll init error:', error);
        }
    }

    // Safe drawer initialization
    function initSafeDrawer() {
        try {
            if (typeof KTDrawer !== 'undefined') {
                KTDrawer.init();
            }
        } catch (error) {
            console.warn('KTDrawer init error:', error);
        }
    }

    // Safe menu initialization
    function initSafeMenu() {
        try {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.init();
            }
        } catch (error) {
            console.warn('KTMenu init error:', error);
        }
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        // Delay initialization to ensure all elements are loaded
        setTimeout(function () {
            initSafeScroll();
            initSafeDrawer();
            initSafeMenu();

            // Initialize tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }, 300);
    });

})();