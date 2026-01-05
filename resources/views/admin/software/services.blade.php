@extends('admin.layouts.app')

@section('page-title', 'Tech Services')
@section('page-description', 'Tech Services — Ravaa Creative Tech')

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
            Software House
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Tech Services
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Layanan Tech</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-gear fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Layanan Tech</h4>
                <span>Kelola layanan software development yang ditawarkan di halaman Software House. Setiap layanan dapat dikustomisasi dengan icon, deskripsi, dan fitur.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="servicesForm">
            @csrf
            
            <!--begin::Section Title-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Judul Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul Utama</label>
                                        <input type="text" class="form-control" 
                                               name="section_title" 
                                               value="Layanan Development Kami"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_description" 
                                                  rows="3"
                                                  required>Kami menyediakan berbagai layanan pengembangan software untuk kebutuhan digital bisnis Anda.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section Title-->
            
            <!--begin::Services List-->
            <div class="row">
                @php
                    $services = [
                        [
                            'id' => 1,
                            'title' => 'Website Development',
                            'icon' => 'fas fa-laptop-code',
                            'description' => 'Pembuatan website company profile, e-commerce, landing page, dan website custom sesuai kebutuhan bisnis Anda.',
                            'features' => ['Website Responsive', 'CMS Custom', 'SEO Friendly', 'Integrasi Payment'],
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'title' => 'Mobile App Development',
                            'icon' => 'fas fa-mobile-alt',
                            'description' => 'Pengembangan aplikasi mobile iOS & Android untuk bisnis, startup, atau kebutuhan internal perusahaan.',
                            'features' => ['Android & iOS', 'Cross-Platform', 'Push Notification', 'API Integration'],
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'title' => 'E-Commerce Solution',
                            'icon' => 'fas fa-shopping-cart',
                            'description' => 'Solusi toko online lengkap dengan sistem manajemen produk, order, payment gateway, dan dashboard analytics.',
                            'features' => ['Multi-Vendor System', 'Payment Gateway', 'Inventory Management', 'Reporting System'],
                            'active' => true,
                            'order' => 3
                        ],
                        [
                            'id' => 4,
                            'title' => 'Custom Software',
                            'icon' => 'fas fa-cogs',
                            'description' => 'Pengembangan software khusus untuk kebutuhan bisnis seperti CRM, ERP, sistem inventory, dan aplikasi internal.',
                            'features' => ['Custom Requirements', 'Scalable Architecture', 'Database Design', 'API Development'],
                            'active' => true,
                            'order' => 4
                        ]
                    ];
                @endphp
                
                @foreach($services as $service)
                <div class="col-lg-3 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-primary">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-primary me-2">{{ $service['order'] }}</span>
                                {{ $service['title'] }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="{{ $service['icon'] }}"></i>
                                    </span>
                                    <select class="form-select" name="services[{{ $service['id'] }}][icon]" data-control="select2">
                                        <option value="fas fa-laptop-code" {{ $service['icon'] == 'fas fa-laptop-code' ? 'selected' : '' }}>Laptop Code</option>
                                        <option value="fas fa-mobile-alt" {{ $service['icon'] == 'fas fa-mobile-alt' ? 'selected' : '' }}>Mobile</option>
                                        <option value="fas fa-shopping-cart" {{ $service['icon'] == 'fas fa-shopping-cart' ? 'selected' : '' }}>Shopping Cart</option>
                                        <option value="fas fa-cogs" {{ $service['icon'] == 'fas fa-cogs' ? 'selected' : '' }}>Cogs</option>
                                        <option value="fas fa-code">Code</option>
                                        <option value="fas fa-server">Server</option>
                                        <option value="fas fa-database">Database</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Layanan</label>
                                <input type="text" class="form-control" 
                                       name="services[{{ $service['id'] }}][title]" 
                                       value="{{ $service['title'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="services[{{ $service['id'] }}][description]" 
                                          rows="3"
                                          required>{{ $service['description'] }}</textarea>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Fitur (pisahkan dengan koma)</label>
                                <textarea class="form-control" 
                                          name="services[{{ $service['id'] }}][features]" 
                                          rows="3"
                                          placeholder="Fitur 1, Fitur 2, Fitur 3">{{ implode(', ', $service['features']) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="services[{{ $service['id'] }}][order]" 
                                           value="{{ $service['order'] }}"
                                           min="1" max="10" required />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid mt-8">
                                        <input class="form-check-input" type="checkbox" 
                                               name="services[{{ $service['id'] }}][active]" 
                                               value="1" 
                                               id="service_{{ $service['id'] }}_active" 
                                               {{ $service['active'] ? 'checked' : '' }} />
                                        <label class="form-check-label" for="service_{{ $service['id'] }}_active">
                                            Tampilkan Layanan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Services List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Layanan Tech</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach(array_slice($services, 0, 2) as $service)
                                <div class="col-lg-6 mb-5">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body p-6">
                                            <div class="d-flex align-items-start mb-4">
                                                <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center me-4" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="{{ $service['icon'] }} fs-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h4 class="fw-bold text-gray-800 mb-2">{{ $service['title'] }}</h4>
                                                    <p class="text-muted">{{ Str::limit($service['description'], 120) }}</p>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <h6 class="fw-bold mb-3">Fitur termasuk:</h6>
                                                <div class="row">
                                                    @foreach(array_slice($service['features'], 0, 2) as $feature)
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-check-circle text-success me-2"></i>
                                                            <span class="text-muted">{{ $feature }}</span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah preview 2 layanan tech yang akan ditampilkan di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetServices()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveServices()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->
@endsection

@push('scripts')
<script>
    function saveServices() {
        const form = document.getElementById('servicesForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Layanan berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetServices() {
        Swal.fire({
            title: "Reset Layanan?",
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
</script>
@endpush