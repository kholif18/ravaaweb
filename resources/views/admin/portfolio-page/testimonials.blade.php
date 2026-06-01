@extends('admin.layouts.app')

@section('page-title', 'Testimonials Slider')

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
        Testimonials Slider
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Testimonial Klien</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_testimonial">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah Testimonial
                </button>
            </div>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
            <i class="bi bi-chat-quote fs-2hx text-success me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-success">Manajemen Testimonial Klien</h4>
                <span>Kelola testimonial dari klien yang akan ditampilkan di halaman portfolio. Testimonial membantu membangun kepercayaan calon klien.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="testimonialsForm">
            @csrf
            
            <!--begin::Testimonials List-->
            <div class="row">
                @php
                    $testimonials = [
                        [
                            'id' => 1,
                            'name' => 'Budi Santoso',
                            'position' => 'Owner, Brew & Co Coffee',
                            'text' => '"Ravaa Creative sangat profesional dalam mengerjakan logo untuk bisnis saya. Mereka memahami kebutuhan dengan baik dan memberikan hasil yang melebihi ekspektasi. Proses revisi juga sangat fleksibel dan responsif."',
                            'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                            'rating' => 5,
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'name' => 'Sari Dewi',
                            'position' => 'Marketing Director, TechSolutions Inc.',
                            'text' => '"Kerjasama dengan Ravaa Creative untuk proyek branding perusahaan kami sangat memuaskan. Tim mereka kreatif, detail-oriented, dan selalu tepat waktu. Hasil akhirnya sangat profesional dan sesuai dengan identitas perusahaan kami."',
                            'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
                            'rating' => 4.5,
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'name' => 'Ahmad Rizki',
                            'position' => 'CEO, FashionHouse ID',
                            'text' => '"Kualitas percetakan dari Ravaa Creative sangat bagus. Mereka membantu kami dari desain hingga produksi katalog produk. Hasil cetakan tajam, warna akurat, dan finishing-nya rapi. Highly recommended!"',
                            'avatar' => 'https://randomuser.me/api/portraits/men/67.jpg',
                            'rating' => 5,
                            'active' => true,
                            'order' => 3
                        ]
                    ];
                @endphp
                
                @foreach($testimonials as $testimonial)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $testimonial['active'] ? 'success' : 'danger' }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $testimonial['active'] ? 'success' : 'danger' }} me-2">{{ $testimonial['order'] }}</span>
                                Testimonial {{ $loop->iteration }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="testimonial-avatar-preview mb-3" style="
                                    width: 80px;
                                    height: 80px;
                                    background-image: url('{{ $testimonial['avatar'] }}');
                                    background-size: cover;
                                    background-position: center;
                                    border-radius: 50%;
                                    border: 3px solid #e4e6ef;
                                "></div>
                                <label class="form-label required">URL Avatar</label>
                                <input type="text" class="form-control" 
                                       name="testimonials[{{ $testimonial['id'] }}][avatar]" 
                                       value="{{ $testimonial['avatar'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama</label>
                                <input type="text" class="form-control" 
                                       name="testimonials[{{ $testimonial['id'] }}][name]" 
                                       value="{{ $testimonial['name'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Posisi/Pekerjaan</label>
                                <input type="text" class="form-control" 
                                       name="testimonials[{{ $testimonial['id'] }}][position]" 
                                       value="{{ $testimonial['position'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Testimonial</label>
                                <textarea class="form-control" 
                                          name="testimonials[{{ $testimonial['id'] }}][text]" 
                                          rows="4"
                                          required>{{ $testimonial['text'] }}</textarea>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Rating</label>
                                    <select class="form-select" name="testimonials[{{ $testimonial['id'] }}][rating]" data-control="select2">
                                        <option value="5" {{ $testimonial['rating'] == 5 ? 'selected' : '' }}>5 Bintang ⭐⭐⭐⭐⭐</option>
                                        <option value="4.5" {{ $testimonial['rating'] == 4.5 ? 'selected' : '' }}>4.5 Bintang ⭐⭐⭐⭐✰</option>
                                        <option value="4" {{ $testimonial['rating'] == 4 ? 'selected' : '' }}>4 Bintang ⭐⭐⭐⭐</option>
                                        <option value="3.5" {{ $testimonial['rating'] == 3.5 ? 'selected' : '' }}>3.5 Bintang ⭐⭐⭐✰</option>
                                        <option value="3" {{ $testimonial['rating'] == 3 ? 'selected' : '' }}>3 Bintang ⭐⭐⭐</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="testimonials[{{ $testimonial['id'] }}][order]" 
                                           value="{{ $testimonial['order'] }}"
                                           min="1" max="10" required />
                                </div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" 
                                       name="testimonials[{{ $testimonial['id'] }}][active]" 
                                       value="1" 
                                       id="testimonial_{{ $testimonial['id'] }}_active" 
                                       {{ $testimonial['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="testimonial_{{ $testimonial['id'] }}_active">
                                    Tampilkan Testimonial
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Testimonials List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Testimonial Slider</h3>
                        </div>
                        <div class="card-body">
                            @foreach($testimonials as $testimonial)
                            @if($testimonial['active'])
                            <div class="testimonial-preview mb-6 p-6" style="
                                background-color: #f8f9fa;
                                border-radius: 10px;
                                border-left: 4px solid #20c997;
                                position: relative;
                            ">
                                <div class="mb-4" style="
                                    font-size: 2.5rem;
                                    color: #20c997;
                                    line-height: 1;
                                ">"</div>
                                <p class="text-gray-700 mb-4">{{ $testimonial['text'] }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <div style="
                                            width: 50px;
                                            height: 50px;
                                            background-image: url('{{ $testimonial['avatar'] }}');
                                            background-size: cover;
                                            background-position: center;
                                            border-radius: 50%;
                                        "></div>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-gray-800 mb-1">{{ $testimonial['name'] }}</h5>
                                        <p class="text-muted fs-7 mb-1">{{ $testimonial['position'] }}</p>
                                        <div class="d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($testimonial['rating']))
                                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                                @elseif($i == ceil($testimonial['rating']) && fmod($testimonial['rating'], 1) > 0)
                                                    <i class="bi bi-star-half text-warning me-1"></i>
                                                @else
                                                    <i class="bi bi-star text-warning me-1"></i>
                                                @endif
                                            @endfor
                                            <span class="text-muted ms-2">{{ number_format($testimonial['rating'], 1) }}/5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            
                            <div class="text-muted fs-7 mt-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Testimonial akan ditampilkan dalam slider dengan navigasi otomatis di halaman Portfolio.
                            </div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetTestimonials()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveTestimonials()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->

<!--begin::Modal - Add Testimonial-->
<div class="modal fade" id="kt_modal_add_testimonial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Testimonial</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_add_testimonial_form" class="form" action="#">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nama</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Nama klien" name="new_testimonial_name" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Posisi/Pekerjaan</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Contoh: Owner, Brew & Co Coffee" name="new_testimonial_position" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Testimonial</label>
                        <textarea class="form-control form-control-solid" rows="4" name="new_testimonial_text" placeholder="Masukkan testimonial dari klien"></textarea>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">URL Avatar</label>
                            <input type="text" class="form-control form-control-solid" placeholder="https://" name="new_testimonial_avatar" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Rating</label>
                            <select class="form-select form-select-solid" name="new_testimonial_rating">
                                <option value="5">5 Bintang ⭐⭐⭐⭐⭐</option>
                                <option value="4.5">4.5 Bintang ⭐⭐⭐⭐✰</option>
                                <option value="4">4 Bintang ⭐⭐⭐⭐</option>
                                <option value="3.5">3.5 Bintang ⭐⭐⭐✰</option>
                                <option value="3">3 Bintang ⭐⭐⭐</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" placeholder="1" name="new_testimonial_order" min="1" max="10" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Status</label>
                            <div class="form-check form-check-custom form-check-solid mt-5">
                                <input class="form-check-input" type="checkbox" value="1" id="new_testimonial_active" checked />
                                <label class="form-check-label" for="new_testimonial_active">Aktif</label>
                            </div>
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
<!--end::Modal - Add Testimonial-->
@endsection

@push('scripts')
<script>
    function saveTestimonials() {
        const form = document.getElementById('testimonialsForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Testimonial berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetTestimonials() {
        Swal.fire({
            title: "Reset Testimonial?",
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
        // Form submission untuk modal tambah testimonial
        const modalForm = document.getElementById('kt_modal_add_testimonial_form');
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
                        text: "Testimonial berhasil ditambahkan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_testimonial'));
                        modal.hide();
                        location.reload();
                    });
                }, 1500);
            });
        }
    });
</script>
@endpush