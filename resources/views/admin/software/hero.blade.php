@extends('admin.layouts.app')

@section('page-title', 'Hero Section')

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
        Hero Section
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Hero Section</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-code-square fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Hero Section</h4>
                <span>Kelola konten utama di bagian atas halaman Software House. Hero section adalah bagian pertama yang dilihat pengunjung.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="heroForm">
            @csrf
            
            <!--begin::Hero Content-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Konten Utama</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Badge</label>
                                <input type="text" class="form-control" 
                                       name="badge_text" 
                                       value="Divisi Software House"
                                       required />
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Icon Badge</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                    <select class="form-select" name="badge_icon" data-control="select2">
                                        <option value="fas fa-code" selected>Code</option>
                                        <option value="fas fa-laptop-code">Laptop Code</option>
                                        <option value="fas fa-microchip">Microchip</option>
                                        <option value="fas fa-robot">Robot</option>
                                        <option value="fas fa-brain">Brain</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Judul Utama</label>
                                <input type="text" class="form-control" 
                                       name="title" 
                                       value="Ravaa Creative Tech"
                                       required />
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="description" 
                                          rows="4"
                                          required>Kami adalah divisi Software House dari Ravaa Creative yang khusus mengembangkan website, aplikasi mobile, dan solusi digital custom untuk bisnis Anda. Tim developer berpengalaman kami siap mewujudkan ide digital Anda.</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Hero Content-->
            
            <!--begin::Hero Actions-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Tombol Aksi</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Button 1 -->
                                <div class="col-md-4 mb-10">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol 1</label>
                                                <input type="text" class="form-control" 
                                                       name="button1_text" 
                                                       value="Lihat Paket Website"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">URL Tombol 1</label>
                                                <input type="text" class="form-control" 
                                                       name="button1_url" 
                                                       value="#pricing"
                                                       placeholder="#pricing atau /pricing" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Button 2 -->
                                <div class="col-md-4 mb-10">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol 2</label>
                                                <input type="text" class="form-control" 
                                                       name="button2_text" 
                                                       value="Portfolio Tech"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">URL Tombol 2</label>
                                                <input type="text" class="form-control" 
                                                       name="button2_url" 
                                                       value="#portfolio"
                                                       placeholder="#portfolio atau /portfolio" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Button 3 -->
                                <div class="col-md-4 mb-10">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol 3</label>
                                                <input type="text" class="form-control" 
                                                       name="button3_text" 
                                                       value="Konsultasi Gratis"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">URL Tombol 3</label>
                                                <input type="text" class="form-control" 
                                                       name="button3_url" 
                                                       value="https://wa.me/6281234567890"
                                                       placeholder="URL WhatsApp atau kontak" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Icon Tombol 3</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </span>
                                                    <select class="form-select" name="button3_icon" data-control="select2">
                                                        <option value="fab fa-whatsapp" selected>WhatsApp</option>
                                                        <option value="fas fa-envelope">Email</option>
                                                        <option value="fas fa-phone">Phone</option>
                                                        <option value="fas fa-comment">Comment</option>
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
            <!--end::Hero Actions-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Hero Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="hero-preview p-10" style="
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                color: white;
                                border-radius: 10px;
                            ">
                                <div class="badge-preview mb-4">
                                    <span style="
                                        background: rgba(255,255,255,0.2);
                                        color: white;
                                        padding: 8px 16px;
                                        border-radius: 20px;
                                        font-size: 0.9rem;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                    ">
                                        <i class="fas fa-code"></i> Divisi Software House
                                    </span>
                                </div>
                                
                                <h1 class="mb-4" style="color: white; font-size: 2.5rem;">Ravaa Creative Tech</h1>
                                
                                <p class="mb-6" style="color: rgba(255,255,255,0.9); max-width: 800px;">
                                    Kami adalah divisi Software House dari Ravaa Creative yang khusus mengembangkan website, aplikasi mobile, dan solusi digital custom untuk bisnis Anda. Tim developer berpengalaman kami siap mewujudkan ide digital Anda.
                                </p>
                                
                                <div class="d-flex flex-wrap gap-3">
                                    <button class="btn" style="
                                        background: white;
                                        color: #667eea;
                                        border: none;
                                        padding: 12px 24px;
                                        border-radius: 5px;
                                        font-weight: 600;
                                    ">Lihat Paket Website</button>
                                    
                                    <button class="btn btn-outline" style="
                                        background: transparent;
                                        color: white;
                                        border: 2px solid white;
                                        padding: 10px 22px;
                                        border-radius: 5px;
                                        font-weight: 600;
                                    ">Portfolio Tech</button>
                                    
                                    <button class="btn btn-light" style="
                                        background: rgba(255,255,255,0.2);
                                        color: white;
                                        border: none;
                                        padding: 12px 24px;
                                        border-radius: 5px;
                                        font-weight: 600;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                    ">
                                        <i class="fab fa-whatsapp"></i> Konsultasi Gratis
                                    </button>
                                </div>
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan Hero Section di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetHero()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveHero()">
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
    function saveHero() {
        const form = document.getElementById('heroForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Hero Section berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetHero() {
        Swal.fire({
            title: "Reset Hero Section?",
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
        const badgeText = document.querySelector('input[name="badge_text"]');
        const badgeIcon = document.querySelector('select[name="badge_icon"]');
        const title = document.querySelector('input[name="title"]');
        const description = document.querySelector('textarea[name="description"]');
        const button1Text = document.querySelector('input[name="button1_text"]');
        const button2Text = document.querySelector('input[name="button2_text"]');
        const button3Text = document.querySelector('input[name="button3_text"]');
        const button3Icon = document.querySelector('select[name="button3_icon"]');
        
        const previewSection = document.querySelector('.hero-preview');
        const previewBadge = previewSection.querySelector('.badge-preview span');
        const previewBadgeIcon = previewBadge.querySelector('i');
        const previewTitle = previewSection.querySelector('h1');
        const previewDescription = previewSection.querySelector('p');
        const previewButton1 = previewSection.querySelector('.btn:not(.btn-outline):not(.btn-light)');
        const previewButton2 = previewSection.querySelector('.btn.btn-outline');
        const previewButton3 = previewSection.querySelector('.btn.btn-light');
        const previewButton3Icon = previewButton3.querySelector('i');
        
        function updatePreview() {
            if (badgeText.value) {
                previewBadge.innerHTML = `<i class="${badgeIcon.value}"></i> ${badgeText.value}`;
            }
            if (title.value) previewTitle.textContent = title.value;
            if (description.value) previewDescription.textContent = description.value;
            if (button1Text.value) previewButton1.textContent = button1Text.value;
            if (button2Text.value) previewButton2.textContent = button2Text.value;
            if (button3Text.value) {
                previewButton3.innerHTML = `<i class="${button3Icon.value}"></i> ${button3Text.value}`;
            }
        }
        
        // Add event listeners
        [badgeText, badgeIcon, title, description, button1Text, button2Text, button3Text, button3Icon].forEach(input => {
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