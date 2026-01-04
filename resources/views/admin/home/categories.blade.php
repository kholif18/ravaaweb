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
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-10" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-10" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
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
                        <div class="d-flex justify-content-end gap-2" data-kt-customer-table-toolbar="base">
                            <button type="button"
                                    class="btn btn-warning"
                                    onclick="resetCategories()">
                                <i class="bi bi-arrow-clockwise fs-2"></i> Reset to Default
                            </button>

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
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 1
                                    </h3>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" 
                                               id="category1_status" 
                                               name="category1_status"
                                               value="1"
                                               @if(isset($categoryData['category1']) && $categoryData['category1']->is_active) checked @endif
                                               onchange="toggleCategoryStatus(1, this.checked)">
                                        <label class="form-check-label" for="category1_status">
                                            <span class="switch-label">Status</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category1_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-paint-bucket" @if(isset($categoryData['category1']) && $categoryData['category1']->icon == 'bi-paint-bucket') selected @endif>Paint Bucket</option>
                                                    <option value="bi-palette" @if(isset($categoryData['category1']) && $categoryData['category1']->icon == 'bi-palette') selected @endif>Palette</option>
                                                    <option value="bi-brush" @if(isset($categoryData['category1']) && $categoryData['category1']->icon == 'bi-brush') selected @endif>Brush</option>
                                                    <option value="bi-pencil" @if(isset($categoryData['category1']) && $categoryData['category1']->icon == 'bi-pencil') selected @endif>Pencil</option>
                                                    <option value="bi-pen" @if(isset($categoryData['category1']) && $categoryData['category1']->icon == 'bi-pen') selected @endif>Pen</option>
                                                </select>
                                                <div class="text-muted fs-7 mt-1">Icon yang akan ditampilkan</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category1_title" 
                                                       value="{{ $categoryData['category1']->title ?? 'Desain Grafis' }}"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category1_description" 
                                                          rows="2"
                                                          required>{{ $categoryData['category1']->description ?? 'Logo, brosur, banner, kartu nama, dan desain kreatif lainnya untuk bisnis Anda.' }}</textarea>
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
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 2
                                    </h3>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" 
                                               id="category2_status" 
                                               name="category2_status"
                                               value="1"
                                               @if(isset($categoryData['category2']) && $categoryData['category2']->is_active) checked @endif
                                               onchange="toggleCategoryStatus(2, this.checked)">
                                        <label class="form-check-label" for="category2_status">
                                            <span class="switch-label">Status</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category2_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-printer" @if(isset($categoryData['category2']) && $categoryData['category2']->icon == 'bi-printer') selected @endif>Printer</option>
                                                    <option value="bi-printer-fill" @if(isset($categoryData['category2']) && $categoryData['category2']->icon == 'bi-printer-fill') selected @endif>Printer Fill</option>
                                                    <option value="bi-file-earmark-text" @if(isset($categoryData['category2']) && $categoryData['category2']->icon == 'bi-file-earmark-text') selected @endif>File Text</option>
                                                    <option value="bi-newspaper" @if(isset($categoryData['category2']) && $categoryData['category2']->icon == 'bi-newspaper') selected @endif>Newspaper</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category2_title" 
                                                       value="{{ $categoryData['category2']->title ?? 'Percetakan' }}"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category2_description" 
                                                          rows="2"
                                                          required>{{ $categoryData['category2']->description ?? 'Cetak offset dan digital dengan kualitas tinggi untuk segala kebutuhan percetakan.' }}</textarea>
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
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 3
                                    </h3>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" 
                                               id="category3_status" 
                                               name="category3_status"
                                               value="1"
                                               @if(isset($categoryData['category3']) && $categoryData['category3']->is_active) checked @endif
                                               onchange="toggleCategoryStatus(3, this.checked)">
                                        <label class="form-check-label" for="category3_status">
                                            <span class="switch-label">Status</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category3_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-pen" @if(isset($categoryData['category3']) && $categoryData['category3']->icon == 'bi-pen') selected @endif>Pen</option>
                                                    <option value="bi-pencil" @if(isset($categoryData['category3']) && $categoryData['category3']->icon == 'bi-pencil') selected @endif>Pencil</option>
                                                    <option value="bi-pencil-fill" @if(isset($categoryData['category3']) && $categoryData['category3']->icon == 'bi-pencil-fill') selected @endif>Pencil Fill</option>
                                                    <option value="bi-pen-fill" @if(isset($categoryData['category3']) && $categoryData['category3']->icon == 'bi-pen-fill') selected @endif>Pen Fill</option>
                                                    <option value="bi-file-earmark" @if(isset($categoryData['category3']) && $categoryData['category3']->icon == 'bi-file-earmark') selected @endif>File</option>
                                                </select>
                                                <div class="text-muted fs-7 mt-1">Icon yang akan ditampilkan</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category3_title" 
                                                       value="{{ $categoryData['category3']->title ?? 'Alat Tulis Kantor' }}"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category3_description" 
                                                          rows="2"
                                                          required>{{ $categoryData['category3']->description ?? 'Berbagai kebutuhan ATK dengan kualitas terbaik untuk mendukung produktivitas.' }}</textarea>
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
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h3 class="card-title text-gray-800">
                                        Kategori 4
                                    </h3>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" 
                                               id="category4_status" 
                                               name="category4_status"
                                               value="1"
                                               @if(isset($categoryData['category4']) && $categoryData['category4']->is_active) checked @endif
                                               onchange="toggleCategoryStatus(4, this.checked)">
                                        <label class="form-check-label" for="category4_status">
                                            <span class="switch-label">Status</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select form-select-solid" name="category4_icon" data-control="select2" data-placeholder="Pilih icon">
                                                    <option value="bi-tshirt" @if(isset($categoryData['category4']) && $categoryData['category4']->icon == 'bi-tshirt') selected @endif>T-Shirt</option>
                                                    <option value="bi-cup-straw" @if(isset($categoryData['category4']) && $categoryData['category4']->icon == 'bi-cup-straw') selected @endif>Cup Straw</option>
                                                    <option value="bi-cup" @if(isset($categoryData['category4']) && $categoryData['category4']->icon == 'bi-cup') selected @endif>Cup</option>
                                                    <option value="bi-bag" @if(isset($categoryData['category4']) && $categoryData['category4']->icon == 'bi-bag') selected @endif>Bag</option>
                                                    <option value="bi-gift" @if(isset($categoryData['category4']) && $categoryData['category4']->icon == 'bi-gift') selected @endif>Gift</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul</label>
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="category4_title" 
                                                       value="{{ $categoryData['category4']->title ?? 'Sablon & Merchandise' }}"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" 
                                                          name="category4_description" 
                                                          rows="2"
                                                          required>{{ $categoryData['category4']->description ?? 'Sablon kaos, mug, tumbler, dan merchandise custom untuk branding perusahaan.' }}</textarea>
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

@push('scripts')
<script>
    // Initialize Select2
    $('[data-control="select2"]').select2({
        placeholder: "Pilih icon",
        allowClear: true
    });
    
    // Toggle category status
    function toggleCategoryStatus(position, isActive) {
        $.ajax({
            url: "{{ route('admin.home.categories.toggle-status', ':position') }}".replace(':position', position),
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                is_active: isActive ? 1 : 0
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan saat mengubah status');
            }
        });
    }
    
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
                    
                    // Submit form
                    form.submit();
                }
            });
        }
    });

    function resetCategories() {
        Swal.fire({
            text: 'Reset semua kategori ke default?',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light'
            }
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.post("{{ route('admin.home.categories.reset') }}", {
                _token: "{{ csrf_token() }}"
            })
            .done(() => {
                Swal.fire({
                    text: 'Kategori berhasil di-reset ke default.',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                }).then(() => {
                    location.reload();
                });
            })
            .fail(() => {
                Swal.fire({
                    text: 'Gagal reset kategori.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            });
        });
    }
</script>
@endpush