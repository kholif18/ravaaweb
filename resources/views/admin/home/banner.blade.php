@extends('admin.layouts.app')

@section('page-title', 'Banner Hero')
@section('page-description', 'Banner Home Content — Ravaa Creative')

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
        Home Banner
    </li>
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div id="kt_toolbar" class="toolbar py-3 py-lg-6">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Banner Hero - Home Page</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
                </li>
                <li class="breadcrumb-item text-gray-600">
                    <a href="#" class="text-gray-600 text-hover-primary">Home Page</a>
                </li>
                <li class="breadcrumb-item text-gray-600">Banner Hero</li>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
@endsection

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        
        <!--begin::Form-->
        <form id="bannerForm" action="{{ route('admin.home.banner.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Edit Banner Hero Home Page</h2>
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
                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                        <!--begin::Icon-->
                        <i class="bi bi-info-circle fs-2hx text-primary me-4"></i>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column">
                            <!--begin::Title-->
                            <h4 class="mb-1 text-primary">Informasi Banner Hero</h4>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <span>Banner ini akan ditampilkan di bagian atas halaman utama website. Gunakan gambar dengan resolusi tinggi (minimal 1200x600px) untuk hasil terbaik.</span>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert-->
                    
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            
                            <!--begin::Input group: Judul Banner-->
                            <div class="mb-10">
                                <label class="form-label required">Judul Banner</label>
                                <input type="text" class="form-control form-control-solid" 
                                       name="title" 
                                       value="Solusi Kreatif untuk Desain, Print & ATK Anda"
                                       placeholder="Masukkan judul banner"
                                       required />
                                <div class="text-muted fs-7">Judul utama yang akan ditampilkan di banner.</div>
                            </div>
                            <!--end::Input group: Judul Banner-->
                            
                            <!--begin::Input group: Deskripsi Banner-->
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi Banner</label>
                                <textarea class="form-control form-control-solid" 
                                          name="description" 
                                          rows="4"
                                          placeholder="Masukkan deskripsi banner"
                                          required>Ravaa Creative menyediakan layanan desain grafis, percetakan, dan alat tulis kantor berkualitas tinggi dengan harga kompetitif. Hasil kreatif yang memukau untuk kebutuhan bisnis Anda.</textarea>
                                <div class="text-muted fs-7">Deskripsi singkat di bawah judul banner.</div>
                            </div>
                            <!--end::Input group: Deskripsi Banner-->
                            
                            <!--begin::Row: Tombol CTA-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 1 - Teks</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button1_text" 
                                           value="Lihat Layanan"
                                           placeholder="Teks tombol pertama"
                                           required />
                                    <div class="text-muted fs-7 mt-1">Contoh: "Lihat Layanan"</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 1 - Link</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button1_link" 
                                           value="{{ url('/layanan') }}"
                                           placeholder="Link tujuan tombol pertama"
                                           required />
                                    <div class="text-muted fs-7 mt-1">Contoh: "/layanan" atau URL lengkap</div>
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 2 - Teks</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button2_text" 
                                           value="Portfolio Kami"
                                           placeholder="Teks tombol kedua"
                                           required />
                                    <div class="text-muted fs-7 mt-1">Contoh: "Portfolio Kami"</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 2 - Link</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button2_link" 
                                           value="{{ url('/portofolio') }}"
                                           placeholder="Link tujuan tombol kedua"
                                           required />
                                    <div class="text-muted fs-7 mt-1">Contoh: "/portofolio" atau URL lengkap</div>
                                </div>
                            </div>
                            <!--end::Row: Tombol CTA-->
                            
                        </div>
                        <!--end::Col-->
                        
                        <!--begin::Col-->
                        <div class="col-lg-4">
                            
                            <!--begin::Card: Preview Gambar-->
                            <div class="card card-flush mb-10">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Gambar Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body text-center">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80)">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-100px" style="background-image: url(https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80)"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah gambar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="banner_image" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="banner_image_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batal">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus gambar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <div class="text-muted">Klik ikon pensil untuk mengubah gambar</div>
                                    <div class="text-muted fs-7 mt-2">Ukuran disarankan: 1200x600px (rasio 2:1)</div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card: Preview Gambar-->
                            
                            <!--begin::Card: Status Banner-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Status Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Switch-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="banner_status" name="status" checked />
                                        <label class="form-check-label" for="banner_status">
                                            Tampilkan Banner
                                        </label>
                                    </div>
                                    <!--end::Switch-->
                                    <div class="text-muted fs-7 mt-2">Nonaktifkan jika ingin menyembunyikan banner dari homepage.</div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card: Status Banner-->
                            
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
    // Image input handler
    var bannerImage = new KTImageInput('banner_image');
    
    // Form validation
    var form = document.getElementById('bannerForm');
    var validator = FormValidation.formValidation(
        form,
        {
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'Judul banner harus diisi'
                        }
                    }
                },
                description: {
                    validators: {
                        notEmpty: {
                            message: 'Deskripsi banner harus diisi'
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
                            text: "Banner berhasil diperbarui!",
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