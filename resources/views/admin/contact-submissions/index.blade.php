@extends('admin.layouts.app')

@section('page-title', 'Pesan Masuk')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.contact-submissions.index') }}">Pesan Masuk</a>
    </li>
@endsection

@section('content')
<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Pesan Masuk</div>
    </div>

    <div class="card-body">
        <div class="table-toolbar" style="display:block !important;">
            <div class="toolbar-group" style="display:block !important;">
                <div style="display:flex !important; align-items:center; gap:8px; flex-wrap:nowrap !important; white-space:nowrap;">
                    <div class="input-group input-group-sm" style="width:200px;flex-shrink:0;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               data-kt-contact-table-filter="search"
                               placeholder="Cari Pesan..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <select name="status" class="form-select form-select-sm" style="width:150px;flex-shrink:0;">
                        <option value="">Semua Status</option>
                        <option value="unread" {{ ($filters['status'] ?? '') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="read" {{ ($filters['status'] ?? '') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                    <button type="button" class="btn btn-light btn-sm" id="kt_contact_reset_filter" style="flex-shrink:0;">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="kt_contact_table_container">
            @include('admin.contact-submissions._table')
        </div>
    </div>
</div>

<!-- Modal Detail Pesan -->
<div class="modal fade" id="kt_modal_detail_contact" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-550px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Detail Pesan</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <div class="modal-body py-4 px-4">
                <div class="mb-3">
                    <label class="fs-7 fw-semibold mb-1">Nama</label>
                    <p class="form-control-static" id="detail_name" style="font-size:0.9rem;"></p>
                </div>
                <div class="mb-3">
                    <label class="fs-7 fw-semibold mb-1">Email</label>
                    <p class="form-control-static" id="detail_email" style="font-size:0.9rem;"></p>
                </div>
                <div class="mb-3">
                    <label class="fs-7 fw-semibold mb-1">Subjek</label>
                    <p class="form-control-static" id="detail_subject" style="font-size:0.9rem;"></p>
                </div>
                <div class="mb-3">
                    <label class="fs-7 fw-semibold mb-1">Pesan</label>
                    <p class="form-control-static" id="detail_message" style="font-size:0.9rem;white-space:pre-wrap;"></p>
                </div>
                <div class="mb-3">
                    <label class="fs-7 fw-semibold mb-1">Dikirim Pada</label>
                    <p class="form-control-static" id="detail_date" style="font-size:0.9rem;"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.contact-submissions.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.contact-submissions.bulk.destroy') }}" style="display:none;">
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

    // Detail pesan
    window.viewContact = async function(id) {
        try {
            const response = await fetch('/admin/contact-submissions/' + id, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            if (data.success) {
                const s = data.submission;
                document.getElementById('detail_name').textContent = s.name;
                document.getElementById('detail_email').textContent = s.email;
                document.getElementById('detail_subject').textContent = s.subject;
                document.getElementById('detail_message').textContent = s.message;
                document.getElementById('detail_date').textContent = new Date(s.created_at).toLocaleString('id-ID', {
                    year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
                });
                const modal = new bootstrap.Modal(document.getElementById('kt_modal_detail_contact'));
                modal.show();

                // Refresh table if status changed
                const row = document.querySelector('tr[data-id="' + id + '"]');
                if (row && s.status === 'read') {
                    const badge = row.querySelector('.status-badge');
                    if (badge) {
                        badge.className = 'badge status-badge';
                        badge.style.cssText = 'background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;';
                        badge.textContent = 'Sudah Dibaca';
                    }
                }
            }
        } catch (e) {
            Ravaa.toast('Gagal memuat detail pesan', 'error');
        }
    };

    // Hapus
    window.deleteContact = function(id, name) {
        Ravaa.confirm('Hapus Pesan?', 'Pesan dari "' + name + '" akan dihapus permanen!').then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // ===== BULK SELECT & DELETE =====
    const tableContainer = document.getElementById('kt_contact_table_container');

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
            Ravaa.toast('Silakan pilih pesan yang akan dihapus', 'warning');
            return;
        }
        Ravaa.confirm('Hapus Pesan Terpilih?', 'Anda akan menghapus <strong>' + selectedIds.length + '</strong> pesan. Tindakan ini tidak dapat dibatalkan!', 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });

    // Filters
    const searchInput = document.querySelector('[data-kt-contact-table-filter="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const resetBtn = document.getElementById('kt_contact_reset_filter');

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
