<script>
    /**
     * Ravaa Admin — Lightweight bridge to app.js methods
     * All core logic lives in public/admin/js/app.js
     */

    // Ensure window.Ravaa exists (app.js defines toast, confirm, alert, deleteItem)
    window.Ravaa = window.Ravaa || {};

    // Setup jQuery AJAX with CSRF (if jQuery is loaded)
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
</script>
