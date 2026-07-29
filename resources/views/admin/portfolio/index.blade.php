@extends('admin.layouts.app')

@section('page-title', 'Portfolio')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.portfolio.index') }}">Portfolio</a>
    </li>
@endsection

@section('content')
<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Portfolio</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_portfolio">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
    </div>

    <div class="card-body">
<div class="table-toolbar" style="display:block !important;">
    <div class="toolbar-group" style="display:block !important;">
        <div style="display:flex !important; align-items:center; gap:8px; flex-wrap:nowrap !important; white-space:nowrap;">
            <div class="input-group input-group-sm" style="width:200px;flex-shrink:0;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control"
                       data-kt-portfolio-table-filter="search"
                       placeholder="Cari Portfolio..."
                       name="search"
                       value="{{ $filters['search'] ?? '' }}">
            </div>
            <select name="status" class="form-select form-select-sm" style="width:150px;flex-shrink:0;">
                <option value="">Semua Status</option>
                <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="button" class="btn btn-light btn-sm" id="kt_portfolio_reset_filter" style="flex-shrink:0;">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </button>
        </div>
    </div>
</div>

        <div id="kt_portfolio_table_container">
            @include('admin.portfolio._table')
        </div>
    </div>
</div>

<!-- Modal Add Portfolio -->
<div class="modal fade" id="kt_modal_add_portfolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Portfolio</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_add_portfolio_form" action="{{ route('admin.portfolio.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Judul Proyek</label>
                            <input type="text" class="form-control form-control-sm" name="title" placeholder="Sistem Informasi Sekolah" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Kategori</label>
                            <input type="text" class="form-control form-control-sm" name="category" placeholder="Web App">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Klien</label>
                            <input type="text" class="form-control form-control-sm" name="client" placeholder="PT Maju Jaya">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">URL Proyek</label>
                            <input type="url" class="form-control form-control-sm" name="project_url" placeholder="https://...">
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Deskripsi</label>
                        <textarea class="form-control form-control-sm" rows="2" name="description" placeholder="Deskripsi proyek..."></textarea>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Gambar Proyek</label>
                        <x-media-picker name="image_media_id" type="image" label="Pilih Gambar" />
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Tech Stack (satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="3" name="tech_text" placeholder="Laravel&#10;Vue.js&#10;MySQL&#10;Tailwind"></textarea>
                        <div class="form-text fs-8">Setiap baris = satu teknologi</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1">
                                <label class="form-check-label fs-8">Featured</label>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);"><i class="bi bi-search me-1"></i> SEO</div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" name="meta_title" placeholder="Meta title untuk SEO">
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" rows="2" name="meta_description" placeholder="Meta description"></textarea>
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

<!-- Modal Edit Portfolio -->
<div class="modal fade" id="kt_modal_edit_portfolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Portfolio</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_edit_portfolio_form" method="POST" data-update-url="{{ route('admin.portfolio.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_portfolio_id">
                <div class="modal-body py-4 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Judul Proyek</label>
                            <input type="text" class="form-control form-control-sm" name="title" id="edit_portfolio_title" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Kategori</label>
                            <input type="text" class="form-control form-control-sm" name="category" id="edit_portfolio_category">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Klien</label>
                            <input type="text" class="form-control form-control-sm" name="client" id="edit_portfolio_client">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">URL Proyek</label>
                            <input type="url" class="form-control form-control-sm" name="project_url" id="edit_portfolio_project_url">
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Deskripsi</label>
                        <textarea class="form-control form-control-sm" rows="2" name="description" id="edit_portfolio_description"></textarea>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Gambar Proyek</label>
                        <x-media-picker name="edit_image_media_id" type="image" label="Pilih Gambar" />
                        <input type="hidden" name="image_media_id" id="edit_image_media_id_value">
                        <input type="hidden" name="image" id="edit_portfolio_image">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Tech Stack (satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="3" name="tech_text" id="edit_portfolio_tech"></textarea>
                        <div class="form-text fs-8">Setiap baris = satu teknologi</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_portfolio_status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="edit_portfolio_featured">
                                <label class="form-check-label fs-8">Featured</label>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);"><i class="bi bi-search me-1"></i> SEO</div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" name="meta_title" id="edit_portfolio_meta_title">
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" rows="2" name="meta_description" id="edit_portfolio_meta_description"></textarea>
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

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.portfolio.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.portfolio.bulk.destroy') }}" style="display:none;">
    @csrf @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

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
        var tbody = document.getElementById('sortable-portfolio');
        if (!tbody || tbody.children.length === 0) return;
        if (tbody._sortable) tbody._sortable.destroy();
        tbody._sortable = Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                var ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                    .map(function(tr) { return parseInt(tr.dataset.id); });
                fetch('{{ route("admin.portfolio.reorder") }}', {
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

    // Helper: convert tech array to newline-separated text
    function techToText(tech) {
        if (!tech || !Array.isArray(tech)) return '';
        return tech.join('\n');
    }

    // Helper: convert newline-separated text to tech array
    function textToTech(text) {
        if (!text) return [];
        return text.split('\n').map(s => s.trim()).filter(Boolean);
    }

    // Add form submit
    const addForm = document.getElementById('kt_modal_add_portfolio_form');
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const techText = this.querySelector('textarea[name="tech_text"]').value;
        const tech = textToTech(techText);
        this.querySelectorAll('input[name="tech[]"]').forEach(el => el.remove());
        tech.forEach(t => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tech[]';
            input.value = t;
            this.appendChild(input);
        });
        this.querySelector('textarea[name="tech_text"]').remove();
        this.submit();
    });

    // Edit form submit
    const editForm = document.getElementById('kt_modal_edit_portfolio_form');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const techText = this.querySelector('textarea[name="tech_text"]').value;
        const tech = textToTech(techText);
        this.querySelectorAll('input[name="tech[]"]').forEach(el => el.remove());
        tech.forEach(t => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tech[]';
            input.value = t;
            this.appendChild(input);
        });
        this.querySelector('textarea[name="tech_text"]').remove();
        // Copy edit_image_media_id → image_media_id before submit
        const src = document.getElementById('edit_image_media_id-input');
        const dst = document.getElementById('edit_image_media_id_value');
        const imgCol = document.getElementById('edit_portfolio_image');
        if (src && dst) {
            dst.value = src.value;
            if (src.value && imgCol) {
                imgCol.value = '';
            }
        }
        this.submit();
    });

    // Edit portfolio function
    window.editPortfolio = async function(id) {
        const response = await fetch(`/admin/portfolio/${id}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const p = data.portfolioItem;
            document.getElementById('edit_portfolio_id').value = p.id;
            document.getElementById('edit_portfolio_title').value = p.title;
            document.getElementById('edit_portfolio_category').value = p.category || '';
            document.getElementById('edit_portfolio_client').value = p.client || '';
            document.getElementById('edit_portfolio_project_url').value = p.project_url || '';
            document.getElementById('edit_portfolio_description').value = p.description || '';
            document.getElementById('edit_portfolio_tech').value = techToText(p.tech);
            document.getElementById('edit_portfolio_status').value = p.status;
            document.getElementById('edit_portfolio_featured').checked = p.is_featured;
            document.getElementById('edit_portfolio_meta_title').value = p.meta_title || '';
            document.getElementById('edit_portfolio_meta_description').value = p.meta_description || '';
            // Reset & init media picker for edit_image_media_id (always, even when no media)
            const editPicInput = document.getElementById('edit_image_media_id-input');
            if (editPicInput) editPicInput.value = p.image_media_id || '';
            const imgCol = document.getElementById('edit_portfolio_image');
            if (imgCol) imgCol.value = p.image || '';

            const previewContainer = document.getElementById('edit_image_media_id-selected');
            if (previewContainer) {
                if (p.image_media_id && p.media_url) {
                    previewContainer.innerHTML = `
                        <div class="media-picker-thumb">
                            <img src="${p.media_url}" alt="${p.media_name || ''}">
                            <button type="button" class="remove-media" onclick="removePickerItem('edit_image_media_id', '${p.image_media_id}'); document.getElementById('edit_portfolio_image').value='';"><i class="bi bi-x"></i></button>
                        </div>
                    `;
                } else if (p.image) {
                    const imgUrl = p.image.startsWith('http') ? p.image : '/storage/' + p.image;
                    previewContainer.innerHTML = `
                        <div class="media-picker-thumb">
                            <img src="${imgUrl}" alt="Preview">
                            <button type="button" class="remove-media" onclick="removePickerItem('edit_image_media_id', ''); document.getElementById('edit_portfolio_image').value='';"><i class="bi bi-x"></i></button>
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
                    selected: (p.image_media_id ? [String(p.image_media_id)] : []),
                    selectedItems: {},
                    currentSearch: '',
                };
            } else {
                window.mediaPickerState['edit_image_media_id'].selected = (p.image_media_id ? [String(p.image_media_id)] : []);
                window.mediaPickerState['edit_image_media_id'].selectedItems = {};
            }
            if (p.image_media_id && p.media_url) {
                window.mediaPickerState['edit_image_media_id'].selectedItems[p.image_media_id] = `<img src="${p.media_url}" alt="${p.media_name || ''}">`;
            }
            const form = document.getElementById('kt_modal_edit_portfolio_form');
            form.action = form.dataset.updateUrl.replace(':id', p.id);
            // Tampilkan modal edit
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_portfolio'));
            modal.show();
        }
    };

    // Delete
    window.deletePortfolio = function(id, title) {
        Ravaa.confirm('Hapus Portfolio?', `Portfolio "${title}" akan dihapus permanen!`).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // ===== BULK SELECT & DELETE =====
    const tableContainer = document.getElementById('kt_portfolio_table_container');

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
            Ravaa.toast('Silakan pilih portfolio yang akan dihapus', 'warning');
            return;
        }
        Ravaa.confirm('Hapus Portfolio Terpilih?', `Anda akan menghapus <strong>${selectedIds.length}</strong> portfolio. Tindakan ini tidak dapat dibatalkan!`, 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });

    // Filters
    const searchInput = document.querySelector('[data-kt-portfolio-table-filter="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const resetBtn = document.getElementById('kt_portfolio_reset_filter');

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
