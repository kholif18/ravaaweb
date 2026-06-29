@extends('admin.layouts.app')

@section('page-title', 'Produk')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.products.index') }}">Produk</a>
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="glass-card">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">Daftar Produk</div>
        <div class="card-header-btns">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <div class="card-body">
        <!-- Table toolbar with search + filter row -->
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 280px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               id="product-search"
                               placeholder="Cari Produk..."
                               value="{{ request('search') }}">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="product-reset-filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
            <div class="toolbar-group">
                <select id="product-category-filter" class="form-select form-select-sm" style="min-width: 150px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <select id="product-status-filter" class="form-select form-select-sm" style="min-width: 110px;">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <select id="product-per-page" class="form-select form-select-sm" style="width: 68px;">
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </div>

        <!-- Bulk actions -->
        <div class="bulk-actions" id="product-bulk-actions" style="display: none;">
            <div class="bulk-info">
                <span id="product-selected-count">0</span> item dipilih
            </div>
            <div class="bulk-btns">
                <button type="button" class="btn btn-danger btn-sm" id="btn-bulk-delete-products">
                    <i class="bi bi-trash"></i> Hapus Terpilih
                </button>
                <button type="button" class="btn btn-light btn-sm" id="btn-deselect-all-products">
                    <i class="bi bi-x-circle"></i> Batal Pilih
                </button>
            </div>
        </div>

        <!--begin::Product Table Container-->
        <div id="kt_product_table_container">
            @include('admin.products._table')
        </div>
        <!--end::Product Table Container-->
    </div>
</div>
<!--end::Card-->

<!-- Hidden Forms for Actions -->
<form id="product-bulk-delete-form" method="POST" action="{{ route('admin.products.bulk.destroy') }}" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="product-bulk-delete-ids">
</form>
@endsection

@push('styles')
<style>
    .card-header-btns { display: flex; align-items: center; gap: 0.35rem; }
    .bulk-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        background: var(--accent-light);
        border-radius: 10px;
        margin-bottom: 16px;
        border: 1px solid var(--accent);
    }
    .bulk-info { font-size: 14px; font-weight: 500; color: var(--accent); }
    .bulk-btns { display: flex; gap: 8px; }
    .product-thumb {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }
    .product-thumb-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: var(--bg-surface-alt);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 16px;
        border: 1px solid var(--border-color);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const categoryFilter = document.getElementById('product-category-filter');
    const statusFilter = document.getElementById('product-status-filter');
    const perPageSelect = document.getElementById('product-per-page');
    const resetBtn = document.getElementById('product-reset-filter');
    const bulkDeleteBtn = document.getElementById('btn-bulk-delete-products');
    const deselectAllBtn = document.getElementById('btn-deselect-all-products');
    let selectedIds = new Set();
    let searchTimeout;

    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => applyFilters(), 400);
    });

    categoryFilter.addEventListener('change', () => applyFilters());
    statusFilter.addEventListener('change', () => applyFilters());
    perPageSelect.addEventListener('change', () => applyFilters());

    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        statusFilter.value = '';
        perPageSelect.value = '15';
        applyFilters();
    });

    function applyFilters() {
        const params = new URLSearchParams();
        const search = searchInput.value;
        const catId = categoryFilter.value;
        const status = statusFilter.value;
        const perPage = perPageSelect.value;
        if (search) params.set('search', search);
        if (catId) params.set('category_id', catId);
        if (status) params.set('status', status);
        if (perPage !== '15') params.set('per_page', perPage);
        window.location.href = '{{ route("admin.products.index") }}?' + params.toString();
    }

    // Bulk selection
    document.getElementById('kt_product_table_container').addEventListener('click', function(e) {
        const selectBtn = e.target.closest('[data-action="select"]');
        if (selectBtn) {
            const id = selectBtn.dataset.id;
            if (selectedIds.has(id)) {
                selectedIds.delete(id);
                selectBtn.closest('tr').classList.remove('selected');
            } else {
                selectedIds.add(id);
                selectBtn.closest('tr').classList.add('selected');
            }
            updateBulkUI();
        }
    });

    bulkDeleteBtn.addEventListener('click', function() {
        if (selectedIds.size === 0) return;
        if (confirm('Yakin ingin menghapus ' + selectedIds.size + ' produk?')) {
            document.getElementById('product-bulk-delete-ids').value = JSON.stringify([...selectedIds]);
            document.getElementById('product-bulk-delete-form').submit();
        }
    });

    deselectAllBtn.addEventListener('click', function() {
        selectedIds.clear();
        document.querySelectorAll('.selected').forEach(el => el.classList.remove('selected'));
        updateBulkUI();
    });

    function updateBulkUI() {
        document.getElementById('product-selected-count').textContent = selectedIds.size;
        document.getElementById('product-bulk-actions').style.display = selectedIds.size > 0 ? 'flex' : 'none';
    }
});
</script>
@endpush
