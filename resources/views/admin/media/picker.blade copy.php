<!DOCTYPE html>
<html lang="id">
<head>
    <base href="">
    <title>Media Picker - Ravaa Creative</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('admin/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/bootstrap-icons.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <style>
        :root {
            --bs-body-bg: #f5f8fa;
        }
        
        body {
            background: #f5f8fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .card.media-card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            border-radius: 10px;
        }
        
        .card-header.media-header {
            background: #fff;
            border-bottom: 1px solid #eff2f5;
            padding: 1.25rem 1.5rem;
        }
        
        .media-item {
            position: relative;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 15px;
            background: #fff;
        }
        
        .media-item:hover {
            border-color: #009ef7;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,158,247,0.1);
        }
        
        .media-item.selected {
            border-color: #50cd89;
            background-color: #f8fff9;
        }
        
        .media-item.selected::after {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            background-color: #50cd89;
            border-radius: 50%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/%3E%3C/svg%3E");
            background-size: 12px;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .media-thumbnail {
            width: 100%;
            height: 150px;
            object-fit: cover;
            background: #f8f9fa;
        }
        
        .media-info {
            padding: 8px;
            background: #fff;
            border-top: 1px solid #eff2f5;
        }
        
        .media-name {
            font-size: 12px;
            font-weight: 500;
            color: #5e6278;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .media-size {
            font-size: 11px;
            color: #a1a5b7;
        }
        
        .upload-dropzone {
            border: 2px dashed #e4e6ef;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .upload-dropzone:hover {
            border-color: #009ef7;
            background: #f1faff;
        }
        
        .upload-dropzone i {
            font-size: 48px;
            color: #b5b5c3;
            margin-bottom: 15px;
        }
        
        .upload-dropzone.dragover {
            border-color: #50cd89;
            background: #f1fff7;
        }
        
        .search-input {
            border-radius: 8px;
            border: 1px solid #e4e6ef;
            padding: 10px 15px;
        }
        
        .filter-btn {
            border-radius: 8px;
            border: 1px solid #e4e6ef;
            background: #fff;
            padding: 10px 15px;
            transition: all 0.2s;
        }
        
        .filter-btn:hover {
            background: #f5f8fa;
            border-color: #009ef7;
        }
        
        .selected-count {
            background: #50cd89;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 64px;
            color: #b5b5c3;
            margin-bottom: 20px;
        }
        
        .media-type-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
        }
        
        .modal-body iframe {
            border: none;
            width: 100%;
            min-height: 500px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <!--begin::Card-->
        <div class="card media-card">
            <!--begin::Card header-->
            <div class="card-header media-header">
                <div class="card-title">
                    <h3 class="fw-bold m-0">Pilih Media</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light me-3" onclick="window.parent.postMessage({type: 'close-media-picker'}, '*')">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="confirmSelection()" id="selectButton" disabled>
                        <i class="bi bi-check-lg"></i> Pilih
                    </button>
                </div>
            </div>
            <!--end::Card header-->
            
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-7">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative me-4">
                        <i class="bi bi-search fs-3 position-absolute ms-4"></i>
                        <input type="text" 
                               class="form-control form-control-solid w-250px ps-13 search-input" 
                               placeholder="Cari media..." 
                               id="searchInput" 
                               onkeyup="filterMedia()">
                    </div>
                    <!--end::Search-->
                    
                    <!--begin::Filters-->
                    <div class="d-flex align-items-center gap-3">
                        <select class="form-select form-select-solid w-150px" id="typeFilter">
                            <option value="">Semua Tipe</option>
                            <option value="image">Gambar</option>
                            <option value="document">Dokumen</option>
                            <option value="video">Video</option>
                        </select>
                        
                        <button class="btn btn-light-primary" onclick="openUploadModal()">
                            <i class="bi bi-cloud-arrow-up me-2"></i>Upload
                        </button>
                    </div>
                    <!--end::Filters-->
                </div>
                <!--end::Toolbar-->
                
                <!--begin::Media grid-->
                <div class="row g-4" id="mediaGrid">
                    @if(count($media) > 0)
                        @foreach($media as $item)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 media-item-container">
                            <div class="media-item" 
                                data-id="{{ $item->id }}"
                                data-url="{{ $item->url }}"
                                data-name="{{ $item->name }}"
                                data-type="{{ $item->type ?? 'image' }}"
                                data-size="{{ $item->size }}"
                                onclick="toggleSelect(this)">
                                
                                @php
                                    $type = $item->type ?? 'image';
                                @endphp
                                
                                @if($type == 'image')
                                    <img src="{{ $item->thumbnail_url ?? $item->url }}" 
                                        class="media-thumbnail" 
                                        alt="{{ $item->name }}"
                                        onerror="this.src='{{ asset('admin/assets/media/svg/files/blank-image.svg') }}'">
                                    <span class="media-type-badge">Gambar</span>
                                @elseif($type == 'video')
                                    <div class="media-thumbnail d-flex align-items-center justify-content-center bg-light">
                                        <i class="bi bi-play-circle fs-1 text-primary"></i>
                                    </div>
                                    <span class="media-type-badge">Video</span>
                                @else
                                    <div class="media-thumbnail d-flex align-items-center justify-content-center bg-light">
                                        <i class="bi bi-file-earmark-text fs-1 text-gray-600"></i>
                                    </div>
                                    <span class="media-type-badge">Dokumen</span>
                                @endif
                                
                                <div class="media-info">
                                    <div class="media-name">{{ $item->name }}</div>
                                    <div class="media-size">{{ $item->formatted_size }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="bi bi-images"></i>
                                <h4 class="text-muted mt-3">Belum ada media</h4>
                                <p class="text-muted">Upload file pertama Anda untuk memulai</p>
                                <button class="btn btn-primary mt-3" onclick="openUploadModal()">
                                    <i class="bi bi-cloud-arrow-up me-2"></i>Upload File
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end::Media grid-->
                
                <!--begin::Pagination-->
                @if($media->hasPages())
                <div class="d-flex justify-content-center mt-7">
                    {{ $media->links('vendor.pagination.custom') }}
                </div>
                @endif
                <!--end::Pagination-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    
    <!--begin::Upload Modal-->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Media Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="upload-dropzone" id="uploadDropzone">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <h4 class="text-gray-700 mb-2">Seret & Lepaskan file di sini</h4>
                        <p class="text-muted mb-4">atau</p>
                        <button class="btn btn-light-primary" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-folder me-2"></i>Pilih File
                        </button>
                        <p class="text-muted mt-3 mb-1">Ukuran maksimal: 10MB</p>
                        <p class="text-muted">Format yang didukung: JPG, PNG, GIF, PDF, MP4</p>
                    </div>
                    
                    <input type="file" id="fileInput" style="display: none;" multiple onchange="handleFileSelect(this.files)">
                    
                    <!-- Upload Progress -->
                    <div id="uploadProgress" class="mt-4" style="display: none;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Mengupload...</span>
                            <span class="text-muted" id="progressText">0%</span>
                        </div>
                        <div class="progress">
                            <div id="progressBar" class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <!-- Upload Queue -->
                    <div id="uploadQueue" class="mt-4"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="uploadButton" onclick="startUpload()" disabled>
                        <i class="bi bi-cloud-arrow-up me-2"></i>Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Upload Modal-->
    
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('admin/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    
    <script>
        let selectedMedia = null;
        let uploadQueue = [];
        
        // Initialize modal
        const uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
        
        // Format bytes helper
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
        
        // Toggle media selection
        function toggleSelect(element) {
            // If single selection mode (get from URL parameter)
            const urlParams = new URLSearchParams(window.location.search);
            const multiple = urlParams.get('multiple') === 'true';
            
            if (!multiple) {
                // Single selection - deselect all first
                document.querySelectorAll('.media-item').forEach(item => {
                    item.classList.remove('selected');
                });
                
                // Select clicked item
                element.classList.add('selected');
                selectedMedia = {
                    id: element.dataset.id,
                    url: element.dataset.url,
                    name: element.dataset.name,
                    type: element.dataset.type,
                    size: element.dataset.size
                };
                
                // Enable select button
                document.getElementById('selectButton').disabled = false;
            } else {
                // Multiple selection - toggle selection
                element.classList.toggle('selected');
                
                // Update selected count
                const selectedItems = document.querySelectorAll('.media-item.selected');
                const countBadge = document.getElementById('selectedCount');
                
                if (selectedItems.length > 0) {
                    if (!countBadge) {
                        const button = document.getElementById('selectButton');
                        button.innerHTML = `<span class="selected-count me-2">${selectedItems.length}</span> Pilih`;
                        button.disabled = false;
                    } else {
                        countBadge.textContent = selectedItems.length;
                    }
                } else {
                    document.getElementById('selectButton').innerHTML = '<i class="bi bi-check-lg"></i> Pilih';
                    document.getElementById('selectButton').disabled = true;
                }
            }
        }
        
        // Confirm selection
        function confirmSelection() {
            const urlParams = new URLSearchParams(window.location.search);
            const multiple = urlParams.get('multiple') === 'true';
            const target = urlParams.get('target') || 'main';
            
            console.log('Confirming selection:', { multiple, target, selectedMedia }); // Debug
            
            if (multiple) {
                const selectedItems = document.querySelectorAll('.media-item.selected');
                const mediaArray = [];
                
                selectedItems.forEach(item => {
                    mediaArray.push({
                        id: item.dataset.id,
                        url: item.dataset.url,
                        name: item.dataset.name,
                        type: item.dataset.type,
                        size: item.dataset.size
                    });
                });
                
                console.log('Sending multiple media:', mediaArray); // Debug
                
                window.parent.postMessage({
                    type: 'media-selected-multiple',
                    target: target,
                    media: mediaArray
                }, '*');
            } else {
                if (selectedMedia) {
                    console.log('Sending single media:', selectedMedia); // Debug
                    
                    window.parent.postMessage({
                        type: 'media-selected',
                        target: target,
                        media: selectedMedia
                    }, '*');
                }
            }
            
            window.parent.postMessage({type: 'close-media-picker'}, '*');
        }
        
        // Filter media by search
        function filterMedia() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const typeFilter = document.getElementById('typeFilter').value;
            const items = document.querySelectorAll('.media-item-container');
            
            items.forEach(item => {
                const mediaItem = item.querySelector('.media-item');
                const name = mediaItem.dataset.name.toLowerCase();
                const type = mediaItem.dataset.type;
                
                const matchesSearch = name.includes(searchTerm);
                const matchesType = !typeFilter || type === typeFilter;
                
                if (matchesSearch && matchesType) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        // Open upload modal
        function openUploadModal() {
            uploadModal.show();
        }
        
        // Handle drag and drop
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('uploadDropzone');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropzone.classList.add('dragover');
            }
            
            function unhighlight() {
                dropzone.classList.remove('dragover');
            }
            
            dropzone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFileSelect(files);
            }
        });
        
        // Handle file selection
        function handleFileSelect(files) {
            uploadQueue = [];
            const queueElement = document.getElementById('uploadQueue');
            queueElement.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                // Validasi file size (5MB limit sesuai store method)
                if (file.size > 5 * 1024 * 1024) {
                    alert(`File ${file.name} terlalu besar. Ukuran maksimal 5MB`);
                    return;
                }
                
                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
                if (!validTypes.includes(file.type)) {
                    alert(`Format file ${file.name} tidak didukung. Hanya gambar (JPG, PNG, GIF, WebP, SVG) yang diperbolehkan`);
                    return;
                }
                
                uploadQueue.push(file);
                
                // Tambahkan ke queue display dengan status
                const fileElement = document.createElement('div');
                fileElement.className = 'd-flex justify-content-between align-items-center p-3 border rounded mb-2 queue-item';
                fileElement.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="status-icon me-3">
                            <i class="bi bi-clock text-muted"></i>
                        </div>
                        <div>
                            <div class="fw-medium">${file.name}</div>
                            <small class="text-muted">${formatBytes(file.size)} • ${file.type}</small>
                        </div>
                    </div>
                `;
                queueElement.appendChild(fileElement);
            });
            
            // Enable/disable upload button
            const uploadButton = document.getElementById('uploadButton');
            uploadButton.disabled = uploadQueue.length === 0;
            uploadButton.innerHTML = uploadQueue.length > 0 
                ? `<i class="bi bi-cloud-arrow-up me-2"></i>Upload (${uploadQueue.length})`
                : `<i class="bi bi-cloud-arrow-up me-2"></i>Upload`;
        }
        
        // Start upload
        function startUpload() {
            if (uploadQueue.length === 0) return;
            
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const uploadProgress = document.getElementById('uploadProgress');
            const uploadButton = document.getElementById('uploadButton');
            const uploadQueueElement = document.getElementById('uploadQueue');
            
            uploadProgress.style.display = 'block';
            uploadButton.disabled = true;
            uploadButton.innerHTML = '<i class="bi bi-cloud-arrow-up me-2"></i>Mengupload...';
            
            // Reset queue display
            const queueItems = uploadQueueElement.querySelectorAll('.queue-item');
            queueItems.forEach(item => {
                const statusIcon = item.querySelector('.status-icon');
                statusIcon.innerHTML = '<i class="bi bi-hourglass-split text-warning"></i>';
            });
            
            // Upload files one by one
            let uploadedCount = 0;
            let uploadedMedia = [];
            
            uploadQueue.forEach((file, index) => {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                const xhr = new XMLHttpRequest();
                const queueItem = uploadQueueElement.children[index];
                const statusIcon = queueItem.querySelector('.status-icon');
                
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = ((uploadedCount + (e.loaded / e.total)) / uploadQueue.length) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressText.textContent = Math.round(percentComplete) + '%';
                    }
                });
                
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            uploadedCount++;
                            uploadedMedia.push(response.media);
                            
                            // Update status di queue
                            statusIcon.innerHTML = '<i class="bi bi-check-circle text-success"></i>';
                            
                            // Update progress
                            const percentComplete = (uploadedCount / uploadQueue.length) * 100;
                            progressBar.style.width = percentComplete + '%';
                            progressText.textContent = Math.round(percentComplete) + '%';
                            
                            if (uploadedCount === uploadQueue.length) {
                                // Semua file berhasil diupload
                                progressBar.classList.remove('progress-bar-animated');
                                progressBar.classList.add('bg-success');
                                
                                // Tunggu 1 detik kemudian refresh
                                setTimeout(() => {
                                    uploadModal.hide();
                                    
                                    // Refresh halaman untuk menampilkan file baru
                                    location.reload();
                                }, 1000);
                            }
                        } else {
                            // Upload gagal
                            statusIcon.innerHTML = '<i class="bi bi-x-circle text-danger"></i>';
                            alert(`Gagal mengupload ${file.name}: ${response.message || 'Unknown error'}`);
                        }
                    } else {
                        // HTTP error
                        statusIcon.innerHTML = '<i class="bi bi-x-circle text-danger"></i>';
                        alert(`Gagal mengupload ${file.name}: HTTP ${xhr.status}`);
                    }
                };
                
                xhr.onerror = function() {
                    statusIcon.innerHTML = '<i class="bi bi-x-circle text-danger"></i>';
                    alert(`Gagal mengupload ${file.name}: Network error`);
                };
                
                xhr.open('POST', '{{ route("admin.media.upload") }}');
                xhr.send(formData);
            });
        }
        
        // Type filter change
        document.getElementById('typeFilter').addEventListener('change', filterMedia);
        
        // Handle messages from parent
        window.addEventListener('message', function(event) {
            if (event.data.type === 'init-media-picker') {
                // Initialize with settings from parent
                const settings = event.data.settings;
                // Apply settings if needed
            }
        });
        
        // Send ready message to parent
        window.parent.postMessage({type: 'media-picker-ready'}, '*');
    </script>
</body>
</html>