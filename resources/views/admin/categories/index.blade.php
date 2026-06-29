@extends('admin.layouts.app')

@section('page-title', 'Kategori Produk')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.categories.index') }}">Kategori Produk</a>
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<!--begin::Card-->
<div class="glass-card">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">Daftar Kategori Produk</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
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
                               data-kt-category-table-filter="search" 
                               placeholder="Cari Kategori..." 
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="kt_category_reset_filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
            <div class="toolbar-group">
                <select name="status" class="form-select form-select-sm" style="min-width: 110px;">
                    <option value="">Semua Status</option>
                    <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <select name="parent" class="form-select form-select-sm" style="min-width: 150px;">
                    <option value="">Semua Parent</option>
                    <option value="null" {{ ($filters['parent'] ?? '') == 'null' ? 'selected' : '' }}>Root</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ ($filters['parent'] ?? '') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--end::Toolbar-->

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
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Kategori</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            
            <form id="kt_modal_add_category_form" class="form" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Nama Kategori</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="Masukkan nama kategori" 
                               name="name" 
                               id="add_category_name"
                               required />
                        <div class="text-danger fs-8 mt-1" id="name-error"></div>
                    </div>
                    
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Deskripsi</label>
                        <textarea class="form-control form-control-sm" 
                                  rows="2" 
                                  placeholder="Masukkan deskripsi kategori" 
                                  name="description"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Icon</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i id="add_icon_preview" class="fas fa-icons"></i>
                                </span>
                                <select class="form-select form-select-sm" id="add_category_icon" name="icon">
                                    <option value="fas fa-tags">Tags</option>
                                    <option value="fas fa-print">Print</option>
                                    <option value="fas fa-paint-brush">Paint Brush</option>
                                    <option value="fas fa-paperclip">Paperclip</option>
                                    <option value="fas fa-gift">Gift</option>
                                    <option value="fas fa-desktop">Desktop</option>
                                    <option value="fas fa-envelope-open-text">Envelope</option>
                                    <option value="fas fa-palette">Palette</option>
                                    <option value="fas fa-tools">Tools</option>
                                    <option value="fas fa-box">Box</option>
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
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Urutan</label>
                            <input type="number" class="form-control form-control-sm" 
                                   min="1" max="100" value="1" name="order" required />
                        </div>

                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Warna</label>
                            <select class="form-select form-select-sm" name="color" id="add_category_color">
                                <option value="primary" selected>Blue</option>
                                <option value="success">Green</option>
                                <option value="info">Cyan</option>
                                <option value="warning">Yellow</option>
                                <option value="danger">Red</option>
                                <option value="dark">Dark</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status" required>
                                <option value="active" selected>Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Parent Kategori</label>
                            <select class="form-select form-select-sm" name="parent_id">
                                <option value="">-- Tanpa Parent --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Slug (URL)</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="slug-otomatis-jika-kosong" 
                               name="slug" />
                    </div>
                    
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);">
                            <i class="bi bi-search me-1"></i> SEO Settings
                        </div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" 
                                       placeholder="Meta title untuk SEO" 
                                       name="meta_title" />
                            </div>
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" 
                                          rows="2"
                                          placeholder="Meta description untuk SEO" 
                                          name="meta_description"></textarea>
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Keywords</label>
                                <input type="text" class="form-control form-control-sm" 
                                       placeholder="Keyword1, Keyword2, Keyword3" 
                                       name="meta_keywords" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="kt_modal_add_category_submit">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Mohon tunggu...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal - Add Category-->

<!--begin::Modal - Edit Category-->
<div class="modal fade" id="kt_modal_edit_category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Kategori</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            
            <form id="kt_modal_edit_category_form" class="form" method="POST" data-update-url="{{ route('admin.categories.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_category_id" />
                <div class="modal-body py-4 px-4">
                    
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Nama Kategori</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="Masukkan nama kategori" 
                               name="name" 
                               id="edit_category_name"
                               required />
                        <div class="text-danger fs-8 mt-1" id="edit_name-error"></div>
                    </div>
                    
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Deskripsi</label>
                        <textarea class="form-control form-control-sm" 
                                  rows="2" 
                                  placeholder="Masukkan deskripsi kategori" 
                                  name="description" 
                                  id="edit_category_description"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Icon</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i id="icon_preview" class="fas fa-icons"></i>
                                </span>
                                <select class="form-select form-select-sm" 
                                        name="icon" 
                                        id="edit_category_icon" 
                                        required>
                                    <option value="fas fa-tags">Tags</option>
                                    <option value="fas fa-print">Print</option>
                                    <option value="fas fa-paint-brush">Paint Brush</option>
                                    <option value="fas fa-paperclip">Paperclip</option>
                                    <option value="fas fa-gift">Gift</option>
                                    <option value="fas fa-desktop">Desktop</option>
                                    <option value="fas fa-envelope-open-text">Envelope</option>
                                    <option value="fas fa-palette">Palette</option>
                                    <option value="fas fa-tools">Tools</option>
                                    <option value="fas fa-box">Box</option>
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
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Urutan</label>
                            <input type="number" class="form-control form-control-sm" 
                                   min="1" max="100" 
                                   name="order" 
                                   id="edit_category_order"
                                   required />
                        </div>

                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Warna</label>
                            <select class="form-select form-select-sm" name="color" id="edit_category_color">
                                <option value="primary">Blue</option>
                                <option value="success">Green</option>
                                <option value="info">Cyan</option>
                                <option value="warning">Yellow</option>
                                <option value="danger">Red</option>
                                <option value="dark">Dark</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_category_status" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Parent Kategori</label>
                            <select class="form-select form-select-sm" name="parent_id" id="edit_category_parent">
                                <option value="">-- Tanpa Parent --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Slug (URL)</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="slug-kategori" 
                               name="slug" 
                               id="edit_category_slug" />
                    </div>
                    
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);">
                            <i class="bi bi-search me-1"></i> SEO Settings
                        </div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" 
                                       placeholder="Meta title untuk SEO" 
                                       name="meta_title" 
                                       id="edit_category_meta_title" />
                            </div>
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" 
                                          rows="2"
                                          placeholder="Meta description untuk SEO" 
                                          name="meta_description" 
                                          id="edit_category_meta_description"></textarea>
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Keywords</label>
                                <input type="text" class="form-control form-control-sm" 
                                       placeholder="Keyword1, Keyword2, Keyword3" 
                                       name="meta_keywords" 
                                       id="edit_category_meta_keywords" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="kt_modal_edit_category_submit">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">Mohon tunggu...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
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
    /* Search + action input group compact */
    .input-group.input-group-sm .input-group-text {
        background: transparent;
        border-color: rgba(0, 0, 0, 0.1);
        color: var(--text-muted);
        padding: 0.2rem 0.5rem;
    }
    .input-group.input-group-sm .form-control {
        border-left: 0;
    }
    .input-group.input-group-sm:focus-within .input-group-text,
    .input-group.input-group-sm:focus-within .form-control {
        border-color: var(--accent);
    }
    .input-group.input-group-sm:focus-within .form-control {
        box-shadow: 0 0 0 2px var(--accent-light);
    }
    /* Card header buttons compact */
    .card-header-btns {
        display: flex; align-items: center; gap: 0.35rem;
    }
    /* Paginator compact */
    .pagination { margin: 0 !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show session messages as toast
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            Ravaa.toast('{{ $error }}', 'error');
        @endforeach
    @endif
});

// Add Modal
const addIconSelect = document.getElementById('add_category_icon');
const addIconPreview = document.getElementById('add_icon_preview');

// Edit Modal
const editIconSelect = document.getElementById('edit_category_icon');
const editIconPreview = document.getElementById('icon_preview');

const COLOR_MAP = {
    'primary': '#0071e3',
    'success': '#15803d',
    'info':    '#0891b2',
    'warning': '#b45309',
    'danger':  '#b91c1c',
    'dark':    '#1e293b',
};

function updateIconPreview(selectId, previewId, colorSelectId) {
    const select = document.getElementById(selectId);
    const preview = document.getElementById(previewId);
    const colorSelect = colorSelectId ? document.getElementById(colorSelectId) : null;

    if (!select || !preview) return;

    function refresh() {
        preview.className = select.value;
        if (colorSelect) {
            preview.style.color = COLOR_MAP[colorSelect.value] || '#0071e3';
        }
    }

    refresh();

    select.addEventListener('change', refresh);
    if (colorSelect) {
        colorSelect.addEventListener('change', refresh);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateIconPreview('add_category_icon', 'add_icon_preview', 'add_category_color');
    updateIconPreview('edit_category_icon', 'icon_preview', 'edit_category_color');
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
            document.getElementById('edit_category_color').value = category.color || 'primary';
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
            Ravaa.toast(data.message || 'Gagal memuat data kategori', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        Ravaa.toast('Terjadi kesalahan: ' + error.message, 'error');
    }
}

// Delete Category Function
function deleteCategory(id, name) {
    Ravaa.confirm('Hapus Kategori?', `Kategori "${name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`)
        .then((result) => {
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
    
    Ravaa.confirm(`${action} Kategori?`, `Kategori "${name}" akan di${action.toLowerCase()}.`, 'question')
        .then((result) => {
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
                Ravaa.toast('Terdapat kesalahan validasi', 'error');
            } else if (data.success) {
                // Close modal and refresh page
                bootstrap.Modal.getInstance(
                    document.getElementById('kt_modal_add_category')
                ).hide();
                addForm.reset();
                Ravaa.toast(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            addSubmitButton.removeAttribute('data-kt-indicator');
            addSubmitButton.disabled = false;
            console.error('Error:', error);
            Ravaa.toast('Terjadi kesalahan saat menyimpan data', 'error');
        });
    });

    document.getElementById('kt_modal_add_category')
    .addEventListener('shown.bs.modal', () => {
        document.getElementById('add_category_name').focus();
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
    .addEventListener('shown.bs.modal', () => {
        document.getElementById('edit_category_name').focus();
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
                Ravaa.toast('Terdapat kesalahan validasi', 'error');
            } else if (data.success) {
                // Close modal and refresh page
                bootstrap.Modal.getInstance(
                    document.getElementById('kt_modal_edit_category')
                ).hide();
                Ravaa.toast(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            editSubmitButton.removeAttribute('data-kt-indicator');
            editSubmitButton.disabled = false;
            console.error('Error:', error);
            Ravaa.toast('Terjadi kesalahan saat menyimpan data', 'error');
        });
    });
    
    // Update bulk delete button visibility (re-queries DOM for AJAX reloads)
    function updateBulkDeleteButton() {
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
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
    
    // Bulk delete (using event delegation for AJAX reloads)
    document.addEventListener('click', function(e) {
        const bulkDeleteBtn = e.target.closest('#bulk-delete-btn');
        if (!bulkDeleteBtn) return;
        
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        
        if (selectedIds.length === 0) {
            Ravaa.toast('Silakan pilih kategori yang akan dihapus', 'warning');
            return;
        }
        
        Ravaa.confirm('Hapus Kategori Terpilih?', `Anda akan menghapus <strong>${selectedIds.length}</strong> kategori. Tindakan ini tidak dapat dibatalkan!`, 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });
    
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

    // Re-query per_page dynamically because the element is inside AJAX-replaced content
    function getPerPageValue() {
        const el = document.querySelector('select[name="per_page"]');
        return el ? el.value : '10';
    }

    async function applyFilters(page = 1) {
        // Show loading state
        tableContainer.style.opacity = '0.5';
        tableContainer.style.pointerEvents = 'none';

        const url = new URL(window.location.href);
        const search = searchInput.value;
        const status = statusFilter.value;
        const parent = parentFilter.value;
        const perPage = getPerPageValue();

        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');

        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');

        if (parent) url.searchParams.set('parent', parent);
        else url.searchParams.delete('parent');

        if (perPage) url.searchParams.set('per_page', perPage);
        else url.searchParams.delete('per_page');

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
            Ravaa.toast('Gagal memfilter data', 'error');
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

    // Debounce search on input
    let searchTimer;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                applyFilters();
            }, 500);
        });

        // Enter triggers search immediately
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                applyFilters();
            }
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            applyFilters();
        });
    }

    if (parentFilter) {
        parentFilter.addEventListener('change', function() {
            applyFilters();
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            parentFilter.value = '';
            const perPageEl = document.querySelector('select[name="per_page"]');
            if (perPageEl) {
                perPageEl.value = '10';
            }
            applyFilters();
        });
    }

    // Per-page change with event delegation
    document.addEventListener('change', function(e) {
        if (e.target.matches('select[name="per_page"]')) {
            applyFilters();
        }
    });

    // Initial event binding
    initializeTableEvents();
});
</script>
@endpush