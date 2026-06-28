<script>
    /**
     * Ravaa Admin Global Helpers & Modular Components
     * Handles: Swal, Toasts, AJAX CSRF, and Common UI actions
     */

    const Ravaa = {
        /**
         * Show SweetAlert confirmation
         */
        confirm: function(title, text, icon = 'warning') {
            return Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light'
                }
            });
        },

        /**
         * Show simple alert
         */
        alert: function(title, text, icon = 'success') {
            return Swal.fire({
                title: title,
                text: text,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        },

        /**
         * Show Toast notification
         */
        toast: function(message, type = 'success') {
            const toastElement = document.getElementById('kt_docs_toast_toggle');
            if (!toastElement) return;

            // Update content and show
            // Note: Metronic uses bootstrap toasts usually
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toastr-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            if (type === 'success') toastr.success(message);
            else if (type === 'error') toastr.error(message);
            else if (type === 'warning') toastr.warning(message);
            else toastr.info(message);
        },

        /**
         * AJAX Delete Helper
         */
        deleteItem: function(url, callback) {
            this.confirm('Hapus Data?', 'Data yang dihapus tidak dapat dikembalikan!')
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Ravaa.toast('Data berhasil dihapus');
                                if (callback) callback(response);
                                else location.reload();
                            },
                            error: function(xhr) {
                                Ravaa.toast('Gagal menghapus data', 'error');
                                console.error(xhr);
                            }
                        });
                    }
                });
        }
    };

    // Setup jQuery AJAX with CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>