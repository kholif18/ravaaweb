@extends('admin.layouts.app')

@section('page-title', 'Service Categories')
@section('page-description', 'Service Categories — Ravaa Creative')

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

    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted text-hover-primary">
            Home Page
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Service Categories
    </li>
@endsection

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        
        <!--begin::Form-->
        <form id="categoriesForm" action="{{ route('admin.home.categories.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Edit Service Categories</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save fs-2"></i> Simpan Semua
                            </button>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    
                    <!--begin::Alert-->
                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                        <!--begin::Icon-->
                        <i class="bi bi-info-circle fs-2hx text-primary me-4"></i>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column">
                            <!--begin::Title-->
                            <h4 class="mb-1 text-primary">Informasi Service Categories</h4>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <span>Kategori layanan ini akan ditampilkan di homepage sebagai 4 kotak layanan. Anda dapat mengubah ikon, judul, dan deskripsi untuk setiap kategori.</span>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->
                    
                    <!--begin::Row: Category 1-->
                    <div class="row mb-15">
                        <div class="col-12">
                            <div class="card card-bordered">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 1
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category1_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-paint-bucket" selected>Paint Bucket</option>
                                                    <option value="bi-palette">Palette</option>
                                                    <option value="bi-brush">Brush</option>
                                                    <option value="bi-pencil">Pencil</option>
                                                    <option value="bi-pen">Pen</option>
                                                </select>
                                                <div class="text-muted fs-7 mt-1">Icon yang akan ditampilkan</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category1_title" 
                                                       value="Desain Grafis"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category1_description" 
                                                          rows="2"
                                                          required>Logo, brosur, banner, kartu nama, dan desain kreatif lainnya untuk bisnis Anda.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Row: Category 1-->
                    
                    <!--begin::Row: Category 2-->
                    <div class="row mb-15">
                        <div class="col-12">
                            <div class="card card-bordered">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 2
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category2_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-printer" selected>Printer</option>
                                                    <option value="bi-printer-fill">Printer Fill</option>
                                                    <option value="bi-file-earmark-text">File Text</option>
                                                    <option value="bi-newspaper">Newspaper</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category2_title" 
                                                       value="Percetakan"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category2_description" 
                                                          rows="2"
                                                          required>Cetak offset dan digital dengan kualitas tinggi untuk segala kebutuhan percetakan.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Row: Category 2-->
                    
                    <!--begin::Row: Category 3-->
                    <div class="row mb-15">
                        <div class="col-12">
                            <div class="card card-bordered">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 3
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category3_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-pen" selected>Pen</option>
                                                    <option value="bi-pencil">Pencil</option>
                                                    <option value="bi-pencil-fill">Pencil Fill</option>
                                                    <option value="bi-pen-fill">Pen Fill</option>
                                                    <option value="bi-file-earmark">File</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category3_title" 
                                                       value="Alat Tulis Kantor"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category3_description" 
                                                          rows="2"
                                                          required>Berbagai kebutuhan ATK dengan kualitas terbaik untuk mendukung produktivitas.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Row: Category 3-->
                    
                    <!--begin::Row: Category 4-->
                    <div class="row mb-15">
                        <div class="col-12">
                            <div class="card card-bordered">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 4
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category4_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-tshirt" selected>T-Shirt</option>
                                                    <option value="bi-cup-straw">Cup Straw</option>
                                                    <option value="bi-cup">Cup</option>
                                                    <option value="bi-bag">Bag</option>
                                                    <option value="bi-gift">Gift</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category4_title" 
                                                       value="Sablon & Merchandise"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category4_description" 
                                                          rows="2"
                                                          required>Sablon kaos, mug, tumbler, dan merchandise custom untuk branding perusahaan.</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Row: Category 4-->
                    
                </div>
                <!--end::Card body-->
                
                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light me-3">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Perubahan</span>
                        <span class="indicator-progress">Mohon tunggu...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Card footer-->
                
            </div>
            <!--end::Card-->
            
        </form>
        <!--end::Form-->
        
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection

@push('styles')
<!--begin::Select2 CSS-->
<link href="{{ asset('admin/assets/plugins/custom/select2/select2.bundle.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<!--begin::Select2 JS-->
<script src="{{ asset('admin/assets/plugins/custom/select2/select2.bundle.js') }}"></script>

<script>
    // Initialize Select2
    $('[data-control="select2"]').select2({
        placeholder: "Pilih icon",
        allowClear: true
    });
    
    // Form validation
    var form = document.getElementById('categoriesForm');
    var validator = FormValidation.formValidation(
        form,
        {
            fields: {
                'category1_title': {
                    validators: {
                        notEmpty: {
                            message: 'Judul kategori 1 harus diisi'
                        }
                    }
                },
                'category2_title': {
                    validators: {
                        notEmpty: {
                            message: 'Judul kategori 2 harus diisi'
                        }
                    }
                },
                'category3_title': {
                    validators: {
                        notEmpty: {
                            message: 'Judul kategori 3 harus diisi'
                        }
                    }
                },
                'category4_title': {
                    validators: {
                        notEmpty: {
                            message: 'Judul kategori 4 harus diisi'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.mb-10',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );
    
    // Submit handler
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        if (validator) {
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indicator
                    const submitButton = form.querySelector('[type="submit"]');
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                    
                    // Simulate form submission
                    setTimeout(function() {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                        
                        // Show success message
                        Swal.fire({
                            text: "Kategori layanan berhasil diperbarui!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }, 1500);
                }
            });
        }
    });
</script>
@endpush