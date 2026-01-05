@extends('admin.layouts.app')

@section('page-title', 'Promo Banner')
@section('page-description', 'Promo Banner — Ravaa Creative')

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
            Produk Page
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
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Banner Promosi</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_banner">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah Banner
                </button>
            </div>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
            <i class="bi bi-megaphone fs-2hx text-warning me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-warning">Informasi Banner Promosi</h4>
                <span>Kelola banner promosi yang akan ditampilkan di halaman produk. Maksimal 3 banner aktif dalam waktu bersamaan.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="bannersForm">
            @csrf
            
            <!--begin::Banners List-->
            <div class="row">
                @php
                    $banners = [
                        [
                            'id' => 1,
                            'title' => 'Gratis Konsultasi Desain!',
                            'description' => 'Dapatkan konsultasi desain gratis untuk 5 project pertama Anda.',
                            'button_text' => 'Hubungi Sekarang',
                            'button_url' => '#',
                            'background_color' => '#7209b7',
                            'text_color' => '#ffffff',
                            'position' => 'bottom',
                            'active' => true,
                            'start_date' => '2024-01-01',
                            'end_date' => '2024-12-31',
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'title' => 'Diskon 20% Desain Logo',
                            'description' => 'Khusus bulan ini, dapatkan diskon 20% untuk paket desain logo profesional.',
                            'button_text' => 'Pesan Sekarang',
                            'button_url' => '#',
                            'background_color' => '#4cc9f0',
                            'text_color' => '#000000',
                            'position' => 'middle',
                            'active' => true,
                            'start_date' => '2024-03-01',
                            'end_date' => '2024-03-31',
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'title' => 'Free Ongkir Jabodetabek',
                            'description' => 'Gratis ongkos kirim untuk wilayah Jabodetabek dengan minimal pembelian Rp 500.000.',
                            'button_text' => 'Lihat Produk',
                            'button_url' => '#',
                            'background_color' => '#4361ee',
                            'text_color' => '#ffffff',
                            'position' => 'top',
                            'active' => false,
                            'start_date' => '2024-02-01',
                            'end_date' => '2024-02-29',
                            'order' => 3
                        ]
                    ];
                @endphp
                
                @foreach($banners as $banner)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $banner['active'] ? 'success' : 'danger' }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $banner['active'] ? 'success' : 'danger' }} me-2">{{ $banner['order'] }}</span>
                                Banner {{ $loop->iteration }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Judul Banner</label>
                                <input type="text" class="form-control" 
                                       name="banners[{{ $banner['id'] }}][title]" 
                                       value="{{ $banner['title'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="banners[{{ $banner['id'] }}][description]" 
                                          rows="3"
                                          required>{{ $banner['description'] }}</textarea>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Teks Tombol</label>
                                    <input type="text" class="form-control" 
                                           name="banners[{{ $banner['id'] }}][button_text]" 
                                           value="{{ $banner['button_text'] }}"
                                           required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">URL Tombol</label>
                                    <input type="text" class="form-control" 
                                           name="banners[{{ $banner['id'] }}][button_url]" 
                                           value="{{ $banner['button_url'] }}"
                                           required />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Warna Latar</label>
                                    <input type="color" class="form-control form-control-color" 
                                           name="banners[{{ $banner['id'] }}][background_color]" 
                                           value="{{ $banner['background_color'] }}" 
                                           title="Pilih warna latar" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Warna Teks</label>
                                    <input type="color" class="form-control form-control-color" 
                                           name="banners[{{ $banner['id'] }}][text_color]" 
                                           value="{{ $banner['text_color'] }}" 
                                           title="Pilih warna teks" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Posisi</label>
                                    <select class="form-select" name="banners[{{ $banner['id'] }}][position]" data-control="select2">
                                        <option value="top" {{ $banner['position'] == 'top' ? 'selected' : '' }}>Atas Halaman</option>
                                        <option value="middle" {{ $banner['position'] == 'middle' ? 'selected' : '' }}>Tengah Halaman</option>
                                        <option value="bottom" {{ $banner['position'] == 'bottom' ? 'selected' : '' }}>Bawah Halaman</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="banners[{{ $banner['id'] }}][order]" 
                                           value="{{ $banner['order'] }}"
                                           min="1" max="5" required />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Tanggal Mulai</label>
                                    <input type="date" class="form-control" 
                                           name="banners[{{ $banner['id'] }}][start_date]" 
                                           value="{{ $banner['start_date'] }}"
                                           required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" 
                                           name="banners[{{ $banner['id'] }}][end_date]" 
                                           value="{{ $banner['end_date'] }}"
                                           required />
                                </div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" 
                                       name="banners[{{ $banner['id'] }}][active]" 
                                       value="1" 
                                       id="banner_{{ $banner['id'] }}_active" 
                                       {{ $banner['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="banner_{{ $banner['id'] }}_active">
                                    Banner Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Banners List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Banner Promosi</h3>
                        </div>
                        <div class="card-body">
                            @foreach($banners as $banner)
                            @if($banner['active'])
                            <div class="promo-preview mb-6" style="
                                background-color: {{ $banner['background_color'] }};
                                color: {{ $banner['text_color'] }};
                                padding: 25px;
                                border-radius: 10px;
                                text-align: center;
                                margin-bottom: 20px;
                                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                            ">
                                <h4 style="color: {{ $banner['text_color'] }}; margin-bottom: 10px; font-weight: bold;">{{ $banner['title'] }}</h4>
                                <p style="color: {{ $banner['text_color'] }}; margin-bottom: 20px; opacity: 0.9;">{{ $banner['description'] }}</p>
                                <a href="{{ $banner['button_url'] }}" class="btn d-inline-block" style="
                                    background-color: {{ $banner['text_color'] }};
                                    color: {{ $banner['background_color'] }};
                                    border: none;
                                    padding: 8px 20px;
                                    border-radius: 5px;
                                    text-decoration: none;
                                    font-weight: 600;
                                    max-width: 200px;
                                    margin: 0 auto;
                                    transition: transform 0.3s;
                                " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    {{ $banner['button_text'] }}
                                </a>
                                <div class="mt-3" style="color: {{ $banner['text_color'] }}; opacity: 0.8;">
                                    <small>Posisi: {{ $banner['position'] == 'top' ? 'Atas' : ($banner['position'] == 'middle' ? 'Tengah' : 'Bawah') }} | 
                                    Periode: {{ \Carbon\Carbon::parse($banner['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($banner['end_date'])->format('d M Y') }}</small>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            
                            @if(!$banners[0]['active'] && !$banners[1]['active'] && !$banners[2]['active'])
                            <div class="text-center p-10">
                                <i class="bi bi-megaphone fs-2hx text-muted mb-4"></i>
                                <div class="fw-bold text-gray-800 mb-2">Tidak ada banner aktif</div>
                                <p class="text-muted">Tidak ada banner promosi yang aktif saat ini.</p>
                            </div>
                            @endif
                            
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan banner promosi di halaman Produk (hanya banner aktif yang ditampilkan).</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetBanners()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveBanners()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->

<!--begin::Modal - Add Banner-->
<div class="modal fade" id="kt_modal_add_banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Banner Promosi</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_add_banner_form" class="form" action="#">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Judul Banner</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Masukkan judul banner" name="new_banner_title" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" rows="3" name="new_banner_description" placeholder="Masukkan deskripsi banner"></textarea>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Teks Tombol</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: Pesan Sekarang" name="new_button_text" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">URL Tombol</label>
                            <input type="text" class="form-control form-control-solid" placeholder="https://" name="new_button_url" />
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Warna Latar</label>
                            <input type="color" class="form-control form-control-color" name="new_background_color" value="#7209b7" title="Pilih warna latar" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Warna Teks</label>
                            <input type="color" class="form-control form-control-color" name="new_text_color" value="#ffffff" title="Pilih warna teks" />
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Posisi Banner</label>
                            <select class="form-select form-select-solid" name="new_banner_position">
                                <option value="top">Atas Halaman</option>
                                <option value="middle" selected>Tengah Halaman</option>
                                <option value="bottom">Bawah Halaman</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" placeholder="1" name="new_banner_order" min="1" max="5" />
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Tanggal Mulai</label>
                            <input type="date" class="form-control form-control-solid" name="new_start_date" value="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Tanggal Berakhir</label>
                            <input type="date" class="form-control form-control-solid" name="new_end_date" value="{{ date('Y-m-d', strtotime('+1 month')) }}" />
                        </div>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Status</label>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" id="new_banner_active" checked />
                            <label class="form-check-label" for="new_banner_active">Aktifkan Banner</label>
                        </div>
                    </div>
                    
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Add Banner-->
@endsection

@push('scripts')
<script>
    function saveBanners() {
        const form = document.getElementById('bannersForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Banner berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetBanners() {
        Swal.fire({
            title: "Reset Banner?",
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
    
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission untuk modal tambah banner
        const modalForm = document.getElementById('kt_modal_add_banner_form');
        if (modalForm) {
            modalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitButton = modalForm.querySelector('button[type="submit"]');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                
                setTimeout(function() {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    
                    Swal.fire({
                        text: "Banner berhasil ditambahkan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_banner'));
                        modal.hide();
                        location.reload();
                    });
                }, 1500);
            });
        }
    });
</script>
@endpush