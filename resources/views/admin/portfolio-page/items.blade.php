@extends('admin.layouts.app')

@section('page-title', 'Portfolio Items')
@section('page-description', 'Portfolio Items — Ravaa Creative')

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
            Portfolio Page
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Portfolio Items
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Item Portfolio</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_portfolio">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah Portfolio
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
                <h4 class="mb-1 text-info">Manajemen Item Portfolio</h4>
                <span>Kelola karya portfolio yang akan ditampilkan di halaman portfolio. Setiap item dapat dikategorikan dan diurutkan sesuai preferensi.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="portfolioForm">
            @csrf
            
            <!--begin::Portfolio List-->
            <div class="row">
                @php
                    $portfolioItems = [
                        [
                            'id' => 1,
                            'title' => 'Logo & Branding untuk Kafe "Brew & Co"',
                            'category' => 'logo',
                            'category_name' => 'Logo Design',
                            'client' => 'Brew & Co Coffee',
                            'description' => 'Desain logo modern dan elegan untuk kafe specialty coffee di Jakarta. Logo mencerminkan kehangatan dan kualitas kopi premium.',
                            'image' => 'https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'year' => '2023',
                            'order' => 1,
                            'active' => true,
                            'tags' => ['Logo Design', 'Coffee Shop', 'Modern']
                        ],
                        [
                            'id' => 2,
                            'title' => 'Corporate Branding untuk Startup Tech',
                            'category' => 'branding',
                            'category_name' => 'Corporate Branding',
                            'client' => 'TechSolutions Inc.',
                            'description' => 'Paket branding lengkap termasuk logo, kartu nama, kop surat, dan panduan visual untuk perusahaan teknologi yang sedang berkembang.',
                            'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'year' => '2023',
                            'order' => 2,
                            'active' => true,
                            'tags' => ['Branding', 'Corporate', 'Tech']
                        ],
                        [
                            'id' => 3,
                            'title' => 'Cetak Katalog Produk Fashion',
                            'category' => 'printing',
                            'category_name' => 'Percetakan',
                            'client' => 'FashionHouse ID',
                            'description' => 'Desain dan percetakan katalog produk fashion dengan kualitas premium, menggunakan teknik cetak offset dan finishing khusus.',
                            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'year' => '2023',
                            'order' => 3,
                            'active' => true,
                            'tags' => ['Printing', 'Catalog', 'Fashion']
                        ],
                        [
                            'id' => 4,
                            'title' => 'Merchandise untuk Event Perusahaan',
                            'category' => 'merchandise',
                            'category_name' => 'Merchandise',
                            'client' => 'GlobalCorp Ltd.',
                            'description' => 'Produksi merchandise berupa kaos, topi, dan tumbler untuk acara tahunan perusahaan dengan desain custom yang menarik.',
                            'image' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'year' => '2023',
                            'order' => 4,
                            'active' => true,
                            'tags' => ['Merchandise', 'Event', 'Corporate']
                        ],
                        [
                            'id' => 5,
                            'title' => 'Desain Kemasan Produk Makanan',
                            'category' => 'packaging',
                            'category_name' => 'Packaging',
                            'client' => 'LocalFood Brand',
                            'description' => 'Desain kemasan yang eye-catching untuk produk makanan lokal, dengan fokus pada daya tarik visual dan informasi produk yang jelas.',
                            'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'year' => '2023',
                            'order' => 5,
                            'active' => true,
                            'tags' => ['Packaging', 'Food', 'Design']
                        ],
                        [
                            'id' => 6,
                            'title' => 'Logo untuk Studio Fitness & Wellness',
                            'category' => 'logo',
                            'category_name' => 'Logo Design',
                            'client' => 'FitLife Studio',
                            'description' => 'Desain logo yang energik dan modern untuk studio fitness, menggambarkan gerakan dan kesehatan secara visual.',
                            'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'year' => '2023',
                            'order' => 6,
                            'active' => true,
                            'tags' => ['Logo Design', 'Fitness', 'Modern']
                        ]
                    ];
                @endphp
                
                @foreach($portfolioItems as $item)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $item['active'] ? 'success' : 'danger' }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $item['active'] ? 'success' : 'danger' }} me-2">{{ $item['order'] }}</span>
                                Portfolio {{ $loop->iteration }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="portfolio-preview mb-3" style="
                                    width: 100%;
                                    height: 150px;
                                    background-image: url('{{ $item['image'] }}');
                                    background-size: cover;
                                    background-position: center;
                                    border-radius: 5px;
                                    border: 1px solid #e4e6ef;
                                "></div>
                                <label class="form-label required">Gambar</label>
                                <input type="text" class="form-control" 
                                       name="portfolio[{{ $item['id'] }}][image]" 
                                       value="{{ $item['image'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Portfolio</label>
                                <input type="text" class="form-control" 
                                       name="portfolio[{{ $item['id'] }}][title]" 
                                       value="{{ $item['title'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="portfolio[{{ $item['id'] }}][description]" 
                                          rows="3"
                                          required>{{ $item['description'] }}</textarea>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Klien</label>
                                    <input type="text" class="form-control" 
                                           name="portfolio[{{ $item['id'] }}][client]" 
                                           value="{{ $item['client'] }}"
                                           required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Tahun</label>
                                    <input type="text" class="form-control" 
                                           name="portfolio[{{ $item['id'] }}][year]" 
                                           value="{{ $item['year'] }}"
                                           required />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Kategori</label>
                                    <select class="form-select" name="portfolio[{{ $item['id'] }}][category]" data-control="select2">
                                        <option value="logo" {{ $item['category'] == 'logo' ? 'selected' : '' }}>Logo Design</option>
                                        <option value="branding" {{ $item['category'] == 'branding' ? 'selected' : '' }}>Branding</option>
                                        <option value="printing" {{ $item['category'] == 'printing' ? 'selected' : '' }}>Percetakan</option>
                                        <option value="merchandise" {{ $item['category'] == 'merchandise' ? 'selected' : '' }}>Merchandise</option>
                                        <option value="packaging" {{ $item['category'] == 'packaging' ? 'selected' : '' }}>Packaging</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="portfolio[{{ $item['id'] }}][order]" 
                                           value="{{ $item['order'] }}"
                                           min="1" max="20" required />
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Tags (pisahkan dengan koma)</label>
                                <input type="text" class="form-control" 
                                       name="portfolio[{{ $item['id'] }}][tags]" 
                                       value="{{ implode(', ', $item['tags']) }}" />
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" 
                                       name="portfolio[{{ $item['id'] }}][active]" 
                                       value="1" 
                                       id="portfolio_{{ $item['id'] }}_active" 
                                       {{ $item['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="portfolio_{{ $item['id'] }}_active">
                                    Tampilkan Portfolio
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Portfolio List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Portfolio Items</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach(array_slice($portfolioItems, 0, 3) as $item)
                                <div class="col-lg-4 col-md-6 mb-5">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body p-4">
                                            <div class="mb-4" style="
                                                width: 100%;
                                                height: 150px;
                                                background-image: url('{{ $item['image'] }}');
                                                background-size: cover;
                                                background-position: center;
                                                border-radius: 5px;
                                            "></div>
                                            <div class="mb-2">
                                                <span class="badge badge-light-primary">{{ $item['category_name'] }}</span>
                                            </div>
                                            <h4 class="fw-bold text-gray-800 mb-2">{{ Str::limit($item['title'], 50) }}</h4>
                                            <p class="text-muted fs-7 mb-3">{{ Str::limit($item['description'], 80) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted fs-8">
                                                    <i class="bi bi-person me-1"></i>{{ $item['client'] }}
                                                </span>
                                                <span class="text-muted fs-8">
                                                    <i class="bi bi-calendar me-1"></i>{{ $item['year'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah preview 3 portfolio item yang akan ditampilkan di halaman Portfolio.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetPortfolio()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="savePortfolio()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->

<!--begin::Modal - Add Portfolio-->
<div class="modal fade" id="kt_modal_add_portfolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Item Portfolio</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_add_portfolio_form" class="form" action="#">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Judul Portfolio</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Masukkan judul portfolio" name="new_portfolio_title" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" rows="3" name="new_portfolio_description" placeholder="Masukkan deskripsi portfolio"></textarea>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">URL Gambar</label>
                            <input type="text" class="form-control form-control-solid" placeholder="https://" name="new_portfolio_image" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Kategori</label>
                            <select class="form-select form-select-solid" name="new_portfolio_category">
                                <option value="logo">Logo Design</option>
                                <option value="branding">Branding</option>
                                <option value="printing">Percetakan</option>
                                <option value="merchandise">Merchandise</option>
                                <option value="packaging">Packaging</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Klien</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Nama klien" name="new_portfolio_client" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Tahun</label>
                            <input type="text" class="form-control form-control-solid" placeholder="2023" name="new_portfolio_year" />
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" placeholder="1" name="new_portfolio_order" min="1" max="20" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Status</label>
                            <div class="form-check form-check-custom form-check-solid mt-5">
                                <input class="form-check-input" type="checkbox" value="1" id="new_portfolio_active" checked />
                                <label class="form-check-label" for="new_portfolio_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Tags</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Desain, Logo, Branding (pisahkan dengan koma)" name="new_portfolio_tags" />
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
<!--end::Modal - Add Portfolio-->
@endsection

@push('scripts')
<script>
    function savePortfolio() {
        const form = document.getElementById('portfolioForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Portfolio berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetPortfolio() {
        Swal.fire({
            title: "Reset Portfolio?",
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
        // Form submission untuk modal tambah portfolio
        const modalForm = document.getElementById('kt_modal_add_portfolio_form');
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
                        text: "Portfolio berhasil ditambahkan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_portfolio'));
                        modal.hide();
                        location.reload();
                    });
                }, 1500);
            });
        }
    });
</script>
@endpush