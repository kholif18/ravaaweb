@extends('admin.layouts.app')

@section('page-title', 'Portfolio Filter')
@section('page-description', 'Portfolio Filter — Ravaa Creative')

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
        Portfolio Filter
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Filter Portfolio</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-filter-circle fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Manajemen Filter Portfolio</h4>
                <span>Kelola kategori filter yang akan ditampilkan di halaman portfolio. Filter membantu pengunjung menemukan karya sesuai kategori yang diinginkan.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="filterForm">
            @csrf
            
            <!--begin::Filter List-->
            <div class="row">
                @php
                    $portfolioFilters = [
                        [
                            'id' => 1,
                            'name' => 'Semua Karya',
                            'icon' => 'bi-grid-3x3-gap',
                            'category' => 'all',
                            'active' => true,
                            'order' => 1
                        ],
                        [
                            'id' => 2,
                            'name' => 'Desain Logo',
                            'icon' => 'bi-palette',
                            'category' => 'logo',
                            'active' => true,
                            'order' => 2
                        ],
                        [
                            'id' => 3,
                            'name' => 'Branding',
                            'icon' => 'bi-brush',
                            'category' => 'branding',
                            'active' => true,
                            'order' => 3
                        ],
                        [
                            'id' => 4,
                            'name' => 'Percetakan',
                            'icon' => 'bi-printer',
                            'category' => 'printing',
                            'active' => true,
                            'order' => 4
                        ],
                        [
                            'id' => 5,
                            'name' => 'Merchandise',
                            'icon' => 'bi-tshirt',
                            'category' => 'merchandise',
                            'active' => true,
                            'order' => 5
                        ],
                        [
                            'id' => 6,
                            'name' => 'Packaging',
                            'icon' => 'bi-box',
                            'category' => 'packaging',
                            'active' => false,
                            'order' => 6
                        ]
                    ];
                @endphp
                
                @foreach($portfolioFilters as $filter)
                <div class="col-lg-4 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-{{ $filter['active'] ? 'success' : 'danger' }}">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-{{ $filter['active'] ? 'success' : 'danger' }} me-2">{{ $filter['order'] }}</span>
                                {{ $filter['name'] }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Nama Filter</label>
                                <input type="text" class="form-control" 
                                       name="filters[{{ $filter['id'] }}][name]" 
                                       value="{{ $filter['name'] }}"
                                       required />
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Icon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi {{ $filter['icon'] }}"></i>
                                        </span>
                                        <select class="form-select" name="filters[{{ $filter['id'] }}][icon]" data-control="select2">
                                            <option value="bi-grid-3x3-gap" {{ $filter['icon'] == 'bi-grid-3x3-gap' ? 'selected' : '' }}>Grid</option>
                                            <option value="bi-palette" {{ $filter['icon'] == 'bi-palette' ? 'selected' : '' }}>Palette</option>
                                            <option value="bi-brush" {{ $filter['icon'] == 'bi-brush' ? 'selected' : '' }}>Brush</option>
                                            <option value="bi-printer" {{ $filter['icon'] == 'bi-printer' ? 'selected' : '' }}>Printer</option>
                                            <option value="bi-tshirt" {{ $filter['icon'] == 'bi-tshirt' ? 'selected' : '' }}>T-Shirt</option>
                                            <option value="bi-box" {{ $filter['icon'] == 'bi-box' ? 'selected' : '' }}>Box</option>
                                            <option value="bi-image" {{ $filter['icon'] == 'bi-image' ? 'selected' : '' }}>Image</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Urutan</label>
                                    <input type="number" class="form-control" 
                                           name="filters[{{ $filter['id'] }}][order]" 
                                           value="{{ $filter['order'] }}"
                                           min="1" max="10" required />
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Kategori (ID)</label>
                                <input type="text" class="form-control" 
                                       name="filters[{{ $filter['id'] }}][category]" 
                                       value="{{ $filter['category'] }}"
                                       placeholder="Contoh: logo, branding, dll"
                                       required />
                            </div>
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" 
                                       name="filters[{{ $filter['id'] }}][active]" 
                                       value="1" 
                                       id="filter_{{ $filter['id'] }}_active" 
                                       {{ $filter['active'] ? 'checked' : '' }} />
                                <label class="form-check-label" for="filter_{{ $filter['id'] }}_active">
                                    Tampilkan Filter
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Filter List-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Filter Portfolio</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                @foreach($portfolioFilters as $filter)
                                @if($filter['active'])
                                <div class="position-relative">
                                    <button type="button" class="btn btn-light-primary d-flex align-items-center px-4 py-3">
                                        <i class="bi {{ $filter['icon'] }} me-2"></i>
                                        {{ $filter['name'] }}
                                    </button>
                                    @if($filter['category'] == 'all')
                                    <span class="position-absolute top-0 start-100 translate-middle badge badge-primary" style="font-size: 0.6rem;">
                                        default
                                    </span>
                                    @endif
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <div class="text-muted fs-7">Ini adalah tampilan filter portfolio di halaman Portfolio. Filter "Semua Karya" akan aktif secara default.</div>
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
        <button type="button" class="btn btn-light me-3" onclick="resetFilter()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveFilter()">
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
    function saveFilter() {
        const form = document.getElementById('filterForm');
        const submitButton = form.querySelector('.btn-primary');
        
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        
        setTimeout(function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
            
            Swal.fire({
                text: "Filter berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
    
    function resetFilter() {
        Swal.fire({
            title: "Reset Filter?",
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