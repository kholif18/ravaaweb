@extends('admin.layouts.app')

@section('page-title', 'Development Process')

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
        Development Process
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Proses Pengembangan</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-diagram-3 fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Proses Pengembangan</h4>
                <span>Kelola langkah-langkah proses pengembangan software yang akan ditampilkan di halaman Software House.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="processForm">
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
                                               value="Proses Pengembangan"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_description" 
                                                  rows="3"
                                                  required>Kami mengikuti proses pengembangan yang terstruktur untuk memastikan kualitas dan ketepatan waktu.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section Title-->
            
            <!--begin::Process Steps-->
            <div class="row">
                @php
                    $processSteps = [
                        [
                            'id' => 1,
                            'title' => 'Konsultasi & Analisis',
                            'description' => 'Diskusi kebutuhan, analisis requirement, dan perencanaan proyek.',
                            'number' => '1',
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'title' => 'UI/UX Design',
                            'description' => 'Mendesain user interface dan experience yang optimal.',
                            'number' => '2',
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'title' => 'Development',
                            'description' => 'Pengembangan kode dengan teknologi terbaru dan best practices.',
                            'number' => '3',
                            'active' => true,
                            'order' => 3
                        ],
                        [
                            'id' => 4,
                            'title' => 'Testing & QA',
                            'description' => 'Pengujian menyeluruh untuk memastikan kualitas software.',
                            'number' => '4',
                            'active' => true,
                            'order' => 4
                        ],
                        [
                            'id' => 5,
                            'title' => 'Deployment & Support',
                            'description' => 'Peluncuran dan dukungan pasca-launch untuk maintenance.',
                            'number' => '5',
                            'active' => true,
                            'order' => 5
                        ]
                    ];
                @endphp
                
                @foreach($processSteps as $step)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-primary">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-primary me-2">{{ $step['order'] }}</span>
                                Step {{ $step['number'] }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Nomor Step</label>
                                <input type="number" class="form-control" 
                                       name="steps[{{ $step['id'] }}][number]" 
                                       value="{{ $step['number'] }}"
                                       min="1" max="10" required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Step</label>
                                <input type="text" class="form-control" 
                                       name="steps[{{ $step['id'] }}][title]" 
                                       value="{{ $step['title'] }}"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="steps[{{ $step['id'] }}][description]" 
                                          rows="3"
                                          required>{{ $step['description'] }}</textarea>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="steps[{{ $step['id'] }}][order]" 
                                           value="{{ $step['order'] }}"
                                           min="1" max="10" required />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid mt-8">
                                        <input class="form-check-input" type="checkbox" 
                                               name="steps[{{ $step['id'] }}][active]" 
                                               value="1" 
                                               id="step_{{ $step['id'] }}_active" 
                                               {{ $step['active'] ? 'checked' : '' }} />
                                        <label class="form-check-label" for="step_{{ $step['id'] }}_active">
                                            Tampilkan Step
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Process Steps-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Proses Pengembangan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                @foreach(array_slice($processSteps, 0, 3) as $step)
                                <div class="col-lg-4 col-md-6 mb-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="step-number-preview mb-4" style="
                                            width: 60px;
                                            height: 60px;
                                            background-color: #667eea;
                                            color: white;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 1.5rem;
                                            font-weight: bold;
                                        ">{{ $step['number'] }}</div>
                                        <h5 class="fw-bold text-gray-800 mb-3">{{ $step['title'] }}</h5>
                                        <p class="text-muted">{{ $step['description'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah preview 3 langkah proses pengembangan yang akan ditampilkan di halaman Software House.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetProcess()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveProcess()">
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
    function saveProcess() {
        const form = document.getElementById('processForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Proses Pengembangan berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetProcess() {
        Swal.fire({
            title: "Reset Proses Pengembangan?",
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