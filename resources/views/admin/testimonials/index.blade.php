@extends('admin.layouts.app')

@section('page-title', 'Testimoni')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.testimonials.index') }}">Testimoni</a>
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Testimoni</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_testimonial">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width:200px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               data-kt-testimonial-table-filter="search"
                               placeholder="Cari Testimoni..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <select name="status" class="form-select form-select-sm" style="min-width:110px;">
                        <option value="">Semua Status</option>
                        <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <button type="button" class="btn btn-light btn-sm" id="kt_testimonial_reset_filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="kt_testimonial_table_container">
            @include('admin.testimonials._table')
        </div>
    </div>
</div>

<!-- Modal Add Testimonial -->
<div class="modal fade" id="kt_modal_add_testimonial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-550px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Testimoni</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_add_testimonial_form" action="{{ route('admin.testimonials.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Nama Klien</label>
                            <input type="text" class="form-control form-control-sm" name="client_name" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Foto Klien</label>
                            <x-media-picker name="image_media_id" type="image" label="Pilih Foto" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Jabatan</label>
                            <input type="text" class="form-control form-control-sm" name="position" placeholder="CEO">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Perusahaan</label>
                            <input type="text" class="form-control form-control-sm" name="company" placeholder="PT Maju Jaya">
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Isi Testimoni</label>
                        <textarea class="form-control form-control-sm" rows="3" name="content" placeholder="Kesan dan pesan klien..." required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Rating</label>
                            <select class="form-select form-select-sm" name="rating">
                                <option value="5">5 ★</option>
                                <option value="4">4 ★</option>
                                <option value="3">3 ★</option>
                                <option value="2">2 ★</option>
                                <option value="1">1 ★</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
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

<!-- Modal Edit Testimonial -->
<div class="modal fade" id="kt_modal_edit_testimonial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-550px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Testimoni</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_edit_testimonial_form" method="POST" data-update-url="{{ route('admin.testimonials.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_testimonial_id">
                <div class="modal-body py-4 px-4">
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Nama Klien</label>
                            <input type="text" class="form-control form-control-sm" name="client_name" id="edit_testimonial_client_name" required>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Foto Klien</label>
                            <x-media-picker name="edit_image_media_id" type="image" label="Pilih Foto" />
                            <input type="hidden" name="image_media_id" id="edit_image_media_id_value">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Jabatan</label>
                            <input type="text" class="form-control form-control-sm" name="position" id="edit_testimonial_position">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Perusahaan</label>
                            <input type="text" class="form-control form-control-sm" name="company" id="edit_testimonial_company">
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Isi Testimoni</label>
                        <textarea class="form-control form-control-sm" rows="3" name="content" id="edit_testimonial_content" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Rating</label>
                            <select class="form-select form-select-sm" name="rating" id="edit_testimonial_rating">
                                <option value="5">5 ★</option>
                                <option value="4">4 ★</option>
                                <option value="3">3 ★</option>
                                <option value="2">2 ★</option>
                                <option value="1">1 ★</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_testimonial_status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
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

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.testimonials.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.testimonials.bulk.destroy') }}" style="display:none;">
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

    // ===== SORTABLE DRAG-AND-DROP =====
    function initSortable() {
        var tbody = document.getElementById('sortable-testimonials');
        if (!tbody || tbody.children.length === 0) return;
        if (tbody._sortable) tbody._sortable.destroy();
        tbody._sortable = Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                var ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                    .map(function(tr) { return parseInt(tr.dataset.id); });
                fetch('{{ route("admin.testimonials.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) Ravaa.toast(data.message || 'Urutan berhasil diperbarui', 'success');
                })
                .catch(function() { Ravaa.toast('Gagal memperbarui urutan', 'error'); });
            }
        });
    }
    initSortable();

    // Edit testimonial function
    window.editTestimonial = async function(id) {
        const response = await fetch(`/admin/testimonials/${id}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const t = data.testimonial;
            document.getElementById('edit_testimonial_id').value = t.id;
            document.getElementById('edit_testimonial_client_name').value = t.client_name;
            document.getElementById('edit_testimonial_position').value = t.position || '';
            document.getElementById('edit_testimonial_company').value = t.company || '';
            document.getElementById('edit_testimonial_content').value = t.content;
            document.getElementById('edit_testimonial_rating').value = t.rating || 5;
            document.getElementById('edit_testimonial_status').value = t.status;
            // Reset & init media picker for edit_image_media_id (always, even when no media)
            const editPicInput = document.getElementById('edit_image_media_id-input');
            if (editPicInput) editPicInput.value = t.image_media_id || '';
            const previewContainer = document.getElementById('edit_image_media_id-selected');
            if (previewContainer) {
                if (t.image_media_id && t.media_url) {
                    previewContainer.innerHTML = `
                        <div class="media-picker-thumb">
                            <img src="${t.media_url}" alt="${t.media_name || ''}">
                            <button type="button" class="remove-media" onclick="removePickerItem('edit_image_media_id', '${t.image_media_id}')"><i class="bi bi-x"></i></button>
                        </div>
                    `;
                } else {
                    previewContainer.innerHTML = `
                        <div class="media-picker-empty">
                            <i class="bi bi-image"></i>
                            <span>Belum ada media dipilih</span>
                        </div>
                    `;
                }
            }
            // Initialize/sync media picker state
            if (!window.mediaPickerState) window.mediaPickerState = {};
            if (!window.mediaPickerState['edit_image_media_id']) {
                window.mediaPickerState['edit_image_media_id'] = {
                    multiple: false,
                    type: 'image',
                    selected: (t.image_media_id ? [String(t.image_media_id)] : []),
                    selectedItems: {},
                    currentSearch: '',
                };
            } else {
                window.mediaPickerState['edit_image_media_id'].selected = (t.image_media_id ? [String(t.image_media_id)] : []);
                window.mediaPickerState['edit_image_media_id'].selectedItems = {};
            }
            if (t.image_media_id && t.media_url) {
                window.mediaPickerState['edit_image_media_id'].selectedItems[t.image_media_id] = `<img src="${t.media_url}" alt="${t.media_name || ''}">`;
            }
            const form = document.getElementById('kt_modal_edit_testimonial_form');
            form.action = form.dataset.updateUrl.replace(':id', t.id);
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_testimonial'));
            modal.show();
        }
    };

    // Copy edit_image_media_id → image_media_id on form submit
    document.getElementById('kt_modal_edit_testimonial_form').addEventListener('submit', function() {
        const src = document.getElementById('edit_image_media_id-input');
        const dst = document.getElementById('edit_image_media_id_value');
        if (src && dst) dst.value = src.value;
    });

    // Delete
    window.deleteTestimonial = function(id, name) {
        Ravaa.confirm('Hapus Testimoni?', `Testimoni dari "${name}" akan dihapus permanen!`).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // Update Status
    window.updateStatus = function(id, status, name) {
        const action = status === 'active' ? 'Aktifkan' : 'Nonaktifkan';
        Ravaa.confirm(`${action} Testimoni?`, `Testimoni dari "${name}" akan di${action.toLowerCase()}.`, 'question').then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/testimonials/${id}/status`;
                form.innerHTML = `@csrf @method('PUT') <input type="hidden" name="status" value="${status}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    // ===== BULK SELECT & DELETE =====
    const tableContainer = document.getElementById('kt_testimonial_table_container');

    function updateBulkDeleteButton() {
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        if (!bulkDeleteBtn) return;
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        if (selectedIds.length > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
            bulkDeleteBtn.innerHTML = '<i class="bi bi-trash"></i> Hapus Terpilih (' + selectedIds.length + ')';
        } else {
            bulkDeleteBtn.style.display = 'none';
        }
    }

    function initializeTableEvents() {
        const selectAll = document.getElementById('select-all');
        const selectItems = tableContainer.querySelectorAll('.select-item');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                selectItems.forEach(item => { item.checked = this.checked; });
                updateBulkDeleteButton();
            });
        }
        selectItems.forEach(item => {
            item.addEventListener('change', updateBulkDeleteButton);
        });
    }
    initializeTableEvents();

    document.addEventListener('click', function(e) {
        const bulkDeleteBtn = e.target.closest('#bulk-delete-btn');
        if (!bulkDeleteBtn) return;
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        if (selectedIds.length === 0) {
            Ravaa.toast('Silakan pilih testimoni yang akan dihapus', 'warning');
            return;
        }
        Ravaa.confirm('Hapus Testimoni Terpilih?', `Anda akan menghapus <strong>${selectedIds.length}</strong> testimoni. Tindakan ini tidak dapat dibatalkan!`, 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });

    // Filters
    const searchInput = document.querySelector('[data-kt-testimonial-table-filter="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const resetBtn = document.getElementById('kt_testimonial_reset_filter');

    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        const status = statusFilter.value;
        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
        if (page > 1) url.searchParams.set('page', page); else url.searchParams.delete('page');
        try {
            const response = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            tableContainer.innerHTML = await response.text();
            window.history.pushState({}, '', url.toString());
            initSortable();
            initializeTableEvents();
        } catch (e) { Ravaa.toast('Gagal memfilter', 'error'); }
        finally { tableContainer.style.opacity = '1'; }
    }

    let searchTimer;
    if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => applyFilters(), 500); });
    if (statusFilter) statusFilter.addEventListener('change', () => applyFilters());
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; statusFilter.value = ''; applyFilters(); });
});
</script>
@endpush
