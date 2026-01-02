@extends('admin.layouts.app')

@section('page-title', 'Process Section')
@section('page-description', 'Proses Pengerjaan — Ravaa Creative')

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
        Process Section
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Proses Pengerjaan</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="saveProcess()">
                    <i class="bi bi-save fs-2"></i> Simpan Perubahan
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
                <h4 class="mb-1 text-info">Informasi Proses Pengerjaan</h4>
                <span>Atur 4 langkah proses pengerjaan yang ditampilkan di halaman Layanan. Proses ini membantu klien memahami workflow kerja dengan kami.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="processForm">
            @csrf
            
            <!--begin::Section title-->
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
                                               value="Proses Pengerjaan"
                                               required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label required">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="section_description" 
                                                  rows="3"
                                                  required>Kami memiliki proses pengerjaan yang terstruktur untuk memastikan hasil terbaik dan kepuasan pelanggan.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Section title-->
            
            <!--begin::Process Steps-->
            <div class="row">
                
                <!-- Step 1 -->
                <div class="col-lg-3 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-primary">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-primary me-2">1</span>
                                Langkah 1
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-chat-left-dots"></i>
                                    </span>
                                    <select class="form-select" name="steps[1][icon]" data-control="select2">
                                        <option value="bi-chat-left-dots" selected>Chat Dots</option>
                                        <option value="bi-chat-left">Chat</option>
                                        <option value="bi-chat-left-text">Chat Text</option>
                                        <option value="bi-telephone">Telephone</option>
                                        <option value="bi-envelope">Envelope</option>
                                        <option value="bi-person">Person</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Langkah</label>
                                <input type="text" class="form-control" 
                                       name="steps[1][title]" 
                                       value="Konsultasi"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="steps[1][description]" 
                                          rows="3"
                                          required>Diskusikan kebutuhan dan konsep proyek Anda dengan tim kami untuk menentukan solusi terbaik.</textarea>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="steps[1][active]" value="1" id="step1_active" checked />
                                <label class="form-check-label" for="step1_active">
                                    Tampilkan Langkah
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="col-lg-3 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-success">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-success me-2">2</span>
                                Langkah 2
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </span>
                                    <select class="form-select" name="steps[2][icon]" data-control="select2">
                                        <option value="bi-file-earmark-text" selected>File Text</option>
                                        <option value="bi-file-earmark">File</option>
                                        <option value="bi-file-earmark-check">File Check</option>
                                        <option value="bi-clipboard">Clipboard</option>
                                        <option value="bi-clipboard-check">Clipboard Check</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Langkah</label>
                                <input type="text" class="form-control" 
                                       name="steps[2][title]" 
                                       value="Penawaran & Kontrak"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="steps[2][description]" 
                                          rows="3"
                                          required>Kami akan memberikan penawaran harga yang transparan dan perjanjian kerja yang jelas.</textarea>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="steps[2][active]" value="1" id="step2_active" checked />
                                <label class="form-check-label" for="step2_active">
                                    Tampilkan Langkah
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="col-lg-3 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-warning">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-warning me-2">3</span>
                                Langkah 3
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-gear"></i>
                                    </span>
                                    <select class="form-select" name="steps[3][icon]" data-control="select2">
                                        <option value="bi-gear" selected>Gear</option>
                                        <option value="bi-gear-wide">Gear Wide</option>
                                        <option value="bi-tools">Tools</option>
                                        <option value="bi-hammer">Hammer</option>
                                        <option value="bi-wrench">Wrench</option>
                                        <option value="bi-cpu">CPU</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Langkah</label>
                                <input type="text" class="form-control" 
                                       name="steps[3][title]" 
                                       value="Pengerjaan"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="steps[3][description]" 
                                          rows="3"
                                          required>Tim ahli kami akan mengerjakan proyek dengan standar kualitas tertinggi sesuai timeline.</textarea>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="steps[3][active]" value="1" id="step3_active" checked />
                                <label class="form-check-label" for="step3_active">
                                    Tampilkan Langkah
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="col-lg-3 col-md-6 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-danger">
                            <h3 class="card-title text-gray-800">
                                <span class="badge badge-danger me-2">4</span>
                                Langkah 4
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-truck"></i>
                                    </span>
                                    <select class="form-select" name="steps[4][icon]" data-control="select2">
                                        <option value="bi-truck" selected>Truck</option>
                                        <option value="bi-box-seam">Box Seam</option>
                                        <option value="bi-box">Box</option>
                                        <option value="bi-check-circle">Check Circle</option>
                                        <option value="bi-check-all">Check All</option>
                                        <option value="bi-check-square">Check Square</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Judul Langkah</label>
                                <input type="text" class="form-control" 
                                       name="steps[4][title]" 
                                       value="Pengiriman"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="steps[4][description]" 
                                          rows="3"
                                          required>Hasil akhir dikirimkan sesuai kesepakatan dengan jaminan kualitas dan ketepatan waktu.</textarea>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="steps[4][active]" value="1" id="step4_active" checked />
                                <label class="form-check-label" for="step4_active">
                                    Tampilkan Langkah
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!--end::Process Steps-->
            
            <!--begin::Preview Section-->
            <div class="row mt-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">Preview Proses Pengerjaan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <!-- Preview Step 1 -->
                                <div class="col-lg-3 col-md-6 mb-5">
                                    <div class="bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                        <i class="bi bi-chat-left-dots fs-2x text-primary"></i>
                                    </div>
                                    <div class="fw-bold text-gray-800 mb-2">Konsultasi</div>
                                    <p class="text-muted">Diskusikan kebutuhan dan konsep proyek Anda dengan tim kami untuk menentukan solusi terbaik.</p>
                                </div>
                                <!-- Preview Step 2 -->
                                <div class="col-lg-3 col-md-6 mb-5">
                                    <div class="bg-light-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                        <i class="bi bi-file-earmark-text fs-2x text-success"></i>
                                    </div>
                                    <div class="fw-bold text-gray-800 mb-2">Penawaran & Kontrak</div>
                                    <p class="text-muted">Kami akan memberikan penawaran harga yang transparan dan perjanjian kerja yang jelas.</p>
                                </div>
                                <!-- Preview Step 3 -->
                                <div class="col-lg-3 col-md-6 mb-5">
                                    <div class="bg-light-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                        <i class="bi bi-gear fs-2x text-warning"></i>
                                    </div>
                                    <div class="fw-bold text-gray-800 mb-2">Pengerjaan</div>
                                    <p class="text-muted">Tim ahli kami akan mengerjakan proyek dengan standar kualitas tertinggi sesuai timeline.</p>
                                </div>
                                <!-- Preview Step 4 -->
                                <div class="col-lg-3 col-md-6 mb-5">
                                    <div class="bg-light-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                        <i class="bi bi-truck fs-2x text-danger"></i>
                                    </div>
                                    <div class="fw-bold text-gray-800 mb-2">Pengiriman</div>
                                    <p class="text-muted">Hasil akhir dikirimkan sesuai kesepakatan dengan jaminan kualitas dan ketepatan waktu.</p>
                                </div>
                            </div>
                            <div class="text-muted fs-7 mt-3">Ini adalah tampilan proses pengerjaan di halaman Layanan.</div>
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

@push('styles')
<link href="{{ asset('admin/assets/plugins/custom/select2/select2.bundle.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('admin/assets/plugins/custom/select2/select2.bundle.js') }}"></script>
<script>
    // Initialize Select2
    $(document).ready(function() {
        $('[data-control="select2"]').select2({
            minimumResultsForSearch: 5
        });
    });
    
    // Update preview
    function updatePreview() {
        const steps = {
            1: { icon: 'chat-left-dots', title: 'Konsultasi', color: 'primary' },
            2: { icon: 'file-earmark-text', title: 'Penawaran & Kontrak', color: 'success' },
            3: { icon: 'gear', title: 'Pengerjaan', color: 'warning' },
            4: { icon: 'truck', title: 'Pengiriman', color: 'danger' }
        };
        
        Object.keys(steps).forEach(step => {
            const form = document.forms.processForm;
            const stepData = steps[step];
            
            // Get values from form
            const icon = form.querySelector(`select[name="steps[${step}][icon]"]`).value.replace('bi-', '');
            const title = form.querySelector(`input[name="steps[${step}][title]"]`).value;
            const description = form.querySelector(`textarea[name="steps[${step}][description]"]`).value;
            
            // Update preview
            const preview = document.querySelectorAll('.col-lg-3.col-md-6.mb-5')[step-1];
            if (preview) {
                preview.querySelector('i').className = `bi bi-${icon} fs-2x text-${stepData.color}`;
                preview.querySelector('.fw-bold').textContent = title;
                preview.querySelector('p').textContent = description;
                
                // Update icon color
                preview.querySelector('.rounded-circle').className = 
                    `bg-light-${stepData.color} rounded-circle d-inline-flex align-items-center justify-content-center mb-4`;
            }
        });
    }
    
    // Add event listeners for real-time preview
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('processForm');
        form.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        });
    });
    
    // Reset form
    function resetProcess() {
        if (confirm('Reset semua perubahan? Data akan dikembalikan ke nilai default.')) {
            document.getElementById('processForm').reset();
            
            // Reset select2
            $('[data-control="select2"]').val(null).trigger('change');
            
            // Set default values
            const defaultValues = {
                'section_title': 'Proses Pengerjaan',
                'section_description': 'Kami memiliki proses pengerjaan yang terstruktur untuk memastikan hasil terbaik dan kepuasan pelanggan.',
                1: { icon: 'bi-chat-left-dots', title: 'Konsultasi', description: 'Diskusikan kebutuhan dan konsep proyek Anda dengan tim kami untuk menentukan solusi terbaik.' },
                2: { icon: 'bi-file-earmark-text', title: 'Penawaran & Kontrak', description: 'Kami akan memberikan penawaran harga yang transparan dan perjanjian kerja yang jelas.' },
                3: { icon: 'bi-gear', title: 'Pengerjaan', description: 'Tim ahli kami akan mengerjakan proyek dengan standar kualitas tertinggi sesuai timeline.' },
                4: { icon: 'bi-truck', title: 'Pengiriman', description: 'Hasil akhir dikirimkan sesuai kesepakatan dengan jaminan kualitas dan ketepatan waktu.' }
            };
            
            // Apply defaults
            Object.keys(defaultValues).forEach(key => {
                if (typeof defaultValues[key] === 'object') {
                    $(`select[name="steps[${key}][icon]"]`).val(defaultValues[key].icon).trigger('change');
                    $(`input[name="steps[${key}][title]"]`).val(defaultValues[key].title);
                    $(`textarea[name="steps[${key}][description]"]`).val(defaultValues[key].description);
                } else {
                    const element = document.querySelector(`[name="${key}"]`);
                    if (element) element.value = defaultValues[key];
                }
            });
            
            // Update preview
            updatePreview();
            
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
    }
    
    // Save process
    function saveProcess() {
        const form = document.getElementById('processForm');
        
        // Validate
        let isValid = true;
        form.querySelectorAll('[required]').forEach(element => {
            if (!element.value.trim()) {
                isValid = false;
                element.focus();
                return false;
            }
        });
        
        if (!isValid) {
            Swal.fire({
                text: "Semua field yang wajib diisi harus terisi!",
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
        const saveButton = event.target;
        const indicatorLabel = saveButton.querySelector('.indicator-label');
        const indicatorProgress = saveButton.querySelector('.indicator-progress');
        
        indicatorLabel.style.display = 'none';
        indicatorProgress.style.display = 'inline-flex';
        saveButton.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            indicatorLabel.style.display = 'inline';
            indicatorProgress.style.display = 'none';
            saveButton.disabled = false;
            
            Swal.fire({
                text: "Proses pengerjaan berhasil disimpan!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }, 1500);
    }
</script>
@endpush