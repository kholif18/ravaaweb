<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        /* ========== STYLING UNTUK MEDIA PICKER MODAL ========== */
        #mediaPickerModal .modal-xxl {
            max-width: 1200px;
        }

        #mediaPickerModal .modal-body {
            min-height: 600px;
            max-height: 70vh;
        }

        /* Nav tabs */
        .nav-tabs-line {
            border-bottom: 1px solid #dee2e6;
        }

        .nav-tabs-line .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
        }

        .nav-tabs-line .nav-link:hover {
            color: #0d6efd;
            border-bottom-color: #dee2e6;
        }

        .nav-tabs-line .nav-link.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
            background: transparent;
        }

        /* ========== FIXED HEIGHT UNTUK MEDIA PICKER ========== */
#mediaLibraryGrid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
}

.media-item {
    position: relative;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    background: white;
    height: 250px; /* FIXED HEIGHT TOTAL */
    display: flex;
    flex-direction: column;
    transition: all 0.2s ease;
}

.media-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.media-item.selected {
    border-color: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}

/* Image container dengan fixed height */
.media-img-container {
    position: relative;
    width: 100%;
    height: 160px; /* Fixed height untuk gambar */
    background-color: #f8f9fa;
    border-bottom: 1px solid #e5e7eb;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Gambar dengan object-fit cover */
.media-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* PASTIKAN gambar proporsional dan mengisi container */
    transition: transform 0.3s ease;
}

.media-item:hover .media-img {
    transform: scale(1.05);
}

/* Info section dengan fixed height */
.media-info {
    padding: 12px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 90px; /* Fixed height untuk info */
}

.media-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    line-height: 1.3;
}

.media-meta {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: auto;
}

/* Check indicator untuk selected */
.media-item.selected::after {
    content: "✓";
    position: absolute;
    top: 8px;
    right: 8px;
    width: 24px;
    height: 24px;
    background: #10b981;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    z-index: 10;
}

/* Hapus semua class yang bentrok */
.media-card-img,
.media-card-item,
.media-card-overlay,
.media-card-body,
.media-card-title,
.media-card-meta,
.media-check-badge,
.fixed-thumbnail {
    display: none !important;
}

/* Hapus style untuk row grid lama */
#mediaLibraryGrid.row.g-3,
#mediaLibraryGrid.row.g-3 > div {
    all: unset !important;
}

        /* Select button - hidden karena akan klik gambar langsung */
        .btn-select-media {
            position: absolute;
            bottom: 12px;
            right: 12px;
            display: none; /* Sembunyikan karena kita akan klik gambar langsung */
        }

        /* Selection Info */
        .selection-info {
            background: #e7f1ff;
            border: 1px solid #b6d4fe;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Upload Zone */
        .upload-zone {
            border: 2px dashed #dee2e6;
            transition: all 0.3s;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #0d6efd;
            background: #e7f1ff;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            #mediaPickerModal .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
        }

        /* ========== GRID LAYOUT UNTUK MEDIA PICKER ========== */
        /* Row container untuk grid */
        #mediaLibraryGrid.row.g-3 {
            --bs-gutter-x: 0.75rem;
            --bs-gutter-y: 0.75rem;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));
        }

        #mediaLibraryGrid.row.g-3 > .col-xl-2,
        #mediaLibraryGrid.row.g-3 > .col-lg-3,
        #mediaLibraryGrid.row.g-3 > .col-md-4,
        #mediaLibraryGrid.row.g-3 > .col-sm-6 {
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            padding-top: var(--bs-gutter-y);
        }

        /* Media Card - khusus untuk picker */
        .media-card-item {
            position: relative;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.2s ease;
            cursor: pointer;
            background: white;
            height: 100%;
        }

        .media-card-item:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }

        .media-card-item.selected {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }

        /* Image Container */
        .media-card-item:hover .media-card-img img {
            transform: scale(1.05);
        }

        /* Check Indicator */
        .media-check-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
            font-size: 12px;
        }

        .media-card-item.selected .media-check-badge {
            display: flex;
        }

        /* Overlay untuk select button */
        .media-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .media-card-item:hover .media-card-overlay {
            display: flex;
        }

        .media-card-overlay .btn {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }

        /* Card Body (Info) */
        .media-card-body {
            padding: 0.75rem;
            border-top: 1px solid #e5e7eb;
        }

        .media-card-title {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #1f2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .media-card-meta {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0;
            line-height: 1.2;
        }

        /* Responsive Columns untuk picker */
        @media (min-width: 1400px) {
            .col-xxl-2 {
                flex: 0 0 auto;
                width: 16.66666667%;
            }
        }

        @media (min-width: 1200px) and (max-width: 1399.98px) {
            .col-xl-3 {
                flex: 0 0 auto;
                width: 25%;
            }
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {
            .col-lg-4 {
                flex: 0 0 auto;
                width: 33.333333%;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .col-md-6 {
                flex: 0 0 auto;
                width: 50%;
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .col-sm-6 {
                flex: 0 0 auto;
                width: 50%;
            }
        }

        @media (max-width: 575.98px) {
            .col-6 {
                flex: 0 0 auto;
                width: 50%;
            }
        }
    </style>
</head>
<body class="{{ request('mode') === 'picker' ? 'picker-mode' : '' }}">
    
    @if(request('embedded') === 'true')
        <div class="picker-content">
            
            <!-- Tab content -->
            <div class="tab-content" id="mediaPickerTabContent">
                <!-- Tab 1: Media Library -->
                <div class="tab-pane fade show active" id="media-library" role="tabpanel">
                    @include('admin.media.picker-content')
                </div>
                
                <!-- Tab 2: Upload -->
                <div class="tab-pane fade" id="upload" role="tabpanel">
                    <div class="upload-tab-content">
                        <div class="upload-dropzone" id="uploadDropzone">
                            <i class="bi bi-cloud-arrow-up" style="font-size: 48px; color: #6c757d; margin-bottom: 16px;"></i>
                            <h4>Drop files to upload</h4>
                            <p class="text-muted mb-4">or</p>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                <i class="bi bi-folder2-open me-2"></i> Select Files
                            </button>
                            <p class="text-muted mt-3 mb-1">Maximum upload file size: 5MB</p>
                            <p class="text-muted">Allowed: JPG, JPEG, PNG, GIF, WebP, SVG</p>
                        </div>
                        
                        <input type="file" id="fileInput" class="d-none" multiple accept="image/*">
                        
                        <!-- Upload Progress -->
                        <div id="uploadProgressContainer" class="mt-4" style="display: none;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Uploading...</span>
                                <span class="text-muted" id="uploadProgressText">0%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                     style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <!-- Upload Queue -->
                        <div id="uploadQueue" class="mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
        
    @else
        {{-- Mode standalone (halaman biasa) --}}
        @section('content')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Media Picker</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-light btn-close-picker">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
            </div>
            <div class="card-body">
                @include('admin.media.picker-content')
            </div>
        </div>
        @endsection
    @endif

    @if(request('embedded') === 'true')
        {{-- JavaScript khusus untuk embedded mode --}}
        <script>
            let selectedMediaItems = [];
            const isMultiple = {{ request('multiple', 'false') === 'true' ? 'true' : 'false' }};
            const target = '{{ request('target', 'main') }}';
            
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Media picker loaded in modal mode');
                
                // Inisialisasi tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                
                // Inisialisasi tabs dengan benar
                initializeTabs();
                
                // Handle select button click
                document.querySelectorAll('.btn-select-media').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();
                        handleSelectButtonClick(this);
                    });
                });
                
                // Handle media selection (click on card) - hanya untuk multiple mode
                if (isMultiple) {
                    document.addEventListener('click', function(e) {
                        const mediaCard = e.target.closest('.media-item');
                        if (!mediaCard) return;
                        
                        // Skip jika klik tombol langsung
                        if (e.target.closest('.btn-select-media')) return;
                        
                        toggleMediaSelection(mediaCard);
                    });
                }
                
                // Setup upload
                setupUpload();
                
                // Update UI untuk modal
                updateUIForModal();
            });
            
            function initializeTabs() {
                const tabTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tab"]'));
                tabTriggerList.forEach(function (tabTriggerEl) {
                    tabTriggerEl.addEventListener('click', function (event) {
                        event.preventDefault();
                        const tab = new bootstrap.Tab(tabTriggerEl);
                        tab.show();
                    });
                });
            }
            
            function handleSelectButtonClick(button) {
                const mediaId = parseInt(button.dataset.mediaId);
                const mediaUrl = button.dataset.mediaUrl;
                const mediaThumbnail = button.dataset.mediaThumbnail;
                const mediaName = button.dataset.mediaName;
                
                if (isMultiple) {
                    // Multiple selection untuk gallery
                    const mediaCard = button.closest('.media-item');
                    if (mediaCard) {
                        toggleMediaSelection(mediaCard);
                    }
                } else {
                    // Single selection untuk main image
                    // Kirim ke parent window
                    window.parent.postMessage({
                        type: 'media-selected',
                        target: target,
                        media: [{
                            id: mediaId,
                            url: mediaUrl,
                            thumbnail: mediaThumbnail,
                            name: mediaName
                        }],
                        isMultiple: false
                    }, '*');
                }
            }
            
            function toggleMediaSelection(mediaCard) {
                const mediaId = parseInt(mediaCard.dataset.id);
                const mediaUrl = mediaCard.dataset.url;
                const mediaThumbnail = mediaCard.dataset.thumbnail;
                const mediaName = mediaCard.dataset.name;
                const isSelected = mediaCard.classList.contains('selected');
                
                if (isMultiple) {
                    // Multiple selection mode
                    if (isSelected) {
                        // Remove from selection
                        mediaCard.classList.remove('selected');
                        selectedMediaItems = selectedMediaItems.filter(item => item.id !== mediaId);
                    } else {
                        // Add to selection
                        mediaCard.classList.add('selected');
                        selectedMediaItems.push({
                            id: mediaId,
                            url: mediaUrl,
                            thumbnail: mediaThumbnail,
                            name: mediaName
                        });
                    }
                    updateSelectionUI();
                }
            }
            
            function updateSelectionUI() {
                const selectedCount = selectedMediaItems.length;
                const bulkInfo = document.getElementById('bulkSelectionInfo');
                const countElement = document.getElementById('selectedCount');
                
                if (countElement) {
                    countElement.textContent = selectedCount;
                }
                
                // Show/hide bulk info
                if (bulkInfo) {
                    if (selectedCount > 0) {
                        bulkInfo.style.display = 'flex';
                    } else {
                        bulkInfo.style.display = 'none';
                    }
                }
            }
            
            function updateUIForModal() {
                const bulkInfo = document.getElementById('bulkSelectionInfo');
                const countElement = document.getElementById('selectedCount');
                
                if (bulkInfo) {
                    if (isMultiple) {
                        bulkInfo.style.display = 'none'; // Hide initially for gallery
                    } else {
                        bulkInfo.style.display = 'none'; // Hide for main image
                    }
                    
                    if (countElement) {
                        countElement.textContent = selectedMediaItems.length;
                    }
                }
            }
            
            function insertSelectedMedia() {
                if (selectedMediaItems.length === 0) {
                    alert('Pilih media terlebih dahulu');
                    return;
                }
                
                // Kirim ke parent window
                window.parent.postMessage({
                    type: 'media-selected',
                    target: target,
                    media: selectedMediaItems,
                    isMultiple: isMultiple
                }, '*');
            }
            
            // ... (setupUpload dan uploadFiles tetap sama)
        </script>
    @endif
</body>
</html>