<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        .picker-mode {
            background: #f5f8fa;
            min-height: 100vh;
        }
        
        .picker-header {
            position: sticky;
            top: 0;
            border-radius: 10px 10px 0 0;
            z-index: 100;
            background: white;
            border-bottom: 1px solid #e4e6ef;
            padding: 1rem 1.5rem;
        }
        
        .picker-content {
            padding: 1.5rem;
            max-height: calc(100vh - 70px);
            overflow-y: auto;
        }
        
        .media-item.selected .card {
            border-color: #198754;
            box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2);
        }
        
        .media-item.selected .card::before {
            content: "✓";
            position: absolute;
            top: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background: #198754;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            z-index: 10;
        }
        
        /* Fixed height untuk thumbnail */
        .fixed-thumbnail {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
        }
        
        /* Grid untuk media items */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }
        
        /* Tab style seperti WordPress */
        .nav-tabs-wordpress {
            border-bottom: 2px solid #dee2e6;
        }
        
        .nav-tabs-wordpress .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 10px 20px;
            margin-bottom: -2px;
        }
        
        .nav-tabs-wordpress .nav-link:hover {
            border: none;
            color: #0d6efd;
        }
        
        .nav-tabs-wordpress .nav-link.active {
            background: none;
            border: none;
            border-bottom: 2px solid #0d6efd;
            color: #0d6efd;
        }
        
        /* Bulk selection */
        .bulk-selection-info {
            background: #e7f1ff;
            border: 1px solid #b6d4fe;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 16px;
            display: none;
        }
        
        .bulk-selection-info.show {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Upload tab content */
        .upload-tab-content {
            padding: 30px;
            text-align: center;
        }
        
        .upload-dropzone {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px 20px;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .upload-dropzone:hover {
            border-color: #0d6efd;
            background: #e7f1ff;
        }
        
        .upload-dropzone.dragover {
            border-color: #198754;
            background: #d1e7dd;
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