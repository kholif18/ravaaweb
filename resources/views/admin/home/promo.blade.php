@extends('admin.layouts.app')

@section('page-title', 'Manajemen Promo Banner')
@section('page-description', 'Kelola promo banner untuk homepage — Ravaa Creative')

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
        Manajemen Promo Banner
    </li>
@endsection

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-fluid">
        
        <!--begin::Form-->
        <form id="promoForm" action="{{ route('admin.home.promo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Manajemen Promo Banner Homepage</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-check-custom form-check-solid me-5">
                                <input class="form-check-input" type="checkbox" value="1" id="promo_status" name="status" {{ $promo->status ?? 'checked' }} />
                                <label class="form-check-label fw-bold" for="promo_status">
                                    Aktifkan Promo Banner
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
                            <h4 class="mb-1 text-warning">Tips Promo Efektif!</h4>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <ul class="mb-0">
                                <li>Gunakan gambar produk yang menarik untuk meningkatkan konversi</li>
                                <li>Tambahkan benefit/value proposition yang jelas</li>
                                <li>Buat CTA (Call-to-Action) yang mudah ditemukan</li>
                                <li>Promo banner akan otomatis tersembunyi setelah tanggal berakhir</li>
                            </ul>
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
                                       value="{{ old('title', $promo->title ?? 'Diskon Spesial 20% Bulan Ini!') }}"
                                       placeholder="Contoh: Promo Spesial Bulan Ini!"
                                       required />
                                <div class="text-muted fs-7">Judul utama yang akan ditampilkan dengan ukuran besar.</div>
                            </div>
                            <!--end::Input group: Judul Promo-->
                            
                            <!--begin::Input group: Subjudul-->
                            <div class="mb-10">
                                <label class="form-label">Subjudul (Opsional)</label>
                                <input type="text" class="form-control form-control-solid" 
                                       name="subtitle" 
                                       value="{{ old('subtitle', $promo->subtitle ?? 'Untuk semua layanan desain & percetakan di Ravaa Creative') }}"
                                       placeholder="Contoh: Khusus bulan November" />
                                <div class="text-muted fs-7">Teks pendukung di bawah judul utama.</div>
                            </div>
                            <!--end::Input group: Subjudul-->
                            
                            <!--begin::Row: Tanggal Promo-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Tanggal Mulai</label>
                                        <input type="date" class="form-control form-control-solid" 
                                               name="start_date" 
                                               value="{{ old('start_date', $promo->start_date ?? date('Y-m-d')) }}"
                                               required />
                                        <div class="text-muted fs-7 mt-1">Tanggal promo mulai ditampilkan.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Tanggal Berakhir</label>
                                        <input type="date" class="form-control form-control-solid" 
                                               name="expiry_date" 
                                               value="{{ old('expiry_date', $promo->expiry_date ?? date('Y-m-d', strtotime('+30 days'))) }}"
                                               required />
                                        <div class="text-muted fs-7 mt-1">Promo akan berakhir pada tanggal ini.</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Row: Tanggal Promo-->
                            
                            <!--begin::Input group: Benefit List-->
                            <div class="mb-10">
                                <label class="form-label required">Benefit / Keuntungan</label>
                                <div class="benefits-container">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control benefit-input" placeholder="Contoh: Gratis konsultasi desain">
                                        <button class="btn btn-primary" type="button" id="addBenefitBtn">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="benefits-list" id="benefitsList">
                                        <!-- Benefits will be added here -->
                                        @if(isset($promo->benefits) && is_array($promo->benefits))
                                            @foreach($promo->benefits as $benefit)
                                            <div class="benefit-item d-flex align-items-center mb-2">
                                                <span class="bullet bullet-primary me-2"></span>
                                                <span class="benefit-text">{{ $benefit }}</span>
                                                <input type="hidden" name="benefits[]" value="{{ $benefit }}">
                                                <button type="button" class="btn btn-icon btn-sm btn-light ms-auto remove-benefit">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        @else
                                            <!-- Default benefits -->
                                            <div class="benefit-item d-flex align-items-center mb-2">
                                                <span class="bullet bullet-primary me-2"></span>
                                                <span class="benefit-text">Gratis konsultasi desain</span>
                                                <input type="hidden" name="benefits[]" value="Gratis konsultasi desain">
                                                <button type="button" class="btn btn-icon btn-sm btn-light ms-auto remove-benefit">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div class="benefit-item d-flex align-items-center mb-2">
                                                <span class="bullet bullet-primary me-2"></span>
                                                <span class="benefit-text">Free revisi 3x</span>
                                                <input type="hidden" name="benefits[]" value="Free revisi 3x">
                                                <button type="button" class="btn btn-icon btn-sm btn-light ms-auto remove-benefit">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div class="benefit-item d-flex align-items-center mb-2">
                                                <span class="bullet bullet-primary me-2"></span>
                                                <span class="benefit-text">Gratis pengiriman area Jogja</span>
                                                <input type="hidden" name="benefits[]" value="Gratis pengiriman area Jogja">
                                                <button type="button" class="btn btn-icon btn-sm btn-light ms-auto remove-benefit">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-muted fs-7">Daftar benefit yang akan ditampilkan dalam format checklist.</div>
                            </div>
                            <!--end::Input group: Benefit List-->
                            
                            <!--begin::Input group: CTA Text-->
                            <div class="mb-10">
                                <label class="form-label required">Teks Call-to-Action</label>
                                <input type="text" class="form-control form-control-solid" 
                                       name="cta_text" 
                                       value="{{ old('cta_text', $promo->cta_text ?? 'Hubungi kami sekarang untuk dapatkan penawaran!') }}"
                                       placeholder="Contoh: Pesan Sekarang!"
                                       required />
                                <div class="text-muted fs-7">Teks untuk memotivasi pengunjung mengambil tindakan.</div>
                            </div>
                            <!--end::Input group: CTA Text-->
                            
                            <!--begin::Input group: Kontak Informasi-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Nomor WhatsApp</label>
                                        <input type="text" class="form-control form-control-solid" 
                                               name="whatsapp_number" 
                                               value="{{ old('whatsapp_number', $promo->whatsapp_number ?? '628xxxxxxxxx') }}"
                                               placeholder="628xxxxxxxxx"
                                               required />
                                        <div class="text-muted fs-7 mt-1">Nomor untuk link WhatsApp (tanpa + atau 0).</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label">Nomor Telepon (Opsional)</label>
                                        <input type="text" class="form-control form-control-solid" 
                                               name="phone_number" 
                                               value="{{ old('phone_number', $promo->phone_number ?? '') }}"
                                               placeholder="0274xxxxxx" />
                                        <div class="text-muted fs-7 mt-1">Nomor telepon untuk link tel:</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group: Kontak Informasi-->
                            
                        </div>
                        <!--end::Col-->
                        
                        <!--begin::Col-->
                        <div class="col-lg-4">
                            
                            <!--begin::Card: Gambar Promo Banner-->
                            <div class="card card-flush mb-10">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Gambar Promo Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Image upload-->
                                    <div class="image-upload-container">
                                        <div class="image-preview mb-3" id="imagePreview">
                                            @if(isset($promo->image_url) && $promo->image_url)
                                                <img src="{{ asset($promo->image_url) }}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                            @else
                                                <div class="placeholder bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <span class="text-muted">Preview gambar akan muncul di sini</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Gambar Baru</label>
                                            <input type="file" class="form-control form-control-solid" 
                                                   name="image" 
                                                   id="imageUpload"
                                                   accept="image/*" />
                                            <div class="text-muted fs-7 mt-1">Rekomendasi: 400x300px, format JPG/PNG.</div>
                                        </div>
                                        @if(isset($promo->image_url) && $promo->image_url)
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1" />
                                            <label class="form-check-label" for="remove_image">
                                                Hapus gambar saat ini
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                    <!--end::Image upload-->
                                </div>
                            </div>
                            <!--end::Card: Gambar Promo Banner-->
                            
                            <!--begin::Card: Preview Promo Banner-->
                            <div class="card card-flush mb-10">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Preview Promo Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body p-0">
                                    <!--begin::Promo preview-->
                                    <div class="promo-preview" id="promoPreview">
                                        <!-- Preview will be updated by JavaScript -->
                                    </div>
                                    <!--end::Promo preview-->
                                </div>
                            </div>
                            <!--end::Card: Preview Promo Banner-->
                            
                            <!--begin::Card: Warna Tema-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <h3 class="card-title">Warna Tema Banner</h3>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Color options-->
                                    <div class="row g-3 mb-3">
                                        @php
                                            $colors = [
                                                'primary' => ['name' => 'Biru', 'value' => '#1e3c72', 'gradient' => 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)'],
                                                'success' => ['name' => 'Hijau', 'value' => '#00b894', 'gradient' => 'linear-gradient(135deg, #00b894 0%, #00a085 100%)'],
                                                'warning' => ['name' => 'Kuning', 'value' => '#fdcb6e', 'gradient' => 'linear-gradient(135deg, #fdcb6e 0%, #e17055 100%)'],
                                                'danger' => ['name' => 'Merah', 'value' => '#e17055', 'gradient' => 'linear-gradient(135deg, #e17055 0%, #d63031 100%)'],
                                                'purple' => ['name' => 'Ungu', 'value' => '#6c5ce7', 'gradient' => 'linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)'],
                                            ];
                                        @endphp
                                        
                                        @foreach($colors as $key => $color)
                                        <div class="col-6">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" 
                                                       name="color" 
                                                       value="{{ $key }}" 
                                                       id="color_{{ $key }}" 
                                                       {{ (isset($promo->color) && $promo->color == $key) || (!isset($promo->color) && $key == 'primary') ? 'checked' : '' }} />
                                                <label class="form-check-label" for="color_{{ $key }}">
                                                    <span class="d-flex align-items-center">
                                                        <span class="bullet bullet-sm me-2" style="background-color: {{ $color['value'] }}"></span>
                                                        {{ $color['name'] }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!--end::Color options-->
                                    <div class="text-muted fs-7">Pilih warna tema untuk promo banner.</div>
                                </div>
                            </div>
                            <!--end::Card: Warna Tema-->
                            
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    
                </div>
                <!--end::Card body-->
                
                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('admin.home.promo.preview') }}" class="btn btn-light me-3" target="_blank">
                        <i class="bi bi-eye fs-2"></i> Preview Live
                    </a>
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
    // Color themes data
    const colorThemes = {
        primary: {
            gradient: 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)',
            badge: '#ff6b6b',
            benefit: '#4cd137'
        },
        success: {
            gradient: 'linear-gradient(135deg, #00b894 0%, #00a085 100%)',
            badge: '#fd79a8',
            benefit: '#55efc4'
        },
        warning: {
            gradient: 'linear-gradient(135deg, #fdcb6e 0%, #e17055 100%)',
            badge: '#0984e3',
            benefit: '#ffeaa7'
        },
        danger: {
            gradient: 'linear-gradient(135deg, #e17055 0%, #d63031 100%)',
            badge: '#00cec9',
            benefit: '#fab1a0'
        },
        purple: {
            gradient: 'linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)',
            badge: '#ff7675',
            benefit: '#a29bfe'
        }
    };
    
    // Benefit Management
    document.addEventListener('DOMContentLoaded', function() {
        const addBenefitBtn = document.getElementById('addBenefitBtn');
        const benefitInput = document.querySelector('.benefit-input');
        const benefitsList = document.getElementById('benefitsList');
        
        // Add new benefit
        addBenefitBtn.addEventListener('click', function() {
            const benefitText = benefitInput.value.trim();
            if (benefitText) {
                const benefitItem = document.createElement('div');
                benefitItem.className = 'benefit-item d-flex align-items-center mb-2';
                benefitItem.innerHTML = `
                    <span class="bullet bullet-primary me-2"></span>
                    <span class="benefit-text">${benefitText}</span>
                    <input type="hidden" name="benefits[]" value="${benefitText}">
                    <button type="button" class="btn btn-icon btn-sm btn-light ms-auto remove-benefit">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                benefitsList.appendChild(benefitItem);
                benefitInput.value = '';
                updatePromoPreview();
            }
        });
        
        // Remove benefit
        benefitsList.addEventListener('click', function(e) {
            if (e.target.closest('.remove-benefit')) {
                e.target.closest('.benefit-item').remove();
                updatePromoPreview();
            }
        });
        
        // Add benefit on Enter key
        benefitInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addBenefitBtn.click();
            }
        });
        
        // Image upload preview
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
        
        if (imageUpload) {
            imageUpload.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">`;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Initialize preview
        updatePromoPreview();
    });
    
    // Update promo preview
    function updatePromoPreview() {
        const title = document.querySelector('input[name="title"]').value || 'Judul Promo';
        const subtitle = document.querySelector('input[name="subtitle"]').value || 'Subjudul promomu di sini';
        const ctaText = document.querySelector('input[name="cta_text"]').value || 'Hubungi kami sekarang!';
        const selectedColor = document.querySelector('input[name="color"]:checked')?.value || 'primary';
        const colorTheme = colorThemes[selectedColor];
        
        // Get benefits
        const benefits = [];
        document.querySelectorAll('#benefitsList .benefit-text').forEach(el => {
            benefits.push(el.textContent);
        });
        
        // Create preview HTML
        const previewHTML = `
            <div class="promo-preview-content" style="background: ${colorTheme.gradient}; color: white; padding: 30px;">
                <div style="text-align: center;">
                    <span style="background: ${colorTheme.badge}; color: white; padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; display: inline-block; margin-bottom: 15px;">
                        PENAWARAN TERBATAS
                    </span>
                    <h3 style="font-size: 24px; color: white; margin-bottom: 10px; line-height: 1.2;">${title}</h3>
                    <p style="opacity: 0.9; margin-bottom: 20px;">${subtitle}</p>
                    
                    ${benefits.length > 0 ? `
                    <div class="preview-benefits-list">
                        ${benefits.map(benefit => `
                            <div class="preview-benefit-item">
                                <span class="preview-benefit-icon" style="background: ${colorTheme.benefit}">✓</span>
                                <span>${benefit}</span>
                            </div>
                        `).join('')}
                    </div>
                    ` : ''}
                    
                    <div style="margin: 25px 0;">
                        <p style="font-size: 18px; font-weight: 500; margin-bottom: 15px;">${ctaText}</p>
                        <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                            <a href="#" style="background: #25d366; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                💬 WhatsApp
                            </a>
                            <a href="#" style="background: transparent; color: white; border: 2px solid rgba(255,255,255,0.3); padding: 12px 25px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                📞 Telepon
                            </a>
                        </div>
                    </div>
                    
                    <p style="font-size: 14px; opacity: 0.8; margin-top: 20px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        ⏳ Promo berlaku hingga {{ isset($promo->expiry_date) ? \Carbon\Carbon::parse($promo->expiry_date)->format('d F Y') : date('d F Y', strtotime('+30 days')) }}
                    </p>
                </div>
            </div>
        `;
        
        document.getElementById('promoPreview').innerHTML = previewHTML;
    }
    
    // Add event listeners for form changes
    document.querySelectorAll('#promoForm input, #promoForm textarea').forEach(element => {
        element.addEventListener('input', updatePromoPreview);
    });
    
    document.querySelectorAll('input[name="color"]').forEach(radio => {
        radio.addEventListener('change', updatePromoPreview);
    });
    
    // Form validation
    var form = document.getElementById('promoForm');
    if (form) {
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
                    cta_text: {
                        validators: {
                            notEmpty: {
                                message: 'Teks CTA harus diisi'
                            }
                        }
                    },
                    whatsapp_number: {
                        validators: {
                            notEmpty: {
                                message: 'Nomor WhatsApp harus diisi'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'Nomor harus berisi angka saja'
                            }
                        }
                    },
                    start_date: {
                        validators: {
                            notEmpty: {
                                message: 'Tanggal mulai harus diisi'
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
                        
                        // Submit form
                        form.submit();
                    }
                });
            }
        });
    }
    
    // Image remove checkbox handler
    const removeImageCheckbox = document.getElementById('remove_image');
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            const imageUpload = document.getElementById('imageUpload');
            if (this.checked) {
                imageUpload.disabled = true;
                imageUpload.value = '';
            } else {
                imageUpload.disabled = false;
            }
        });
    }
</script>
@endpush