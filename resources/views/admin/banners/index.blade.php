@extends('admin.layouts.app')

@section('page-title', 'Banner / Hero')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.banners.index') }}">Banner / Hero</a>
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Banner</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_banner">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 280px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               data-kt-banner-table-filter="search"
                               placeholder="Cari Banner..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="kt_banner_reset_filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="kt_banner_table_container">
            @include('admin.banners._table')
        </div>
    </div>
</div>

<!-- Modal Add Banner -->
<div class="modal fade" id="kt_modal_add_banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Banner</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_add_banner_form" action="{{ route('admin.banners.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Judul Banner</label>
                        <input type="text" class="form-control form-control-sm" name="title" placeholder="Selamat Datang di Ravaa Creative" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Subtitle</label>
                        <input type="text" class="form-control form-control-sm" name="subtitle" placeholder="Solusi kreatif untuk bisnis Anda">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Gambar Banner</label>
                        <x-media-picker name="image_media_id" type="image" label="Pilih Gambar" />
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Teks CTA</label>
                            <input type="text" class="form-control form-control-sm" name="cta_text" placeholder="Lihat Katalog">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">URL CTA</label>
                            <input type="url" class="form-control form-control-sm" name="cta_url" placeholder="/product">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Badge</label>
                            <input type="text" class="form-control form-control-sm" name="badge" placeholder="Baru">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Urutan</label>
                            <input type="number" class="form-control form-control-sm" name="order" min="0" value="0">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label fs-8">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Banner -->
<div class="modal fade" id="kt_modal_edit_banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Banner</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_edit_banner_form" method="POST" data-update-url="{{ route('admin.banners.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_banner_id">
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Judul Banner</label>
                        <input type="text" class="form-control form-control-sm" name="title" id="edit_banner_title" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Subtitle</label>
                        <input type="text" class="form-control form-control-sm" name="subtitle" id="edit_banner_subtitle">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Gambar Banner</label>
                        <div id="edit_banner_image_media_picker">
                            <x-media-picker name="image_media_id" type="image" label="Pilih Gambar" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Teks CTA</label>
                            <input type="text" class="form-control form-control-sm" name="cta_text" id="edit_banner_cta_text">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">URL CTA</label>
                            <input type="url" class="form-control form-control-sm" name="cta_url" id="edit_banner_cta_url">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Badge</label>
                            <input type="text" class="form-control form-control-sm" name="badge" id="edit_banner_badge">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Urutan</label>
                            <input type="number" class="form-control form-control-sm" name="order" id="edit_banner_order" min="0">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit_banner_active">
                                <label class="form-check-label fs-8">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.banners.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.banners.bulk.destroy') }}" style="display:none;">
    @csrf @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('styles')
<style>
    .input-group.input-group-sm .input-group-text { background: transparent; border-color: rgba(0,0,0,0.1); color: var(--text-muted); padding: 0.2rem 0.5rem; }
    .input-group.input-group-sm .form-control { border-left: 0; }
    .input-group.input-group-sm:focus-within .input-group-text,
    .input-group.input-group-sm:focus-within .form-control { border-color: var(--accent); }
    .input-group.input-group-sm:focus-within .form-control { box-shadow: 0 0 0 2px var(--accent-light); }
    .card-header-btns { display: flex; align-items: center; gap: 0.35rem; }
    .pagination { margin: 0 !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif

    // Edit banner function
    window.editBanner = async function(id) {
        const response = await fetch(`/admin/banners/${id}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const b = data.banner;
            document.getElementById('edit_banner_id').value = b.id;
            document.getElementById('edit_banner_title').value = b.title;
            document.getElementById('edit_banner_subtitle').value = b.subtitle || '';
            document.getElementById('edit_banner_cta_text').value = b.cta_text || '';
            document.getElementById('edit_banner_cta_url').value = b.cta_url || '';
            document.getElementById('edit_banner_badge').value = b.badge || '';
            document.getElementById('edit_banner_order').value = b.order;
            document.getElementById('edit_banner_active').checked = b.is_active;
            // Pre-set media picker for image_media_id
            if (b.image_media_id) {
                const pickerInput = document.querySelector('#edit_banner_image_media_picker input[name="image_media_id"]');
                if (pickerInput) pickerInput.value = b.image_media_id;
            }
            const form = document.getElementById('kt_modal_edit_banner_form');
            form.action = form.dataset.updateUrl.replace(':id', b.id);
            // Tampilkan modal edit
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_banner'));
            modal.show();
        }
    };

    // Delete
    window.deleteBanner = function(id, title) {
        Ravaa.confirm('Hapus Banner?', `Banner "${title}" akan dihapus permanen!`).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // Filters
    const tableContainer = document.getElementById('kt_banner_table_container');
    const searchInput = document.querySelector('[data-kt-banner-table-filter="search"]');
    const resetBtn = document.getElementById('kt_banner_reset_filter');

    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (page > 1) url.searchParams.set('page', page); else url.searchParams.delete('page');
        try {
            const response = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            tableContainer.innerHTML = await response.text();
            window.history.pushState({}, '', url.toString());
        } catch (e) { Ravaa.toast('Gagal memfilter', 'error'); }
        finally { tableContainer.style.opacity = '1'; }
    }

    let searchTimer;
    if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => applyFilters(), 500); });
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; applyFilters(); });
});
</script>
@endpush
