@extends('admin.layouts.app')

@section('page-title', 'Service Categories')

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
        Service Categories
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Kategori Layanan</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveChangesModal">
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
                <h4 class="mb-1 text-info">Informasi Kategori Layanan</h4>
                <span>Kelola 5 kategori layanan yang ditampilkan di halaman Layanan. Kategori ini akan muncul sebagai tab yang dapat diklik oleh pengunjung.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::Form-->
        <form id="serviceCategoriesForm">
            @csrf
            
            <!--begin::Tab categories-->
            <div class="row">
                <!-- Category 1: Desain Grafis -->
                <div class="col-md-4 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-primary">
                            <h3 class="card-title text-gray-800">
                                <i class="bi bi-paint-bucket me-2"></i>
                                Kategori 1
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-icons"></i>
                                    </span>
                                    <select class="form-select form-select-solid" name="categories[1][icon]">
                                        <option value="bi-paint-brush" selected>Paint Brush</option>
                                        <option value="bi-palette">Palette</option>
                                        <option value="bi-brush">Brush</option>
                                        <option value="bi-pencil">Pencil</option>
                                        <option value="bi-pen">Pen</option>
                                        <option value="bi-easel">Easel</option>
                                        <option value="bi-images">Images</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Kategori</label>
                                <input type="text" class="form-control" 
                                       name="categories[1][name]" 
                                       value="Desain Grafis"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Data Attribute</label>
                                <input type="text" class="form-control" 
                                       name="categories[1][data_service]" 
                                       value="design"
                                       placeholder="data-service attribute" />
                                <div class="text-muted fs-7 mt-1">Untuk JavaScript filtering</div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="categories[1][active]" value="1" id="cat1_active" checked />
                                <label class="form-check-label" for="cat1_active">
                                    Aktifkan Kategori
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category 2: Percetakan -->
                <div class="col-md-4 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-success">
                            <h3 class="card-title text-gray-800">
                                <i class="bi bi-printer me-2"></i>
                                Kategori 2
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-printer"></i>
                                    </span>
                                    <select class="form-select form-select-solid" name="categories[2][icon]">
                                        <option value="bi-printer" selected>Printer</option>
                                        <option value="bi-printer-fill">Printer Fill</option>
                                        <option value="bi-file-earmark-text">File Text</option>
                                        <option value="bi-newspaper">Newspaper</option>
                                        <option value="bi-file-earmark-pdf">PDF File</option>
                                        <option value="bi-file-earmark">Document</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Kategori</label>
                                <input type="text" class="form-control" 
                                       name="categories[2][name]" 
                                       value="Percetakan"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Data Attribute</label>
                                <input type="text" class="form-control" 
                                       name="categories[2][data_service]" 
                                       value="printing"
                                       placeholder="data-service attribute" />
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="categories[2][active]" value="1" id="cat2_active" checked />
                                <label class="form-check-label" for="cat2_active">
                                    Aktifkan Kategori
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category 3: ATK & Perlengkapan -->
                <div class="col-md-4 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-warning">
                            <h3 class="card-title text-gray-800">
                                <i class="bi bi-pen me-2"></i>
                                Kategori 3
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-icons"></i>
                                    </span>
                                    <select class="form-select form-select-solid" name="categories[3][icon]">
                                        <option value="fas fa-pen-fancy" selected>Pen Fancy</option>
                                        <option value="fas fa-pen">Pen</option>
                                        <option value="fas fa-pencil">Pencil</option>
                                        <option value="fas fa-pencil-alt">Pencil Alt</option>
                                        <option value="fas fa-ruler">Ruler</option>
                                        <option value="fas fa-scissors">Scissors</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Kategori</label>
                                <input type="text" class="form-control" 
                                       name="categories[3][name]" 
                                       value="ATK & Perlengkapan"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Data Attribute</label>
                                <input type="text" class="form-control" 
                                       name="categories[3][data_service]" 
                                       value="atk"
                                       placeholder="data-service attribute" />
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="categories[3][active]" value="1" id="cat3_active" checked />
                                <label class="form-check-label" for="cat3_active">
                                    Aktifkan Kategori
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category 4: Sablon & Merchandise -->
                <div class="col-md-4 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-danger">
                            <h3 class="card-title text-gray-800">
                                <i class="bi bi-tshirt me-2"></i>
                                Kategori 4
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-icons"></i>
                                    </span>
                                    <select class="form-select form-select-solid" name="categories[4][icon]">
                                        <option value="fas fa-tshirt" selected>T-Shirt</option>
                                        <option value="fas fa-cup-straw">Cup Straw</option>
                                        <option value="fas fa-cup">Cup</option>
                                        <option value="fas fa-bag">Bag</option>
                                        <option value="fas fa-gift">Gift</option>
                                        <option value="fas fa-tag">Tag</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Kategori</label>
                                <input type="text" class="form-control" 
                                       name="categories[4][name]" 
                                       value="Sablon & Merchandise"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Data Attribute</label>
                                <input type="text" class="form-control" 
                                       name="categories[4][data_service]" 
                                       value="merchandise"
                                       placeholder="data-service attribute" />
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="categories[4][active]" value="1" id="cat4_active" checked />
                                <label class="form-check-label" for="cat4_active">
                                    Aktifkan Kategori
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category 5: Digital Printing -->
                <div class="col-md-4 mb-10">
                    <div class="card card-bordered h-100">
                        <div class="card-header bg-light-info">
                            <h3 class="card-title text-gray-800">
                                <i class="fas fa-laptop me-2"></i>
                                Kategori 5
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-icons"></i>
                                    </span>
                                    <select class="form-select form-select-solid" name="categories[5][icon]">
                                        <option value="fas fa-laptop-code" selected>Laptop Code</option>
                                        <option value="fas fa-printer">Printer</option>
                                        <option value="fas fa-code-slash">Code Slash</option>
                                        <option value="fas fa-display">Display</option>
                                        <option value="fas fa-tablet">Tablet</option>
                                        <option value="fas fa-phone">Phone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Nama Kategori</label>
                                <input type="text" class="form-control" 
                                       name="categories[5][name]" 
                                       value="Digital Printing"
                                       required />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Data Attribute</label>
                                <input type="text" class="form-control" 
                                       name="categories[5][data_service]" 
                                       value="digital"
                                       placeholder="data-service attribute" />
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="categories[5][active]" value="1" id="cat5_active" checked />
                                <label class="form-check-label" for="cat5_active">
                                    Aktifkan Kategori
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Tab categories-->
            
        </form>
        <!--end::Form-->
        
    </div>
    <!--end::Card body-->
    
    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="button" class="btn btn-light me-3" onclick="resetForm()">Reset</button>
        <button type="button" class="btn btn-primary" onclick="saveChanges()">
            <span class="indicator-label">Simpan Perubahan</span>
            <span class="indicator-progress">Mohon tunggu...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
</div>
<!--end::Card-->

<!--begin::Modal: Save Changes-->
<div class="modal fade" tabindex="-1" id="saveChangesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Simpan Perubahan</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menyimpan perubahan pada kategori layanan?</p>
                <div class="text-muted">Perubahan akan langsung diterapkan ke halaman Layanan.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="confirmSave()">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal: Save Changes-->
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
            minimumResultsForSearch: 5,
            placeholder: "Pilih icon"
        });
    });
    
    // Reset form
    function resetForm() {
        if (confirm('Reset semua perubahan? Data akan dikembalikan ke nilai awal.')) {
            document.getElementById('serviceCategoriesForm').reset();
            
            // Reset select2
            $('[data-control="select2"]').val(null).trigger('change');
            
            // Set default values back
            const defaultValues = {
                1: { icon: 'bi-paint-brush', name: 'Desain Grafis', data_service: 'design' },
                2: { icon: 'bi-printer', name: 'Percetakan', data_service: 'printing' },
                3: { icon: 'bi-pen-fancy', name: 'ATK & Perlengkapan', data_service: 'atk' },
                4: { icon: 'bi-tshirt', name: 'Sablon & Merchandise', data_service: 'merchandise' },
                5: { icon: 'bi-laptop-code', name: 'Digital Printing', data_service: 'digital' }
            };
            
            Object.keys(defaultValues).forEach(key => {
                $(`select[name="categories[${key}][icon]"]`).val(defaultValues[key].icon).trigger('change');
                $(`input[name="categories[${key}][name]"]`).val(defaultValues[key].name);
                $(`input[name="categories[${key}][data_service]"]`).val(defaultValues[key].data_service);
            });
            
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
    
    // Validate form
    function validateForm() {
        const form = document.getElementById('serviceCategoriesForm');
        let isValid = true;
        let errorMessage = '';
        
        // Check all category names
        for (let i = 1; i <= 5; i++) {
            const nameInput = form.querySelector(`input[name="categories[${i}][name]"]`);
            if (!nameInput.value.trim()) {
                isValid = false;
                errorMessage = `Nama kategori ${i} harus diisi`;
                nameInput.focus();
                break;
            }
            
            const iconSelect = form.querySelector(`select[name="categories[${i}][icon]"]`);
            if (!iconSelect.value) {
                isValid = false;
                errorMessage = `Icon kategori ${i} harus dipilih`;
                break;
            }
        }
        
        if (!isValid) {
            Swal.fire({
                text: errorMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
        
        return isValid;
    }
    
    // Show save modal
    function saveChanges() {
        if (validateForm()) {
            $('#saveChangesModal').modal('show');
        }
    }
    
    // Confirm save
    function confirmSave() {
        $('#saveChangesModal').modal('hide');
        
        // Show loading indicator
        const saveButton = document.querySelector('.btn-primary .indicator-label');
        const indicator = document.querySelector('.btn-primary .indicator-progress');
        saveButton.style.display = 'none';
        indicator.style.display = 'inline-flex';
        
        // Simulate API call
        setTimeout(() => {
            saveButton.style.display = 'inline';
            indicator.style.display = 'none';
            
            Swal.fire({
                text: "Kategori layanan berhasil diperbarui!",
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