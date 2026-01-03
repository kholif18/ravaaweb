@extends('admin.layouts.app')

@section('page-title', 'Banner Hero')
@section('page-description', 'Banner Home Content — Ravaa Creative')

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
        Banner Hero
    </li>
@endsection

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                <i class="bi bi-check-circle-fill fs-2hx text-success me-4"></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-success">Berhasil!</h4>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                <i class="bi bi-x-circle-fill fs-2hx text-danger me-4"></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-danger">Terjadi Kesalahan!</h4>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        <!--begin::Form-->
        <form id="bannerForm" action="{{ route('admin.home.banner.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Add hidden input for banner ID -->
            <input type="hidden" name="banner_id" value="{{ $banner->id ?? '' }}">
            
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
                                       value="{{ old('title', $banner->title ?? 'Solusi Kreatif untuk Desain, Print & ATK Anda') }}"
                                       placeholder="Masukkan judul banner"
                                       required />
                                @error('title')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
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
                                          required>{{ old('description', $banner->description ?? 'Ravaa Creative menyediakan layanan desain grafis, percetakan, dan alat tulis kantor berkualitas tinggi dengan harga kompetitif. Hasil kreatif yang memukau untuk kebutuhan bisnis Anda.') }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-7">Deskripsi singkat di bawah judul banner.</div>
                            </div>
                            <!--end::Input group: Deskripsi Banner-->
                            
                            <!--begin::Row: Tombol CTA-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 1 - Teks</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button1_text" 
                                           value="{{ old('button1_text', $banner->button1_text ?? 'Lihat Layanan') }}"
                                           placeholder="Teks tombol pertama"
                                           required />
                                    @error('button1_text')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="text-muted fs-7 mt-1">Contoh: "Lihat Layanan"</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 1 - Link</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button1_link" 
                                           value="{{ old('button1_link', $banner->button1_link ?? url('/layanan')) }}"
                                           placeholder="Link tujuan tombol pertama"
                                           required />
                                    @error('button1_link')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="text-muted fs-7 mt-1">Contoh: "/layanan" atau URL lengkap</div>
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 2 - Teks</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button2_text" 
                                           value="{{ old('button2_text', $banner->button2_text ?? 'Portfolio Kami') }}"
                                           placeholder="Teks tombol kedua"
                                           required />
                                    @error('button2_text')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="text-muted fs-7 mt-1">Contoh: "Portfolio Kami"</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Tombol 2 - Link</label>
                                    <input type="text" class="form-control form-control-solid" 
                                           name="button2_link" 
                                           value="{{ old('button2_link', $banner->button2_link ?? url('/portofolio')) }}"
                                           placeholder="Link tujuan tombol kedua"
                                           required />
                                    @error('button2_link')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
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
                                    <div class="image-input image-input-outline mb-3" data-kt-image-input="true" 
                                         style="background-image: url('{{ $banner->image_url ?? 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}')">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-100px" 
                                             style="background-image: url('{{ $banner->image_url ?? 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}')"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                               data-kt-image-input-action="change" 
                                               data-bs-toggle="tooltip" 
                                               title="Ubah gambar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="banner_image" accept=".png, .jpg, .jpeg, .gif, .webp" />
                                            <input type="hidden" name="banner_image_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                              data-kt-image-input-action="cancel" 
                                              data-bs-toggle="tooltip" 
                                              title="Batal">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                              data-kt-image-input-action="remove" 
                                              data-bs-toggle="tooltip" 
                                              title="Hapus gambar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <div class="text-muted">Klik ikon pensil untuk mengubah gambar</div>
                                    <div class="text-muted fs-7 mt-2">Ukuran disarankan: 1200x600px (rasio 2:1)</div>
                                    
                                    @error('banner_image')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
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
                                        <input class="form-check-input" type="checkbox" value="1" 
                                               id="banner_status" name="status" 
                                               {{ old('status', $banner->status ?? true) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="banner_status">
                                            Tampilkan Banner
                                        </label>
                                    </div>
                                    <!--end::Switch-->
                                    @error('status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
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
                <div class="card-footer d-flex justify-content-between py-6 px-9">
                    <div>
                        <button type="button" class="btn btn-light-danger me-3" onclick="resetBanner()">
                            <i class="bi bi-arrow-clockwise me-2"></i> Reset ke Default
                        </button>
                        <button type="reset" class="btn btn-light">Reset Form</button>
                    </div>
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
        
        // Submit handler
        form.addEventListener('submit', function (e) {
            // Show loading indicator
            const submitButton = this.querySelector('[type="submit"]');
            submitButton.setAttribute('data-kt-indicator', 'on');
            submitButton.disabled = true;
            
            // Form will submit normally for server-side validation
        });
        
        // Reset banner to defaults
        function resetBanner() {
            Swal.fire({
                title: 'Reset Banner?',
                text: 'Banner akan dikembalikan ke nilai default. Data yang ada akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang mereset banner',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit reset request
                    fetch('{{ route("admin.home.banner.reset") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire({
                                text: data.message || 'Banner berhasil direset!',
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                text: data.message || 'Gagal reset banner',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        Swal.fire({
                            text: 'Terjadi kesalahan saat mereset banner',
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    });
                }
            });
        }
        
        // AJAX image upload preview (optional enhancement)
        document.querySelector('input[name="banner_image"]')?.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                // Optional: Add client-side validation
                const file = this.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        text: 'Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                    this.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    Swal.fire({
                        text: 'Ukuran file terlalu besar. Maksimal 5MB.',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                    this.value = '';
                    return;
                }
                
                // Preview image locally before upload
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageWrapper = document.querySelector('.image-input-wrapper');
                    const imageInput = document.querySelector('.image-input');
                    if (imageWrapper && imageInput) {
                        imageWrapper.style.backgroundImage = `url('${e.target.result}')`;
                        imageInput.style.backgroundImage = `url('${e.target.result}')`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush