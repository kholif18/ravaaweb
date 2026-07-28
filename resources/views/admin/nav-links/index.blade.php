@extends('admin.layouts.app')

@section('page-title', 'Navbar Links')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.nav-links.index') }}">Navbar Links</a>
    </li>
@endsection

@section('content')
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Link Navbar</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_nav_link" onclick="resetAddForm()">
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
                               data-kt-nav-link-table-filter="search"
                               placeholder="Cari Link..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <select class="form-select form-select-sm" name="position" id="filter-position" style="width:150px;flex-shrink:0;">
                        <option value="">Semua Posisi</option>
                        <option value="navbar" {{ ($filters['position'] ?? '') === 'navbar' ? 'selected' : '' }}>Desktop</option>
                        <option value="mobile" {{ ($filters['position'] ?? '') === 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="both" {{ ($filters['position'] ?? '') === 'both' ? 'selected' : '' }}>Keduanya</option>
                    </select>
                    <button type="button" class="btn btn-light btn-sm" id="kt_nav_link_reset_filter" style="flex-shrink:0;">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="kt_nav_link_table_container">
            @include('admin.nav-links._table')
        </div>
    </div>
</div>

<!-- Modal Add / Edit -->
<div class="modal fade" id="kt_modal_add_nav_link" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold" id="modal-title">Tambah Link Navbar</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_add_nav_link_form" action="{{ route('admin.nav-links.store') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" id="form_parent_id" value="">
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Label</label>
                        <input type="text" class="form-control form-control-sm" name="label" id="form_label" placeholder="Portfolio" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">URL</label>
                        <input type="text" class="form-control form-control-sm" name="url" id="form_url" placeholder="/portofolio" required>
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px;">
                            Internal: <code>/portofolio</code> | Eksternal: <code>https://forms.google.com/...</code>
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Posisi</label>
                        <select class="form-select form-select-sm" name="position" id="form_position" required>
                            <option value="both">Keduanya (Desktop + Mobile)</option>
                            <option value="navbar">Navbar Desktop Saja</option>
                            <option value="mobile">Mobile Saja</option>
                        </select>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Target</label>
                        <select class="form-select form-select-sm" name="target" id="form_target" required>
                            <option value="_self">Tab yang sama</option>
                            <option value="_blank">Tab baru</option>
                        </select>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Status</label>
                        <select class="form-select form-select-sm" name="is_active" id="form_is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
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

<!-- Modal Edit -->
<div class="modal fade" id="kt_modal_edit_nav_link" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Link Navbar</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_edit_nav_link_form" method="POST" data-update-url="{{ route('admin.nav-links.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_nav_link_id">
                <input type="hidden" name="parent_id" id="edit_parent_id" value="">
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Label</label>
                        <input type="text" class="form-control form-control-sm" name="label" id="edit_nav_link_label" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">URL</label>
                        <input type="text" class="form-control form-control-sm" name="url" id="edit_nav_link_url" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Posisi</label>
                        <select class="form-select form-select-sm" name="position" id="edit_nav_link_position" required>
                            <option value="both">Keduanya (Desktop + Mobile)</option>
                            <option value="navbar">Navbar Desktop Saja</option>
                            <option value="mobile">Mobile Saja</option>
                        </select>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Target</label>
                        <select class="form-select form-select-sm" name="target" id="edit_nav_link_target" required>
                            <option value="_self">Tab yang sama</option>
                            <option value="_blank">Tab baru</option>
                        </select>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Status</label>
                        <select class="form-select form-select-sm" name="is_active" id="edit_nav_link_is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
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

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.nav-links.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.nav-links.bulk.destroy') }}" style="display:none;">
    @csrf @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('styles')
<style>
    /* Override admin CSS flex-wrap for inline filter */
    .table-toolbar { flex-wrap: nowrap !important; }
    .table-toolbar .toolbar-group { flex-wrap: nowrap !important; }

    /* Firefox fixes */
    @-moz-document url-prefix() {
        .table-toolbar { display: flex !important; }
        .table-toolbar .toolbar-group { display: flex !important; }
        .table td { padding: 0.4rem 0.55rem; }
        .btn-icon { display: inline-flex; align-items: center; justify-content: center; }
        .form-check-input { margin-top: 0; }
    }

    .input-group.input-group-sm .input-group-text { background: transparent; border-color: rgba(0,0,0,0.1); color: var(--text-muted); padding: 0.2rem 0.5rem; }
    .input-group.input-group-sm .form-control { border-left: 0; }
    .input-group.input-group-sm:focus-within .input-group-text,
    .input-group.input-group-sm:focus-within .form-control { border-color: var(--accent); }
    .input-group.input-group-sm:focus-within .form-control { box-shadow: 0 0 0 2px var(--accent-light); }
    .card-header-btns { display: flex; align-items: center; gap: 0.35rem; }
    .pagination { margin: 0 !important; }
    .child-row { background: rgba(0,0,0,0.02); }
    .child-row td:first-child { padding-left: 2.5rem !important; }
    .child-indicator { color: var(--accent); font-size: 0.75rem; margin-right: 4px; }
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

    window.resetAddForm = function() {
        document.getElementById('form_parent_id').value = '';
        document.getElementById('modal-title').textContent = 'Tambah Link Navbar';
        document.getElementById('form_label').value = '';
        document.getElementById('form_url').value = '';
        document.getElementById('form_position').value = 'both';
        document.getElementById('form_target').value = '_self';
        document.getElementById('form_is_active').value = '1';
    };

    window.addChildToParent = function(parentId, parentLabel) {
        resetAddForm();
        document.getElementById('form_parent_id').value = parentId;
        document.getElementById('modal-title').textContent = 'Tambah Child untuk "' + parentLabel + '"';
        var modal = new bootstrap.Modal(document.getElementById('kt_modal_add_nav_link'));
        modal.show();
    };

    window.editNavLink = async function(id) {
        const response = await fetch(`/admin/nav-links/${id}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const nl = data.navLink;
            document.getElementById('edit_nav_link_id').value = nl.id;
            document.getElementById('edit_parent_id').value = nl.parent_id || '';
            document.getElementById('edit_nav_link_label').value = nl.label;
            document.getElementById('edit_nav_link_url').value = nl.url;
            document.getElementById('edit_nav_link_position').value = nl.position;
            document.getElementById('edit_nav_link_target').value = nl.target;
            document.getElementById('edit_nav_link_is_active').value = nl.is_active ? '1' : '0';
            const form = document.getElementById('kt_modal_edit_nav_link_form');
            form.action = form.dataset.updateUrl.replace(':id', nl.id);
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_nav_link'));
            modal.show();
        }
    };

    window.deleteNavLink = function(id, label) {
        Ravaa.confirm('Hapus Link?', 'Link "' + label + '" akan dihapus permanen! Child items juga akan dihapus.').then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    window.updateStatus = function(id, isActive, label) {
        const action = isActive ? 'Aktifkan' : 'Nonaktifkan';
        Ravaa.confirm(action + ' Link?', 'Link "' + label + '" akan di' + (isActive ? 'aktifkan' : 'nonaktifkan') + '.', 'question').then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/nav-links/${id}/status`;
                form.innerHTML = `@csrf @method('PUT') <input type="hidden" name="is_active" value="${isActive}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    const tableContainer = document.getElementById('kt_nav_link_table_container');

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
            Ravaa.toast('Silakan pilih link yang akan dihapus', 'warning');
            return;
        }
        Ravaa.confirm('Hapus Link Terpilih?', 'Anda akan menghapus <strong>' + selectedIds.length + '</strong> link. Tindakan ini tidak dapat dibatalkan!', 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });

    const searchInput = document.querySelector('[data-kt-nav-link-table-filter="search"]');
    const resetBtn = document.getElementById('kt_nav_link_reset_filter');
    const positionFilter = document.getElementById('filter-position');

    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        const position = positionFilter.value;
        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (position) url.searchParams.set('position', position); else url.searchParams.delete('position');
        if (page > 1) url.searchParams.set('page', page); else url.searchParams.delete('page');
        try {
            const response = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            tableContainer.innerHTML = await response.text();
            window.history.pushState({}, '', url.toString());
            initializeTableEvents();
        } catch (e) { Ravaa.toast('Gagal memfilter', 'error'); }
        finally { tableContainer.style.opacity = '1'; }
    }

    let searchTimer;
    if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => applyFilters(), 500); });
    if (positionFilter) positionFilter.addEventListener('change', () => applyFilters());
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; positionFilter.value = ''; applyFilters(); });
});
</script>
@endpush
