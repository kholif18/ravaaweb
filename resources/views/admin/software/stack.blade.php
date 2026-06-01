@extends('admin.layouts.app')

@section('page-title', 'Tech Stack')

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
        Tech Stack
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Technology Stack</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-stack fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Tech Stack</h4>
                <span>Kelola teknologi yang digunakan dalam pengembangan software. Setiap teknologi dapat dikustomisasi dengan icon, nama, dan deskripsi.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="stackForm">
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
                                               value="Technology Stack Kami"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_description" 
                                                  rows="3"
                                                  required>Kami menggunakan teknologi terbaru dan terpercaya untuk pengembangan software yang berkualitas.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section Title-->
            
            <!--begin::Tech Stack List-->
            <div class="row">
                @php
                    $techStack = [
                        [
                            'id' => 1,
                            'name' => 'HTML5',
                            'icon' => 'fab fa-html5',
                            'icon_class' => 'html',
                            'description' => 'Frontend Structure',
                            'color' => '#e34f26',
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'name' => 'CSS3',
                            'icon' => 'fab fa-css3-alt',
                            'icon_class' => 'css',
                            'description' => 'Styling & Design',
                            'color' => '#264de4',
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'name' => 'JavaScript',
                            'icon' => 'fab fa-js-square',
                            'icon_class' => 'js',
                            'description' => 'Frontend Logic',
                            'color' => '#f0db4f',
                            'active' => true,
                            'order' => 3
                        ],
                        [
                            'id' => 4,
                            'name' => 'React.js',
                            'icon' => 'fab fa-react',
                            'icon_class' => 'react',
                            'description' => 'Frontend Framework',
                            'color' => '#61dafb',
                            'active' => true,
                            'order' => 4
                        ],
                        [
                            'id' => 5,
                            'name' => 'Node.js',
                            'icon' => 'fab fa-node-js',
                            'icon_class' => 'node',
                            'description' => 'Backend Runtime',
                            'color' => '#68a063',
                            'active' => true,
                            'order' => 5
                        ],
                        [
                            'id' => 6,
                            'name' => 'PHP',
                            'icon' => 'fab fa-php',
                            'icon_class' => 'php',
                            'description' => 'Server Side',
                            'color' => '#777bb4',
                            'active' => true,
                            'order' => 6
                        ],
                        [
                            'id' => 7,
                            'name' => 'Laravel',
                            'icon' => 'fab fa-laravel',
                            'icon_class' => 'laravel',
                            'description' => 'PHP Framework',
                            'color' => '#ff2d20',
                            'active' => true,
                            'order' => 7
                        ],
                        [
                            'id' => 8,
                            'name' => 'Flutter',
                            'icon' => 'fab fa-flutter',
                            'icon_class' => 'flutter',
                            'description' => 'Mobile Cross-Platform',
                            'color' => '#02569b',
                            'active' => true,
                            'order' => 8
                        ]
                    ];
                @endphp
                
                @foreach($techStack as $tech)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $tech['icon_class'] }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $tech['icon_class'] }} me-2">{{ $tech['order'] }}</span>
                                {{ $tech['name'] }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="{{ $tech['icon'] }}"></i>
                                    </span>
                                    <select class="form-select" name="tech[{{ $tech['id'] }}][icon]" data-control="select2">
                                        <option value="fab fa-html5" {{ $tech['icon'] == 'fab fa-html5' ? 'selected' : '' }}>HTML5</option>
                                        <option value="fab fa-css3-alt" {{ $tech['icon'] == 'fab fa-css3-alt' ? 'selected' : '' }}>CSS3</option>
                                        <option value="fab fa-js-square" {{ $tech['icon'] == 'fab fa-js-square' ? 'selected' : '' }}>JavaScript</option>
                                        <option value="fab fa-react" {{ $tech['icon'] == 'fab fa-react' ? 'selected' : '' }}>React.js</option>
                                        <option value="fab fa-node-js" {{ $tech['icon'] == 'fab fa-node-js' ? 'selected' : '' }}>Node.js</option>
                                        <option value="fab fa-php" {{ $tech['icon'] == 'fab fa-php' ? 'selected' : '' }}>PHP</option>
                                        <option value="fab fa-laravel" {{ $tech['icon'] == 'fab fa-laravel' ? 'selected' : '' }}>Laravel</option>
                                        <option value="fab fa-flutter" {{ $tech['icon'] == 'fab fa-flutter' ? 'selected' : '' }}>Flutter</option>
                                        <option value="fab fa-vuejs">Vue.js</option>
                                        <option value="fab fa-angular">Angular</option>
                                        <option value="fab fa-python">Python</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Teknologi</label>
                                <input type="text" class="form-control" 
                                       name="tech[{{ $tech['id'] }}][name]" 
                                       value="{{ $tech['name'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi Singkat</label>
                                <input type="text" class="form-control" 
                                       name="tech[{{ $tech['id'] }}][description]" 
                                       value="{{ $tech['description'] }}"
                                       required />
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Warna Icon</label>
                                    <input type="color" class="form-control form-control-color" 
                                           name="tech[{{ $tech['id'] }}][color]" 
                                           value="{{ $tech['color'] }}" 
                                           title="Pilih warna icon" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="tech[{{ $tech['id'] }}][order]" 
                                           value="{{ $tech['order'] }}"
                                           min="1" max="20" required />
                                </div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" 
                                       name="tech[{{ $tech['id'] }}][active]" 
                                       value="1" 
                                       id="tech_{{ $tech['id'] }}_active" 
                                       {{ $tech['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="tech_{{ $tech['id'] }}_active">
                                    Tampilkan Teknologi
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Tech Stack List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Tech Stack</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                @foreach(array_slice($techStack, 0, 8) as $tech)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-5">
                                    <div class="tech-preview-item">
                                        <div class="tech-icon-preview mb-3" style="
                                            font-size: 3rem;
                                            color: {{ $tech['color'] }};
                                        ">
                                            <i class="{{ $tech['icon'] }}"></i>
                                        </div>
                                        <h5 class="fw-bold text-gray-800 mb-2">{{ $tech['name'] }}</h5>
                                        <p class="text-muted fs-7">{{ $tech['description'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan Tech Stack di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetStack()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveStack()">
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
    function saveStack() {
        const form = document.getElementById('stackForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Tech Stack berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetStack() {
        Swal.fire({
            title: "Reset Tech Stack?",
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
</script>
@endpush