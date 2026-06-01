@extends('admin.layouts.app')

@section('page-title', 'Kategori Produk')

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
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1 me-5">
                <i class="bi bi-search fs-3 position-absolute ms-6"></i>
                <input type="text" 
                       data-kt-category-table-filter="search" 
                       class="form-control form-control-solid w-250px ps-15" 
                       placeholder="Cari Kategori..." 
                       name="search"
                       value="{{ $filters['search'] ?? '' }}" />
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->
        
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end align-items-center" data-kt-category-table-toolbar="base">
                <!--begin::Filter-->
                <div class="me-3">
                    <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-solid w-125px" data-placeholder="Status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                
                <div class="me-3">
                    <select name="parent" data-control="select2" class="form-select form-select-solid w-200px" data-placeholder="Parent">
                        <option value="">Semua Parent</option>
                        <option value="null" {{ ($filters['parent'] ?? '') == 'null' ? 'selected' : '' }}>Tanpa Parent (Root)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ ($filters['parent'] ?? '') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="button" class="btn btn-light-primary me-3" id="kt_category_reset_filter">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </button>
                <!--end::Filter-->

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
        <!--begin::Category Table Container-->
        <div id="kt_category_table_container">
            @include('admin.categories._table')
        </div>
        <!--end::Category Table Container-->
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
                                    <i id="add_icon_preview" class="fas fa-icons"></i>
                                </span>
                                <select
                                    class="form-select form-select-solid"
                                    id="add_category_icon"
                                    name="icon">

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
                                    <option value="fas fa-shopping-bag">Shopping Bag</option>
                                    <option value="fas fa-shopping-cart">Shopping Cart</option>
                                    <option value="fas fa-tshirt">T-Shirt</option>
                                    <option value="fas fa-laptop">Laptop</option>
                                    <option value="fas fa-mobile-alt">Mobile</option>
                                    <option value="fas fa-camera">Camera</option>
                                    <option value="fas fa-book">Book</option>
                                    <option value="fas fa-utensils">Utensils</option>
                                    <option value="fas fa-home">Home</option>
                                    <option value="fas fa-heart">Heart</option>
                                    <option value="fas fa-star">Star</option>
                                    <option value="fas fa-cog">Gear</option>
                                    <option value="fas fa-user">User</option>
                                    <option value="fas fa-image">Image</option>
                                    <option value="fas fa-music">Music</option>
                                    <option value="fas fa-film">Film</option>
                                    <option value="fas fa-gamepad">Gamepad</option>
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
                <form id="kt_modal_edit_category_form" class="form" method="POST" data-update-url="{{ route('admin.categories.update', ':id') }}">
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
                                    <i id="icon_preview" class="fas fa-icons"></i>
                                </span>
                                <select class="form-select form-select-solid" 
                                        name="icon" 
                                        id="edit_category_icon" 
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
                                    <option value="fas fa-shopping-bag">Shopping Bag</option>
                                    <option value="fas fa-shopping-cart">Shopping Cart</option>
                                    <option value="fas fa-tshirt">T-Shirt</option>
                                    <option value="fas fa-laptop">Laptop</option>
                                    <option value="fas fa-mobile-alt">Mobile</option>
                                    <option value="fas fa-camera">Camera</option>
                                    <option value="fas fa-book">Book</option>
                                    <option value="fas fa-utensils">Utensils</option>
                                    <option value="fas fa-home">Home</option>
                                    <option value="fas fa-heart">Heart</option>
                                    <option value="fas fa-star">Star</option>
                                    <option value="fas fa-cog">Gear</option>
                                    <option value="fas fa-user">User</option>
                                    <option value="fas fa-image">Image</option>
                                    <option value="fas fa-music">Music</option>
                                    <option value="fas fa-film">Film</option>
                                    <option value="fas fa-gamepad">Gamepad</option>
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
<form id="delete-form" method="POST" data-delete-url="{{ route('admin.categories.destroy', ':id') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="status-form" method="POST" data-status-url="{{ route('admin.categories.status.update', ':id') }}" style="display: none;">
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

// Add Modal
const addIconSelect = document.getElementById('add_category_icon');
const addIconPreview = document.getElementById('add_icon_preview');

// Edit Modal
const editIconSelect = document.getElementById('edit_category_icon');
const editIconPreview = document.getElementById('icon_preview');

function updateIconPreview(selectId, previewId) {
    const select = document.getElementById(selectId);
    const preview = document.getElementById(previewId);

    if (!select || !preview) return;

    preview.className = select.value;

    select.addEventListener('change', () => {
        preview.className = select.value;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    updateIconPreview('add_category_icon', 'add_icon_preview');
    updateIconPreview('edit_category_icon', 'icon_preview');
});

// Edit Category Function
async function editCategory(id) {
    try {
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
            document.getElementById('icon_preview').className = category.icon;
            document.getElementById('edit_category_order').value = category.order;
            document.getElementById('edit_category_status').value = category.status;
            document.getElementById('edit_category_parent').value = category.parent_id || '';
            document.getElementById('edit_category_slug').value = category.slug;
            document.getElementById('edit_category_meta_title').value = category.meta_title || '';
            document.getElementById('edit_category_meta_description').value = category.meta_description || '';
            document.getElementById('edit_category_meta_keywords').value = category.meta_keywords || '';

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
            const form = document.getElementById('kt_modal_edit_category_form');

            form.action = form.dataset.updateUrl.replace(':id', category.id);
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
        text: `Kategori "${name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`,
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
            form.action = form.dataset.deleteUrl.replace(':id', id);
            form.submit();
        }
    });
}

// Update Status Function
function updateStatus(id, status, name) {
    const action = status === 'active' ? 'Aktifkan' : 'Nonaktifkan';
    
    Swal.fire({
        title: `${action} Kategori?`,
        text: `Kategori "${name}" akan di${action.toLowerCase()}.`,
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
            form.action = form.dataset.statusUrl.replace(':id', id);
            document.getElementById('status-input').value = status;
            form.submit();
        }
    });
}

// Form Submission with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Add Category Form
    const addForm = document.getElementById('kt_modal_add_category_form');
    const addSubmitButton = document.getElementById('kt_modal_add_category_submit');
    
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        addSubmitButton.setAttribute('data-kt-indicator', 'on');
        addSubmitButton.disabled = true;
        
        // Clear previous errors
        document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');
        
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
                bootstrap.Modal.getInstance(
                    document.getElementById('kt_modal_add_category')
                ).hide();
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

    document.getElementById('kt_modal_add_category')
    .addEventListener('hidden.bs.modal', () => {

        addForm.reset();

        document
            .querySelectorAll('[id$="-error"]')
            .forEach(el => {
                el.textContent = '';
            });
    });
    
    document.getElementById('kt_modal_edit_category')
    .addEventListener('hidden.bs.modal', () => {

        document
            .querySelectorAll('[id$="-error"]')
            .forEach(el => {
                el.textContent = '';
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
        document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');
        
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
                bootstrap.Modal.getInstance(
                    document.getElementById('kt_modal_edit_category')
                ).hide();
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
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    
    // Update bulk delete button visibility
    function updateBulkDeleteButton() {
        if (!bulkDeleteBtn) return;
        
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        
        if (selectedIds.length > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
            bulkDeleteBtn.innerHTML = `<i class="bi bi-trash"></i> Hapus Terpilih (${selectedIds.length})`;
        } else {
            bulkDeleteBtn.style.display = 'none';
        }
    }
    
    // Bulk delete
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
            const selectedIds = Array.from(selectedItems).map(item => item.value);
            
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
    
    const addNameInput = document.querySelector(
        '#kt_modal_add_category_form input[name="name"]'
    );

    const addSlugInput = document.querySelector(
        '#kt_modal_add_category_form input[name="slug"]'
    );

    if (addNameInput && addSlugInput) {
        addNameInput.addEventListener('input', function() {
            if (!addSlugInput.value) {
                addSlugInput.value = this.value
                    .toLowerCase()
                    .replace(/[^\w\s]/gi, '')
                    .replace(/\s+/g, '-');
            }
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle Filters
    const tableContainer = document.getElementById('kt_category_table_container');
    const searchInput = document.querySelector('[data-kt-category-table-filter="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const parentFilter = document.querySelector('select[name="parent"]');
    const resetBtn = document.getElementById('kt_category_reset_filter');

    async function applyFilters(page = 1) {
        // Show loading state
        tableContainer.style.opacity = '0.5';
        tableContainer.style.pointerEvents = 'none';

        const url = new URL(window.location.href);
        const search = searchInput.value;
        const status = statusFilter.value;
        const parent = parentFilter.value;

        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');

        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');

        if (parent) url.searchParams.set('parent', parent);
        else url.searchParams.delete('parent');

        if (page > 1) url.searchParams.set('page', page);
        else url.searchParams.delete('page');

        try {
            const response = await fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const html = await response.text();
            tableContainer.innerHTML = html;
            
            // Update URL in browser
            window.history.pushState({}, '', url.toString());

            // Re-initialize any components if needed (like checkboxes)
            initializeTableEvents();

        } catch (error) {
            console.error('Error filtering:', error);
            showToast('error', 'Gagal memfilter data', 'Error!');
        } finally {
            tableContainer.style.opacity = '1';
            tableContainer.style.pointerEvents = 'auto';
        }
    }

    function initializeTableEvents() {
        // Re-initialize select all checkbox
        const selectAll = document.getElementById('select-all');
        const selectItems = document.querySelectorAll('.select-item');
        
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                selectItems.forEach(item => {
                    item.checked = this.checked;
                });
                updateBulkDeleteButton();
            });
        }
        
        selectItems.forEach(item => {
            item.addEventListener('change', updateBulkDeleteButton);
        });

        // Handle AJAX Pagination Links
        const paginationLinks = tableContainer.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                applyFilters(page);
            });
        });

        updateBulkDeleteButton();
    }

    // Debounce search
    let searchTimer;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                applyFilters();
            }, 500);
        });
    }

    if (statusFilter) {
        $(statusFilter).on('change', function() {
            applyFilters();
        });
    }

    if (parentFilter) {
        $(parentFilter).on('change', function() {
            applyFilters();
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            $(statusFilter).val('').trigger('change.select2');
            $(parentFilter).val('').trigger('change.select2');
            applyFilters();
        });
    }

    // Initial event binding
    initializeTableEvents();
});
</script>
@endpush