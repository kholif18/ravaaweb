@extends('admin.layouts.app')

@section('page-title', 'Pricing Plans')
@section('page-description', 'Pricing Plans — Ravaa Creative Tech')

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
        Pricing Plans
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Paket Pricing</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-tags fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Pricing Plans</h4>
                <span>Kelola paket harga untuk layanan website development. Setiap paket dapat dikustomisasi dengan fitur dan harga yang berbeda.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="pricingForm">
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
                                               value="Paket Website Development"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_description" 
                                                  rows="3"
                                                  required>Pilih paket yang sesuai dengan kebutuhan bisnis Anda. Semua paket termasuk domain, hosting, dan maintenance.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section Title-->
            
            <!--begin::Pricing Plans-->
            <div class="row">
                @php
                    $pricingPlans = [
                        [
                            'id' => 1,
                            'name' => 'Paket Basic',
                            'price' => 'Rp 3.9JT',
                            'period' => 'One-time payment',
                            'features' => [
                                '5 Halaman Website' => true,
                                'Design Responsive' => true,
                                'CMS Simple' => true,
                                'Kontak Form' => true,
                                'E-commerce' => false,
                                'Admin Panel' => false,
                                'Mobile App' => false
                            ],
                            'button_text' => 'Pesan Sekarang',
                            'button_url' => 'https://wa.me/6281234567890',
                            'is_popular' => false,
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'name' => 'Paket Professional',
                            'price' => 'Rp 8.9JT',
                            'period' => 'One-time payment',
                            'features' => [
                                '10-15 Halaman Website' => true,
                                'Design Custom' => true,
                                'CMS Custom' => true,
                                'Admin Panel' => true,
                                'Basic E-commerce' => true,
                                'SEO Optimization' => true,
                                'Mobile App' => false
                            ],
                            'button_text' => 'Pesan Sekarang',
                            'button_url' => 'https://wa.me/6281234567890',
                            'is_popular' => true,
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'name' => 'Paket Enterprise',
                            'price' => 'Rp 19.9JT',
                            'period' => 'Custom Project',
                            'features' => [
                                'Unlimited Pages' => true,
                                'Advanced E-commerce' => true,
                                'Mobile App Included' => true,
                                'Custom Features' => true,
                                'API Integration' => true,
                                'Priority Support' => true,
                                '1 Year Maintenance' => true
                            ],
                            'button_text' => 'Konsultasi Proyek',
                            'button_url' => 'https://wa.me/6281234567890',
                            'is_popular' => false,
                            'active' => true,
                            'order' => 3
                        ]
                    ];
                @endphp
                
                @foreach($pricingPlans as $plan)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100 {{ $plan['is_popular'] ? 'border-primary' : '' }}">
                        @if($plan['is_popular'])
                        <div class="card-header bg-primary">
                            <div class="card-title text-white">
                                <span class="badge badge-white me-2">{{ $plan['order'] }}</span>
                                {{ $plan['name'] }}
                            </div>
                        </div>
                        @else
                        <div class="card-header bg-light">
                            <div class="card-title text-gray-800">
                                <span class="badge badge-light me-2">{{ $plan['order'] }}</span>
                                {{ $plan['name'] }}
                            </div>
                        </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Nama Paket</label>
                                <input type="text" class="form-control" 
                                       name="plans[{{ $plan['id'] }}][name]" 
                                       value="{{ $plan['name'] }}"
                                       required />
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Harga</label>
                                    <input type="text" class="form-control" 
                                           name="plans[{{ $plan['id'] }}][price]" 
                                           value="{{ $plan['price'] }}"
                                           placeholder="Rp 3.9JT"
                                           required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Periode</label>
                                    <input type="text" class="form-control" 
                                           name="plans[{{ $plan['id'] }}][period]" 
                                           value="{{ $plan['period'] }}"
                                           placeholder="One-time payment"
                                           required />
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Fitur (format: Fitur:true/false)</label>
                                <textarea class="form-control" 
                                          name="plans[{{ $plan['id'] }}][features]" 
                                          rows="5"
                                          placeholder="Fitur 1:true&#10;Fitur 2:false&#10;Fitur 3:true"
                                          required>@foreach($plan['features'] as $feature => $included)
{{ $feature }}:{{ $included ? 'true' : 'false' }}
@endforeach</textarea>
                                <div class="text-muted fs-7 mt-2">Format: Nama Fitur:true atau false</div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Teks Tombol</label>
                                    <input type="text" class="form-control" 
                                           name="plans[{{ $plan['id'] }}][button_text]" 
                                           value="{{ $plan['button_text'] }}"
                                           required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">URL Tombol</label>
                                    <input type="text" class="form-control" 
                                           name="plans[{{ $plan['id'] }}][button_url]" 
                                           value="{{ $plan['button_url'] }}"
                                           required />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="plans[{{ $plan['id'] }}][order]" 
                                           value="{{ $plan['order'] }}"
                                           min="1" max="5" required />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid mt-8">
                                        <input class="form-check-input" type="checkbox" 
                                               name="plans[{{ $plan['id'] }}][is_popular]" 
                                               value="1" 
                                               id="plan_{{ $plan['id'] }}_popular" 
                                               {{ $plan['is_popular'] ? 'checked' : '' }} />
                                        <label class="form-check-label" for="plan_{{ $plan['id'] }}_popular">
                                            Paket Populer
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" 
                                       name="plans[{{ $plan['id'] }}][active]" 
                                       value="1" 
                                       id="plan_{{ $plan['id'] }}_active" 
                                       {{ $plan['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="plan_{{ $plan['id'] }}_active">
                                    Tampilkan Paket
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Pricing Plans-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Pricing Plans</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($pricingPlans as $plan)
                                <div class="col-lg-4 col-md-6 mb-5">
                                    <div class="card card-bordered h-100 {{ $plan['is_popular'] ? 'border-primary border-2' : '' }}">
                                        @if($plan['is_popular'])
                                        <div class="position-absolute top-0 start-50 translate-middle mt-n3">
                                            <span class="badge bg-primary">POPULAR</span>
                                        </div>
                                        @endif
                                        
                                        <div class="card-header {{ $plan['is_popular'] ? 'bg-primary' : 'bg-light' }} py-6">
                                            <h3 class="card-title {{ $plan['is_popular'] ? 'text-white' : 'text-gray-800' }}">
                                                {{ $plan['name'] }}
                                            </h3>
                                            <div class="card-toolbar">
                                                <div class="fs-1 fw-bold {{ $plan['is_popular'] ? 'text-white' : 'text-gray-800' }}">{{ $plan['price'] }}</div>
                                                <div class="text-muted fs-7">{{ $plan['period'] }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="card-body p-6">
                                            <div class="mb-6">
                                                <h6 class="fw-bold mb-4">Fitur termasuk:</h6>
                                                @foreach(array_slice($plan['features'], 0, 4) as $feature => $included)
                                                <div class="d-flex align-items-center mb-3">
                                                    @if($included)
                                                    <i class="bi bi-check-circle text-success me-3"></i>
                                                    <span class="text-gray-700">{{ $feature }}</span>
                                                    @else
                                                    <i class="bi bi-x-circle text-muted me-3"></i>
                                                    <span class="text-muted">{{ $feature }}</span>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                            <div class="mt-auto">
                                                <a href="{{ $plan['button_url'] }}" 
                                                   class="btn {{ $plan['is_popular'] ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                    {{ $plan['button_text'] }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan Pricing Plans di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetPricing()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="savePricing()">
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
    function savePricing() {
        const form = document.getElementById('pricingForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Pricing Plans berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetPricing() {
        Swal.fire({
            title: "Reset Pricing Plans?",
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