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
                    <!-- File Selection -->
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

<script>
// File management for upload modal
let selectedFiles = [];

// Initialize upload modal
document.addEventListener('DOMContentLoaded', function() {
    const uploadModalEl = document.getElementById('uploadModal');
    if (uploadModalEl) {
        window.uploadModal = new bootstrap.Modal(uploadModalEl);
        
        // File input change handler
        document.getElementById('fileInput')?.addEventListener('change', handleFileInputChange);
        
        // Browse files button
        document.getElementById('browseFiles')?.addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });
        
        // Clear all button
        document.getElementById('clearAll')?.addEventListener('click', clearAllFiles);
        
        // Upload form submit
        document.getElementById('uploadForm')?.addEventListener('submit', handleUploadSubmit);
        
        // Modal close reset
        uploadModalEl.addEventListener('hidden.bs.modal', resetUploadForm);
    }
});

async function handleFileInputChange(e) {
    const files = Array.from(e.target.files);
    const maxSize = 5 * 1024 * 1024;
    
    if (files.length === 0) {
        showPickerToast('warning', 'Tidak ada file yang dipilih');
        return;
    }
    
    // Filter files
    const validFiles = files.filter(file => file.size <= maxSize);
    const invalidFiles = files.filter(file => file.size > maxSize);
    
    // Show warnings
    if (invalidFiles.length > 0) {
        const names = invalidFiles.slice(0, 3).map(f => f.name).join(', ');
        const message = invalidFiles.length > 3 ? 
            `${names} dan ${invalidFiles.length - 3} file lainnya terlalu besar (max 5MB)` :
            `${names} terlalu besar (max 5MB)`;
        showPickerToast('warning', message, 'File Terlalu Besar');
    }
    
    // Add files to selection
    selectedFiles.push(...validFiles);
    selectedFiles.push(...invalidFiles);
    
    // Remove duplicates
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
    
    // Reset file input
    e.target.value = '';
    
    // Hide warning
    const warningEl = document.getElementById('noFileWarning');
    if (warningEl) warningEl.classList.add('d-none');
}

function updateFileInfo() {
    const totalFiles = selectedFiles.length;
    const maxSize = 5 * 1024 * 1024;
    let totalSize = 0;
    let validFiles = 0;
    let invalidFilesCount = 0;
    
    // Reset preview borders
    document.querySelectorAll('.preview-image').forEach(preview => {
        preview.classList.remove('border', 'border-danger');
    });
    
    selectedFiles.forEach((file, index) => {
        if (file.size <= maxSize) {
            totalSize += file.size;
            validFiles++;
        } else {
            invalidFilesCount++;
            const previewEl = document.getElementById(`preview-${index}`);
            if (previewEl) {
                previewEl.querySelector('.preview-image').classList.add('border', 'border-danger');
            }
        }
    });
    
    const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
    const sizePercentage = Math.min((totalSize / (maxSize * 10)) * 100, 100);
    
    // Update UI elements
    const previewCountEl = document.getElementById('previewCount');
    const fileCountEl = document.getElementById('fileCount');
    const totalSizeEl = document.getElementById('totalSize');
    const sizeProgressEl = document.getElementById('sizeProgress');
    const fileInfoEl = document.getElementById('fileInfo');
    const previewContainerEl = document.getElementById('previewContainer');
    
    if (totalFiles > 0) {
        let countText = `${validFiles} file valid`;
        if (invalidFilesCount > 0) {
            countText += ` (${invalidFilesCount} file terlalu besar)`;
        }
        
        if (previewCountEl) previewCountEl.textContent = totalFiles;
        if (fileCountEl) fileCountEl.textContent = countText;
        if (totalSizeEl) totalSizeEl.textContent = `${totalSizeMB} MB`;
        if (sizeProgressEl) sizeProgressEl.style.width = `${sizePercentage}%`;
        
        if (fileInfoEl) {
            if (invalidFilesCount > 0) {
                fileInfoEl.classList.remove('alert-light');
                fileInfoEl.classList.add('alert-warning');
            } else {
                fileInfoEl.classList.remove('alert-warning');
                fileInfoEl.classList.add('alert-light');
            }
            fileInfoEl.classList.remove('d-none');
        }
        
        if (previewContainerEl) previewContainerEl.classList.remove('d-none');
    } else {
        if (fileInfoEl) fileInfoEl.classList.add('d-none');
        if (previewContainerEl) previewContainerEl.classList.add('d-none');
    }
}

async function updatePreviews() {
    const container = document.getElementById('imagePreviews');
    if (!container) return;
    
    container.innerHTML = '';
    
    if (selectedFiles.length === 0) return;
    
    const maxSize = 5 * 1024 * 1024;
    
    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];
        const isInvalid = file.size > maxSize;
        const previewHTML = await createPreview(file, i, isInvalid);
        container.insertAdjacentHTML('beforeend', previewHTML);
    }
    
    // Add event listeners to remove buttons
    document.querySelectorAll('.remove-preview').forEach(button => {
        button.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            selectedFiles.splice(index, 1);
            updatePreviews();
            updateFileInfo();
        });
    });
}

function createPreview(file, index, isInvalid = false) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const fileSize = (file.size / 1024).toFixed(1);
            const fileName = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
            const maxSizeMB = (5 * 1024 * 1024) / (1024 * 1024);
            
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

function clearAllFiles() {
    selectedFiles = [];
    const container = document.getElementById('imagePreviews');
    if (container) container.innerHTML = '';
    updateFileInfo();
}

function resetUploadForm() {
    selectedFiles = [];
    const form = document.getElementById('uploadForm');
    if (form) form.reset();
    
    const elementsToReset = [
        'imagePreviews',
        'fileInfo',
        'previewContainer',
        'uploadProgress',
        'noFileWarning'
    ];
    
    elementsToReset.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('d-none');
            if (id === 'imagePreviews') el.innerHTML = '';
        }
    });
    
    const uploadButton = document.getElementById('uploadButton');
    const cancelBtn = document.getElementById('cancelBtn');
    if (uploadButton) uploadButton.disabled = false;
    if (cancelBtn) cancelBtn.disabled = false;
}

async function handleUploadSubmit(e) {
    e.preventDefault();
    
    // Validate files
    if (selectedFiles.length === 0) {
        const warningEl = document.getElementById('noFileWarning');
        if (warningEl) {
            warningEl.classList.remove('d-none');
            warningEl.scrollIntoView({ behavior: 'smooth' });
        }
        showPickerToast('error', 'Pilih minimal 1 file gambar untuk diupload');
        return;
    }
    
    const maxSize = 5 * 1024 * 1024;
    const invalidFiles = selectedFiles.filter(file => file.size > maxSize);
    
    if (invalidFiles.length > 0) {
        showPickerToast('error', 'Beberapa file terlalu besar. Maksimal 5MB per file');
        return;
    }
    
    // Prepare for upload
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadStatus = document.getElementById('uploadStatus');
    const uploadButton = document.getElementById('uploadButton');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressText = document.getElementById('progressText');
    const currentFile = document.getElementById('currentFile');
    const cancelBtn = document.getElementById('cancelBtn');
    
    if (uploadProgress) uploadProgress.classList.remove('d-none');
    if (uploadStatus) uploadStatus.textContent = 'Mengupload ' + selectedFiles.length + ' file...';
    if (uploadButton) {
        uploadButton.disabled = true;
        uploadButton.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Uploading...';
    }
    if (cancelBtn) cancelBtn.disabled = true;
    
    // Create FormData
    const formData = new FormData();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (csrfToken) {
        formData.append('_token', csrfToken);
    }
    
    selectedFiles.forEach((file, index) => {
        formData.append(`files[${index}]`, file);
    });
    
    try {
        const response = await fetch('{{ route("admin.media.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            
            if (result.success) {
                showPickerToast('success', result.message, 'Upload Berhasil!');
                
                // Close modal and refresh
                if (window.uploadModal) window.uploadModal.hide();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                let errorMessage = result.message || 'Upload gagal';
                showPickerToast('error', errorMessage, 'Upload Gagal!');
                resetUploadState();
            }
        } else {
            const error = await response.text();
            console.error('Upload error:', error);
            showPickerToast('error', 'Terjadi kesalahan saat upload', 'Error!');
            resetUploadState();
        }
    } catch (error) {
        console.error('Upload error:', error);
        showPickerToast('error', 'Gagal terhubung ke server', 'Network Error!');
        resetUploadState();
    }
}

function resetUploadState() {
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadButton = document.getElementById('uploadButton');
    const cancelBtn = document.getElementById('cancelBtn');
    
    if (uploadProgress) uploadProgress.classList.add('d-none');
    if (uploadButton) {
        uploadButton.disabled = false;
        uploadButton.innerHTML = '<i class="bi bi-upload me-1"></i>Upload';
    }
    if (cancelBtn) cancelBtn.disabled = false;
}

// Toast function for picker
function showPickerToast(type, message, title = '') {
    // Use existing toast system if available
    if (window.showToast) {
        window.showToast(type, message, title);
        return;
    }
    
    // Simple toast for picker
    const toastId = 'toast-' + Date.now();
    const icons = {
        'success': 'bi-check-circle-fill text-success',
        'error': 'bi-x-circle-fill text-danger',
        'warning': 'bi-exclamation-triangle-fill text-warning',
        'info': 'bi-info-circle-fill text-info'
    };
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" 
             role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${icons[type] || 'bi-info-circle-fill'} me-2"></i>
                    ${title ? `<strong>${title}:</strong> ` : ''}${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    let container = document.getElementById('pickerToastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'pickerToastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        delay: 3000,
        autohide: true
    });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}
</script>

<style>
/* Preview styles */
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

/* Warning animation */
#noFileWarning {
    animation: pulseWarning 2s infinite;
}

@keyframes pulseWarning {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}
</style>