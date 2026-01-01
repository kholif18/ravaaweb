@extends('admin.layouts.app')

@section('page-title', 'Promo Banner')
@section('page-description', 'Promo Banner — Ravaa Creative')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}"
           class="text-muted text-hover-primary">
            Home
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Promo Banner
    </li>
@endsection

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        
        <!--begin::Form-->
        <form id="promoForm" action="{{ route('admin.home.promo.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Edit Promo Banner Home Page</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-check-custom form-check-solid me-5">
                                <input class="form-check-input" type="checkbox" value="1" id="promo_status" name="status" checked />
                                <label class="form-check-label fw-bold" for="promo_status">
                                    Aktifkan Promo
                                </label>
                            </div>
                            <!--end::Switch-->
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
                    <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                        <!--begin::Icon-->
                        <i class="bi bi-exclamation-triangle fs-2hx text-warning me-4"></i>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column">
                            <!--begin::Title-->
                            <h4 class="mb-1 text-warning">Perhatian!</h4>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <span>Promo banner akan otomatis tersembunyi setelah tanggal berakhir. Pastikan untuk memperbarui promo secara berkala.</span>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->
                    
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            
                            <!--begin::Input group: Judul Promo-->
                            <div class="mb-10">
                                <label class="form-label required">Judul Promo</label>
                                <input type="text" class="form-control form-control-solid" 
                                       name="title" 
                                       value="Promo Spesial Bulan Ini!"
                                       placeholder="Masukkan judul promo"
                                       required />
                                <div class="text-muted fs-7">Judul utama promo yang akan ditampilkan.</div>
                            </div>
                            <!--end::Input group: Judul Promo-->
                            
                            <!--begin::Input group: Deskripsi Promo-->
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi Promo</label>
                                <textarea class="form-control form-control-solid" 
                                          name="description" 
                                          rows="3"
                                          placeholder="Masukkan deskripsi promo"
                                          required>Dapatkan diskon 20% untuk semua layanan desain dan 15% untuk produk percetakan.</textarea>
                                <div class="text-muted fs-7">Deskripsi detail tentang promo yang ditawarkan.</div>
                            </div>
                            <!--end::Input group: Deskripsi Promo-->
                            
                            <!--begin::Row: Kode Promo dan Tanggal-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Kode Promo</label>
                                        <input type="text" class="form-control form-control-solid" 
                                               name="promo_code" 
                                               value="RAVAA20"
                                               placeholder="Masukkan kode promo"
                                               required />
                                        <div class="text-muted fs-7 mt-1">Kode yang akan digunakan pelanggan.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Tanggal Berakhir</label>
                                        <input type="date" class="form-control form-control-solid" 
                                               name="expiry_date" 
                                               value="2023-11-30"
                                               required />
                                        <div class="text-muted fs-7 mt-1">Promo akan berakhir pada tanggal ini.</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Row: Kode Promo dan Tanggal-->
                            
                            <!--begin::Input group: Pesan Tambahan-->
                            <div class="mb-10">
                                <label class="form-label">Pesan Tambahan (Opsional)</label>
                                <input type="text" class="form-control form-control-solid" 
                                       name="additional_text" 
                                       value="Promo berlaku hingga 30 November 2023"
                                       placeholder="Masukkan pesan tambahan" />
                                <div class="text-muted fs-7">Pesan tambahan di bawah kode promo.</div>
                            </div>
                            <!--end::Input group: Pesan Tambahan-->
                            
                        </div>
                        <!--end::Col-->
                        
                        <!--begin::Col-->
                        <div class="col-lg-4">
                            
                            <!--begin::Card: Preview Promo Banner-->
                            <div class="card card-flush mb-10">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Preview Promo Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Promo preview-->
                                    <div class="bg-primary rounded p-5 text-center text-white">
                                        <h3 class="fw-bold mb-3">Promo Spesial Bulan Ini!</h3>
                                        <p class="mb-3">Dapatkan diskon 20% untuk semua layanan desain dan 15% untuk produk percetakan.</p>
                                        <p class="mb-2">Gunakan kode promo:</p>
                                        <div class="bg-white text-primary fw-bold fs-3 py-2 px-4 rounded d-inline-block mb-3">
                                            RAVAA20
                                        </div>
                                        <p class="mb-0">Promo berlaku hingga 30 November 2023</p>
                                    </div>
                                    <!--end::Promo preview-->
                                    <div class="text-muted mt-3">Ini adalah tampilan promo di homepage.</div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card: Preview Promo Banner-->
                            
                            <!--begin::Card: Warna Promo-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Warna Promo Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Color options-->
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="color" value="primary" id="color_primary" checked />
                                                <label class="form-check-label" for="color_primary">
                                                    <span class="d-flex align-items-center">
                                                        <span class="bullet bullet-primary bullet-sm me-2"></span>
                                                        Primary (Biru)
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="color" value="success" id="color_success" />
                                                <label class="form-check-label" for="color_success">
                                                    <span class="d-flex align-items-center">
                                                        <span class="bullet bullet-success bullet-sm me-2"></span>
                                                        Success (Hijau)
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="color" value="warning" id="color_warning" />
                                                <label class="form-check-label" for="color_warning">
                                                    <span class="d-flex align-items-center">
                                                        <span class="bullet bullet-warning bullet-sm me-2"></span>
                                                        Warning (Kuning)
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="color" value="danger" id="color_danger" />
                                                <label class="form-check-label" for="color_danger">
                                                    <span class="d-flex align-items-center">
                                                        <span class="bullet bullet-danger bullet-sm me-2"></span>
                                                        Danger (Merah)
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Color options-->
                                    <div class="text-muted fs-7 mt-3">Pilih warna tema untuk promo banner.</div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card: Warna Promo-->
                            
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    
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
    // Update preview saat input berubah
    function updatePromoPreview() {
        const title = document.querySelector('input[name="title"]').value;
        const description = document.querySelector('textarea[name="description"]').value;
        const promoCode = document.querySelector('input[name="promo_code"]').value;
        const additionalText = document.querySelector('input[name="additional_text"]').value;
        
        // Update preview
        const preview = document.querySelector('.bg-primary.rounded');
        preview.querySelector('h3').textContent = title || 'Judul Promo';
        preview.querySelector('p:nth-of-type(1)').textContent = description || 'Deskripsi promo';
        preview.querySelector('.bg-white').textContent = promoCode || 'KODEPROMO';
        preview.querySelector('p:nth-of-type(3)').textContent = additionalText || 'Pesan tambahan';
    }
    
    // Add event listeners
    document.querySelectorAll('#promoForm input, #promoForm textarea').forEach(element => {
        element.addEventListener('input', updatePromoPreview);
    });
    
    // Form validation
    var form = document.getElementById('promoForm');
    var validator = FormValidation.formValidation(
        form,
        {
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'Judul promo harus diisi'
                        }
                    }
                },
                description: {
                    validators: {
                        notEmpty: {
                            message: 'Deskripsi promo harus diisi'
                        }
                    }
                },
                promo_code: {
                    validators: {
                        notEmpty: {
                            message: 'Kode promo harus diisi'
                        }
                    }
                },
                expiry_date: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal berakhir harus diisi'
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
                            text: "Promo banner berhasil diperbarui!",
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
    
    // Initialize preview
    updatePromoPreview();
</script>
@endpush