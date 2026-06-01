@extends('admin.layouts.app')

@section('page-title', 'Featured Products')

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
        Featured Products
    </li>
@endsection

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        
        <!--begin::Form-->
        <form id="featuredForm" action="{{ route('admin.home.featured.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Atur Featured Products di Home Page</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save fs-2"></i> Simpan Perubahan
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
                    <div class="alert alert-info d-flex align-items-center p-5 mb-10">
                        <!--begin::Icon-->
                        <i class="bi bi-info-circle fs-2hx text-info me-4"></i>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column">
                            <!--begin::Title-->
                            <h4 class="mb-1 text-info">Informasi Featured Products</h4>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <span>Pilih maksimal 8 produk yang akan ditampilkan di bagian "Produk & Layanan Terbaru" pada homepage. Produk akan ditampilkan dalam 3 tab: Produk Terbaru, Sedang Diskon, dan Paling Laris.</span>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->
                    
                    <!--begin::Tab section-->
                    <div class="mb-15">
                        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_new">Produk Terbaru</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_discount">Sedang Diskon</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_popular">Paling Laris</a>
                            </li>
                        </ul>
                    </div>
                    <!--end::Tab section-->
                    
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        
                        <!--begin::Tab pane: Produk Terbaru-->
                        <div class="tab-pane fade show active" id="kt_tab_new" role="tabpanel">
                            
                            <div class="row mb-10">
                                <div class="col-12">
                                    <h4 class="text-gray-800 mb-3">Pilih 4 Produk Terbaru</h4>
                                    <p class="text-muted">Produk yang baru ditambahkan ke katalog.</p>
                                </div>
                            </div>
                            
                            <!--begin::Row: Product selection-->
                            <div class="row g-5">
                                <!-- Product 1 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Paket Desain Logo">
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Paket Desain Logo Profesional</h5>
                                                <div class="text-primary fw-bold">Rp 499.000</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="new_products[]" value="1" id="new_product_1" checked />
                                                <label class="form-check-label" for="new_product_1">
                                                    Tampilkan sebagai Produk Terbaru
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Product 2 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Cetak Brosur">
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Cetak Brosur A4 Full Color</h5>
                                                <div class="text-primary fw-bold">Rp 1.200/lembar</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="new_products[]" value="2" id="new_product_2" />
                                                <label class="form-check-label" for="new_product_2">
                                                    Tampilkan sebagai Produk Terbaru
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Product 3 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Notebook Custom">
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Notebook Custom Logo Perusahaan</h5>
                                                <div class="text-primary fw-bold">Rp 25.000/buku</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="new_products[]" value="3" id="new_product_3" />
                                                <label class="form-check-label" for="new_product_3">
                                                    Tampilkan sebagai Produk Terbaru
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Product 4 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Sablon Kaos">
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Sablon Kaos Polo Custom</h5>
                                                <div class="text-primary fw-bold">Rp 85.000/pcs</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="new_products[]" value="4" id="new_product_4" checked />
                                                <label class="form-check-label" for="new_product_4">
                                                    Tampilkan sebagai Produk Terbaru
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Row: Product selection-->
                            
                        </div>
                        <!--end::Tab pane: Produk Terbaru-->
                        
                        <!--begin::Tab pane: Sedang Diskon-->
                        <div class="tab-pane fade" id="kt_tab_discount" role="tabpanel">
                            
                            <div class="row mb-10">
                                <div class="col-12">
                                    <h4 class="text-gray-800 mb-3">Pilih Produk dengan Diskon</h4>
                                    <p class="text-muted">Produk yang sedang memiliki potongan harga.</p>
                                </div>
                            </div>
                            
                            <!--begin::Row: Discount products-->
                            <div class="row g-5">
                                <!-- Discount Product 1 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5 position-relative">
                                                <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Cetak Brosur">
                                                <span class="badge badge-danger position-absolute top-0 start-0 m-2">DISKON 15%</span>
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Cetak Brosur A4 Full Color</h5>
                                                <div class="text-primary fw-bold">Rp 1.200/lembar</div>
                                                <div class="text-muted text-decoration-line-through">Rp 1.400/lembar</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="discount_products[]" value="2" id="discount_product_2" checked />
                                                <label class="form-check-label" for="discount_product_2">
                                                    Tampilkan sebagai Produk Diskon
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Discount Product 2 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5 position-relative">
                                                <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Stiker Vinyl">
                                                <span class="badge badge-danger position-absolute top-0 start-0 m-2">DISKON 10%</span>
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Stiker Vinyl Outdoor</h5>
                                                <div class="text-primary fw-bold">Rp 45.000/m²</div>
                                                <div class="text-muted text-decoration-line-through">Rp 50.000/m²</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="discount_products[]" value="5" id="discount_product_5" />
                                                <label class="form-check-label" for="discount_product_5">
                                                    Tampilkan sebagai Produk Diskon
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Add more discount products as needed -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                            <i class="bi bi-plus-circle fs-1 text-gray-400 mb-3"></i>
                                            <p class="text-muted">Tambah produk diskon lainnya</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Row: Discount products-->
                            
                        </div>
                        <!--end::Tab pane: Sedang Diskon-->
                        
                        <!--begin::Tab pane: Paling Laris-->
                        <div class="tab-pane fade" id="kt_tab_popular" role="tabpanel">
                            
                            <div class="row mb-10">
                                <div class="col-12">
                                    <h4 class="text-gray-800 mb-3">Pilih Produk Paling Laris</h4>
                                    <p class="text-muted">Produk dengan penjualan terbanyak atau paling banyak dilihat.</p>
                                </div>
                            </div>
                            
                            <!--begin::Row: Popular products-->
                            <div class="row g-5">
                                <!-- Popular Product 1 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Paket Desain Logo">
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Paket Desain Logo Profesional</h5>
                                                <div class="text-primary fw-bold">Rp 499.000</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="popular_products[]" value="1" id="popular_product_1" checked />
                                                <label class="form-check-label" for="popular_product_1">
                                                    Tampilkan sebagai Produk Laris
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Popular Product 2 -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                                     class="rounded w-100" alt="Sablon Kaos">
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="text-gray-800">Sablon Kaos Polo Custom</h5>
                                                <div class="text-primary fw-bold">Rp 85.000/pcs</div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="popular_products[]" value="4" id="popular_product_4" />
                                                <label class="form-check-label" for="popular_product_4">
                                                    Tampilkan sebagai Produk Laris
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Add more popular products as needed -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                            <i class="bi bi-plus-circle fs-1 text-gray-400 mb-3"></i>
                                            <p class="text-muted">Tambah produk laris lainnya</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Row: Popular products-->
                            
                        </div>
                        <!--end::Tab pane: Paling Laris-->
                        
                    </div>
                    <!--end::Tab content-->
                    
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
    // Limit checkbox selection
    function limitCheckboxSelection(checkboxGroupName, maxSelection) {
        const checkboxes = document.querySelectorAll(`input[name="${checkboxGroupName}[]"]`);
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll(`input[name="${checkboxGroupName}[]"]:checked`).length;
                
                if (checkedCount > maxSelection) {
                    this.checked = false;
                    Swal.fire({
                        text: `Maksimal ${maxSelection} produk yang dapat dipilih untuk kategori ini.`,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }
    
    // Initialize checkbox limits
    document.addEventListener('DOMContentLoaded', function() {
        limitCheckboxSelection('new_products', 4);
        limitCheckboxSelection('discount_products', 4);
        limitCheckboxSelection('popular_products', 4);
    });
    
    // Form validation
    var form = document.getElementById('featuredForm');
    
    // Submit handler
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Check if at least one product is selected in each tab
        const newProducts = document.querySelectorAll('input[name="new_products[]"]:checked').length;
        const discountProducts = document.querySelectorAll('input[name="discount_products[]"]:checked').length;
        const popularProducts = document.querySelectorAll('input[name="popular_products[]"]:checked').length;
        
        if (newProducts === 0 && discountProducts === 0 && popularProducts === 0) {
            Swal.fire({
                text: "Pilih minimal 1 produk dari salah satu kategori.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return;
        }
        
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
                text: "Featured products berhasil diperbarui!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    });
</script>
@endpush