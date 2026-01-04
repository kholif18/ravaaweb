@extends('admin.layouts.app')

@section('page-title', 'Service Content')
@section('page-description', 'Kelola Konten Detail — Ravaa Creative')

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
            Layanan Page
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Service Content
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Konten Detail Semua Layanan</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light-primary" onclick="toggleAllSections()">
                    <i class="bi bi-arrows-collapse me-2"></i> Buka/Tutup Semua
                </button>
                <button type="button" class="btn btn-primary" onclick="saveAllServices()">
                    <i class="bi bi-save fs-2"></i> Simpan Semua
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
                <h4 class="mb-1 text-info">Informasi Konten Layanan</h4>
                <span>Kelola konten detail untuk semua kategori layanan. Konten ini akan muncul saat pengunjung mengklik tab kategori.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Accordion-->
        <div class="accordion" id="serviceAccordion">
            
            <!-- ==================== LAYANAN 1: DESAIN GRAFIS ==================== -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDesign">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDesign" aria-expanded="true" aria-controls="collapseDesign">
                        <i class="bi bi-paint-brush me-3"></i>
                        Desain Grafis Profesional
                        <span class="badge badge-light-primary ms-2">Aktif</span>
                    </button>
                </h2>
                <div id="collapseDesign" class="accordion-collapse collapse show" aria-labelledby="headingDesign" data-bs-parent="#serviceAccordion">
                    <div class="accordion-body">
                        <form class="service-form" data-service="design">
                            @csrf
                            <input type="hidden" name="service_id" value="design">
                            
                            <!--begin::Header Section-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul Layanan</label>
                                        <input type="text" class="form-control" 
                                               name="title" 
                                               value="Desain Grafis Profesional"
                                               required />
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label required">Sub-judul</label>
                                        <input type="text" class="form-control" 
                                               name="subtitle" 
                                               value="Mewujudkan ide kreatif Anda menjadi desain visual yang menarik"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Icon Layanan</label>
                                        <select class="form-select" name="icon" data-control="select2">
                                            <option value="bi-paint-brush" selected>Paint Brush</option>
                                            <option value="bi-palette">Palette</option>
                                            <option value="bi-brush">Brush</option>
                                            <option value="bi-pencil">Pencil</option>
                                            <option value="bi-easel">Easel</option>
                                            <option value="bi-images">Images</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label">Status Tampilan</label>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="design_active" checked />
                                            <label class="form-check-label" for="design_active">
                                                Tampilkan layanan ini di halaman
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header Section-->
                            
                            <!--begin::Description-->
                            <div class="mb-15">
                                <label class="form-label required">Deskripsi Layanan</label>
                                <textarea class="form-control" name="description" rows="4" required>Layanan desain grafis profesional kami mencakup pembuatan logo, branding, brosur, banner, dan materi promosi lainnya. Tim desainer berpengalaman kami siap membantu mengkomunikasikan pesan bisnis Anda melalui desain visual yang menarik dan efektif.</textarea>
                            </div>
                            <!--end::Description-->
                            
                            <!--begin::CTA Buttons-->
                            <div class="row mb-15">
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-header">
                                            <h4 class="card-title">Tombol Call-to-Action 1</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta1_text" 
                                                       value="Konsultasi Gratis"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Link Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta1_link" 
                                                       value="#"
                                                       placeholder="https://wa.me/6281234567890 atau /kontak" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Warna Tombol</label>
                                                <select class="form-select" name="cta1_color">
                                                    <option value="primary" selected>Primary (Biru)</option>
                                                    <option value="success">Success (Hijau)</option>
                                                    <option value="warning">Warning (Kuning)</option>
                                                    <option value="danger">Danger (Merah)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-header">
                                            <h4 class="card-title">Tombol Call-to-Action 2</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta2_text" 
                                                       value="Lihat Portfolio"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Link Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta2_link" 
                                                       value="{{ url('/portofolio') }}"
                                                       placeholder="/portofolio" />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Warna Tombol</label>
                                                <select class="form-select" name="cta2_color">
                                                    <option value="outline-primary" selected>Outline Primary</option>
                                                    <option value="outline-success">Outline Success</option>
                                                    <option value="outline-warning">Outline Warning</option>
                                                    <option value="outline-danger">Outline Danger</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::CTA Buttons-->
                            
                            <!--begin::Service Features-->
                            <div class="mb-15">
                                <label class="form-label required">Fitur Layanan (3 fitur utama)</label>
                                <div class="row g-5">
                                    <!-- Fitur 1 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-primary">
                                                <h4 class="card-title">Fitur 1</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[1][icon]" data-control="select2">
                                                        <option value="bi-bullseye" selected>Bullseye (Target)</option>
                                                        <option value="bi-palette">Palette</option>
                                                        <option value="bi-brush">Brush</option>
                                                        <option value="bi-pencil">Pencil</option>
                                                        <option value="bi-pen">Pen</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[1][title]" 
                                                           value="Desain Logo & Branding"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[1][description]" rows="3" required>Pembuatan logo, identitas visual, dan panduan branding untuk membangun citra perusahaan yang kuat dan konsisten.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 2 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-success">
                                                <h4 class="card-title">Fitur 2</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[2][icon]" data-control="select2">
                                                        <option value="bi-newspaper" selected>Newspaper</option>
                                                        <option value="bi-file-earmark-text">File Text</option>
                                                        <option value="bi-card-text">Card Text</option>
                                                        <option value="bi-megaphone">Megaphone</option>
                                                        <option value="bi-bullhorn">Bullhorn</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[2][title]" 
                                                           value="Materi Promosi"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[2][description]" rows="3" required>Desain brosur, flyer, banner, katalog, dan materi promosi cetak maupun digital lainnya untuk kampanye pemasaran.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 3 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-warning">
                                                <h4 class="card-title">Fitur 3</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[3][icon]" data-control="select2">
                                                        <option value="bi-desktop" selected>Desktop</option>
                                                        <option value="bi-laptop">Laptop</option>
                                                        <option value="bi-phone">Phone</option>
                                                        <option value="bi-tablet">Tablet</option>
                                                        <option value="bi-display">Display</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[3][title]" 
                                                           value="Digital & UI/UX Design"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[3][description]" rows="3" required>Desain website, aplikasi mobile, user interface, dan pengalaman pengguna untuk platform digital.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Service Features-->
                            
                            <!--begin::Packages Section-->
                            <div class="mb-15">
                                <div class="d-flex justify-content-between align-items-center mb-10">
                                    <h4 class="text-gray-800">Paket Layanan Desain</h4>
                                    <button type="button" class="btn btn-sm btn-light-primary" onclick="addPackage('design')">
                                        <i class="bi bi-plus-circle me-2"></i> Tambah Paket
                                    </button>
                                </div>
                                
                                <div class="row" id="design-packages-container">
                                    <!-- Paket Dasar -->
                                    <div class="col-md-4 mb-5">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header">
                                                <h4 class="card-title">Paket Dasar</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Nama Paket</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[1][name]" 
                                                           value="Paket Dasar"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Harga</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[1][price]" 
                                                           value="Rp 499K"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Periode/Deskripsi</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[1][period]" 
                                                           value="Proyek sederhana" />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Fitur (satu per baris)</label>
                                                    <textarea class="form-control" name="packages[1][features]" rows="5">1 konsep desain
3 revisi minor
File final (JPG, PNG)
- File sumber (AI/PSD)
- Panduan branding</textarea>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Text Tombol</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[1][button_text]" 
                                                           value="Pilih Paket" />
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid mb-5">
                                                    <input class="form-check-input" type="checkbox" name="packages[1][popular]" value="1" id="package1_popular" />
                                                    <label class="form-check-label" for="package1_popular">
                                                        Tandai sebagai Popular
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Paket Profesional -->
                                    <div class="col-md-4 mb-5">
                                        <div class="card card-bordered card-primary h-100">
                                            <div class="card-header bg-primary text-white">
                                                <h4 class="card-title text-white">Paket Profesional</h4>
                                                <span class="badge badge-light mt-2">POPULAR</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Nama Paket</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[2][name]" 
                                                           value="Paket Profesional"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Harga</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[2][price]" 
                                                           value="Rp 1.299K"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Periode/Deskripsi</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[2][period]" 
                                                           value="Proyek komprehensif" />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Fitur</label>
                                                    <textarea class="form-control" name="packages[2][features]" rows="5">3 konsep desain
Revisi tanpa batas
File final semua format
File sumber (AI/PSD)
Panduan branding lengkap</textarea>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Text Tombol</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[2][button_text]" 
                                                           value="Pilih Paket" />
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid mb-5">
                                                    <input class="form-check-input" type="checkbox" name="packages[2][popular]" value="1" id="package2_popular" checked />
                                                    <label class="form-check-label" for="package2_popular">
                                                        Tandai sebagai Popular
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Paket Perusahaan -->
                                    <div class="col-md-4 mb-5">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header">
                                                <h4 class="card-title">Paket Perusahaan</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Nama Paket</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[3][name]" 
                                                           value="Paket Perusahaan"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Harga</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[3][price]" 
                                                           value="Rp 3.999K"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Periode/Deskripsi</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[3][period]" 
                                                           value="Paket bulanan" />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Fitur</label>
                                                    <textarea class="form-control" name="packages[3][features]" rows="5">Unlimited desain proyek
Prioritas pengerjaan
Konsultasi branding
Support 24/7
Revisi tanpa batas</textarea>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label">Text Tombol</label>
                                                    <input type="text" class="form-control" 
                                                           name="packages[3][button_text]" 
                                                           value="Pilih Paket" />
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid mb-5">
                                                    <input class="form-check-input" type="checkbox" name="packages[3][popular]" value="1" id="package3_popular" />
                                                    <label class="form-check-label" for="package3_popular">
                                                        Tandai sebagai Popular
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Packages Section-->
                            
                            <!--begin::Form Actions-->
                            <div class="d-flex justify-content-between border-top pt-10 mt-10">
                                <button type="button" class="btn btn-light" onclick="resetService('design')">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-light me-3" onclick="previewService('design')">
                                        <i class="bi bi-eye me-2"></i> Preview
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="saveService('design')">
                                        <i class="bi bi-check-circle me-2"></i> Simpan Layanan Desain
                                    </button>
                                </div>
                            </div>
                            <!--end::Form Actions-->
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== END LAYANAN 1 ==================== -->
            
            <!-- ==================== LAYANAN 2: PERCETAKAN ==================== -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPrinting">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrinting" aria-expanded="false" aria-controls="collapsePrinting">
                        <i class="bi bi-printer me-3"></i>
                        Layanan Percetakan
                        <span class="badge badge-light-primary ms-2">Aktif</span>
                    </button>
                </h2>
                <div id="collapsePrinting" class="accordion-collapse collapse" aria-labelledby="headingPrinting" data-bs-parent="#serviceAccordion">
                    <div class="accordion-body">
                        <form class="service-form" data-service="printing">
                            @csrf
                            <input type="hidden" name="service_id" value="printing">
                            
                            <!--begin::Header Section-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul Layanan</label>
                                        <input type="text" class="form-control" 
                                               name="title" 
                                               value="Layanan Percetakan"
                                               required />
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label required">Sub-judul</label>
                                        <input type="text" class="form-control" 
                                               name="subtitle" 
                                               value="Cetak berkualitas tinggi untuk segala kebutuhan bisnis Anda"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Icon Layanan</label>
                                        <select class="form-select" name="icon" data-control="select2">
                                            <option value="bi-printer" selected>Printer</option>
                                            <option value="bi-printer-fill">Printer Fill</option>
                                            <option value="bi-file-earmark-text">File Text</option>
                                            <option value="bi-newspaper">Newspaper</option>
                                            <option value="bi-file-earmark-pdf">PDF File</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label">Status Tampilan</label>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="printing_active" checked />
                                            <label class="form-check-label" for="printing_active">
                                                Tampilkan layanan ini di halaman
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header Section-->
                            
                            <!--begin::Description-->
                            <div class="mb-15">
                                <label class="form-label required">Deskripsi Layanan</label>
                                <textarea class="form-control" name="description" rows="4" required>Layanan percetakan kami mencakup cetak offset dan digital untuk berbagai media dan ukuran. Dengan peralatan modern dan tenaga ahli, kami menjamin hasil cetak yang tajam, warna akurat, dan ketahanan yang optimal untuk semua produk cetakan Anda.</textarea>
                            </div>
                            <!--end::Description-->
                            
                            <!--begin::CTA Buttons-->
                            <div class="row mb-15">
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-header">
                                            <h4 class="card-title">Tombol Call-to-Action 1</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta1_text" 
                                                       value="Request Quotation"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Link Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta1_link" 
                                                       value="#"
                                                       placeholder="Link untuk request quotation" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-header">
                                            <h4 class="card-title">Tombol Call-to-Action 2</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta2_text" 
                                                       value="Lihat Katalog"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Link Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta2_link" 
                                                       value="#"
                                                       placeholder="Link ke katalog percetakan" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::CTA Buttons-->
                            
                            <!--begin::Service Features-->
                            <div class="mb-15">
                                <label class="form-label required">Fitur Layanan (3 fitur utama)</label>
                                <div class="row g-5">
                                    <!-- Fitur 1 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-primary">
                                                <h4 class="card-title">Fitur 1</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[1][icon]" data-control="select2">
                                                        <option value="bi-scroll" selected>Scroll</option>
                                                        <option value="bi-newspaper">Newspaper</option>
                                                        <option value="bi-file-earmark-text">File Text</option>
                                                        <option value="bi-journal-text">Journal Text</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[1][title]" 
                                                           value="Cetak Offset"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[1][description]" rows="3" required>Cetak berkualitas tinggi untuk kebutuhan dalam jumlah besar seperti brosur, buku, katalog, dan kemasan produk.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 2 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-success">
                                                <h4 class="card-title">Fitur 2</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[2][icon]" data-control="select2">
                                                        <option value="bi-printer" selected>Printer</option>
                                                        <option value="bi-printer-fill">Printer Fill</option>
                                                        <option value="bi-printer-fill">Printer Fill</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[2][title]" 
                                                           value="Digital Printing"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[2][description]" rows="3" required>Cetak cepat dengan kualitas tinggi untuk kebutuhan dalam jumlah kecil hingga menengah dengan fleksibilitas waktu.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 3 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-warning">
                                                <h4 class="card-title">Fitur 3</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[3][icon]" data-control="select2">
                                                        <option value="bi-cut" selected>Cut (Scissors)</option>
                                                        <option value="bi-scissors">Scissors</option>
                                                        <option value="bi-box">Box</option>
                                                        <option value="bi-gift">Gift</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[3][title]" 
                                                           value="Finishing & Packaging"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[3][description]" rows="3" required>Layanan finishing seperti laminating, spot UV, emboss, dan packaging yang memperindah hasil cetakan.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Service Features-->
                            
                            <!--begin::Form Actions-->
                            <div class="d-flex justify-content-between border-top pt-10 mt-10">
                                <button type="button" class="btn btn-light" onclick="resetService('printing')">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-light me-3" onclick="previewService('printing')">
                                        <i class="bi bi-eye me-2"></i> Preview
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="saveService('printing')">
                                        <i class="bi bi-check-circle me-2"></i> Simpan Layanan Percetakan
                                    </button>
                                </div>
                            </div>
                            <!--end::Form Actions-->
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== END LAYANAN 2 ==================== -->
            
            <!-- ==================== LAYANAN 3: ATK ==================== -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAtk">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAtk" aria-expanded="false" aria-controls="collapseAtk">
                        <i class="bi bi-pen-fancy me-3"></i>
                        ATK & Perlengkapan Kantor
                        <span class="badge badge-light-primary ms-2">Aktif</span>
                    </button>
                </h2>
                <div id="collapseAtk" class="accordion-collapse collapse" aria-labelledby="headingAtk" data-bs-parent="#serviceAccordion">
                    <div class="accordion-body">
                        <form class="service-form" data-service="atk">
                            @csrf
                            <input type="hidden" name="service_id" value="atk">
                            
                            <!--begin::Header Section-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul Layanan</label>
                                        <input type="text" class="form-control" 
                                               name="title" 
                                               value="ATK & Perlengkapan Kantor"
                                               required />
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label required">Sub-judul</label>
                                        <input type="text" class="form-control" 
                                               name="subtitle" 
                                               value="Kebutuhan alat tulis kantor lengkap dengan harga kompetitif"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Icon Layanan</label>
                                        <select class="form-select" name="icon" data-control="select2">
                                            <option value="bi-pen-fancy" selected>Pen Fancy</option>
                                            <option value="bi-pen">Pen</option>
                                            <option value="bi-pencil">Pencil</option>
                                            <option value="bi-pencil-fill">Pencil Fill</option>
                                            <option value="bi-ruler">Ruler</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label">Status Tampilan</label>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="atk_active" checked />
                                            <label class="form-check-label" for="atk_active">
                                                Tampilkan layanan ini di halaman
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header Section-->
                            
                            <!--begin::Description-->
                            <div class="mb-15">
                                <label class="form-label required">Deskripsi Layanan</label>
                                <textarea class="form-control" name="description" rows="4" required>Menyediakan berbagai kebutuhan alat tulis kantor (ATK) dan perlengkapan kantor lainnya dengan kualitas terjamin. Kami juga menerima pesanan custom dengan logo perusahaan untuk kebutuhan branding internal dan eksternal.</textarea>
                            </div>
                            <!--end::Description-->
                            
                            <!--begin::CTA Buttons-->
                            <div class="row mb-15">
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-header">
                                            <h4 class="card-title">Tombol Call-to-Action 1</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta1_text" 
                                                       value="Lihat Katalog ATK"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Link Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta1_link" 
                                                       value="#"
                                                       placeholder="Link ke katalog ATK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-header">
                                            <h4 class="card-title">Tombol Call-to-Action 2</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label">Teks Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta2_text" 
                                                       value="Request Quotation"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label">Link Tombol</label>
                                                <input type="text" class="form-control" 
                                                       name="cta2_link" 
                                                       value="#"
                                                       placeholder="Link untuk request quotation" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::CTA Buttons-->
                            
                            <!--begin::Service Features-->
                            <div class="mb-15">
                                <label class="form-label required">Fitur Layanan (3 fitur utama)</label>
                                <div class="row g-5">
                                    <!-- Fitur 1 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-primary">
                                                <h4 class="card-title">Fitur 1</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[1][icon]" data-control="select2">
                                                        <option value="bi-pen" selected>Pen</option>
                                                        <option value="bi-pencil">Pencil</option>
                                                        <option value="bi-pencil-fill">Pencil Fill</option>
                                                        <option value="bi-ruler">Ruler</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[1][title]" 
                                                           value="Alat Tulis Standar"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[1][description]" rows="3" required>Berbagai alat tulis kantor seperti pulpen, pensil, penggaris, penghapus, dan perlengkapan menulis lainnya.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 2 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-success">
                                                <h4 class="card-title">Fitur 2</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[2][icon]" data-control="select2">
                                                        <option value="bi-printer" selected>Printer</option>
                                                        <option value="bi-printer-fill">Printer Fill</option>
                                                        <option value="bi-cart">Cart</option>
                                                        <option value="bi-cart-fill">Cart Fill</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[2][title]" 
                                                           value="Perlengkapan Cetak"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[2][description]" rows="3" required>Kertas, tinta printer, toner, dan consumables lainnya untuk mendukung operasional kantor.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 3 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-warning">
                                                <h4 class="card-title">Fitur 3</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[3][icon]" data-control="select2">
                                                        <option value="bi-box" selected>Box</option>
                                                        <option value="bi-box-seam">Box Seam</option>
                                                        <option value="bi-gift">Gift</option>
                                                        <option value="bi-tags">Tags</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[3][title]" 
                                                           value="ATK Custom"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[3][description]" rows="3" required>Pembuatan alat tulis kantor custom dengan logo perusahaan untuk kebutuhan branding dan promosi.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Service Features-->
                            
                            <!--begin::Form Actions-->
                            <div class="d-flex justify-content-between border-top pt-10 mt-10">
                                <button type="button" class="btn btn-light" onclick="resetService('atk')">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-light me-3" onclick="previewService('atk')">
                                        <i class="bi bi-eye me-2"></i> Preview
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="saveService('atk')">
                                        <i class="bi bi-check-circle me-2"></i> Simpan Layanan ATK
                                    </button>
                                </div>
                            </div>
                            <!--end::Form Actions-->
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== END LAYANAN 3 ==================== -->
            
            <!-- ==================== LAYANAN 4: MERCHANDISE ==================== -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingMerchandise">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMerchandise" aria-expanded="false" aria-controls="collapseMerchandise">
                        <i class="bi bi-tshirt me-3"></i>
                        Sablon & Merchandise
                        <span class="badge badge-light-primary ms-2">Aktif</span>
                    </button>
                </h2>
                <div id="collapseMerchandise" class="accordion-collapse collapse" aria-labelledby="headingMerchandise" data-bs-parent="#serviceAccordion">
                    <div class="accordion-body">
                        <form class="service-form" data-service="merchandise">
                            @csrf
                            <input type="hidden" name="service_id" value="merchandise">
                            
                            <!--begin::Header Section-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul Layanan</label>
                                        <input type="text" class="form-control" 
                                               name="title" 
                                               value="Sablon & Merchandise"
                                               required />
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label required">Sub-judul</label>
                                        <input type="text" class="form-control" 
                                               name="subtitle" 
                                               value="Produk merchandise custom untuk branding dan promosi perusahaan"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Icon Layanan</label>
                                        <select class="form-select" name="icon" data-control="select2">
                                            <option value="bi-tshirt" selected>T-Shirt</option>
                                            <option value="bi-cup-straw">Cup Straw</option>
                                            <option value="bi-cup">Cup</option>
                                            <option value="bi-bag">Bag</option>
                                            <option value="bi-gift">Gift</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label">Status Tampilan</label>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="merchandise_active" checked />
                                            <label class="form-check-label" for="merchandise_active">
                                                Tampilkan layanan ini di halaman
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header Section-->
                            
                            <!--begin::Description-->
                            <div class="mb-15">
                                <label class="form-label required">Deskripsi Layanan</label>
                                <textarea class="form-control" name="description" rows="4" required>Layanan pembuatan merchandise custom seperti kaos, topi, mug, tumbler, tas, dan berbagai produk promosi lainnya dengan desain sesuai kebutuhan branding perusahaan Anda. Kami menggunakan teknik sablon dan printing terbaik untuk hasil yang tahan lama dan menarik.</textarea>
                            </div>
                            <!--end::Description-->
                            
                            <!--begin::Service Features-->
                            <div class="mb-15">
                                <label class="form-label required">Fitur Layanan (3 fitur utama)</label>
                                <div class="row g-5">
                                    <!-- Fitur 1 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-primary">
                                                <h4 class="card-title">Fitur 1</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[1][icon]" data-control="select2">
                                                        <option value="bi-tshirt" selected>T-Shirt</option>
                                                        <option value="bi-person">Person</option>
                                                        <option value="bi-person-badge">Person Badge</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[1][title]" 
                                                           value="Sablon Kaos & Pakaian"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[1][description]" rows="3" required>Sablon kaos, kemeja, jaket, dan pakaian lainnya dengan berbagai teknik untuk hasil terbaik.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 2 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-success">
                                                <h4 class="card-title">Fitur 2</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[2][icon]" data-control="select2">
                                                        <option value="bi-mug-hot" selected>Mug Hot</option>
                                                        <option value="bi-cup">Cup</option>
                                                        <option value="bi-cup-straw">Cup Straw</option>
                                                        <option value="bi-gift">Gift</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[2][title]" 
                                                           value="Merchandise Promosi"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[2][description]" rows="3" required>Pembuatan mug, tumbler, gantungan kunci, tas, dan merchandise promosi lainnya.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 3 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-warning">
                                                <h4 class="card-title">Fitur 3</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[3][icon]" data-control="select2">
                                                        <option value="bi-gift" selected>Gift</option>
                                                        <option value="bi-box">Box</option>
                                                        <option value="bi-box-seam">Box Seam</option>
                                                        <option value="bi-suit-heart">Suit Heart</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[3][title]" 
                                                           value="Corporate Gift"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[3][description]" rows="3" required>Paket corporate gift custom untuk klien, karyawan, atau acara perusahaan dengan packaging eksklusif.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Service Features-->
                            
                            <!--begin::Form Actions-->
                            <div class="d-flex justify-content-between border-top pt-10 mt-10">
                                <button type="button" class="btn btn-light" onclick="resetService('merchandise')">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-light me-3" onclick="previewService('merchandise')">
                                        <i class="bi bi-eye me-2"></i> Preview
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="saveService('merchandise')">
                                        <i class="bi bi-check-circle me-2"></i> Simpan Layanan Merchandise
                                    </button>
                                </div>
                            </div>
                            <!--end::Form Actions-->
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== END LAYANAN 4 ==================== -->
            
            <!-- ==================== LAYANAN 5: DIGITAL PRINTING ==================== -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDigital">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDigital" aria-expanded="false" aria-controls="collapseDigital">
                        <i class="bi bi-laptop-code me-3"></i>
                        Digital Printing Khusus
                        <span class="badge badge-light-primary ms-2">Aktif</span>
                    </button>
                </h2>
                <div id="collapseDigital" class="accordion-collapse collapse" aria-labelledby="headingDigital" data-bs-parent="#serviceAccordion">
                    <div class="accordion-body">
                        <form class="service-form" data-service="digital">
                            @csrf
                            <input type="hidden" name="service_id" value="digital">
                            
                            <!--begin::Header Section-->
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Judul Layanan</label>
                                        <input type="text" class="form-control" 
                                               name="title" 
                                               value="Digital Printing Khusus"
                                               required />
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label required">Sub-judul</label>
                                        <input type="text" class="form-control" 
                                               name="subtitle" 
                                               value="Solusi printing digital untuk kebutuhan khusus dan material unik"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Icon Layanan</label>
                                        <select class="form-select" name="icon" data-control="select2">
                                            <option value="bi-laptop-code" selected>Laptop Code</option>
                                            <option value="bi-printer">Printer</option>
                                            <option value="bi-code-slash">Code Slash</option>
                                            <option value="bi-display">Display</option>
                                            <option value="bi-tablet">Tablet</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <label class="form-label">Status Tampilan</label>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" id="digital_active" checked />
                                            <label class="form-check-label" for="digital_active">
                                                Tampilkan layanan ini di halaman
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header Section-->
                            
                            <!--begin::Description-->
                            <div class="mb-15">
                                <label class="form-label required">Deskripsi Layanan</label>
                                <textarea class="form-control" name="description" rows="4" required>Layanan digital printing khusus untuk media dan material unik seperti stiker vinyl, banner flexi, spanduk, backdrop, sticker cutting, dan printing pada berbagai media non-kertas. Cocok untuk kebutuhan indoor dan outdoor dengan ketahanan yang disesuaikan.</textarea>
                            </div>
                            <!--end::Description-->
                            
                            <!--begin::Service Features-->
                            <div class="mb-15">
                                <label class="form-label required">Fitur Layanan (3 fitur utama)</label>
                                <div class="row g-5">
                                    <!-- Fitur 1 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-primary">
                                                <h4 class="card-title">Fitur 1</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[1][icon]" data-control="select2">
                                                        <option value="bi-sticky-note" selected>Sticky Note</option>
                                                        <option value="bi-tag">Tag</option>
                                                        <option value="bi-tag-fill">Tag Fill</option>
                                                        <option value="bi-stickies">Stickies</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[1][title]" 
                                                           value="Sticker & Label"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[1][description]" rows="3" required>Cetak stiker vinyl, hologram, label produk, dan sticker cutting untuk berbagai kebutuhan.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 2 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-success">
                                                <h4 class="card-title">Fitur 2</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[2][icon]" data-control="select2">
                                                        <option value="bi-flag" selected>Flag</option>
                                                        <option value="bi-flag-fill">Flag Fill</option>
                                                        <option value="bi-signpost">Signpost</option>
                                                        <option value="bi-signpost-2">Signpost 2</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[2][title]" 
                                                           value="Banner & Spanduk"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[2][description]" rows="3" required>Cetak banner flexi, spanduk, backdrop, dan media promosi outdoor dengan kualitas tahan cuaca.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fitur 3 -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-header bg-light-warning">
                                                <h4 class="card-title">Fitur 3</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-5">
                                                    <label class="form-label required">Icon</label>
                                                    <select class="form-select" name="features[3][icon]" data-control="select2">
                                                        <option value="bi-id-card" selected>ID Card</option>
                                                        <option value="bi-card-heading">Card Heading</option>
                                                        <option value="bi-card-text">Card Text</option>
                                                        <option value="bi-award">Award</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Judul Fitur</label>
                                                    <input type="text" class="form-control" 
                                                           name="features[3][title]" 
                                                           value="Printing Khusus"
                                                           required />
                                                </div>
                                                <div class="mb-5">
                                                    <label class="form-label required">Deskripsi</label>
                                                    <textarea class="form-control" name="features[3][description]" rows="3" required>Printing pada akrilik, kayu, kain, logam, dan media unik lainnya untuk kebutuhan khusus.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Service Features-->
                            
                            <!--begin::Form Actions-->
                            <div class="d-flex justify-content-between border-top pt-10 mt-10">
                                <button type="button" class="btn btn-light" onclick="resetService('digital')">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-light me-3" onclick="previewService('digital')">
                                        <i class="bi bi-eye me-2"></i> Preview
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="saveService('digital')">
                                        <i class="bi bi-check-circle me-2"></i> Simpan Layanan Digital
                                    </button>
                                </div>
                            </div>
                            <!--end::Form Actions-->
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== END LAYANAN 5 ==================== -->
            
        </div>
        <!--end::Accordion-->
        
    </div>
    <!--end::Card body-->
    
    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-between py-6 px-9">
        <div class="text-muted">
            <span id="activeServicesCount">5</span> dari 5 layanan aktif
        </div>
        <div>
            <button type="button" class="btn btn-light me-3" onclick="resetAllServices()">
                <i class="bi bi-arrow-clockwise me-2"></i> Reset Semua
            </button>
            <button type="button" class="btn btn-primary" onclick="saveAllServices()">
                <i class="bi bi-save me-2"></i> Simpan Semua Layanan
            </button>
        </div>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->
@endsection

@push('scripts')
<script>
    // Initialize Select2
    $(document).ready(function() {
        $('[data-control="select2"]').select2({
            minimumResultsForSearch: 5
        });
    });
    
    // Toggle all accordion sections
    function toggleAllSections() {
        const accordionButtons = document.querySelectorAll('.accordion-button');
        const allExpanded = Array.from(accordionButtons).every(button => 
            button.getAttribute('aria-expanded') === 'true'
        );
        
        accordionButtons.forEach(button => {
            if (allExpanded) {
                if (!button.classList.contains('collapsed')) {
                    button.click();
                }
            } else {
                if (button.classList.contains('collapsed')) {
                    button.click();
                }
            }
        });
    }
    
    // Reset individual service
    function resetService(serviceId) {
        Swal.fire({
            title: `Reset Layanan ${serviceId.toUpperCase()}?`,
            text: "Semua perubahan pada layanan ini akan dikembalikan ke nilai default.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Reset",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.querySelector(`form[data-service="${serviceId}"]`);
                form.reset();
                
                // Reset select2
                form.querySelectorAll('[data-control="select2"]').forEach(select => {
                    $(select).val(null).trigger('change');
                });
                
                Swal.fire({
                    text: `Layanan ${serviceId} berhasil direset!`,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
    
    // Reset all services
    function resetAllServices() {
        Swal.fire({
            title: "Reset Semua Layanan?",
            text: "Semua perubahan pada semua layanan akan dikembalikan ke nilai default.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Reset Semua",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelectorAll('.service-form').forEach(form => {
                    form.reset();
                    form.querySelectorAll('[data-control="select2"]').forEach(select => {
                        $(select).val(null).trigger('change');
                    });
                });
                
                Swal.fire({
                    text: "Semua layanan berhasil direset!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
    
    // Preview service
    function previewService(serviceId) {
        // In real app, show preview modal or new tab
        Swal.fire({
            title: "Preview Layanan",
            text: `Fitur preview untuk layanan ${serviceId} akan ditampilkan di jendela baru.`,
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Buka Preview",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Open new tab with preview
                window.open(`/preview/service/${serviceId}`, '_blank');
            }
        });
    }
    
    // Save individual service
    function saveService(serviceId) {
        const form = document.querySelector(`form[data-service="${serviceId}"]`);
        const formData = new FormData(form);
        const serviceName = form.querySelector('input[name="title"]').value || serviceId;
        
        // Validate required fields
        let isValid = true;
        form.querySelectorAll('[required]').forEach(element => {
            if (!element.value.trim()) {
                isValid = false;
                element.focus();
                element.classList.add('is-invalid');
            } else {
                element.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            Swal.fire({
                text: "Harap isi semua field yang wajib diisi!",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return;
        }
        
        // Show loading
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        button.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            
            Swal.fire({
                title: "Berhasil!",
                text: `Layanan "${serviceName}" berhasil disimpan.`,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    // Save all services
    function saveAllServices() {
        Swal.fire({
            title: "Simpan Semua Layanan?",
            text: "Semua perubahan pada semua layanan akan disimpan.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Simpan Semua",
            cancelButtonText: "Batal",
            showDenyButton: true,
            denyButtonText: "Validasi Dulu",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light",
                denyButton: "btn btn-warning"
            }
        }).then((result) => {
            if (result.isDenied) {
                // Validate all forms
                let allValid = true;
                let invalidForms = [];
                
                document.querySelectorAll('.service-form').forEach(form => {
                    const serviceId = form.dataset.service;
                    let formValid = true;
                    
                    form.querySelectorAll('[required]').forEach(element => {
                        if (!element.value.trim()) {
                            formValid = false;
                            element.classList.add('is-invalid');
                        }
                    });
                    
                    if (!formValid) {
                        allValid = false;
                        invalidForms.push(serviceId);
                    }
                });
                
                if (!allValid) {
                    Swal.fire({
                        title: "Validasi Gagal",
                        html: `Layanan berikut masih ada field yang kosong: <strong>${invalidForms.join(', ')}</strong>`,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Semua data valid! Klik 'Ya, Simpan Semua' untuk menyimpan.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
                
            } else if (result.isConfirmed) {
                // Show loading
                const saveButton = document.querySelector('.btn-primary[onclick="saveAllServices()"]');
                const originalText = saveButton.innerHTML;
                saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                saveButton.disabled = true;
                
                // Simulate saving all forms
                setTimeout(() => {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                    
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Semua layanan berhasil disimpan.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }, 2000);
            }
        });
    }
    
    // Add package (dynamic)
    function addPackage(serviceId) {
        const container = document.getElementById(`${serviceId}-packages-container`);
        const packageCount = container.children.length + 1;
        
        const packageHTML = `
            <div class="col-md-4 mb-5" id="package-${serviceId}-${packageCount}">
                <div class="card card-bordered h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Paket ${packageCount}</h4>
                        <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removePackage('${serviceId}', ${packageCount})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label required">Nama Paket</label>
                            <input type="text" class="form-control" 
                                   name="packages[${packageCount}][name]" 
                                   value="Paket ${packageCount}"
                                   required />
                        </div>
                        <div class="mb-5">
                            <label class="form-label required">Harga</label>
                            <input type="text" class="form-control" 
                                   name="packages[${packageCount}][price]" 
                                   value="Rp 0"
                                   required />
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Periode/Deskripsi</label>
                            <input type="text" class="form-control" 
                                   name="packages[${packageCount}][period]" 
                                   value="" />
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Fitur (satu per baris)</label>
                            <textarea class="form-control" name="packages[${packageCount}][features]" rows="5"></textarea>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Text Tombol</label>
                            <input type="text" class="form-control" 
                                   name="packages[${packageCount}][button_text]" 
                                   value="Pilih Paket" />
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input" type="checkbox" name="packages[${packageCount}][popular]" value="1" id="package${packageCount}_popular" />
                            <label class="form-check-label" for="package${packageCount}_popular">
                                Tandai sebagai Popular
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', packageHTML);
        
        Swal.fire({
            text: "Paket baru berhasil ditambahkan!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    }
    
    // Remove package
    function removePackage(serviceId, packageId) {
        Swal.fire({
            title: "Hapus Paket?",
            text: "Paket ini akan dihapus dari layanan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const element = document.getElementById(`package-${serviceId}-${packageId}`);
                if (element) {
                    element.remove();
                    
                    Swal.fire({
                        text: "Paket berhasil dihapus!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            }
        });
    }
    
    // Update active services count
    function updateActiveServicesCount() {
        const activeCheckboxes = document.querySelectorAll('.service-form input[name="active"]:checked');
        document.getElementById('activeServicesCount').textContent = activeCheckboxes.length;
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateActiveServicesCount();
        
        // Update count when checkboxes change
        document.querySelectorAll('.service-form input[name="active"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateActiveServicesCount);
        });
    });
</script>
@endpush