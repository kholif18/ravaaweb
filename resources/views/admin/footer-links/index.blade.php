@extends('admin.layouts.app')

@section('page-title', 'Footer Links')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.footer-links.index') }}">Footer Links</a>
    </li>
@endsection

@section('content')
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Link Footer</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_footer_link">
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
                               data-kt-footer-link-table-filter="search"
                               placeholder="Cari Link..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="kt_footer_link_reset_filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="kt_footer_link_table_container">
            @include('admin.footer-links._table')
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="kt_modal_add_footer_link" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Link Footer</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_add_footer_link_form" action="{{ route('admin.footer-links.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Label</label>
                        <input type="text" class="form-control form-control-sm" name="label" placeholder="Portfolio" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">URL</label>
                        <input type="text" class="form-control form-control-sm" name="url" placeholder="/portofolio" required>
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px;">
                            Bisa URL internal (contoh: <code>/portofolio</code>) atau eksternal (contoh: <code>https://...</code>)
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Status</label>
                        <select class="form-select form-select-sm" name="is_active">
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
<div class="modal fade" id="kt_modal_edit_footer_link" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Link Footer</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_edit_footer_link_form" method="POST" data-update-url="{{ route('admin.footer-links.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_footer_link_id">
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Label</label>
                        <input type="text" class="form-control form-control-sm" name="label" id="edit_footer_link_label" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">URL</label>
                        <input type="text" class="form-control form-control-sm" name="url" id="edit_footer_link_url" required>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Status</label>
                        <select class="form-select form-select-sm" name="is_active" id="edit_footer_link_is_active">
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

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.footer-links.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.footer-links.bulk.destroy') }}" style="display:none;">
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
        var tbody = document.getElementById('sortable-footer-links');
        if (!tbody || tbody.children.length === 0) return;
        if (tbody._sortable) tbody._sortable.destroy();
        tbody._sortable = Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                var ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                    .map(function(tr) { return parseInt(tr.dataset.id); });
                fetch('{{ route("admin.footer-links.reorder") }}', {
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

    // Edit
    window.editFooterLink = async function(id) {
        const response = await fetch(`/admin/footer-links/${id}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const fl = data.footerLink;
            document.getElementById('edit_footer_link_id').value = fl.id;
            document.getElementById('edit_footer_link_label').value = fl.label;
            document.getElementById('edit_footer_link_url').value = fl.url;
            document.getElementById('edit_footer_link_is_active').value = fl.is_active ? '1' : '0';
            const form = document.getElementById('kt_modal_edit_footer_link_form');
            form.action = form.dataset.updateUrl.replace(':id', fl.id);
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_footer_link'));
            modal.show();
        }
    };

    // Hapus
    window.deleteFooterLink = function(id, label) {
        Ravaa.confirm('Hapus Link?', 'Link "' + label + '" akan dihapus permanen!').then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // Update Status
    window.updateStatus = function(id, isActive, label) {
        const action = isActive ? 'Aktifkan' : 'Nonaktifkan';
        Ravaa.confirm(action + ' Link?', 'Link "' + label + '" akan di' + (isActive ? 'aktifkan' : 'nonaktifkan') + '.', 'question').then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/footer-links/${id}/status`;
                form.innerHTML = `@csrf @method('PUT') <input type="hidden" name="is_active" value="${isActive}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    // ===== BULK SELECT & DELETE =====
    const tableContainer = document.getElementById('kt_footer_link_table_container');

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

    // Filters
    const searchInput = document.querySelector('[data-kt-footer-link-table-filter="search"]');
    const resetBtn = document.getElementById('kt_footer_link_reset_filter');

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
            initSortable();
            initializeTableEvents();
        } catch (e) { Ravaa.toast('Gagal memfilter', 'error'); }
        finally { tableContainer.style.opacity = '1'; }
    }

    let searchTimer;
    if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => applyFilters(), 500); });
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; applyFilters(); });
});
</script>
@endpush
