@extends('admin.layouts.app')

@section('page-title', 'Product Categories')

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
            Produk Page
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Product Categories
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Kategori Produk</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah Kategori
                </button>
            </div>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-info-circle fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Informasi Kategori Produk</h4>
                <span>Kelola kategori produk yang akan ditampilkan di halaman produk. Urutkan kategori sesuai preferensi tampilan.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="categoriesForm">
            @csrf
            
            <!--begin::Categories List-->
            <div class="row">
                @php
                    $categories = [
                        [
                            'id' => 1,
                            'name' => 'Desain Grafis',
                            'icon' => 'bi-palette',
                            'color' => 'primary',
                            'product_count' => 12,
                            'description' => 'Layanan desain grafis profesional untuk logo, branding, dan materi promosi.',
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'name' => 'Percetakan',
                            'icon' => 'bi-printer',
                            'color' => 'success',
                            'product_count' => 18,
                            'description' => 'Layanan percetakan offset dan digital untuk berbagai kebutuhan bisnis.',
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'name' => 'ATK & Perlengkapan',
                            'icon' => 'bi-pencil',
                            'color' => 'warning',
                            'product_count' => 10,
                            'description' => 'Alat tulis kantor dan perlengkapan kantor custom dengan logo perusahaan.',
                            'active' => true,
                            'order' => 3
                        ],
                        [
                            'id' => 4,
                            'name' => 'Sablon & Merchandise',
                            'icon' => 'bi-tshirt',
                            'color' => 'danger',
                            'product_count' => 6,
                            'description' => 'Sablon kaos dan merchandise custom untuk promosi perusahaan.',
                            'active' => true,
                            'order' => 4
                        ],
                        [
                            'id' => 5,
                            'name' => 'Digital Printing',
                            'icon' => 'bi-laptop',
                            'color' => 'info',
                            'product_count' => 8,
                            'description' => 'Layanan digital printing untuk stiker, banner, dan material promosi.',
                            'active' => true,
                            'order' => 5
                        ],
                        [
                            'id' => 6,
                            'name' => 'Spanduk & Baliho',
                            'icon' => 'bi-image',
                            'color' => 'dark',
                            'product_count' => 5,
                            'description' => 'Pembuatan spanduk dan baliho untuk outdoor advertising.',
                            'active' => false,
                            'order' => 6
                        ]
                    ];
                @endphp
                
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $category['color'] }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $category['color'] }} me-2">{{ $category['order'] }}</span>
                                {{ $category['name'] }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi {{ $category['icon'] }}"></i>
                                    </span>
                                    <select class="form-select" name="categories[{{ $category['id'] }}][icon]" data-control="select2">
                                        <option value="bi-palette" {{ $category['icon'] == 'bi-palette' ? 'selected' : '' }}>Palette</option>
                                        <option value="bi-printer" {{ $category['icon'] == 'bi-printer' ? 'selected' : '' }}>Printer</option>
                                        <option value="bi-pencil" {{ $category['icon'] == 'bi-pencil' ? 'selected' : '' }}>Pencil</option>
                                        <option value="bi-tshirt" {{ $category['icon'] == 'bi-tshirt' ? 'selected' : '' }}>T-Shirt</option>
                                        <option value="bi-laptop" {{ $category['icon'] == 'bi-laptop' ? 'selected' : '' }}>Laptop</option>
                                        <option value="bi-image" {{ $category['icon'] == 'bi-image' ? 'selected' : '' }}>Image</option>
                                        <option value="bi-brush" {{ $category['icon'] == 'bi-brush' ? 'selected' : '' }}>Brush</option>
                                        <option value="bi-tools" {{ $category['icon'] == 'bi-tools' ? 'selected' : '' }}>Tools</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Kategori</label>
                                <input type="text" class="form-control" 
                                       name="categories[{{ $category['id'] }}][name]" 
                                       value="{{ $category['name'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="categories[{{ $category['id'] }}][description]" 
                                          rows="3"
                                          required>{{ $category['description'] }}</textarea>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Warna</label>
                                    <select class="form-select" name="categories[{{ $category['id'] }}][color]" data-control="select2">
                                        <option value="primary" {{ $category['color'] == 'primary' ? 'selected' : '' }}>Primary (Biru)</option>
                                        <option value="success" {{ $category['color'] == 'success' ? 'selected' : '' }}>Success (Hijau)</option>
                                        <option value="warning" {{ $category['color'] == 'warning' ? 'selected' : '' }}>Warning (Kuning)</option>
                                        <option value="danger" {{ $category['color'] == 'danger' ? 'selected' : '' }}>Danger (Merah)</option>
                                        <option value="info" {{ $category['color'] == 'info' ? 'selected' : '' }}>Info (Biru Muda)</option>
                                        <option value="dark" {{ $category['color'] == 'dark' ? 'selected' : '' }}>Dark (Gelap)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="categories[{{ $category['id'] }}][order]" 
                                           value="{{ $category['order'] }}"
                                           min="1" max="20" required />
                                </div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" 
                                       name="categories[{{ $category['id'] }}][active]" 
                                       value="1" 
                                       id="category_{{ $category['id'] }}_active" 
                                       {{ $category['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="category_{{ $category['id'] }}_active">
                                    Tampilkan Kategori
                                </label>
                            </div>
                            <div class="mt-3 text-muted">
                                <small>{{ $category['product_count'] }} produk dalam kategori ini</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Categories List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Kategori Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                @foreach(array_slice($categories, 0, 6) as $category)
                                <div class="col-lg-2 col-md-4 col-sm-6 mb-5">
                                    <div class="bg-light-{{ $category['color'] }} rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                                         style="width: 70px; height: 70px;">
                                        <i class="bi {{ $category['icon'] }} fs-2x text-{{ $category['color'] }}"></i>
                                    </div>
                                    <div class="fw-bold text-gray-800 mb-2">{{ $category['name'] }}</div>
                                    <p class="text-muted fs-7">{{ $category['product_count'] }} produk</p>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan kategori produk di halaman Produk (6 kategori pertama).</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Preview Section-->
            
        </form>
        <!--end::Form-->
        
    </div>
    <!--end::Card body-->
    
    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="button" class="btn btn-light me-3" onclick="resetCategories()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveCategories()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->

<!--begin::Modal - Add Category-->
<div class="modal fade" id="kt_modal_add_category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Kategori Baru</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_add_category_form" class="form" action="#">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Masukkan nama kategori" name="new_category_name" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" rows="3" name="new_category_description" placeholder="Deskripsi kategori"></textarea>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Icon</label>
                            <select class="form-select form-select-solid" name="new_category_icon">
                                <option value="bi-palette">Palette (Desain)</option>
                                <option value="bi-printer">Printer (Percetakan)</option>
                                <option value="bi-pencil">Pencil (ATK)</option>
                                <option value="bi-tshirt">T-Shirt (Sablon)</option>
                                <option value="bi-laptop">Laptop (Digital)</option>
                                <option value="bi-image">Image (Spanduk)</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Warna</label>
                            <select class="form-select form-select-solid" name="new_category_color">
                                <option value="primary">Primary (Biru)</option>
                                <option value="success">Success (Hijau)</option>
                                <option value="warning">Warning (Kuning)</option>
                                <option value="danger">Danger (Merah)</option>
                                <option value="info">Info (Biru Muda)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" placeholder="1" name="new_category_order" min="1" max="20" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Status</label>
                            <div class="form-check form-check-custom form-check-solid mt-5">
                                <input class="form-check-input" type="checkbox" value="1" id="new_category_active" checked />
                                <label class="form-check-label" for="new_category_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
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
@endsection

@push('scripts')
<script>
    function saveCategories() {
        const form = document.getElementById('categoriesForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Kategori berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetCategories() {
        Swal.fire({
            title: "Reset Kategori?",
            text: "Semua perubahan akan dikembalikan ke nilai awal.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Reset",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission untuk modal tambah kategori
        const modalForm = document.getElementById('kt_modal_add_category_form');
        if (modalForm) {
            modalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitButton = modalForm.querySelector('button[type="submit"]');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                
                setTimeout(function() {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    
                    Swal.fire({
                        text: "Kategori berhasil ditambahkan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_category'));
                        modal.hide();
                        location.reload();
                    });
                }, 1500);
            });
        }
    });
</script>
@endpush