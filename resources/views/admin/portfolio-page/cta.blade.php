@extends('admin.layouts.app')

@section('page-title', 'CTA Section')
@section('page-description', 'CTA Section — Ravaa Creative')

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
                <span>Kelola Call to Action (CTA) yang akan ditampilkan di akhir halaman portfolio. CTA membantu mengkonversi pengunjung menjadi klien.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="ctaForm">
            @csrf
            
            <!--begin::Section title-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Konten CTA</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul CTA</label>
                                        <input type="text" class="form-control" 
                                               name="cta_title" 
                                               value="Siap Bekerja Sama dengan Kami?"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Background Color</label>
                                        <input type="color" class="form-control form-control-color" 
                                               name="cta_background" 
                                               value="#667eea" 
                                               title="Pilih warna background CTA" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi CTA</label>
                                <textarea class="form-control" 
                                          name="cta_description" 
                                          rows="3"
                                          required>Jadikan ide kreatif Anda menjadi kenyataan dengan tim profesional Ravaa Creative. Konsultasikan proyek Anda sekarang.</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section title-->
            
            <!--begin::Button Settings-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Pengaturan Tombol</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Teks Tombol</label>
                                        <input type="text" class="form-control" 
                                               name="button_text" 
                                               value="Konsultasi Proyek"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Icon Tombol</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <select class="form-select" name="button_icon" data-control="select2">
                                                <option value="bi-envelope" selected>Envelope</option>
                                                <option value="bi-chat-left-dots">Chat</option>
                                                <option value="bi-whatsapp">WhatsApp</option>
                                                <option value="bi-telephone">Telephone</option>
                                                <option value="bi-calendar-check">Calendar</option>
                                                <option value="bi-pencil">Pencil</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">URL Tujuan</label>
                                        <input type="text" class="form-control" 
                                               name="button_url" 
                                               value="/kontak"
                                               placeholder="Contoh: /kontak atau https://wa.me/6281234567890"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label">Target Link</label>
                                        <select class="form-select" name="button_target" data-control="select2">
                                            <option value="_self" selected>Tab yang sama</option>
                                            <option value="_blank">Tab baru</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Button Settings-->
            
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
                                padding: 40px 20px;
                            ">
                                <h3 class="mb-4" style="color: white; font-weight: bold;">Siap Bekerja Sama dengan Kami?</h3>
                                <p class="mb-5" style="color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">Jadikan ide kreatif Anda menjadi kenyataan dengan tim profesional Ravaa Creative. Konsultasikan proyek Anda sekarang.</p>
                                <a href="/kontak" class="btn btn-light px-5" style="
                                    background-color: white;
                                    color: #667eea;
                                    font-weight: 600;
                                    padding: 10px 30px;
                                    border-radius: 5px;
                                    text-decoration: none;
                                ">
                                    <i class="bi bi-envelope me-2"></i>Konsultasi Proyek
                                </a>
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan CTA Section di halaman Portfolio.</div>
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
        const buttonText = document.querySelector('input[name="button_text"]');
        const buttonIcon = document.querySelector('select[name="button_icon"]');
        const ctaBackground = document.querySelector('input[name="cta_background"]');
        
        const previewSection = document.querySelector('.cta-preview');
        const previewTitle = previewSection.querySelector('h3');
        const previewDescription = previewSection.querySelector('p');
        const previewButton = previewSection.querySelector('.btn');
        const previewIcon = previewButton.querySelector('i');
        
        function updatePreview() {
            if (ctaTitle.value) previewTitle.textContent = ctaTitle.value;
            if (ctaDescription.value) previewDescription.textContent = ctaDescription.value;
            if (buttonText.value) previewButton.innerHTML = `<i class="${buttonIcon.value} me-2"></i>${buttonText.value}`;
            
            // Update background color dengan gradient
            const color = ctaBackground.value;
            previewSection.style.background = `linear-gradient(135deg, ${color} 0%, ${adjustColor(color, -30)} 100%)`;
            previewButton.style.color = color;
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
        [ctaTitle, ctaDescription, buttonText, buttonIcon, ctaBackground].forEach(input => {
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