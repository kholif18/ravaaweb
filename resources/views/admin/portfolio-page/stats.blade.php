@extends('admin.layouts.app')

@section('page-title', 'Stats Counter')

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
        Stats Counter
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Stats Counter</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
            <i class="bi bi-bar-chart fs-2hx text-primary me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-primary">Manajemen Stats Counter</h4>
                <span>Kelola statistik yang akan ditampilkan di halaman portfolio. Statistik membantu menunjukkan pencapaian dan pengalaman perusahaan.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="statsForm">
            @csrf
            
            <!--begin::Stats List-->
            <div class="row">
                @php
                    $stats = [
                        [
                            'id' => 1,
                            'title' => 'Proyek Selesai',
                            'value' => 250,
                            'suffix' => '+',
                            'icon' => 'bi-diagram-3',
                            'icon_color' => 'primary',
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'title' => 'Klien Puas',
                            'value' => 150,
                            'suffix' => '+',
                            'icon' => 'bi-people',
                            'icon_color' => 'success',
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'title' => 'Tingkat Kepuasan',
                            'value' => 98,
                            'suffix' => '%',
                            'icon' => 'bi-award',
                            'icon_color' => 'warning',
                            'active' => true,
                            'order' => 3
                        ],
                        [
                            'id' => 4,
                            'title' => 'Pengalaman',
                            'value' => 5,
                            'suffix' => ' Tahun',
                            'icon' => 'bi-clock-history',
                            'icon_color' => 'danger',
                            'active' => false,
                            'order' => 4
                        ]
                    ];
                @endphp
                
                @foreach($stats as $stat)
                <div class="col-lg-3 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $stat['icon_color'] }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $stat['icon_color'] }} me-2">{{ $stat['order'] }}</span>
                                Stat {{ $loop->iteration }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Judul Statistik</label>
                                <input type="text" class="form-control" 
                                       name="stats[{{ $stat['id'] }}][title]" 
                                       value="{{ $stat['title'] }}"
                                       required />
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Nilai</label>
                                    <input type="number" class="form-control" 
                                           name="stats[{{ $stat['id'] }}][value]" 
                                           value="{{ $stat['value'] }}"
                                           min="0" max="9999" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Suffix</label>
                                    <input type="text" class="form-control" 
                                           name="stats[{{ $stat['id'] }}][suffix]" 
                                           value="{{ $stat['suffix'] }}"
                                           placeholder="Contoh: +, %, Tahun"
                                           required />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Icon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi {{ $stat['icon'] }}"></i>
                                        </span>
                                        <select class="form-select" name="stats[{{ $stat['id'] }}][icon]" data-control="select2">
                                            <option value="bi-diagram-3" {{ $stat['icon'] == 'bi-diagram-3' ? 'selected' : '' }}>Diagram</option>
                                            <option value="bi-people" {{ $stat['icon'] == 'bi-people' ? 'selected' : '' }}>People</option>
                                            <option value="bi-award" {{ $stat['icon'] == 'bi-award' ? 'selected' : '' }}>Award</option>
                                            <option value="bi-clock-history" {{ $stat['icon'] == 'bi-clock-history' ? 'selected' : '' }}>Clock</option>
                                            <option value="bi-star" {{ $stat['icon'] == 'bi-star' ? 'selected' : '' }}>Star</option>
                                            <option value="bi-check-circle" {{ $stat['icon'] == 'bi-check-circle' ? 'selected' : '' }}>Check Circle</option>
                                            <option value="bi-trophy" {{ $stat['icon'] == 'bi-trophy' ? 'selected' : '' }}>Trophy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Warna Icon</label>
                                    <select class="form-select" name="stats[{{ $stat['id'] }}][icon_color]" data-control="select2">
                                        <option value="primary" {{ $stat['icon_color'] == 'primary' ? 'selected' : '' }}>Primary (Biru)</option>
                                        <option value="success" {{ $stat['icon_color'] == 'success' ? 'selected' : '' }}>Success (Hijau)</option>
                                        <option value="warning" {{ $stat['icon_color'] == 'warning' ? 'selected' : '' }}>Warning (Kuning)</option>
                                        <option value="danger" {{ $stat['icon_color'] == 'danger' ? 'selected' : '' }}>Danger (Merah)</option>
                                        <option value="info" {{ $stat['icon_color'] == 'info' ? 'selected' : '' }}>Info (Biru Muda)</option>
                                        <option value="dark" {{ $stat['icon_color'] == 'dark' ? 'selected' : '' }}>Dark (Gelap)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="stats[{{ $stat['id'] }}][order]" 
                                           value="{{ $stat['order'] }}"
                                           min="1" max="10" required />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid mt-8">
                                        <input class="form-check-input" type="checkbox" 
                                               name="stats[{{ $stat['id'] }}][active]" 
                                               value="1" 
                                               id="stat_{{ $stat['id'] }}_active" 
                                               {{ $stat['active'] ? 'checked' : '' }} />
                                        <label class="form-check-label" for="stat_{{ $stat['id'] }}_active">
                                            Tampilkan Statistik
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Stats List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Stats Counter</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                @foreach($stats as $stat)
                                @if($stat['active'])
                                <div class="col-lg-3 col-md-6 mb-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="bg-light-{{ $stat['icon_color'] }} rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                                             style="width: 80px; height: 80px;">
                                            <i class="bi {{ $stat['icon'] }} fs-2x text-{{ $stat['icon_color'] }}"></i>
                                        </div>
                                        <div class="fs-1 fw-bold text-gray-800 mb-2">
                                            {{ $stat['value'] }}<span class="text-{{ $stat['icon_color'] }}">{{ $stat['suffix'] }}</span>
                                        </div>
                                        <div class="fw-semibold text-gray-600">{{ $stat['title'] }}</div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <div class="text-muted fs-7 mt-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Statistik akan ditampilkan dengan animasi counter di halaman Portfolio.
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
        <button type="button" class="btn btn-light me-3" onclick="resetStats()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveStats()">
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
    function saveStats() {
        const form = document.getElementById('statsForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Statistik berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetStats() {
        Swal.fire({
            title: "Reset Statistik?",
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