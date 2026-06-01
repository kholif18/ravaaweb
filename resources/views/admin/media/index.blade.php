@extends('admin.layouts.app')

@section('page-title', 'Media Gallery')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
            Dashboard
        </a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Media Gallery</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Media Gallery</h3>
        <div class="card-toolbar">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload"></i> Upload Media
            </button>
        </div>
    </div>
    
    <div class="card-body">
        @if(($mode ?? 'manager') !== 'picker')
        <!-- Filters -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6 d-flex align-items-center gap-3">
                <!-- Select All -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAllMedia">
                    <label class="form-check-label fw-semibold" for="selectAllMedia">
                        Pilih Semua
                    </label>
                </div>

                <!-- Delete Selected -->
                <button id="btnDeleteSelected" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Hapus Terpilih
                </button>

                <button id="btnDownloadSelected" class="btn btn-success">
                    <i class="bi bi-download"></i> Download Terpilih
                </button>
            </div>

            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Cari media..." id="searchInput">
            </div>
            <div class="col-md-2">
                <button class="btn btn-light w-100" id="clearFilters">
                    <i class="bi bi-x-circle"></i> Clear
                </button>
            </div>
        </div>
        @endif

        <!-- Info jika belum ada media -->
        @if(!isset($media) || $media->isEmpty())
        <div class="text-center py-10">
            <i class="bi bi-images fs-4hx text-gray-400 mb-5"></i>
            <h3 class="text-gray-600">Belum Ada Media</h3>
            <p class="text-muted">Upload gambar pertama Anda untuk mulai menggunakan media gallery.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload"></i> Upload Media Pertama
            </button>
        </div>
        @else
        <!-- Media Grid -->
        <div class="row" id="mediaGrid">
            @foreach($media as $item)
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-4 media-item"
                data-id="{{ $item->id }}"
                data-name="{{ strtolower($item->name ?? '') }}"
                data-extension="{{ strtolower($item->extension ?? '') }}"
                data-date="{{ optional($item->created_at)->format('Y-m-d') }}">
                <div class="card card-bordered h-100">
                    <div class="card-body p-2 text-center">
                        <div class="position-relative mb-2 media-thumb">
                            <!-- Thumbnail Image -->
                            <img src="{{ $item->thumbnail_url ?? $item->url }}"
                                class="img-fluid rounded h-100 w-100 object-fit-cover"
                                alt="{{ $item->alt_text ?? $item->name }}"
                                loading="lazy"
                                onerror="this.src='{{ asset('images/default-image.png') }}'">

                            <!-- Selection checkbox -->                         
                            @if(($mode ?? 'manager') !== 'picker')
                                <div class="position-absolute top-0 start-0 m-2">
                                    <input type="checkbox" class="form-check-input media-checkbox" value="{{ $item->id }}">
                                </div>
                            @endif

                            <!-- Usage badge -->
                            @if(isset($item->usage_count) && $item->usage_count > 0)
                            <span class="position-absolute top-0 end-0 m-2 badge bg-info">
                                {{ $item->usage_count }}
                            </span>
                            @endif
                            
                            <!-- Type badge -->
                            <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                                {{ strtoupper($item->extension ?? 'jpg') }}
                            </span>
                        </div>
                        
                        <div class="d-flex flex-column text-start">
                            <!-- File name -->
                            <div class="mb-1">
                                <small class="text-dark fw-semibold text-truncate d-block" 
                                       title="{{ $item->name ?? '' }}" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top">
                                    {{ isset($item->name) ? Str::limit($item->name, 25) : 'Unknown' }}
                                </small>
                            </div>
                            
                            <!-- File info -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-file-earmark-text me-1"></i>
                                    {{ $item->formatted_size ?? '0 KB' }}
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ optional($item->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                            
                            <div class="d-flex gap-2 mt-auto">

                            {{-- TOMBOL PILIH (hanya muncul di picker) --}}
                            @if(($mode ?? 'manager') === 'picker')
                                <button class="btn btn-primary btn-sm w-100 btn-select-media"
                                        data-media-id="{{ $item->id }}"
                                        data-media-url="{{ $item->url }}"
                                        data-media-name="{{ $item->name }}">
                                    <i class="bi bi-check-circle me-1"></i> Pilih
                                </button>

                            {{-- MODE MANAGER (media library normal) --}}
                            @else
                                <div class="d-flex gap-1 w-100 mt-2">

                                    <a href="{{ route('admin.media.download', $item->id) }}"
                                    class="btn btn-sm btn-light flex-fill"
                                    title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    <button type="button"
                                        class="btn btn-sm btn-light flex-fill"
                                        onclick="copyUrl('{{ $item->url }}')"
                                        title="Copy URL">
                                        <i class="bi bi-link"></i>
                                    </button>

                                    <a href="{{ $item->url }}"
                                    target="_blank"
                                    class="btn btn-sm btn-light flex-fill"
                                    title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <button type="button"
                                        class="btn btn-sm btn-danger flex-fill"
                                        onclick="deleteMedia({{ $item->id }}, '{{ $item->name }}')"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            @endif

                        </div>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if(method_exists($media, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $media->links('vendor.pagination.custom') }}
        </div>
        @endif
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-cloud-upload me-2"></i>Upload Media
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <!-- File Selection - HAPUS required dari input -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih Gambar</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-fill">
                                <input type="file" 
                                       class="form-control" 
                                       name="files[]" 
                                       id="fileInput" 
                                       multiple 
                                       accept="image/*">
                                       <!-- ⬆️ HAPUS required -->
                            </div>
                            <button type="button" class="btn btn-light" id="browseFiles">
                                <i class="bi bi-folder2-open"></i>
                            </button>
                        </div>
                        <div class="form-text">
                            Max 5MB per file. Format yang didukung: JPG, PNG, GIF, WebP, SVG
                        </div>
                    </div>

                    <!-- Warning jika belum pilih file -->
                    <div id="noFileWarning" class="alert alert-warning d-none mb-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Pilih minimal 1 file gambar untuk diupload.
                    </div>

                    <!-- File Info -->
                    <div id="fileInfo" class="alert alert-light d-none mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <i class="bi bi-info-circle me-2"></i>
                                <span id="fileCount">0 file</span>
                            </div>
                            <div>
                                <span id="totalSize" class="badge bg-primary">0 MB</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div id="sizeProgress" 
                                 class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Preview Container -->
                    <div id="previewContainer" class="d-none mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="bi bi-images me-2"></i>Preview Gambar
                                <span class="badge bg-primary ms-2" id="previewCount">0</span>
                            </h6>
                            <button type="button" class="btn btn-sm btn-light" id="clearAll">
                                <i class="bi bi-trash me-1"></i>Hapus Semua
                            </button>
                        </div>
                        <div id="imagePreviews" class="row g-3"></div>
                    </div>

                    <!-- Upload Progress -->
                    <div id="uploadProgress" class="d-none">
                        <div class="alert alert-info mb-3">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border spinner-border-sm me-2"></div>
                                <span id="uploadStatus">Menyiapkan upload...</span>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 20px;">
                            <div id="uploadProgressBar" 
                                 class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" 
                                 style="width: 0%">
                                <span id="progressText">0%</span>
                            </div>
                        </div>
                        <div id="uploadDetails" class="text-center small text-muted">
                            <span id="currentFile">-</span>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelBtn">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="uploadButton">
                        <i class="bi bi-upload me-1"></i>Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.media-item {
    transition: transform 0.2s, box-shadow 0.2s;
}
.media-item:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.media-checkbox:checked {
    background-color: #009ef7;
    border-color: #009ef7;
}
.card-bordered {
    border: 1px solid #e4e6ef;
    transition: border-color 0.2s;
}
.card-bordered:hover {
    border-color: #009ef7;
}
.object-fit-cover {
    object-fit: cover;
}

.media-thumb {
    height: 180px;
    overflow: hidden;   /* tetap untuk crop gambar */
}

.media-item.selected .media-thumb img {
    filter: brightness(0.7);
}

.media-item.selected .media-thumb::after {
    content: "✓";
    position: absolute;
    inset: 0;
    background: rgba(13,110,253,.35);
    color: white;
    font-size: 48px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

/* Preview image styles */
.preview-image {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
    border: 1px solid #e4e6ef;
    transition: all 0.2s;
}
.preview-image:hover {
    transform: scale(1.02);
    border-color: #009ef7;
}
.preview-image img {
    height: 120px;
    object-fit: cover;
}
.preview-info {
    padding: 8px;
    background: white;
    border-top: 1px solid #e4e6ef;
}
.preview-info small {
    font-size: 11px;
}
.remove-preview {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.remove-preview:hover {
    background: #ff6b6b;
    color: white;
    border-color: #ff6b6b;
}

/* Custom scrollbar */
#imagePreviews {
    max-height: 400px;
    overflow-y: auto;
}
#imagePreviews::-webkit-scrollbar {
    width: 6px;
}
#imagePreviews::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}
#imagePreviews::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}
#imagePreviews::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Tambahkan ke styles section */
#noFileWarning {
    animation: pulseWarning 2s infinite;
}

@keyframes pulseWarning {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.preview-image.border-danger {
    border-width: 2px !important;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
    20%, 40%, 60%, 80% { transform: translateX(2px); }
}

.upload-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Style untuk file yang terlalu besar */
.preview-image .text-danger {
    font-weight: bold;
}

.card,
.media-item {
    overflow: visible !important;
}

.dropdown-menu {
    z-index: 1055; /* lebih tinggi dari card grid */
}
</style>
@endpush

@push('scripts')
<script>
    window.MEDIA_MODE = "{{ $mode ?? 'manager' }}";
// Toast notification system
function showToast(type, message, title = '') {
    const toastId = 'toast-' + Date.now();
    const icons = {
        'success': 'bi-check-circle-fill text-success',
        'error': 'bi-x-circle-fill text-danger',
        'warning': 'bi-exclamation-triangle-fill text-warning',
        'info': 'bi-info-circle-fill text-info'
    };
    
    const colors = {
        'success': 'border-success',
        'error': 'border-danger',
        'warning': 'border-warning',
        'info': 'border-info'
    };
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center border ${colors[type] || 'border-info'}" 
             role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${icons[type] || 'bi-info-circle-fill text-info'} me-2"></i>
                    <strong>${title || type.charAt(0).toUpperCase() + type.slice(1)}:</strong> ${message}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        delay: 5000,
        autohide: true
    });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}

// Initialize tooltips
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Copy URL to clipboard
function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        showToast('success', 'URL berhasil disalin ke clipboard');
    }).catch(err => {
        showToast('error', 'Gagal menyalin URL');
        console.error('Copy failed:', err);
    });
}

// Delete media
function deleteMedia(id, name) {
    Swal.fire({
        title: 'Hapus Media?',
        html: `Media <strong>"${name}"</strong> akan dihapus permanen.`,
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/media/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    Swal.showLoading();
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: response.message || 'Media berhasil dihapus.',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });
                    $(`.media-item[data-id="${id}"]`).fadeOut(300, function() {
                        $(this).remove();
                        if ($('.media-item').length === 0) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus';
                    Swal.fire('Error!', message, 'error');
                }
            });
        }
    });
}

// Filter media
function filterMedia() {
    const search = $('#searchInput').val().toLowerCase().trim();
    const extension = $('#filterExtension').val();
    
    $('.media-item').each(function() {
        const name = $(this).data('name');
        const itemExtension = $(this).data('extension');
        
        let match = true;
        
        if (search) {
            match = match && name.includes(search);
        }
        
        if (extension && extension !== 'all') {
            match = match && itemExtension === extension;
        }
        
        $(this).toggle(match);
    });
}

// File Preview System
let selectedFiles = [];

// Perbaikan updateFileInfo
function updateFileInfo() {
    const totalFiles = selectedFiles.length;
    const maxSize = 5 * 1024 * 1024; // 5MB
    let totalSize = 0;
    let validFiles = 0;
    let invalidFilesCount = 0;
    
    // Reset semua preview border
    $('.preview-image').removeClass('border border-danger');
    
    selectedFiles.forEach((file, index) => {
        if (file.size <= maxSize) {
            totalSize += file.size;
            validFiles++;
        } else {
            invalidFilesCount++;
            // Tandai preview yang invalid
            $(`#preview-${index} .preview-image`).addClass('border border-danger');
        }
    });
    
    const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
    const sizePercentage = Math.min((totalSize / (maxSize * 10)) * 100, 100);
    
    // Update preview count
    $('#previewCount').text(totalFiles);
    
    // Update info display
    if (totalFiles > 0) {
        let countText = `${validFiles} file valid`;
        if (invalidFilesCount > 0) {
            countText += ` (${invalidFilesCount} file terlalu besar)`;
        }
        
        $('#fileCount').text(countText);
        $('#totalSize').text(`${totalSizeMB} MB`);
        $('#sizeProgress').css('width', `${sizePercentage}%`);
        
        if (invalidFilesCount > 0) {
            $('#fileInfo').removeClass('alert-light').addClass('alert-warning');
        } else {
            $('#fileInfo').removeClass('alert-warning').addClass('alert-light');
        }
        
        $('#fileInfo').removeClass('d-none');
        $('#previewContainer').removeClass('d-none');
        $('#noFileWarning').addClass('d-none');
    } else {
        $('#fileInfo').addClass('d-none');
        $('#previewContainer').addClass('d-none');
    }
}

// Perbaikan fungsi untuk menampilkan preview
async function updatePreviews() {
    const container = $('#imagePreviews');
    container.empty();
    
    if (selectedFiles.length === 0) {
        return;
    }
    
    const maxSize = 5 * 1024 * 1024;
    
    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];
        const isInvalid = file.size > maxSize;
        const previewHTML = await createPreview(file, i, isInvalid);
        container.append(previewHTML);
    }
    
    // Add event listeners to remove buttons
    $('.remove-preview').on('click', function() {
        const index = $(this).data('index');
        selectedFiles.splice(index, 1);
        updatePreviews();
        updateFileInfo();
    });
}

// Perbaikan createPreview untuk menampilkan warning size
function createPreview(file, index, isInvalid = false) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const fileSize = (file.size / 1024).toFixed(1);
            const fileName = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
            const maxSizeMB = (5 * 1024 * 1024) / (1024 * 1024); // 5MB dalam MB
            
            let sizeClass = '';
            let sizeText = `${fileSize} KB`;
            
            if (isInvalid) {
                sizeClass = 'text-danger';
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(1);
                sizeText = `${fileSizeMB} MB (Max ${maxSizeMB}MB)`;
            }
            
            const previewHTML = `
                <div class="col-6 col-md-4 col-lg-3" id="preview-${index}">
                    <div class="preview-image ${isInvalid ? 'border border-danger' : ''}">
                        <img src="${e.target.result}" class="w-100" alt="Preview" style="height: 100px;">
                        <button type="button" class="remove-preview" data-index="${index}">
                            <i class="bi bi-x"></i>
                        </button>
                        <div class="preview-info">
                            <small class="d-block text-truncate">${fileName}</small>
                            <small class="text-muted ${sizeClass}">
                                ${sizeText} • ${file.type.split('/')[1] || 'image'}
                            </small>
                            ${isInvalid ? '<small class="text-danger d-block"><i class="bi bi-exclamation-triangle"></i> File terlalu besar</small>' : ''}
                        </div>
                    </div>
                </div>
            `;
            
            resolve(previewHTML);
        };
        reader.readAsDataURL(file);
    });
}

// File input change handler - PERBAIKAN
$('#fileInput').on('change', async function(e) {
    const files = Array.from(e.target.files);
    const maxSize = 5 * 1024 * 1024;
    
    if (files.length === 0) {
        showToast('warning', 'Tidak ada file yang dipilih');
        return;
    }
    
    // Filter out files that are too large
    const validFiles = files.filter(file => file.size <= maxSize);
    const invalidFiles = files.filter(file => file.size > maxSize);
    
    // Show warning for invalid files
    if (invalidFiles.length > 0) {
        const names = invalidFiles.slice(0, 3).map(f => f.name).join(', ');
        const message = invalidFiles.length > 3 ? 
            `${names} dan ${invalidFiles.length - 3} file lainnya terlalu besar (max 5MB)` :
            `${names} terlalu besar (max 5MB)`;
        showToast('warning', message, 'File Terlalu Besar');
    }
    
    // Add valid files to selection
    selectedFiles.push(...validFiles);
    
    // Add invalid files dengan warning
    selectedFiles.push(...invalidFiles);
    
    // Remove duplicates by name and size
    selectedFiles = selectedFiles.filter((file, index, self) =>
        index === self.findIndex(f => 
            f.name === file.name && 
            f.size === file.size &&
            f.lastModified === file.lastModified
        )
    );
    
    // Update UI
    await updatePreviews();
    updateFileInfo();
    
    // Reset file input (boleh kosong sekarang)
    $(this).val('');
    
    // Sembunyikan warning no file
    $('#noFileWarning').addClass('d-none');
});

// Reset modal handler
$('#uploadModal').on('hidden.bs.modal', function() {
    selectedFiles = [];
    $('#uploadForm')[0].reset();
    $('#imagePreviews').empty();
    $('#fileInfo').addClass('d-none');
    $('#previewContainer').addClass('d-none');
    $('#uploadProgress').addClass('d-none');
    $('#noFileWarning').addClass('d-none');
    $('#uploadButton').prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Upload');
    $('#cancelBtn').prop('disabled', false);
});

// Saat modal dibuka, focus ke file input
$('#uploadModal').on('shown.bs.modal', function() {
    $('#fileInput').focus();
});

// Clear all files
$('#clearAll').on('click', function() {
    selectedFiles = [];
    $('#imagePreviews').empty();
    $('#fileInfo').addClass('d-none');
    $('#previewContainer').addClass('d-none');
});

// Browse files button
$('#browseFiles').on('click', function() {
    $('#fileInput').click();
});

// Clear filters
$('#clearFilters').on('click', function() {
    $('#searchInput').val('');
    filterMedia();
});

// Search input handler
$('#searchInput').on('input', filterMedia);

// Upload form handler
$('#uploadForm').on('submit', function(e) {
    e.preventDefault();
    
    // Validasi manual: pastikan ada file yang dipilih
    if (selectedFiles.length === 0) {
        $('#noFileWarning').removeClass('d-none');
        $('#previewContainer').addClass('d-none');
        $('#noFileWarning')[0].scrollIntoView({ behavior: 'smooth' });
        showToast('error', 'Pilih minimal 1 file gambar untuk diupload');
        return;
    }
    
    // Validate files
    const maxSize = 5 * 1024 * 1024;
    const invalidFiles = selectedFiles.filter(file => file.size > maxSize);
    
    if (invalidFiles.length > 0) {
        showToast('error', 'Beberapa file terlalu besar. Maksimal 5MB per file');
        invalidFiles.forEach((file, index) => {
            $(`#preview-${selectedFiles.indexOf(file)}`).addClass('border border-danger');
        });
        return;
    }
    
    // Prepare UI for upload
    const $uploadProgress = $('#uploadProgress');
    const $uploadStatus = $('#uploadStatus');
    const $uploadButton = $('#uploadButton');
    const $progressBar = $('#uploadProgressBar');
    const $progressText = $('#progressText');
    const $currentFile = $('#currentFile');
    const $cancelBtn = $('#cancelBtn');
    
    $uploadProgress.removeClass('d-none');
    $uploadButton.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Uploading...');
    $cancelBtn.prop('disabled', true);
    $('#noFileWarning').addClass('d-none');
    
    // Create FormData
    const formData = new FormData();
    
    // Tambahkan CSRF token dari meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', csrfToken);
    
    // Upload files dengan index yang benar
    selectedFiles.forEach((file, index) => {
        formData.append(`files[${index}]`, file);
    });
    
    // Gunakan jQuery AJAX dengan progress tracking
    $.ajax({
        url: '{{ route("admin.media.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        xhr: function() {
            const xhr = new window.XMLHttpRequest();
            
            // Track upload progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    $progressBar.css('width', percent + '%');
                    $progressText.text(percent + '%');
                    
                    // Update current file being uploaded
                    if (percent < 100) {
                        const currentIndex = Math.floor((e.loaded / e.total) * selectedFiles.length);
                        if (currentIndex < selectedFiles.length) {
                            $currentFile.text(`Uploading: ${selectedFiles[currentIndex].name}`);
                        }
                    }
                }
            });
            
            return xhr;
        },
        beforeSend: function() {
            $uploadStatus.text('Mengupload ' + selectedFiles.length + ' file...');
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message, 'Upload Berhasil!');
                
                // Reset form and close modal
                $('#uploadForm')[0].reset();
                selectedFiles = [];
                $uploadProgress.addClass('d-none');
                $('#uploadModal').modal('hide');
                
                // Reload page after delay
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                let errorMessage = response.message || 'Upload gagal';
                if (response.errors && response.errors.length > 0) {
                    errorMessage += ': ' + response.errors.map(e => e.error).join(', ');
                }
                
                showToast('error', errorMessage, 'Upload Gagal!');
                $uploadProgress.addClass('d-none');
                $uploadButton.prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Upload');
                $cancelBtn.prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            console.error('Upload error:', xhr.responseText);
            
            let errorMessage = 'Terjadi kesalahan saat upload.';
            
            if (xhr.status === 419) {
                errorMessage = 'Session expired. Silakan refresh halaman dan coba lagi.';
                // Auto refresh setelah 3 detik
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (error) {
                errorMessage = error;
            }
            
            showToast('error', errorMessage, 'Error!');
            $uploadProgress.addClass('d-none');
            $uploadButton.prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Upload');
            $cancelBtn.prop('disabled', false);
        },
        complete: function() {
            // Reset jika ada error
            $uploadProgress.addClass('d-none');
            $uploadButton.prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Upload');
            $cancelBtn.prop('disabled', false);
        }
    });
});

// Reset modal when closed
$('#uploadModal').on('hidden.bs.modal', function() {
    selectedFiles = [];
    $('#uploadForm')[0].reset();
    $('#imagePreviews').empty();
    $('#fileInfo').addClass('d-none');
    $('#previewContainer').addClass('d-none');
    $('#uploadProgress').addClass('d-none');
    $('#uploadButton').prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Upload');
    $('#cancelBtn').prop('disabled', false);
});

// Bulk Delete
$('#btnDeleteSelected').on('click', function () {

    let ids = $('.media-checkbox:checked').map(function () {
        return this.value;
    }).get();

    if (ids.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Belum ada pilihan',
            text: 'Pilih minimal 1 media terlebih dahulu',
            timer: 1500,
            showConfirmButton: false
        });
        return;
    }

    Swal.fire({
        title: 'Hapus Media?',
        html: `Anda akan menghapus <strong>${ids.length}</strong> media secara permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;

        // Modal loading (mengganti tombol OK)
        Swal.fire({
            title: 'Menghapus...',
            text: 'Mohon tunggu',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('admin.media.bulk.destroy') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: ids
            },
            success: function (response) {

                // Notifikasi sukses tanpa tombol OK
                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: response.message || `${ids.length} media berhasil dihapus.`,
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });

                ids.forEach(id => {
                    $(`.media-item[data-id="${id}"]`).fadeOut(300, function () {
                        $(this).remove();
                    });
                });

                $('#selectAllMedia').prop('checked', false);
            },
            error: function (xhr) {
                const message = xhr.responseJSON?.message || 'Gagal menghapus media';
                Swal.fire('Error!', message, 'error');
            }
        });
    });
});

// Toggle semua checkbox
$('#selectAllMedia').on('change', function () {
    $('.media-checkbox').prop('checked', this.checked);
});

// Jika user klik satu per satu, update Select All
$(document).on('change', '.media-checkbox', function () {
    let total = $('.media-checkbox').length;
    let checked = $('.media-checkbox:checked').length;

    $('#selectAllMedia').prop('checked', total === checked);
});

// Bulk Download
$('#btnDownloadSelected').on('click', function () {

    let ids = $('.media-checkbox:checked').map(function () {
        return this.value;
    }).get();

    if (ids.length === 0) {
        showToast('warning', 'Pilih minimal 1 media');
        return;
    }

    // Buat form dynamic untuk POST (karena file response)
    const form = $('<form>', {
        method: 'POST',
        action: "{{ route('admin.media.bulk.download') }}"
    });

    form.append($('<input>', {
        type: 'hidden',
        name: '_token',
        value: "{{ csrf_token() }}"
    }));

    ids.forEach(id => {
        form.append($('<input>', {
            type: 'hidden',
            name: 'ids[]',
            value: id
        }));
    });

    $('body').append(form);
    form.submit();
    form.remove();
});

// Select media button (for use in other forms)
$(document).on('click', '.btn-select-media', function() {
    const mediaId = $(this).data('media-id');
    const mediaUrl = $(this).data('media-url');
    const mediaName = $(this).data('media-name');
    
    // Dispatch custom event for other components to listen to
    const event = new CustomEvent('media-selected', {
        detail: {
            id: mediaId,
            url: mediaUrl,
            name: mediaName
        }
    });
    window.dispatchEvent(event);
    
    showToast('success', `"${mediaName}" telah dipilih`, 'Media Dipilih');
});

document.querySelectorAll('.media-item').forEach(item => {
    item.addEventListener('click', function (e) {

        // Jangan trigger kalau klik tombol
        if (e.target.closest('button,a')) return;

        // mode picker?
        if (window.MEDIA_MODE !== 'picker') return;

        document.querySelectorAll('.media-item').forEach(i => i.classList.remove('selected'));
        this.classList.add('selected');

    });
});

// Initialize when page loads
$(document).ready(function() {
    console.log('Media gallery initialized');
    initTooltips();
    filterMedia();
});
</script>
@endpush