@extends('admin.layouts.app')

@section('page-title', 'CTA Section')
@section('page-description', 'CTA Section — Ravaa Creative Tech')

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
        CTA Section
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>CTA Section</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-bullhorn fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen CTA Section</h4>
                <span>Kelola Call to Action (CTA) di akhir halaman Software House. CTA ini bertujuan untuk mengkonversi pengunjung menjadi klien.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="ctaForm">
            @csrf
            
            <!--begin::CTA Content-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Konten CTA</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Judul CTA</label>
                                <input type="text" class="form-control" 
                                       name="cta_title" 
                                       value="Siap Transformasi Bisnis Anda ke Digital?"
                                       required />
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="cta_description" 
                                          rows="3"
                                          required>Konsultasikan kebutuhan website atau aplikasi Anda dengan tim developer kami. Dapatkan solusi digital yang tepat untuk pertumbuhan bisnis Anda.</textarea>
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Background Color</label>
                                <input type="color" class="form-control form-control-color" 
                                       name="cta_background" 
                                       value="#667eea" 
                                       title="Pilih warna background CTA" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::CTA Content-->
            
            <!--begin::CTA Buttons-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Tombol CTA</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Button 1 -->
                                <div class="col-md-6 mb-10">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-4">Tombol 1 (Primary)</h5>
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="button1_text" 
                                                       value="Chat via WhatsApp"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label required">URL Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="button1_url" 
                                                       value="https://wa.me/6281234567890"
                                                       placeholder="URL WhatsApp atau kontak" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Icon Tombol</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </span>
                                                    <select class="form-select" name="button1_icon" data-control="select2">
                                                        <option value="fab fa-whatsapp" selected>WhatsApp</option>
                                                        <option value="fas fa-calendar-alt">Calendar</option>
                                                        <option value="fas fa-envelope">Email</option>
                                                        <option value="fas fa-phone">Phone</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Button 2 -->
                                <div class="col-md-6 mb-10">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-4">Tombol 2 (Secondary)</h5>
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="button2_text" 
                                                       value="Jadwalkan Meeting"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label required">URL Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="button2_url" 
                                                       value="/kontak"
                                                       placeholder="/kontak atau URL meeting" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Icon Tombol</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <select class="form-select" name="button2_icon" data-control="select2">
                                                        <option value="fas fa-calendar-alt" selected>Calendar</option>
                                                        <option value="fas fa-envelope">Email</option>
                                                        <option value="fas fa-phone">Phone</option>
                                                        <option value="fas fa-video">Video</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::CTA Buttons-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview CTA Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="cta-preview text-center p-10" style="
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                color: white;
                                border-radius: 10px;
                                padding: 50px 20px;
                            ">
                                <h2 class="mb-4" style="color: white; font-weight: bold;">Siap Transformasi Bisnis Anda ke Digital?</h2>
                                <p class="mb-5" style="color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">Konsultasikan kebutuhan website atau aplikasi Anda dengan tim developer kami. Dapatkan solusi digital yang tepat untuk pertumbuhan bisnis Anda.</p>
                                
                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                    <button class="btn" style="
                                        background: white;
                                        color: #667eea;
                                        border: none;
                                        padding: 12px 30px;
                                        border-radius: 5px;
                                        font-weight: 600;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                    ">
                                        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                                    </button>
                                    
                                    <button class="btn btn-outline-light" style="
                                        background: transparent;
                                        color: white;
                                        border: 2px solid white;
                                        padding: 10px 28px;
                                        border-radius: 5px;
                                        font-weight: 600;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                    ">
                                        <i class="fas fa-calendar-alt"></i> Jadwalkan Meeting
                                    </button>
                                </div>
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan CTA Section di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetCTA()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveCTA()">
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
    function saveCTA() {
        const form = document.getElementById('ctaForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "CTA Section berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetCTA() {
        Swal.fire({
            title: "Reset CTA Section?",
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
    
    // Real-time preview update
    document.addEventListener('DOMContentLoaded', function() {
        const ctaTitle = document.querySelector('input[name="cta_title"]');
        const ctaDescription = document.querySelector('textarea[name="cta_description"]');
        const ctaBackground = document.querySelector('input[name="cta_background"]');
        const button1Text = document.querySelector('input[name="button1_text"]');
        const button1Icon = document.querySelector('select[name="button1_icon"]');
        const button2Text = document.querySelector('input[name="button2_text"]');
        const button2Icon = document.querySelector('select[name="button2_icon"]');
        
        const previewSection = document.querySelector('.cta-preview');
        const previewTitle = previewSection.querySelector('h2');
        const previewDescription = previewSection.querySelector('p');
        const previewButton1 = previewSection.querySelector('.btn:not(.btn-outline-light)');
        const previewButton2 = previewSection.querySelector('.btn.btn-outline-light');
        
        function updatePreview() {
            if (ctaTitle.value) previewTitle.textContent = ctaTitle.value;
            if (ctaDescription.value) previewDescription.textContent = ctaDescription.value;
            if (button1Text.value) previewButton1.innerHTML = `<i class="${button1Icon.value}"></i> ${button1Text.value}`;
            if (button2Text.value) previewButton2.innerHTML = `<i class="${button2Icon.value}"></i> ${button2Text.value}`;
            
            // Update background color dengan gradient
            const color = ctaBackground.value;
            previewSection.style.background = `linear-gradient(135deg, ${color} 0%, ${adjustColor(color, -30)} 100%)`;
            previewButton1.style.color = color;
        }
        
        // Helper function untuk adjust color (sederhana)
        function adjustColor(hex, percent) {
            let r = parseInt(hex.slice(1, 3), 16);
            let g = parseInt(hex.slice(3, 5), 16);
            let b = parseInt(hex.slice(5, 7), 16);
            
            r = Math.min(255, Math.max(0, r + percent));
            g = Math.min(255, Math.max(0, g + percent));
            b = Math.min(255, Math.max(0, b + percent));
            
            return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
        }
        
        // Add event listeners
        [ctaTitle, ctaDescription, button1Text, button1Icon, button2Text, button2Icon, ctaBackground].forEach(input => {
            if (input) {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            }
        });
        
        // Initialize preview
        updatePreview();
    });
</script>
@endpush