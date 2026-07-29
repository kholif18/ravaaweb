@extends('admin.layouts.app')

@section('page-title', 'Kelola Pesanan')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.orders.index') }}">Kelola Pesanan</a>
    </li>
@endsection

@section('content')
<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Pesanan</div>
    </div>

    <div class="card-body">
        <div class="table-toolbar" style="display:block !important;">
            <div class="toolbar-group" style="display:block !important;">
                <div style="display:flex !important; align-items:center; gap:8px; flex-wrap:nowrap !important; white-space:nowrap;">
                    <div class="input-group input-group-sm" style="width:200px;flex-shrink:0;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               data-kt-order-table-filter="search"
                               placeholder="Cari Pesanan..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <select name="type" class="form-select form-select-sm" style="width:150px;flex-shrink:0;">
                        <option value="">Semua Tipe</option>
                        @foreach($typeLabels as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['type'] ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="form-select form-select-sm" style="width:150px;flex-shrink:0;">
                        <option value="">Semua Status</option>
                        @foreach($statusLabels as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-light btn-sm" id="kt_order_reset_filter" style="flex-shrink:0;">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div id="kt_order_table_container">
            @include('admin.orders._table')
        </div>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="kt_modal_detail_order" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Detail Pesanan</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <div class="modal-body py-4 px-4" id="order-detail-body">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="modal-status-form" method="POST" style="display:none;flex:1;">
                    @csrf @method('PATCH')
                    <div style="display:flex;gap:8px;align-items:center;">
                        <select name="status" id="modal-status-select" class="form-select form-select-sm" style="flex:1;">
                            <option value="pending">Menunggu</option>
                            <option value="confirmed">Dikonfirmasi</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm" style="white-space:nowrap;">
                            <i class="bi bi-check-lg"></i> Update
                        </button>
                    </div>
                </form>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.orders.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.orders.bulk.destroy') }}" style="display:none;">
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

    // Detail pesanan
    window.viewOrder = async function(id) {
        const body = document.getElementById('order-detail-body');
        body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        // Setup status form
        const statusForm = document.getElementById('modal-status-form');
        const statusSelect = document.getElementById('modal-status-select');
        statusForm.style.display = 'none';
        statusForm.action = '/admin/orders/' + id + '/status';

        const modal = new bootstrap.Modal(document.getElementById('kt_modal_detail_order'));
        modal.show();

        try {
            const response = await fetch('/admin/orders/' + id, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            if (data.success) {
                body.innerHTML = renderOrderDetail(data.order, data.type_label, data.status_label);
                // Set current status & show form
                statusSelect.value = data.order.status;
                statusForm.style.display = 'block';
            } else {
                body.innerHTML = '<div class="text-center py-4 text-danger">Gagal memuat detail</div>';
            }
        } catch (e) {
            body.innerHTML = '<div class="text-center py-4 text-danger">Gagal memuat detail</div>';
        }
    };

    function renderOrderDetail(order, typeLabel, statusLabel) {
        const data = order.data || {};
        let html = '';

        // Header info
        html += '<div class="detail-section">';
        html += '<h4><i class="bi bi-info-circle"></i> Info Pesanan</h4>';
        html += '<div class="detail-row"><span class="label">Tipe</span><span class="value">' + typeLabel + '</span></div>';
        html += '<div class="detail-row"><span class="label">Status</span><span class="value">' + statusLabel + '</span></div>';
        html += '<div class="detail-row"><span class="label">Tanggal</span><span class="value">' + new Date(order.created_at).toLocaleString('id-ID', { year:'numeric', month:'long', day:'numeric', hour:'2-digit', minute:'2-digit' }) + '</span></div>';
        html += '</div>';

        // Customer info
        html += '<div class="detail-section">';
        html += '<h4><i class="bi bi-person"></i> Data Pemesan</h4>';
        html += '<div class="detail-row"><span class="label">Nama</span><span class="value">' + (order.customer_name || '-') + '</span></div>';
        html += '<div class="detail-row"><span class="label">WhatsApp</span><span class="value">' + (order.whatsapp || '-') + '</span></div>';
        html += '<div class="detail-row"><span class="label">Email</span><span class="value">' + (order.email || '-') + '</span></div>';
        html += '</div>';

        // Type-specific data
        html += '<div class="detail-section">';
        html += '<h4><i class="bi bi-file-text"></i> Data ' + typeLabel + '</h4>';

        if (order.type === 'wedding') {
            if (data.bride) {
                html += '<div style="margin-bottom:8px;"><strong style="font-size:0.8rem;color:var(--text-muted);">Mempelai Wanita</strong></div>';
                html += '<div class="detail-row"><span class="label">Nama</span><span class="value">' + (data.bride.full_name || '-') + ' (' + (data.bride.nickname || '-') + ')</span></div>';
                html += '<div class="detail-row"><span class="label">Bapak</span><span class="value">' + (data.bride.father || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Ibu</span><span class="value">' + (data.bride.mother || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Alamat</span><span class="value">' + (data.bride.address || '-') + '</span></div>';
            }
            if (data.groom) {
                html += '<div style="margin:12px 0 8px;"><strong style="font-size:0.8rem;color:var(--text-muted);">Mempelai Pria</strong></div>';
                html += '<div class="detail-row"><span class="label">Nama</span><span class="value">' + (data.groom.full_name || '-') + ' (' + (data.groom.nickname || '-') + ')</span></div>';
                html += '<div class="detail-row"><span class="label">Bapak</span><span class="value">' + (data.groom.father || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Ibu</span><span class="value">' + (data.groom.mother || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Alamat</span><span class="value">' + (data.groom.address || '-') + '</span></div>';
            }
            if (data.akad && data.akad.venue) {
                html += '<div style="margin:12px 0 8px;"><strong style="font-size:0.8rem;color:var(--text-muted);">Akad Nikah</strong></div>';
                html += '<div class="detail-row"><span class="label">Hari/Tanggal</span><span class="value">' + (data.akad.day || '-') + ', ' + (data.akad.date || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Pukul</span><span class="value">' + (data.akad.time || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Tempat</span><span class="value">' + (data.akad.venue || '-') + '</span></div>';
            }
            if (data.resepsi) {
                html += '<div style="margin:12px 0 8px;"><strong style="font-size:0.8rem;color:var(--text-muted);">Resepsi</strong></div>';
                html += '<div class="detail-row"><span class="label">Hari/Tanggal</span><span class="value">' + (data.resepsi.day || '-') + ', ' + (data.resepsi.date || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Pukul</span><span class="value">' + (data.resepsi.time || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Tempat</span><span class="value">' + (data.resepsi.venue || '-') + '</span></div>';
            }
        } else if (order.type === 'khitan') {
            html += '<div class="detail-row"><span class="label">Nama Anak</span><span class="value">' + (data.child_name || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Bapak</span><span class="value">' + (data.father_name || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Ibu</span><span class="value">' + (data.mother_name || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Alamat</span><span class="value">' + (data.address || '-') + '</span></div>';
            if (data.resepsi) {
                html += '<div style="margin:12px 0 8px;"><strong style="font-size:0.8rem;color:var(--text-muted);">Resepsi</strong></div>';
                html += '<div class="detail-row"><span class="label">Hari/Tanggal</span><span class="value">' + (data.resepsi.day || '-') + ', ' + (data.resepsi.date || '-') + '</span></div>';
                html += '<div class="detail-row"><span class="label">Tempat</span><span class="value">' + (data.resepsi.venue || '-') + '</span></div>';
            }
        } else if (order.type === 'baby_name') {
            html += '<div class="detail-row"><span class="label">Nama Bayi</span><span class="value">' + (data.full_name || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Nama Panggilan</span><span class="value">' + (data.nickname || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Hari Lahir</span><span class="value">' + (data.birth_day || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Tanggal Lahir</span><span class="value">' + (data.birth_date || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Anak ke-</span><span class="value">' + (data.birth_order || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Jenis Kelamin</span><span class="value">' + (data.gender || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Berat</span><span class="value">' + (data.weight || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Panjang</span><span class="value">' + (data.height || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Jam Lahir</span><span class="value">' + (data.birth_time || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Orang Tua</span><span class="value">' + (data.parent_names || '-') + '</span></div>';
        } else if (order.type === 'birthday') {
            html += '<div class="detail-row"><span class="label">Nama</span><span class="value">' + (data.person_name || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Umur ke-</span><span class="value">' + (data.age || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Hari</span><span class="value">' + (data.event_day || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Tanggal Acara</span><span class="value">' + (data.event_date || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="label">Tema</span><span class="value">' + (data.theme || '-') + '</span></div>';
        }

        if (data.notes) {
            html += '<div style="margin:12px 0 8px;"><strong style="font-size:0.8rem;color:var(--text-muted);">Catatan</strong></div>';
            html += '<div style="font-size:0.82rem;color:var(--text-primary);white-space:pre-wrap;">' + data.notes + '</div>';
        }
        html += '</div>';

        // Files
        if (order.file_path && Array.isArray(order.file_path) && order.file_path.length > 0) {
            html += '<div class="detail-section">';
            html += '<h4><i class="bi bi-paperclip"></i> Lampiran (' + order.file_path.length + ' file)</h4>';
            html += '<div style="display:flex;flex-wrap:wrap;gap:8px;">';
            order.file_path.forEach(function(path, i) {
                html += '<a href="/storage/' + path + '" target="_blank" class="btn btn-sm btn-outline" style="font-size:0.78rem;"><i class="bi bi-eye"></i> File ' + (i + 1) + '</a>';
            });
            html += '</div></div>';
        }

        return html;
    }

    // Hapus
    window.deleteOrder = function(id, name) {
        Ravaa.confirm('Hapus Pesanan?', 'Pesanan dari "' + name + '" akan dihapus permanen!').then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // ===== BULK SELECT & DELETE =====
    const tableContainer = document.getElementById('kt_order_table_container');

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
            Ravaa.toast('Silakan pilih pesanan yang akan dihapus', 'warning');
            return;
        }
        Ravaa.confirm('Hapus Pesanan Terpilih?', 'Anda akan menghapus <strong>' + selectedIds.length + '</strong> pesanan. Tindakan ini tidak dapat dibatalkan!', 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });

    // Filters
    const searchInput = document.querySelector('[data-kt-order-table-filter="search"]');
    const typeFilter = document.querySelector('select[name="type"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const resetBtn = document.getElementById('kt_order_reset_filter');

    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        const type = typeFilter.value;
        const status = statusFilter.value;
        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (type) url.searchParams.set('type', type); else url.searchParams.delete('type');
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
    if (typeFilter) typeFilter.addEventListener('change', () => applyFilters());
    if (statusFilter) statusFilter.addEventListener('change', () => applyFilters());
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; typeFilter.value = ''; statusFilter.value = ''; applyFilters(); });
});
</script>
@endpush
