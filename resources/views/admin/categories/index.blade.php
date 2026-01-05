@extends('admin.layouts.app')

@section('page-title', 'Kategori Produk')
@section('page-description', 'Manajemen Kategori Produk — Ravaa Creative')

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
        Kategori Produk
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
            <h2>Manajemen Kategori Produk</h2>
        </div>
        <!--end::Card title-->
        
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-category-table-toolbar="base">
                <!--begin::Add category-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Kategori
                </button>
                <!--end::Add category-->
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
            <i class="bi bi-tags fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Kategori Produk</h4>
                <span>Kelola kategori produk untuk mengorganisir produk Anda. Anda dapat menambahkan, mengedit, atau menghapus kategori sesuai kebutuhan.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        @if($categories->count() > 0)
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_categories_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" id="select-all" />
                        </div>
                    </th>
                    <th class="min-w-150px">Nama Kategori</th>
                    <th class="min-w-150px">Slug</th>
                    <th class="min-w-100px">Icon</th>
                    <th class="min-w-100px">Status</th>
                    <th class="min-w-100px">Urutan</th>
                    <th class="min-w-100px">Jumlah Produk</th>
                    <th class="min-w-100px">Parent</th>
                    <th class="min-w-100px text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @foreach($categories as $category)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input select-item" type="checkbox" value="{{ $category->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <i class="{{ $category->icon }} fs-2 text-primary"></i>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#" class="text-gray-800 text-hover-primary fw-bold" 
                                   onclick="editCategory({{ $category->id }})" 
                                   data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category">
                                    {{ $category->name }}
                                </a>
                                @if($category->description)
                                <span class="text-muted fw-semibold fs-7">{{ Str::limit($category->description, 50) }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-light">{{ $category->slug }}</span>
                    </td>
                    <td>
                        <i class="{{ $category->icon }} fs-3 text-primary"></i>
                    </td>
                    <td>
                        @if($category->status == 'active')
                        <span class="badge badge-light-success">Aktif</span>
                        @else
                        <span class="badge badge-light-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-circle badge-light">{{ $category->order }}</span>
                    </td>
                    <td>
                        <span class="badge badge-light">{{ $category->products_count }} Produk</span>
                    </td>
                    <td>
                        @if($category->parent)
                            <span class="badge badge-light-info">{{ $category->parent->name }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" 
                                       onclick="editCategory({{ $category->id }})" 
                                       data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category">
                                        <i class="bi bi-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" 
                                       onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                        <i class="bi bi-trash me-2"></i> Hapus
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    @if($category->status == 'active')
                                    <a class="dropdown-item text-danger" href="#" 
                                       onclick="updateStatus({{ $category->id }}, 'inactive', '{{ $category->name }}')">
                                        <i class="bi bi-x-circle me-2"></i> Nonaktifkan
                                    </a>
                                    @else
                                    <a class="dropdown-item text-success" href="#" 
                                       onclick="updateStatus({{ $category->id }}, 'active', '{{ $category->name }}')">
                                        <i class="bi bi-check-circle me-2"></i> Aktifkan
                                    </a>
                                    @endif
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
                Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
            </div>
            
            <div class="d-flex align-items-center">
                <!-- Bulk Actions -->
                <div class="me-5">
                    <button type="button" class="btn btn-light-danger btn-sm" id="bulk-delete-btn" style="display: none;">
                        <i class="bi bi-trash"></i> Hapus Terpilih
                    </button>
                </div>
                
                <!-- Pagination -->
                {{ $categories->links('vendor.pagination.custom') }}
            </div>
        </div>
        <!--end::Pagination and Bulk Actions-->
        
        @else
        <!--begin::Empty State-->
        <div class="text-center py-10">
            <i class="bi bi-tags fs-4hx text-gray-400 mb-5"></i>
            <h3 class="text-gray-600">Tidak Ada Kategori</h3>
            <p class="text-muted">Belum ada kategori produk. Tambahkan kategori pertama Anda.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
                <i class="bi bi-plus-circle"></i> Tambah Kategori Pertama
            </button>
        </div>
        <!--end::Empty State-->
        @endif
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<!--begin::Modal - Add Category-->
<div class="modal fade" id="kt_modal_add_category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Kategori Baru</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            
            <div class="modal-body py-10 px-lg-17">
                <form id="kt_modal_add_category_form" class="form" action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" 
                               placeholder="Masukkan nama kategori" 
                               name="name" 
                               required />
                        <div class="text-danger fs-7 mt-1" id="name-error"></div>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" 
                                  rows="3" 
                                  placeholder="Masukkan deskripsi kategori" 
                                  name="description"></textarea>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-icons"></i>
                                </span>
                                <select class="form-select form-select-solid" 
                                        name="icon" 
                                        data-control="select2" 
                                        data-placeholder="Pilih icon"
                                        required>
                                    <option></option>
                                    <option value="fas fa-print">Print</option>
                                    <option value="fas fa-paint-brush">Paint Brush</option>
                                    <option value="fas fa-paperclip">Paperclip</option>
                                    <option value="fas fa-gift">Gift</option>
                                    <option value="fas fa-desktop">Desktop</option>
                                    <option value="fas fa-envelope-open-text">Envelope</option>
                                    <option value="fas fa-palette">Palette</option>
                                    <option value="fas fa-tools">Tools</option>
                                    <option value="fas fa-box">Box</option>
                                    <option value="fas fa-tags" selected>Tags</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" 
                                   min="1" max="100" 
                                   value="1" 
                                   name="order" 
                                   required />
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Status</label>
                            <select class="form-select form-select-solid" name="status" required>
                                <option value="active" selected>Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Parent Kategori</label>
                            <select class="form-select form-select-solid" name="parent_id">
                                <option value="">-- Tanpa Parent --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Slug (URL)</label>
                        <input type="text" class="form-control form-control-solid" 
                               placeholder="slug-otomatis-jika-kosong" 
                               name="slug" />
                        <div class="text-muted fs-7 mt-1">
                            URL friendly version. Kosongkan untuk generate otomatis dari nama.
                        </div>
                    </div>
                    
                    <div class="card card-bordered mb-7">
                        <div class="card-header">
                            <h4 class="card-title">SEO Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="fv-row mb-5">
                                <label class="fs-6 fw-semibold mb-2">Meta Title</label>
                                <input type="text" class="form-control form-control-solid" 
                                       placeholder="Meta title untuk SEO" 
                                       name="meta_title" />
                            </div>
                            
                            <div class="fv-row mb-5">
                                <label class="fs-6 fw-semibold mb-2">Meta Description</label>
                                <textarea class="form-control form-control-solid" 
                                          rows="2"
                                          placeholder="Meta description untuk SEO" 
                                          name="meta_description"></textarea>
                            </div>
                            
                            <div class="fv-row">
                                <label class="fs-6 fw-semibold mb-2">Meta Keywords</label>
                                <input type="text" class="form-control form-control-solid" 
                                       placeholder="Keyword1, Keyword2, Keyword3" 
                                       name="meta_keywords" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="kt_modal_add_category_submit">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Add Category-->

<!--begin::Modal - Edit Category-->
<div class="modal fade" id="kt_modal_edit_category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Edit Kategori</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            
            <div class="modal-body py-10 px-lg-17">
                <form id="kt_modal_edit_category_form" class="form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_category_id" />
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" 
                               placeholder="Masukkan nama kategori" 
                               name="name" 
                               id="edit_category_name"
                               required />
                        <div class="text-danger fs-7 mt-1" id="edit_name-error"></div>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" 
                                  rows="3" 
                                  placeholder="Masukkan deskripsi kategori" 
                                  name="description" 
                                  id="edit_category_description"></textarea>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-icons"></i>
                                </span>
                                <select class="form-select form-select-solid" 
                                        name="icon" 
                                        id="edit_category_icon" 
                                        data-control="select2" 
                                        data-placeholder="Pilih icon"
                                        required>
                                    <option></option>
                                    <option value="fas fa-print">Print</option>
                                    <option value="fas fa-paint-brush">Paint Brush</option>
                                    <option value="fas fa-paperclip">Paperclip</option>
                                    <option value="fas fa-gift">Gift</option>
                                    <option value="fas fa-desktop">Desktop</option>
                                    <option value="fas fa-envelope-open-text">Envelope</option>
                                    <option value="fas fa-palette">Palette</option>
                                    <option value="fas fa-tools">Tools</option>
                                    <option value="fas fa-box">Box</option>
                                    <option value="fas fa-tags">Tags</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" 
                                   min="1" max="100" 
                                   name="order" 
                                   id="edit_category_order"
                                   required />
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Status</label>
                            <select class="form-select form-select-solid" name="status" id="edit_category_status" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Parent Kategori</label>
                            <select class="form-select form-select-solid" name="parent_id" id="edit_category_parent">
                                <option value="">-- Tanpa Parent --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Slug (URL)</label>
                        <input type="text" class="form-control form-control-solid" 
                               placeholder="slug-kategori" 
                               name="slug" 
                               id="edit_category_slug" />
                    </div>
                    
                    <div class="card card-bordered mb-7">
                        <div class="card-header">
                            <h4 class="card-title">SEO Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="fv-row mb-5">
                                <label class="fs-6 fw-semibold mb-2">Meta Title</label>
                                <input type="text" class="form-control form-control-solid" 
                                       placeholder="Meta title untuk SEO" 
                                       name="meta_title" 
                                       id="edit_category_meta_title" />
                            </div>
                            
                            <div class="fv-row mb-5">
                                <label class="fs-6 fw-semibold mb-2">Meta Description</label>
                                <textarea class="form-control form-control-solid" 
                                          rows="2"
                                          placeholder="Meta description untuk SEO" 
                                          name="meta_description" 
                                          id="edit_category_meta_description"></textarea>
                            </div>
                            
                            <div class="fv-row">
                                <label class="fs-6 fw-semibold mb-2">Meta Keywords</label>
                                <input type="text" class="form-control form-control-solid" 
                                       placeholder="Keyword1, Keyword2, Keyword3" 
                                       name="meta_keywords" 
                                       id="edit_category_meta_keywords" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center pt-10">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="kt_modal_edit_category_submit">
                            <span class="indicator-label">Update</span>
                            <span class="indicator-progress">Mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Edit Category-->

<!-- Hidden Forms for Actions -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="status-form" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="status-input">
</form>

<form id="bulk-delete-form" method="POST" action="{{ route('admin.categories.bulk.destroy') }}" style="display: none;">
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
    .symbol-label {
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
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

    document.getElementById('toastContainer').insertAdjacentHTML('beforeend', toastHTML);
    
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

// Edit Category Function
async function editCategory(id) {
    try {
        showToast('info', 'Memuat data kategori...', 'Loading');
        
        const response = await fetch(`/admin/categories/${id}/edit`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            const category = data.category;
            
            // Set form values
            document.getElementById('edit_category_id').value = category.id;
            document.getElementById('edit_category_name').value = category.name;
            document.getElementById('edit_category_description').value = category.description || '';
            document.getElementById('edit_category_icon').value = category.icon;
            document.getElementById('edit_category_order').value = category.order;
            document.getElementById('edit_category_status').value = category.status;
            document.getElementById('edit_category_parent').value = category.parent_id || '';
            document.getElementById('edit_category_slug').value = category.slug;
            document.getElementById('edit_category_meta_title').value = category.meta_title || '';
            document.getElementById('edit_category_meta_description').value = category.meta_description || '';
            document.getElementById('edit_category_meta_keywords').value = category.meta_keywords || '';
            
            // Update select2
            $('#edit_category_icon').val(category.icon).trigger('change');
            
            // Update parent categories dropdown jika ada data
            if (data.parent_categories) {
                const parentSelect = document.getElementById('edit_category_parent');
                // Clear existing options except the first one
                while (parentSelect.options.length > 1) {
                    parentSelect.remove(1);
                }
                
                // Add new options
                data.parent_categories.forEach(parent => {
                    const option = new Option(parent.name, parent.id);
                    parentSelect.add(option);
                });
                
                // Set selected value
                parentSelect.value = category.parent_id || '';
            }
            
            // Set form action
            document.getElementById('kt_modal_edit_category_form').action = `/admin/categories/${category.id}`;
            
            showToast('success', 'Data kategori berhasil dimuat', 'Sukses!');
        } else {
            showToast('error', data.message || 'Gagal memuat data kategori', 'Error!');
        }
    } catch (error) {
        console.error('Error:', error);
        
        if (error.message.includes('JSON')) {
            // Jika response bukan JSON, mungkin server error
            showToast('error', 'Server mengembalikan response yang tidak valid. Coba refresh halaman.', 'Error!');
        } else if (error.message.includes('404')) {
            showToast('error', 'Kategori tidak ditemukan', 'Error!');
        } else if (error.message.includes('500')) {
            showToast('error', 'Terjadi kesalahan di server', 'Error!');
        } else {
            showToast('error', 'Terjadi kesalahan: ' + error.message, 'Error!');
        }
    }
}

// Delete Category Function
function deleteCategory(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Kategori <strong>"${name}"</strong> akan dihapus permanen.`,
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
            const form = document.getElementById('delete-form');
            form.action = `/admin/categories/${id}`;
            form.submit();
        }
    });
}

// Update Status Function
function updateStatus(id, status, name) {
    const action = status === 'active' ? 'Aktifkan' : 'Nonaktifkan';
    
    Swal.fire({
        title: `${action} Kategori?`,
        html: `Kategori <strong>"${name}"</strong> akan di${action.toLowerCase()}.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Ya, ${action}!`,
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-light'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('status-form');
            form.action = `/admin/categories/${id}/status`;
            document.getElementById('status-input').value = status;
            form.submit();
        }
    });
}

// Form Submission with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    $('[data-control="select2"]').select2({
        minimumResultsForSearch: 10
    });
    
    // Add Category Form
    const addForm = document.getElementById('kt_modal_add_category_form');
    const addSubmitButton = document.getElementById('kt_modal_add_category_submit');
    
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        addSubmitButton.setAttribute('data-kt-indicator', 'on');
        addSubmitButton.disabled = true;
        
        // Clear previous errors
        document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            addSubmitButton.removeAttribute('data-kt-indicator');
            addSubmitButton.disabled = false;
            
            if (data.errors) {
                // Display validation errors
                Object.keys(data.errors).forEach(key => {
                    const errorElement = document.getElementById(`${key}-error`);
                    if (errorElement) {
                        errorElement.textContent = data.errors[key][0];
                    }
                });
                showToast('error', 'Terdapat kesalahan validasi', 'Validasi Error!');
            } else if (data.success) {
                // Close modal and refresh page
                $('#kt_modal_add_category').modal('hide');
                addForm.reset();
                showToast('success', data.message, 'Sukses!');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            addSubmitButton.removeAttribute('data-kt-indicator');
            addSubmitButton.disabled = false;
            console.error('Error:', error);
            showToast('error', 'Terjadi kesalahan saat menyimpan data', 'Error!');
        });
    });
    
    // Edit Category Form
    const editForm = document.getElementById('kt_modal_edit_category_form');
    const editSubmitButton = document.getElementById('kt_modal_edit_category_submit');
    
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        editSubmitButton.setAttribute('data-kt-indicator', 'on');
        editSubmitButton.disabled = true;
        
        // Clear previous errors
        document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            editSubmitButton.removeAttribute('data-kt-indicator');
            editSubmitButton.disabled = false;
            
            if (data.errors) {
                // Display validation errors
                Object.keys(data.errors).forEach(key => {
                    const errorElement = document.getElementById(`edit_${key}-error`);
                    if (errorElement) {
                        errorElement.textContent = data.errors[key][0];
                    }
                });
                showToast('error', 'Terdapat kesalahan validasi', 'Validasi Error!');
            } else if (data.success) {
                // Close modal and refresh page
                $('#kt_modal_edit_category').modal('hide');
                showToast('success', data.message, 'Sukses!');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            editSubmitButton.removeAttribute('data-kt-indicator');
            editSubmitButton.disabled = false;
            console.error('Error:', error);
            showToast('error', 'Terjadi kesalahan saat menyimpan data', 'Error!');
        });
    });
    
    // Bulk Actions
    const selectAll = document.getElementById('select-all');
    const selectItems = document.querySelectorAll('.select-item');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    
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
                showToast('warning', 'Silakan pilih kategori yang akan dihapus', 'Peringatan!');
                return;
            }
            
            Swal.fire({
                title: 'Hapus Kategori Terpilih?',
                html: `Anda akan menghapus <strong>${selectedIds.length}</strong> kategori.`,
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
                    document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                    document.getElementById('bulk-delete-form').submit();
                }
            });
        });
    }
    
    // Auto-generate slug from name
    const nameInput = document.getElementById('edit_category_name');
    const slugInput = document.getElementById('edit_category_slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function() {
            if (!slugInput.value) {
                // Simple slug generation
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s]/gi, '')
                    .replace(/\s+/g, '-');
                slugInput.value = slug;
            }
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