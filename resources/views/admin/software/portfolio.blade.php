@extends('admin.layouts.app')

@section('page-title', 'Tech Portfolio')

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
        Tech Portfolio
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Portfolio Tech</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_portfolio">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah Portfolio
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
            <i class="bi bi-laptop fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Portfolio Tech</h4>
                <span>Kelola portfolio website dan aplikasi yang telah dikembangkan. Portfolio membantu membuktikan kemampuan dan pengalaman tim developer.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="portfolioForm">
            @csrf
            
            <!--begin::Section Title-->
            <div class="row mb-15">
                <div class="col-12">
                    <div class="card card-bordered">
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
                                               value="Portfolio Tech Kami"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_description" 
                                                  rows="3"
                                                  required>Beberapa proyek website dan aplikasi yang telah kami kembangkan untuk klien.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section Title-->
            
            <!--begin::Portfolio List-->
            <div class="row">
                @php
                    $portfolioItems = [
                        [
                            'id' => 1,
                            'title' => 'Tokopedia-like Marketplace',
                            'category' => 'E-commerce',
                            'description' => 'Pengembangan platform marketplace dengan sistem multi-vendor, integrasi berbagai payment gateway, dan dashboard analytics lengkap.',
                            'image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'tech' => ['Laravel', 'Vue.js', 'MySQL'],
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'title' => 'Delivery Service App',
                            'category' => 'Mobile App',
                            'description' => 'Aplikasi mobile untuk layanan delivery dengan fitur real-time tracking, in-app chat, dan sistem rating untuk driver dan customer.',
                            'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'tech' => ['Flutter', 'Firebase', 'Node.js'],
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'title' => 'Custom CRM System',
                            'category' => 'CRM System',
                            'description' => 'Sistem CRM khusus untuk perusahaan properti dengan modul lead management, marketing automation, dan reporting dashboard.',
                            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'tech' => ['React.js', 'Express.js', 'MongoDB'],
                            'active' => true,
                            'order' => 3
                        ]
                    ];
                @endphp
                
                @foreach($portfolioItems as $item)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $item['active'] ? 'success' : 'danger' }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $item['active'] ? 'success' : 'danger' }} me-2">{{ $item['order'] }}</span>
                                Portfolio {{ $loop->iteration }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="portfolio-image-preview mb-3" style="
                                    width: 100%;
                                    height: 150px;
                                    background-image: url('{{ $item['image'] }}');
                                    background-size: cover;
                                    background-position: center;
                                    border-radius: 5px;
                                    border: 1px solid #e4e6ef;
                                "></div>
                                <label class="form-label required">URL Gambar</label>
                                <input type="text" class="form-control" 
                                       name="portfolio[{{ $item['id'] }}][image]" 
                                       value="{{ $item['image'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Portfolio</label>
                                <input type="text" class="form-control" 
                                       name="portfolio[{{ $item['id'] }}][title]" 
                                       value="{{ $item['title'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Kategori</label>
                                <select class="form-select" name="portfolio[{{ $item['id'] }}][category]" data-control="select2">
                                    <option value="E-commerce" {{ $item['category'] == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="Mobile App" {{ $item['category'] == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="CRM System" {{ $item['category'] == 'CRM System' ? 'selected' : '' }}>CRM System</option>
                                    <option value="Website">Website</option>
                                    <option value="Dashboard">Dashboard</option>
                                    <option value="Custom Software">Custom Software</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="portfolio[{{ $item['id'] }}][description]" 
                                          rows="3"
                                          required>{{ $item['description'] }}</textarea>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Teknologi (pisahkan dengan koma)</label>
                                <input type="text" class="form-control" 
                                       name="portfolio[{{ $item['id'] }}][tech]" 
                                       value="{{ implode(', ', $item['tech']) }}"
                                       placeholder="Laravel, Vue.js, MySQL" />
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="portfolio[{{ $item['id'] }}][order]" 
                                           value="{{ $item['order'] }}"
                                           min="1" max="10" required />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid mt-8">
                                        <input class="form-check-input" type="checkbox" 
                                               name="portfolio[{{ $item['id'] }}][active]" 
                                               value="1" 
                                               id="portfolio_{{ $item['id'] }}_active" 
                                               {{ $item['active'] ? 'checked' : '' }} />
                                        <label class="form-check-label" for="portfolio_{{ $item['id'] }}_active">
                                            Tampilkan Portfolio
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Portfolio List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Portfolio Tech</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach(array_slice($portfolioItems, 0, 2) as $item)
                                <div class="col-lg-6 mb-5">
                                    <div class="card card-bordered h-100">
                                        <div class="card-body p-0">
                                            <div style="
                                                width: 100%;
                                                height: 200px;
                                                background-image: url('{{ $item['image'] }}');
                                                background-size: cover;
                                                background-position: center;
                                                border-radius: 5px 5px 0 0;
                                            "></div>
                                            <div class="p-6">
                                                <div class="mb-3">
                                                    <span class="badge badge-light-primary">{{ $item['category'] }}</span>
                                                </div>
                                                <h4 class="fw-bold text-gray-800 mb-3">{{ $item['title'] }}</h4>
                                                <p class="text-muted mb-4">{{ Str::limit($item['description'], 120) }}</p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach(array_slice($item['tech'], 0, 3) as $tech)
                                                    <span class="badge badge-light">{{ $tech }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah preview 2 portfolio tech yang akan ditampilkan di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetPortfolio()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="savePortfolio()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->

<!--begin::Modal - Add Portfolio-->
<div class="modal fade" id="kt_modal_add_portfolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Portfolio Tech</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_add_portfolio_form" class="form" action="#">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Judul Portfolio</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Masukkan judul portfolio" name="new_portfolio_title" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Kategori</label>
                        <select class="form-select form-select-solid" name="new_portfolio_category">
                            <option value="E-commerce">E-commerce</option>
                            <option value="Mobile App">Mobile App</option>
                            <option value="CRM System">CRM System</option>
                            <option value="Website">Website</option>
                            <option value="Dashboard">Dashboard</option>
                        </select>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">URL Gambar</label>
                        <input type="text" class="form-control form-control-solid" placeholder="https://" name="new_portfolio_image" />
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" rows="3" name="new_portfolio_description" placeholder="Masukkan deskripsi portfolio"></textarea>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Teknologi (pisahkan dengan koma)</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Laravel, Vue.js, MySQL" name="new_portfolio_tech" />
                    </div>
                    
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" placeholder="1" name="new_portfolio_order" min="1" max="10" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Status</label>
                            <div class="form-check form-check-custom form-check-solid mt-5">
                                <input class="form-check-input" type="checkbox" value="1" id="new_portfolio_active" checked />
                                <label class="form-check-label" for="new_portfolio_active">Aktif</label>
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
<!--end::Modal - Add Portfolio-->
@endsection

@push('scripts')
<script>
    function savePortfolio() {
        const form = document.getElementById('portfolioForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Portfolio berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetPortfolio() {
        Swal.fire({
            title: "Reset Portfolio?",
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
        // Form submission untuk modal tambah portfolio
        const modalForm = document.getElementById('kt_modal_add_portfolio_form');
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
                        text: "Portfolio berhasil ditambahkan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_portfolio'));
                        modal.hide();
                        location.reload();
                    });
                }, 1500);
            });
        }
    });
</script>
@endpush