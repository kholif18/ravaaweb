@extends('admin.layouts.app')

@section('page-title', 'Tambah Produk Baru')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.products.index') }}" class="text-muted text-hover-primary">Semua Produk</a>
    </li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-dark">Tambah Produk</li>
@endsection

@section('content')
<div id="kt_app_content_container" class="app-container container-xxl">
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="bi bi-exclamation-triangle fs-2hx text-danger me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">Terjadi Kesalahan!</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <i class="bi bi-x fs-1 text-danger"></i>
            </button>
        </div>
    @endif

    <form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
        @csrf
        
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        @include('admin.products.partials._basic_info')
                        @include('admin.products.partials._pricing_inventory')
                        @include('admin.products.partials.variants-form', ['product' => null])
                        @include('admin.products.partials._media')
                        @include('admin.products.partials._specifications')
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.products.index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Batal</a>
                <button type="submit" id="submit-btn" class="btn btn-primary">
                    <span class="indicator-label">Simpan Produk</span>
                    <span class="indicator-progress">Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px w-xl-400px mb-7 ms-lg-10">
            @include('admin.products.partials._settings')
            @include('admin.products.partials._related')
            @include('admin.products.partials._tags_seo')
        </div>
    </form>
</div>

<!-- Modal Media Picker -->
@include('admin.products.partials._media_picker_modal')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .trumbowyg-box { margin-top: 5px; }
    .trumbowyg-editor { min-height: 200px; }
    
    /* Media Picker Selection Styling */
    .media-card { cursor: pointer; transition: all 0.2s ease; border: 2px solid transparent; border-radius: 8px; overflow: hidden; position: relative; }
    .media-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .media-card.selected { border-color: #009ef7; background-color: #f1faff; }
    .media-card .media-check { position: absolute; top: 10px; right: 10px; width: 25px; height: 25px; background: #009ef7; color: white; border-radius: 50%; display: none; align-items: center; justify-content: center; z-index: 2; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
    .media-card.selected .media-check { display: flex; }
    .media-card .card-img img { height: 150px; width: 100%; object-fit: cover; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/plugins/table/trumbowyg.table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/langs/id.min.js"></script>

<script>
    // Global variable for media picker
    window.currentVariantPickerIndex = null;
    window.selectedMediaItems = [];
    window.currentPickerTarget = 'main';
    window.searchQuery = '';

    // Register GLOBAL functions
    window.loadMediaLibrary = function(page = 1) {
        $('#mediaLibraryGrid').html('<div class="col-12 text-center py-10"><div class="spinner-border text-primary"></div></div>');
        fetch(`/admin/media/picker?page=${page}&search=${encodeURIComponent(window.searchQuery)}`, { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' } 
        })
        .then(res => res.json())
        .then(data => {
            $('#mediaLibraryGrid').html(data.html);
            window.setupMediaCardEvents();
            window.updatePagination(data.currentPage, data.totalPages);
        })
        .catch(err => console.error('Error loading media:', err));
    };

    window.updatePagination = function(current, total) {
        let html = '<ul class="pagination pagination-outline">';
        html += `<li class="page-item previous ${current === 1 ? 'disabled' : ''}"><a href="javascript:void(0)" class="page-link" onclick="loadMediaLibrary(${current - 1})"><i class="bi bi-chevron-left"></i></a></li>`;
        for (let i = 1; i <= total; i++) {
            if (i === 1 || i === total || (i >= current - 2 && i <= current + 2)) {
                html += `<li class="page-item ${i === current ? 'active' : ''}"><a href="javascript:void(0)" class="page-link" onclick="loadMediaLibrary(${i})">${i}</a></li>`;
            } else if (i === current - 3 || i === current + 3) {
                html += '<li class="page-item disabled"><a href="#" class="page-link">...</a></li>';
            }
        }
        html += `<li class="page-item next ${current === total ? 'disabled' : ''}"><a href="javascript:void(0)" class="page-link" onclick="loadMediaLibrary(${current + 1})"><i class="bi bi-chevron-right"></i></a></li>`;
        html += '</ul>';
        $('#mediaPagination').html(html);
    };

    window.handleFileSelection = function(files) {
        if (!files.length) return;
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) { formData.append('files[]', files[i]); }
        const uploadTab = $('#upload-tab');
        uploadTab.find('.border').addClass('bg-light-primary');
        uploadTab.find('button').prop('disabled', true).text('Uploading...');

        fetch('/admin/media/upload', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                $('.nav-tabs button[data-bs-target="#media-library-tab"]').tab('show');
                window.loadMediaLibrary(1);
            } else { alert('Upload gagal: ' + (data.message || 'Error tidak diketahui')); }
        })
        .catch(err => alert('Terjadi kesalahan saat upload'))
        .finally(() => {
            uploadTab.find('.border').removeClass('bg-light-primary');
            uploadTab.find('button').prop('disabled', false).text('Pilih File');
            $('#fileUpload').val('');
        });
    };

    window.openMediaPicker = function(target, variantIndex = null) {
        window.currentPickerTarget = target;
        window.currentVariantPickerIndex = variantIndex;
        window.selectedMediaItems = [];
        $('#pickerTargetBadge').text(target === 'main' ? 'Gambar Utama' : (target === 'variant' ? 'Gambar Varian' : 'Gallery'));
        const modalEl = document.getElementById('mediaPickerModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
        window.loadMediaLibrary(1);
    };

    window.setupMediaCardEvents = function() {
        $('.media-card').off('click').on('click', function() {
            const media = { id: $(this).data('id'), url: $(this).data('url'), thumbnail: $(this).data('thumbnail') || $(this).data('url'), name: $(this).data('name') };
            if (window.currentPickerTarget === 'main' || window.currentPickerTarget === 'variant') {
                $('.media-card').removeClass('selected');
                $(this).addClass('selected');
                window.selectedMediaItems = [media];
            } else {
                $(this).toggleClass('selected');
                if ($(this).hasClass('selected')) { window.selectedMediaItems.push(media); }
                else { window.selectedMediaItems = window.selectedMediaItems.filter(i => i.id !== media.id); }
            }
            $('#insertMediaBtn').prop('disabled', window.selectedMediaItems.length === 0);
        });
    };

    window.insertSelectedMedia = function() {
        if (window.selectedMediaItems.length === 0) return;
        if (window.currentPickerTarget === 'main') {
            const media = window.selectedMediaItems[0];
            $('#mainImagePreview').html(`<img src="${media.url}" style="max-width: 100%; max-height: 100%; object-fit: contain;">`);
            $('#main_media_id').val(media.id);
            $('#removeMainImage').show();
        } else if (window.currentPickerTarget === 'variant') {
            const media = window.selectedMediaItems[0];
            const variantItem = $(`.variant-item[data-variant-index="${window.currentVariantPickerIndex}"]`);
            if (variantItem.length) {
                variantItem.find('.variant-image-id').val(media.id);
                variantItem.find('.variant-image-preview').html(`<img src="${media.url}" class="img-thumbnail" style="max-height:100px">`);
            }
        } else {
            let galleryIds = JSON.parse($('#gallery_images').val() || '[]');
            window.selectedMediaItems.forEach(media => {
                if (!galleryIds.includes(media.id)) {
                    galleryIds.push(media.id);
                    $('#galleryPreview').append(`<div class="gallery-item position-relative border rounded overflow-hidden" data-id="${media.id}" style="width: 100px; height: 100px;"><img src="${media.thumbnail}" style="width: 100%; height: 100%; object-fit: cover;"><button type="button" class="btn btn-icon btn-bg-light btn-color-danger btn-active-color-danger btn-sm position-absolute top-0 end-0 m-1" style="width: 20px; height: 20px;" onclick="removeGalleryImage(${media.id})"><i class="bi bi-x fs-7"></i></button></div>`);
                }
            });
            $('#gallery_images').val(JSON.stringify(galleryIds));
            $('#galleryPlaceholder').hide();
        }
        bootstrap.Modal.getInstance(document.getElementById('mediaPickerModal')).hide();
    };

    $(document).ready(function() {
        const editorConfig = { lang: 'id', btns: [['viewHTML'], ['undo', 'redo'], ['formatting'], ['strong', 'em', 'del', 'u'], ['link'], ['insertImage'], ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'], ['unorderedList', 'orderedList'], ['table'], ['fullscreen']], autogrow: true };
        $('#description_editor, #specifications_editor, #features_editor, #usage_instructions_editor, #warranty_info_editor').trumbowyg(editorConfig);
        if ($('[data-control="select2"]').length) { $('[data-control="select2"]').select2({ width: '100%' }); }
        
        $('#product_name').on('blur', function() {
            if (!$('#product_slug').val()) {
                $('#product_slug').val($(this).val().toLowerCase().replace(/[^\w\s]/gi, '').replace(/\s+/g, '-'));
            }
        });

        $('#has_variants').on('change', function() {
            const isEnabled = this.checked;
            $('#variant-attributes-section, #variants-container').toggle(isEnabled);
            $('#non-variant-pricing').toggle(!isEnabled);
            window.toggleVariantFields(isEnabled);
        });

        window.toggleVariantFields = function(isEnabled) {
            $('#variants-container input, #variants-container select').prop('disabled', !isEnabled);
            $('#non-variant-pricing input, #non-variant-pricing select').prop('disabled', isEnabled);
        };

        window.toggleVariantFields($('#has_variants').is(':checked'));

        // Handle Product Attributes (Basic Info section)
        $('#add-attribute').on('click', function() {
            const container = $('#variant-attributes-container');
            const html = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="variant_attributes[]" placeholder="Contoh: warna, ukuran, bahan" />
                    <button type="button" class="btn btn-light-danger remove-attribute">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`;
            container.append(html);
        });

        $(document).on('click', '.remove-attribute', function() {
            if ($('#variant-attributes-container .input-group').length > 1) {
                $(this).closest('.input-group').remove();
            } else {
                $(this).closest('.input-group').find('input').val('');
            }
        });

        $('#product-form').on('submit', function() {
            $('#submit-btn').attr('data-kt-indicator', 'on').prop('disabled', true);
        });
    });

    window.searchMediaLibrary = function() { window.searchQuery = $('#mediaSearch').val(); window.loadMediaLibrary(1); };
    window.removeMainImage = function() { $('#mainImagePreview').html('<span class="text-muted fs-7">Belum dipilih</span>'); $('#main_media_id').val(''); $('#removeMainImage').hide(); };
    window.removeGalleryImage = function(id) {
        $(`.gallery-item[data-id="${id}"]`).remove();
        let ids = JSON.parse($('#gallery_images').val() || '[]');
        ids = ids.filter(i => i !== id);
        $('#gallery_images').val(JSON.stringify(ids));
        if (ids.length === 0) $('#galleryPlaceholder').show();
    };
</script>
@endpush
