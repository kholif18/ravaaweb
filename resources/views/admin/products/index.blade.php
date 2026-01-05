@extends('admin.layouts.app')

@section('page-title', 'Semua Produk')
@section('page-description', 'Manajemen Produk — Ravaa Creative')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}"
           class="text-muted text-hover-primary">
            Dashboard
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Semua Produk
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Manajemen Produk</h2>
        </div>
        <!--end::Card title-->
        
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-product-table-toolbar="base">
                <!--begin::Export-->
                <a href="{{ route('admin.products.export') }}" class="btn btn-light-success me-3">
                    <i class="bi bi-download"></i>
                    Export
                </a>
                <!--end::Export-->
                
                <!--begin::Add product-->
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Produk
                </a>
                <!--end::Add product-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-boxes fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Produk</h4>
                <span>Kelola semua produk Anda di sini. Filter, cari, dan kelola produk dengan mudah.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Search and Filters-->
        <div class="card card-bordered mb-10">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.products.index') }}">
                    <div class="row g-8">
                        <div class="col-md-3">
                            <label class="form-label">Cari Produk</label>
                            <input type="text" class="form-control" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nama, SKU, deskripsi..." />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status Stok</label>
                            <select class="form-select" name="stock_status">
                                <option value="">Semua</option>
                                <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="pre_order" {{ request('stock_status') == 'pre_order' ? 'selected' : '' }}>Pre Order</option>
                                <option value="backorder" {{ request('stock_status') == 'backorder' ? 'selected' : '' }}>Backorder</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Harga Min</label>
                                    <input type="number" class="form-control" 
                                           name="min_price" 
                                           value="{{ request('min_price') }}"
                                           placeholder="Min" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Harga Max</label>
                                    <input type="number" class="form-control" 
                                           name="max_price" 
                                           value="{{ request('max_price') }}"
                                           placeholder="Max" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-md-12">
                            <div class="form-check form-check-custom form-check-solid me-5">
                                <input class="form-check-input" type="checkbox" 
                                       name="featured" 
                                       value="1" 
                                       id="featured" 
                                       {{ request('featured') ? 'checked' : '' }} />
                                <label class="form-check-label" for="featured">
                                    Featured Only
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Search and Filters-->
        
        @if($products->count() > 0)
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_products_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" id="select-all" />
                        </div>
                    </th>
                    <th class="min-w-200px">Produk</th>
                    <th class="min-w-100px">SKU</th>
                    <th class="min-w-100px">Kategori</th>
                    <th class="min-w-100px">Harga</th>
                    <th class="min-w-100px">Stok</th>
                    <th class="min-w-100px">Status</th>
                    <th class="min-w-100px">Terjual</th>
                    <th class="min-w-100px text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @foreach($products as $product)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input select-item" type="checkbox" value="{{ $product->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" class="rounded" alt="{{ $product->name }}" />
                                @else
                                    <div class="symbol-label bg-light">
                                        <i class="bi bi-image text-gray-400 fs-2"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-gray-800 text-hover-primary fw-bold mb-1">
                                    {{ $product->name }}
                                </a>
                                @if($product->short_description)
                                <span class="text-muted fs-7">{{ Str::limit($product->short_description, 60) }}</span>
                                @endif
                                <div class="mt-1">
                                    @if($product->is_featured)
                                    <span class="badge badge-light-success badge-sm me-1">Featured</span>
                                    @endif
                                    @if($product->is_best_seller)
                                    <span class="badge badge-light-danger badge-sm me-1">Best Seller</span>
                                    @endif
                                    @if($product->is_new_arrival)
                                    <span class="badge badge-light-info badge-sm me-1">New Arrival</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-light">{{ $product->sku ?? '-' }}</span>
                    </td>
                    <td>
                        @if($product->category)
                            <span class="badge badge-light-info">{{ $product->category->name }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            @if($product->hasDiscount())
                                <span class="text-decoration-line-through text-muted fs-7">
                                    {{ $product->formatted_price }}
                                </span>
                                <span class="text-danger fw-bold">
                                    {{ $product->formatted_discount_price }}
                                </span>
                                <span class="badge badge-light-danger badge-sm mt-1">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @else
                                <span class="fw-bold">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">{{ $product->stock_quantity }}</span>
                            <span class="badge badge-light-{{ $product->stock_status_badge_class }} badge-sm">
                                {{ $product->stock_status_text }}
                            </span>
                        </div>
                    </td>
                    <td>
                        @if($product->status == 'published')
                        <span class="badge badge-light-success">Published</span>
                        @elseif($product->status == 'draft')
                        <span class="badge badge-light-warning">Draft</span>
                        @else
                        <span class="badge badge-light-danger">Archived</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">{{ $product->sold_count }}</span>
                            <span class="text-muted fs-7">{{ $product->view_count }} views</span>
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.products.edit', $product) }}">
                                        <i class="bi bi-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.products.show', $product) }}">
                                        <i class="bi bi-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                          class="d-inline" id="delete-form-{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" 
                                                onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">
                                            <i class="bi bi-trash me-2"></i> Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--end::Table-->
        
        <!--begin::Pagination and Bulk Actions-->
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} produk
            </div>
            
            <div class="d-flex align-items-center">
                <!-- Bulk Actions -->
                <div class="me-5">
                    <button type="button" class="btn btn-light-danger btn-sm" id="bulk-delete-btn" style="display: none;">
                        <i class="bi bi-trash"></i> Hapus Terpilih
                    </button>
                </div>
                
                <!-- Pagination -->
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        </div>
        <!--end::Pagination and Bulk Actions-->
        
        @else
        <!--begin::Empty State-->
        <div class="text-center py-10">
            <i class="bi bi-boxes fs-4hx text-gray-400 mb-5"></i>
            <h3 class="text-gray-600">Tidak Ada Produk</h3>
            <p class="text-muted">Belum ada produk. Tambahkan produk pertama Anda.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Produk Pertama
            </a>
        </div>
        <!--end::Empty State-->
        @endif
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<!-- Bulk Delete Form -->
<form id="bulk-delete-form" method="POST" action="{{ route('admin.products.bulk.destroy') }}" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('styles')
<style>
    .dropdown-menu {
        min-width: 120px;
    }
    .symbol-50px {
        width: 50px;
        height: 50px;
    }
    .symbol-50px img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Toast Styles */
    .toast {
        border: 0;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .toast-success {
        background-color: #d1fae5;
        border-left: 4px solid #10b981;
    }
    .toast-error {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
    }
    .toast-warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
    }
    .toast-info {
        background-color: #e0f2fe;
        border-left: 4px solid #0ea5e9;
    }
</style>
@endpush

@push('scripts')
<script>
// Toast Notification Function
function showToast(type, message, title = '') {
    const toastId = 'toast-' + Date.now();
    const icon = {
        'success': 'bi-check-circle',
        'error': 'bi-x-circle',
        'warning': 'bi-exclamation-triangle',
        'info': 'bi-info-circle'
    }[type] || 'bi-info-circle';

    const color = {
        'success': 'text-success',
        'error': 'text-danger',
        'warning': 'text-warning',
        'info': 'text-info'
    }[type] || 'text-info';

    const toastHTML = `
        <div id="${toastId}" class="toast toast-${type} mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi ${icon} ${color} me-2"></i>
                <strong class="me-auto">${title || type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                <small class="text-muted">baru saja</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    const container = document.getElementById('toastContainer');
    if (!container) {
        console.error('Toast container not found');
        return;
    }
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        delay: 5000,
        autohide: true
    });
    toast.show();

    // Remove toast from DOM after hide
    toastElement.addEventListener('hidden.bs.toast', function () {
        this.remove();
    });
}

// Show session messages as toast
@if(session('success'))
    showToast('success', '{{ session('success') }}', 'Sukses!');
@endif

@if(session('error'))
    showToast('error', '{{ session('error') }}', 'Error!');
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        showToast('error', '{{ $error }}', 'Validasi Error!');
    @endforeach
@endif

// Delete Confirmation Function
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Produk?',
        html: `Produk <strong>"${name}"</strong> akan dihapus permanen beserta semua gambarnya.`,
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

// Bulk Actions
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const selectItems = document.querySelectorAll('.select-item');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');
    const bulkDeleteIds = document.getElementById('bulk-delete-ids');
    
    // Select All
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            selectItems.forEach(item => {
                item.checked = this.checked;
            });
            updateBulkDeleteButton();
        });
    }
    
    // Individual item selection
    selectItems.forEach(item => {
        item.addEventListener('change', updateBulkDeleteButton);
    });
    
    // Update bulk delete button visibility
    function updateBulkDeleteButton() {
        const selectedIds = Array.from(selectItems)
            .filter(item => item.checked)
            .map(item => item.value);
        
        if (selectedIds.length > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
        } else {
            bulkDeleteBtn.style.display = 'none';
        }
    }
    
    // Bulk delete
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = Array.from(selectItems)
                .filter(item => item.checked)
                .map(item => item.value);
            
            if (selectedIds.length === 0) {
                showToast('warning', 'Silakan pilih produk yang akan dihapus', 'Peringatan!');
                return;
            }
            
            Swal.fire({
                title: 'Hapus Produk Terpilih?',
                html: `Anda akan menghapus <strong>${selectedIds.length}</strong> produk beserta semua gambarnya.`,
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkDeleteIds.value = JSON.stringify(selectedIds);
                    bulkDeleteForm.submit();
                }
            });
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush