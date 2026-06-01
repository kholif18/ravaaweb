@extends('admin.layouts.app')

@section('page-title', 'Contact Page')

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

    <li class="breadcrumb-item text-dark">
        Contact Page
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Contact Page Management</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-telephone fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Halaman Kontak</h4>
                <span>Kelola semua konten dan informasi di halaman Contact. Mulai dari informasi kontak, form, FAQ, hingga peta lokasi.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Tabs-->
        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_hero">Hero Section</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_contact">Contact Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_form">Form Options</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_map">Map Section</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_faq">FAQ Section</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_cta">CTA Section</a>
            </li>
        </ul>
        <!--end::Tabs-->
        
        <!--begin::Form-->
        <form id="contactPageForm">
            @csrf
            
            <!--begin::Tab Content-->
            <div class="tab-content">
                <!--begin::Tab Pane - Hero-->
                <div class="tab-pane fade show active" id="kt_tab_hero" role="tabpanel">
                    <div class="card card-bordered mb-10">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Hero Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Judul Utama</label>
                                <input type="text" class="form-control" 
                                       name="hero_title" 
                                       value="Hubungi Kami"
                                       required />
                            </div>
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="hero_description" 
                                          rows="3"
                                          required>Kami siap membantu Anda dengan segala kebutuhan desain, percetakan, dan ATK. Jangan ragu untuk menghubungi kami untuk konsultasi gratis atau informasi lebih lanjut.</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab Pane - Hero-->
                
                <!--begin::Tab Pane - Contact Info-->
                <div class="tab-pane fade" id="kt_tab_contact" role="tabpanel">
                    <!--begin::Section Title-->
                    <div class="card card-bordered mb-10">
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
                                               value="Get in Touch"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_subtitle" 
                                                  rows="3"
                                                  required>Hubungi kami melalui berbagai cara yang tersedia. Tim customer service kami siap membantu Anda dari Senin hingga Jumat, pukul 08.00 - 17.00 WIB.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Section Title-->
                    
                    <!--begin::Contact Information-->
                    <div class="row mb-10">
                        <!-- Alamat Kantor -->
                        <div class="col-lg-4 col-md-6 mb-10">
                            <div class="card card-bordered h-100">
                                <div class="card-header bg-light-primary">
                                    <h4 class="card-title text-gray-800">Alamat Kantor</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <label class="form-label required">Icon</label>
                                        <select class="form-select" name="address_icon" data-control="select2">
                                            <option value="fas fa-map-marker-alt" selected>Map Marker</option>
                                            <option value="fas fa-location-dot">Location</option>
                                            <option value="fas fa-building">Building</option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Judul</label>
                                        <input type="text" class="form-control" 
                                               name="address_title" 
                                               value="Alamat Kantor"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Alamat Baris 1</label>
                                        <input type="text" class="form-control" 
                                               name="address_line1" 
                                               value="Jl. Kreatif No. 123, Kel. Design, Kec. Printing"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Alamat Baris 2</label>
                                        <input type="text" class="form-control" 
                                               name="address_line2" 
                                               value="Jakarta Selatan, 12345" />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Alamat Baris 3</label>
                                        <input type="text" class="form-control" 
                                               name="address_line3" 
                                               value="Indonesia" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Telepon & WhatsApp -->
                        <div class="col-lg-4 col-md-6 mb-10">
                            <div class="card card-bordered h-100">
                                <div class="card-header bg-light-success">
                                    <h4 class="card-title text-gray-800">Telepon & WhatsApp</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <label class="form-label required">Icon</label>
                                        <select class="form-select" name="phone_icon" data-control="select2">
                                            <option value="fas fa-phone" selected>Phone</option>
                                            <option value="fas fa-mobile-alt">Mobile</option>
                                            <option value="fas fa-phone-alt">Phone Alt</option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Judul</label>
                                        <input type="text" class="form-control" 
                                               name="phone_title" 
                                               value="Telepon & WhatsApp"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Telepon Utama</label>
                                        <input type="text" class="form-control" 
                                               name="phone_main" 
                                               value="(021) 1234-5678"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">WhatsApp</label>
                                        <input type="text" class="form-control" 
                                               name="phone_whatsapp" 
                                               value="+62 812-3456-7890"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Jam Operasional</label>
                                        <input type="text" class="form-control" 
                                               name="phone_hours" 
                                               value="Senin - Jumat: 08.00 - 17.00 WIB"
                                               required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-lg-4 col-md-6 mb-10">
                            <div class="card card-bordered h-100">
                                <div class="card-header bg-light-warning">
                                    <h4 class="card-title text-gray-800">Email</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <label class="form-label required">Icon</label>
                                        <select class="form-select" name="email_icon" data-control="select2">
                                            <option value="fas fa-envelope" selected>Envelope</option>
                                            <option value="fas fa-mail-bulk">Mail Bulk</option>
                                            <option value="fas fa-at">At</option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Judul</label>
                                        <input type="text" class="form-control" 
                                               name="email_title" 
                                               value="Email"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Email Utama</label>
                                        <input type="email" class="form-control" 
                                               name="email_main" 
                                               value="info@ravaacreative.com"
                                               required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Email Pemesanan</label>
                                        <input type="email" class="form-control" 
                                               name="email_order" 
                                               value="order@ravaacreative.com" />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label required">Response Time</label>
                                        <input type="text" class="form-control" 
                                               name="email_response" 
                                               value="Response time: 1-2 jam kerja"
                                               required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Contact Information-->
                    
                    <!--begin::Social Media-->
                    <div class="card card-bordered mb-10">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Media Sosial</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-10">
                                    <label class="form-label required">Judul Media Sosial</label>
                                    <input type="text" class="form-control" 
                                           name="social_title" 
                                           value="Ikuti Kami di Media Sosial"
                                           required />
                                </div>
                            </div>
                            
                            <div class="row">
                                @php
                                    $socialMedia = [
                                        [
                                            'id' => 1,
                                            'name' => 'WhatsApp',
                                            'icon' => 'fab fa-whatsapp',
                                            'class' => 'whatsapp',
                                            'url' => 'https://wa.me/6281234567890',
                                            'active' => true,
                                            'order' => 1
                                        ],
                                        [
                                            'id' => 2,
                                            'name' => 'Instagram',
                                            'icon' => 'fab fa-instagram',
                                            'class' => 'instagram',
                                            'url' => 'https://instagram.com/ravaacreative',
                                            'active' => true,
                                            'order' => 2
                                        ],
                                        [
                                            'id' => 3,
                                            'name' => 'Facebook',
                                            'icon' => 'fab fa-facebook-f',
                                            'class' => 'facebook',
                                            'url' => 'https://facebook.com/ravaacreative',
                                            'active' => true,
                                            'order' => 3
                                        ],
                                        [
                                            'id' => 4,
                                            'name' => 'Twitter',
                                            'icon' => 'fab fa-twitter',
                                            'class' => 'twitter',
                                            'url' => 'https://twitter.com/ravaacreative',
                                            'active' => true,
                                            'order' => 4
                                        ],
                                        [
                                            'id' => 5,
                                            'name' => 'Telegram',
                                            'icon' => 'fab fa-telegram',
                                            'class' => 'telegram',
                                            'url' => 'https://t.me/ravaacreative',
                                            'active' => true,
                                            'order' => 5
                                        ]
                                    ];
                                @endphp
                                
                                @foreach($socialMedia as $social)
                                <div class="col-lg-4 col-md-6 mb-10">
                                    <div class="card card-bordered">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title text-gray-800">
                                                <span class="badge badge-light me-2">{{ $social['order'] }}</span>
                                                {{ $social['name'] }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-5">
                                                <label class="form-label required">Icon</label>
                                                <select class="form-select" name="social[{{ $social['id'] }}][icon]" data-control="select2">
                                                    <option value="fab fa-whatsapp" {{ $social['icon'] == 'fab fa-whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                                    <option value="fab fa-instagram" {{ $social['icon'] == 'fab fa-instagram' ? 'selected' : '' }}>Instagram</option>
                                                    <option value="fab fa-facebook-f" {{ $social['icon'] == 'fab fa-facebook-f' ? 'selected' : '' }}>Facebook</option>
                                                    <option value="fab fa-twitter" {{ $social['icon'] == 'fab fa-twitter' ? 'selected' : '' }}>Twitter</option>
                                                    <option value="fab fa-telegram" {{ $social['icon'] == 'fab fa-telegram' ? 'selected' : '' }}>Telegram</option>
                                                    <option value="fab fa-youtube">YouTube</option>
                                                    <option value="fab fa-linkedin">LinkedIn</option>
                                                    <option value="fab fa-tiktok">TikTok</option>
                                                </select>
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label required">Nama Platform</label>
                                                <input type="text" class="form-control" 
                                                       name="social[{{ $social['id'] }}][name]" 
                                                       value="{{ $social['name'] }}"
                                                       required />
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label required">URL</label>
                                                <input type="text" class="form-control" 
                                                       name="social[{{ $social['id'] }}][url]" 
                                                       value="{{ $social['url'] }}"
                                                       placeholder="https://" 
                                                       required />
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-md-6">
                                                    <label class="form-label required">CSS Class</label>
                                                    <input type="text" class="form-control" 
                                                           name="social[{{ $social['id'] }}][class]" 
                                                           value="{{ $social['class'] }}"
                                                           placeholder="whatsapp, instagram, dll" 
                                                           required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Urutan</label>
                                                    <input type="number" class="form-control" 
                                                           name="social[{{ $social['id'] }}][order]" 
                                                           value="{{ $social['order'] }}"
                                                           min="1" max="10" required />
                                                </div>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="social[{{ $social['id'] }}][active]" 
                                                       value="1" 
                                                       id="social_{{ $social['id'] }}_active" 
                                                       {{ $social['active'] ? 'checked' : '' }} />
                                                <label class="form-check-label" for="social_{{ $social['id'] }}_active">
                                                    Tampilkan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--end::Social Media-->
                </div>
                <!--end::Tab Pane - Contact Info-->
                
                <!--begin::Tab Pane - Form Options-->
                <div class="tab-pane fade" id="kt_tab_form" role="tabpanel">
                    <div class="card card-bordered mb-10">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Form Contact Options</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Judul Form</label>
                                <input type="text" class="form-control" 
                                       name="form_title" 
                                       value="Kirim Pesan"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Opsi Subject Form</label>
                                <textarea class="form-control" 
                                          name="form_subjects" 
                                          rows="6"
                                          placeholder="Format: value:Label&#10;value:Label"
                                          required>konsultasi:Konsultasi Desain
pemesanan:Pemesanan Produk
quotation:Request Quotation
kerjasama:Peluang Kerjasama
lainnya:Lainnya</textarea>
                                <div class="text-muted fs-7 mt-2">Format: value:Label (satu opsi per baris)</div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Teks Tombol Submit</label>
                                <input type="text" class="form-control" 
                                       name="form_button_text" 
                                       value="Kirim Pesan"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Icon Tombol Submit</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-paper-plane"></i>
                                    </span>
                                    <select class="form-select" name="form_button_icon" data-control="select2">
                                        <option value="fas fa-paper-plane" selected>Paper Plane</option>
                                        <option value="fas fa-envelope">Envelope</option>
                                        <option value="fas fa-send">Send</option>
                                        <option value="fas fa-share">Share</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab Pane - Form Options-->
                
                <!--begin::Tab Pane - Map Section-->
                <div class="tab-pane fade" id="kt_tab_map" role="tabpanel">
                    <div class="card card-bordered mb-10">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">Map Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Judul Section</label>
                                <input type="text" class="form-control" 
                                       name="map_title" 
                                       value="Lokasi Kami"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Judul Lokasi</label>
                                <input type="text" class="form-control" 
                                       name="map_location_title" 
                                       value="Ravaa Creative Studio"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Alamat Lengkap</label>
                                <input type="text" class="form-control" 
                                       name="map_address" 
                                       value="Jl. Kreatif No. 123, Jakarta Selatan, Indonesia"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Jam Operasional</label>
                                <input type="text" class="form-control" 
                                       name="map_hours" 
                                       value="Buka Senin - Jumat: 08.00 - 17.00 WIB"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Google Maps URL</label>
                                <input type="text" class="form-control" 
                                       name="map_google_url" 
                                       value="https://maps.google.com/?q=Jl.+Kreatif+No.+123,+Jakarta+Selatan"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Teks Tombol Maps</label>
                                <input type="text" class="form-control" 
                                       name="map_button_text" 
                                       value="Buka di Google Maps"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Icon Tombol Maps</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-directions"></i>
                                    </span>
                                    <select class="form-select" name="map_button_icon" data-control="select2">
                                        <option value="fas fa-directions" selected>Directions</option>
                                        <option value="fas fa-map-marker-alt">Map Marker</option>
                                        <option value="fas fa-location-arrow">Location Arrow</option>
                                        <option value="fas fa-external-link-alt">External Link</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Map Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </span>
                                    <select class="form-select" name="map_icon" data-control="select2">
                                        <option value="fas fa-map-marked-alt" selected>Map Marked Alt</option>
                                        <option value="fas fa-map-pin">Map Pin</option>
                                        <option value="fas fa-map">Map</option>
                                        <option value="fas fa-location-dot">Location Dot</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab Pane - Map Section-->
                
                <!--begin::Tab Pane - FAQ Section-->
                <div class="tab-pane fade" id="kt_tab_faq" role="tabpanel">
                    <div class="card card-bordered mb-10">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">FAQ Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Judul Section</label>
                                <input type="text" class="form-control" 
                                       name="faq_title" 
                                       value="Pertanyaan Umum"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Tambahkan FAQ Baru</label>
                                <button type="button" class="btn btn-light-primary btn-sm mb-5" onclick="addNewFAQ()">
                                    <i class="bi bi-plus-circle"></i> Tambah FAQ
                                </button>
                            </div>
                            
                            <!--begin::FAQ List-->
                            <div id="faqList">
                                @php
                                    $faqs = [
                                        [
                                            'id' => 1,
                                            'question' => 'Berapa lama waktu respon untuk pesan yang dikirim via formulir kontak?',
                                            'answer' => 'Kami akan membalas pesan Anda dalam 1-2 jam kerja pada hari dan jam operasional (Senin-Jumat, 08.00-17.00 WIB). Untuk pesan di luar jam operasional, kami akan membalas pada hari kerja berikutnya.',
                                            'active' => true,
                                            'order' => 1
                                        ],
                                        [
                                            'id' => 2,
                                            'question' => 'Apakah menyediakan layanan konsultasi gratis?',
                                            'answer' => 'Ya, kami menyediakan konsultasi gratis selama 30 menit untuk membahas kebutuhan desain atau percetakan Anda. Anda dapat menghubungi via WhatsApp untuk mengatur jadwal konsultasi.',
                                            'active' => true,
                                            'order' => 2
                                        ],
                                        [
                                            'id' => 3,
                                            'question' => 'Apakah bisa datang langsung ke studio/showroom?',
                                            'answer' => 'Ya, Anda bisa datang langsung ke studio kami di Jl. Kreatif No. 123, Jakarta Selatan. Namun, kami menyarankan untuk membuat janji terlebih dahulu via telepon atau WhatsApp agar tim kami siap melayani Anda dengan maksimal.',
                                            'active' => true,
                                            'order' => 3
                                        ],
                                        [
                                            'id' => 4,
                                            'question' => 'Bagaimana cara mendapatkan quotation untuk proyek desain atau percetakan?',
                                            'answer' => 'Anda dapat mengirimkan detail proyek melalui formulir kontak dengan memilih subjek "Request Quotation" atau langsung menghubungi kami via WhatsApp/Telegram. Kami akan mengirimkan quotation dalam 24 jam kerja.',
                                            'active' => true,
                                            'order' => 4
                                        ],
                                        [
                                            'id' => 5,
                                            'question' => 'Apakah melayani pemesanan dari luar kota?',
                                            'answer' => 'Ya, kami melayani pemesanan dari seluruh Indonesia. Untuk layanan desain, semua proses dapat dilakukan online. Untuk produk fisik (percetakan, ATK, merchandise), kami akan mengirimkan ke alamat Anda dengan biaya pengiriman yang disesuaikan.',
                                            'active' => true,
                                            'order' => 5
                                        ]
                                    ];
                                @endphp
                                
                                @foreach($faqs as $faq)
                                <div class="card card-bordered mb-5">
                                    <div class="card-header bg-light">
                                        <h4 class="card-title text-gray-800">
                                            <span class="badge badge-light me-2">{{ $faq['order'] }}</span>
                                            FAQ {{ $loop->iteration }}
                                        </h4>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeFAQ(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <div class="col-md-6">
                                                <label class="form-label required">Pertanyaan</label>
                                                <input type="text" class="form-control" 
                                                       name="faqs[{{ $faq['id'] }}][question]" 
                                                       value="{{ $faq['question'] }}"
                                                       required />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label required">Urutan</label>
                                                <input type="number" class="form-control" 
                                                       name="faqs[{{ $faq['id'] }}][order]" 
                                                       value="{{ $faq['order'] }}"
                                                       min="1" max="20" required />
                                            </div>
                                        </div>
                                        <div class="mb-5">
                                            <label class="form-label required">Jawaban</label>
                                            <textarea class="form-control" 
                                                      name="faqs[{{ $faq['id'] }}][answer]" 
                                                      rows="3"
                                                      required>{{ $faq['answer'] }}</textarea>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="faqs[{{ $faq['id'] }}][active]" 
                                                   value="1" 
                                                   id="faq_{{ $faq['id'] }}_active" 
                                                   {{ $faq['active'] ? 'checked' : '' }} />
                                            <label class="form-check-label" for="faq_{{ $faq['id'] }}_active">
                                                Tampilkan FAQ
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!--end::FAQ List-->
                            
                            <div class="text-muted fs-7">
                                <i class="bi bi-info-circle me-1"></i>
                                FAQ akan ditampilkan dalam bentuk accordion di halaman Contact.
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab Pane - FAQ Section-->
                
                <!--begin::Tab Pane - CTA Section-->
                <div class="tab-pane fade" id="kt_tab_cta" role="tabpanel">
                    <div class="card card-bordered mb-10">
                        <div class="card-header bg-light">
                            <h3 class="card-title text-gray-800">CTA Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Judul CTA</label>
                                <input type="text" class="form-control" 
                                       name="cta_title" 
                                       value="Siap Bekerja Sama dengan Kami?"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Deskripsi CTA</label>
                                <textarea class="form-control" 
                                          name="cta_description" 
                                          rows="3"
                                          required>Konsultasikan kebutuhan desain, printing, atau ATK Anda dengan tim profesional kami. Dapatkan solusi terbaik dengan harga kompetitif.</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Background Color</label>
                                <input type="color" class="form-control form-control-color" 
                                       name="cta_background" 
                                       value="#667eea" 
                                       title="Pilih warna background CTA" />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Teks Tombol</label>
                                <input type="text" class="form-control" 
                                       name="cta_button_text" 
                                       value="Chat via WhatsApp Sekarang"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">URL Tombol</label>
                                <input type="text" class="form-control" 
                                       name="cta_button_url" 
                                       value="https://wa.me/6281234567890"
                                       required />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Icon Tombol</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-whatsapp"></i>
                                    </span>
                                    <select class="form-select" name="cta_button_icon" data-control="select2">
                                        <option value="fab fa-whatsapp" selected>WhatsApp</option>
                                        <option value="fas fa-envelope">Email</option>
                                        <option value="fas fa-phone">Phone</option>
                                        <option value="fas fa-comment-alt">Comment</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab Pane - CTA Section-->
            </div>
            <!--end::Tab Content-->
            
        </form>
        <!--end::Form-->
        
    </div>
    <!--end::Card body-->
    
    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="button" class="btn btn-light me-3" onclick="resetForm()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveContactPage()">
            <span class="indicator-label">Simpan Semua Perubahan</span>
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
    let faqCounter = {{ count($faqs ?? []) }};
    
    function saveContactPage() {
        const form = document.getElementById('contactPageForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Contact Page berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetForm() {
    Swal.fire({
        title: "Reset Contact Page?",
        text: "Semua perubahan akan dikembalikan ke nilai awal.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Reset!",
        cancelButtonText: "Batal",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-light"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('contactPageForm').reset();
            
            // Reset Select2
            $('[data-control="select2"]').each(function() {
                $(this).val($(this).find('option:first').val()).trigger('change');
            });
            
            // Show success message
            Swal.fire({
                text: "Form berhasil direset!",
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

function addNewFAQ() {
    faqCounter++;
    const faqId = 'new_' + Date.now();
    
    const faqHTML = `
    <div class="card card-bordered mb-5" id="faq-${faqId}">
        <div class="card-header bg-light">
            <h4 class="card-title text-gray-800">
                <span class="badge badge-light me-2">${faqCounter}</span>
                FAQ Baru
            </h4>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeFAQ(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-6">
                    <label class="form-label required">Pertanyaan</label>
                    <input type="text" class="form-control" 
                           name="faqs[${faqId}][question]" 
                           value=""
                           required />
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Urutan</label>
                    <input type="number" class="form-control" 
                           name="faqs[${faqId}][order]" 
                           value="${faqCounter}"
                           min="1" max="20" required />
                </div>
            </div>
            <div class="mb-5">
                <label class="form-label required">Jawaban</label>
                <textarea class="form-control" 
                          name="faqs[${faqId}][answer]" 
                          rows="3"
                          required></textarea>
            </div>
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" 
                       name="faqs[${faqId}][active]" 
                       value="1" 
                       id="faq_${faqId}_active" 
                       checked />
                <label class="form-check-label" for="faq_${faqId}_active">
                    Tampilkan FAQ
                </label>
            </div>
        </div>
    </div>`;
    
    document.getElementById('faqList').insertAdjacentHTML('beforeend', faqHTML);
    
    // Smooth scroll to new FAQ
    document.getElementById(`faq-${faqId}`).scrollIntoView({ 
        behavior: 'smooth', 
        block: 'center' 
    });
}

function removeFAQ(button) {
    const card = button.closest('.card');
    const question = card.querySelector('input[name$="[question]"]').value;
    
    Swal.fire({
        title: "Hapus FAQ?",
        html: `FAQ dengan pertanyaan: <strong>"${question || 'FAQ baru'}"</strong> akan dihapus.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-light"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            card.style.opacity = '0';
            card.style.transform = 'translateX(50px)';
            
            setTimeout(() => {
                card.remove();
                // Update FAQ numbers
                updateFAQNumbers();
            }, 300);
        }
    });
}

function updateFAQNumbers() {
    const faqCards = document.querySelectorAll('#faqList .card');
    faqCounter = faqCards.length;
    
    faqCards.forEach((card, index) => {
        const badge = card.querySelector('.badge');
        const orderInput = card.querySelector('input[name$="[order]"]');
        
        if (badge) badge.textContent = index + 1;
        if (orderInput) orderInput.value = index + 1;
        
        // Update title
        const title = card.querySelector('.card-title');
        const titleText = title.textContent.split('FAQ ')[0] + 'FAQ ' + (index + 1);
        title.textContent = titleText;
    });
}

// Initialize Select2
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all Select2 elements
    $('[data-control="select2"]').select2({
        minimumResultsForSearch: 10,
        placeholder: "Pilih opsi",
        allowClear: false
    });
    
    // Initialize form validation
    initFormValidation();
});

function initFormValidation() {
    const form = document.getElementById('contactPageForm');
    
    // Real-time validation
    form.addEventListener('input', function(e) {
        if (e.target.hasAttribute('required')) {
            validateField(e.target);
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        
        if (isValid) {
            saveContactPage();
        }
    });
}

function validateField(field) {
    const value = field.value.trim();
    const isValid = value !== '';
    
    if (field.type === 'email') {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(value)) {
            showFieldError(field, 'Format email tidak valid');
            return false;
        }
    }
    
    if (!isValid) {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    }
    
    removeFieldError(field);
    return true;
}

function showFieldError(field, message) {
    const parent = field.closest('.mb-5, .mb-10');
    if (!parent) return;
    
    let errorElement = parent.querySelector('.invalid-feedback');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback d-block';
        parent.appendChild(errorElement);
    }
    
    errorElement.textContent = message;
    field.classList.add('is-invalid');
}

function removeFieldError(field) {
    field.classList.remove('is-invalid');
    const parent = field.closest('.mb-5, .mb-10');
    if (parent) {
        const errorElement = parent.querySelector('.invalid-feedback');
        if (errorElement) errorElement.remove();
    }
}

// Handle tab changes
document.querySelectorAll('.nav-link').forEach(tab => {
    tab.addEventListener('click', function(e) {
        // Remove active class from all tabs
        document.querySelectorAll('.nav-link').forEach(t => {
            t.classList.remove('active');
        });
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Store current tab in localStorage
        localStorage.setItem('contactPageActiveTab', this.getAttribute('href'));
    });
});

// Restore active tab on page load
document.addEventListener('DOMContentLoaded', function() {
    const activeTab = localStorage.getItem('contactPageActiveTab');
    if (activeTab) {
        const tabLink = document.querySelector(`.nav-link[href="${activeTab}"]`);
        if (tabLink) {
            // Remove active class from all
            document.querySelectorAll('.nav-link').forEach(t => {
                t.classList.remove('active');
                document.querySelector(t.getAttribute('href')).classList.remove('show', 'active');
            });
            
            // Add to selected
            tabLink.classList.add('active');
            document.querySelector(activeTab).classList.add('show', 'active');
        }
    }
});
</script>
@endpush