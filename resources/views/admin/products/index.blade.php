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
            @if($tab !== 'trash')
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
            @endif
        </div>
    </div>
    <!--end::Card header-->

    <div class="card-body">
        <!-- Tabs: Publish | Draft | Trash -->
        <ul class="nav nav-tabs nav-tabs-line mb-3" id="product-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.products.index', ['tab' => 'publish']) }}"
                   class="nav-link {{ $tab === 'publish' ? 'active' : '' }}">
                    <i class="bi bi-check-circle me-1"></i> Publikasi
                    <span class="badge ms-1" style="background: rgba(var(--accent-rgb,79,110,247),0.12); color: var(--accent); font-weight: 500; font-size: 0.7rem;">{{ $countPublish }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.products.index', ['tab' => 'draft']) }}"
                   class="nav-link {{ $tab === 'draft' ? 'active' : '' }}">
                    <i class="bi bi-pencil me-1"></i> Konsep
                    <span class="badge ms-1" style="background: rgba(234,179,8,0.12); color: #a16207; font-weight: 500; font-size: 0.7rem;">{{ $countDraft }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.products.index', ['tab' => 'trash']) }}"
                   class="nav-link {{ $tab === 'trash' ? 'active' : '' }}">
                    <i class="bi bi-trash me-1"></i> Sampah
                    <span class="badge ms-1" style="background: rgba(239,68,68,0.12); color: #b91c1c; font-weight: 500; font-size: 0.7rem;">{{ $countTrash }}</span>
                </a>
            </li>
        </ul>

        <!-- Table toolbar with search + filter row -->
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 200px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               id="product-search"
                               placeholder="Cari Produk..."
                               value="{{ request('search') }}">
                    </div>
                    @if($tab !== 'trash')
                    <select id="product-category-filter" class="form-select form-select-sm" style="min-width: 150px;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @endif
                    <button type="button" class="btn btn-light btn-sm" id="product-reset-filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
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
    <input type="hidden" name="tab" value="{{ $tab }}">
</form>

<form id="product-bulk-restore-form" method="POST" action="{{ route('admin.products.bulk.restore') }}" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="ids" id="product-bulk-restore-ids">
</form>

<form id="product-bulk-force-delete-form" method="POST" action="{{ route('admin.products.force.destroy') }}" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="product-bulk-force-delete-ids">
</form>

<form id="product-single-delete-form" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="product-single-restore-form" method="POST" action="" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form id="product-single-force-delete-form" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .card-header-btns { display: flex; align-items: center; gap: 0.35rem; }
    .product-thumb {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid rgba(0, 0, 0, 0.06);
        flex-shrink: 0;
    }
    .product-thumb-placeholder {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #f5f6f8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted, #9aa0a6);
        font-size: 13px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        flex-shrink: 0;
    }
    #kt_products_table tbody td {
        padding: 8px 10px;
    }
    #kt_products_table thead th {
        padding: 8px 10px;
        font-size: 0.72rem;
        color: var(--text-muted);
        font-weight: 600;
    }
    #kt_products_table tbody tr:hover {
        background: var(--bg-surface-hover);
    }

    /* Tabs styling - macOS style segmented control */
    #product-tabs {
        border-bottom: 1px solid rgba(0,0,0,0.06);
        padding: 0;
        margin-bottom: 1.25rem !important;
        display: flex;
        gap: 0;
    }
    #product-tabs .nav-item {
        margin-bottom: -1px;
        list-style: none;
    }
    #product-tabs .nav-link {
        border: none;
        background: none;
        color: var(--text-muted, #9aa0a6);
        padding: 0.55rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 500;
        position: relative;
        transition: color 0.2s ease;
        border-radius: 0;
        white-space: nowrap;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    #product-tabs .nav-link i {
        font-size: 0.85rem;
        margin-right: 0.35rem;
    }
    #product-tabs .nav-link:hover {
        color: var(--text-primary, #1d1d1f);
        background: rgba(0,113,227,0.04);
    }
    #product-tabs .nav-link.active {
        color: var(--accent, #0071e3);
        background: none;
        font-weight: 600;
    }
    #product-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0.75rem;
        right: 0.75rem;
        height: 2.5px;
        background: var(--accent, #0071e3);
        border-radius: 3px 3px 0 0;
    }
    #product-tabs .nav-link .badge {
        vertical-align: middle;
        font-weight: 500;
        font-size: 0.68rem;
        padding: 0.15em 0.55em;
        margin-left: 0.35rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableContainer = document.getElementById('kt_product_table_container');
    const searchInput = document.getElementById('product-search');
    const categoryFilter = document.getElementById('product-category-filter');
    const resetBtn = document.getElementById('product-reset-filter');
    const currentTab = '{{ $tab }}';
    let searchTimeout;

    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif
    @if($errors->any())
        Ravaa.toast('{{ $errors->first() }}', 'error');
    @endif

    // ===== SELECT ALL / BULK SELECT =====
    function updateBulkUI() {
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const count = selectedItems.length;

        @if($tab === 'trash')
            const restoreBtn = document.getElementById('bulk-restore-btn');
            const forceDeleteBtn = document.getElementById('bulk-force-delete-btn');
            if (restoreBtn) {
                restoreBtn.style.display = count > 0 ? 'inline-block' : 'none';
                restoreBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i> Pulihkan (' + count + ')';
            }
            if (forceDeleteBtn) {
                forceDeleteBtn.style.display = count > 0 ? 'inline-block' : 'none';
                forceDeleteBtn.innerHTML = '<i class="bi bi-trash3"></i> Hapus Permanen (' + count + ')';
            }
        @else
            const deleteBtn = document.getElementById('bulk-delete-btn');
            if (deleteBtn) {
                deleteBtn.style.display = count > 0 ? 'inline-block' : 'none';
                deleteBtn.innerHTML = '<i class="bi bi-trash"></i> Hapus (' + count + ')';
            }
        @endif
    }

    function initializeTableEvents() {
        // Select all / individual checkboxes
        const selectAll = document.getElementById('select-all');
        const selectItems = tableContainer.querySelectorAll('.select-item');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                selectItems.forEach(item => { item.checked = this.checked; });
                updateBulkUI();
            });
        }
        selectItems.forEach(item => {
            item.addEventListener('change', updateBulkUI);
        });

        // Single item action buttons (re-bind after AJAX)
        @if($tab === 'trash')
            document.querySelectorAll('.btn-restore-product').forEach(btn => {
                btn.onclick = function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    Ravaa.confirm('Pulihkan Produk?', `Produk "${name}" akan dipulihkan dari sampah.`, 'question').then(function(result) {
                        if (result.isConfirmed) {
                            const form = document.getElementById('product-single-restore-form');
                            form.action = '/admin/products/' + id + '/restore';
                            form.submit();
                        }
                    });
                };
            });
            document.querySelectorAll('.btn-force-delete-product').forEach(btn => {
                btn.onclick = function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    Ravaa.confirm('Hapus Permanen?', `Produk "${name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`, 'error').then(function(result) {
                        if (result.isConfirmed) {
                            const form = document.getElementById('product-single-force-delete-form');
                            form.action = '/admin/products/' + id + '/force';
                            form.submit();
                        }
                    });
                };
            });
        @else
            document.querySelectorAll('.btn-delete-product').forEach(btn => {
                btn.onclick = function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    Ravaa.confirm('Hapus Produk?', `Produk "${name}" akan dipindahkan ke sampah.`, 'question').then(function(result) {
                        if (result.isConfirmed) {
                            const form = document.getElementById('product-single-delete-form');
                            form.action = '/admin/products/' + id;
                            form.submit();
                        }
                    });
                };
            });
        @endif

        updateBulkUI();
    }
    initializeTableEvents();

    // ===== FILTERS (AJAX) =====
    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        const catId = categoryFilter ? categoryFilter.value : '';

        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (catId) url.searchParams.set('category_id', catId); else url.searchParams.delete('category_id');
        if (page > 1) url.searchParams.set('page', page); else url.searchParams.delete('page');

        try {
            const response = await fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
            });
            const html = await response.text();
            tableContainer.innerHTML = html;
            window.history.pushState({}, '', url.toString());
            initializeTableEvents();
        } catch (e) {
            window.location.href = url.toString();
        } finally {
            tableContainer.style.opacity = '1';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => applyFilters(), 400);
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', () => applyFilters());
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (categoryFilter) categoryFilter.value = '';
            applyFilters();
        });
    }

    // ===== INLINE BULK BUTTONS (inside _table) via event delegation =====
    document.addEventListener('click', function(e) {
        const bulkBtn = e.target.closest('#bulk-delete-btn, #bulk-restore-btn, #bulk-force-delete-btn');
        if (!bulkBtn) return;

        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        if (selectedIds.length === 0) return;

        if (bulkBtn.id === 'bulk-delete-btn') {
            Ravaa.confirm('Hapus Produk?', `Anda akan memindahkan <strong>${selectedIds.length}</strong> produk ke sampah.`, 'question').then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('product-bulk-delete-ids').value = JSON.stringify(selectedIds);
                    document.getElementById('product-bulk-delete-form').submit();
                }
            });
        } else if (bulkBtn.id === 'bulk-restore-btn') {
            Ravaa.confirm('Pulihkan Produk?', `Anda akan memulihkan <strong>${selectedIds.length}</strong> produk dari sampah.`, 'question').then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('product-bulk-restore-ids').value = JSON.stringify(selectedIds);
                    document.getElementById('product-bulk-restore-form').submit();
                }
            });
        } else if (bulkBtn.id === 'bulk-force-delete-btn') {
            Ravaa.confirm('Hapus Permanen?', `Anda akan menghapus permanen <strong>${selectedIds.length}</strong> produk. Tindakan ini tidak dapat dibatalkan!`, 'error').then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('product-bulk-force-delete-ids').value = JSON.stringify(selectedIds);
                    document.getElementById('product-bulk-force-delete-form').submit();
                }
            });
        }
    });
});
</script>
@endpush
