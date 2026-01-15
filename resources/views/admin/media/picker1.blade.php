<div class="h-100 d-flex flex-column">
    <!-- Toolbar -->
    <div class="p-3 border-bottom bg-white">
        <div class="row align-items-center g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0" 
                           placeholder="Cari media..." 
                           id="searchInput" 
                           onkeyup="filterMedia()">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="typeFilter" onchange="filterMedia()">
                    <option value="">Semua Tipe</option>
                    <option value="image">Gambar</option>
                    <option value="document">Dokumen</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group">
                    <button class="btn btn-outline-primary" onclick="refreshMediaList()">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                    <button class="btn btn-primary" onclick="openUploadModalInPicker()">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Upload Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Media Grid -->
    <div class="flex-grow-1 p-3" style="overflow-y: auto;">
        @if(count($media) > 0)
            <div class="row g-3" id="mediaGrid">
                @foreach($media as $item)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 media-item-container">
                    <div class="media-selector-card" 
                         data-id="{{ $item->id }}"
                         data-url="{{ $item->url }}"
                         data-name="{{ $item->name }}"
                         onclick="selectMediaItem(this)">
                        
                        <!-- Checkbox for selection -->
                        <div class="media-checkbox">
                            <input type="checkbox" class="form-check-input media-check" 
                                   id="media_{{ $item->id }}"
                                   data-id="{{ $item->id }}">
                        </div>
                        
                        <!-- Thumbnail -->
                        <div class="media-thumb-container">
                            @if(in_array($item->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']))
                                <img src="{{ $item->thumbnail_url ?? $item->url }}" 
                                     class="media-thumb"
                                     alt="{{ $item->name }}"
                                     onerror="this.src='{{ asset('admin/assets/media/svg/files/blank-image.svg') }}'">
                            @elseif(in_array($item->extension, ['mp4', 'avi', 'mov']))
                                <div class="media-thumb bg-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-play-circle-fill text-primary fs-1"></i>
                                </div>
                            @else
                                <div class="media-thumb bg-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-earmark-text text-secondary fs-1"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Media Info -->
                        <div class="media-info p-2">
                            <div class="media-name text-truncate small" title="{{ $item->name }}">
                                {{ $item->name }}
                            </div>
                            <div class="media-details text-muted x-small">
                                <span>{{ $item->formatted_size }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ strtoupper($item->extension) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-images text-muted" style="font-size: 64px;"></i>
                </div>
                <h5 class="text-muted mb-3">Belum ada media</h5>
                <p class="text-muted mb-4">Upload file pertama Anda untuk memulai</p>
                <button class="btn btn-primary" onclick="openUploadModalInPicker()">
                    <i class="bi bi-cloud-arrow-up me-1"></i> Upload Media
                </button>
            </div>
        @endif
        
        <!-- Pagination -->
        @if($media->hasPages())
        <div class="mt-4">
            {{ $media->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>
</div>

<style>
    .media-selector-card {
        position: relative;
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .media-selector-card:hover {
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .media-selector-card.selected {
        border-color: #198754;
        background-color: #f8fff9;
    }
    
    .media-checkbox {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .media-selector-card:hover .media-checkbox,
    .media-selector-card.selected .media-checkbox {
        opacity: 1;
    }
    
    .media-thumb-container {
        aspect-ratio: 1/1;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .media-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .media-info {
        background: white;
        border-top: 1px solid #f1f1f1;
    }
    
    .x-small {
        font-size: 0.75rem;
    }
</style>

<script>
    let selectedMediaItems = [];
    let isMultiple = {{ request('multiple', 'false') === 'true' ? 'true' : 'false' }};
    let targetType = '{{ request('target', 'main') }}';
    
    function selectMediaItem(element) {
        const mediaId = element.dataset.id;
        const mediaUrl = element.dataset.url;
        const mediaName = element.dataset.name;
        const checkbox = element.querySelector('.media-check');
        
        if (isMultiple) {
            // Multiple selection
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                element.classList.add('selected');
                selectedMediaItems.push({
                    id: mediaId,
                    url: mediaUrl,
                    name: mediaName
                });
            } else {
                element.classList.remove('selected');
                selectedMediaItems = selectedMediaItems.filter(item => item.id !== mediaId);
            }
        } else {
            // Single selection - deselect all first
            document.querySelectorAll('.media-selector-card').forEach(card => {
                card.classList.remove('selected');
                card.querySelector('.media-check').checked = false;
            });
            
            // Select clicked item
            element.classList.add('selected');
            checkbox.checked = true;
            selectedMediaItems = [{
                id: mediaId,
                url: mediaUrl,
                name: mediaName
            }];
        }
        
        updateSelectionUI();
    }
    
    function updateSelectionUI() {
        const confirmBtn = window.parent.document.getElementById('confirmSelectBtn');
        const countText = window.parent.document.getElementById('selectedCountText');
        
        if (selectedMediaItems.length > 0) {
            if (confirmBtn) confirmBtn.disabled = false;
            if (countText) {
                if (isMultiple) {
                    countText.textContent = `${selectedMediaItems.length} media dipilih`;
                } else {
                    countText.textContent = '1 media dipilih';
                }
            }
        } else {
            if (confirmBtn) confirmBtn.disabled = true;
            if (countText) countText.textContent = 'Pilih media untuk melanjutkan';
        }
    }
    
    function filterMedia() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value;
        const items = document.querySelectorAll('.media-item-container');
        
        items.forEach(item => {
            const mediaCard = item.querySelector('.media-selector-card');
            const name = mediaCard.dataset.name.toLowerCase();
            
            let matchesSearch = searchTerm === '' || name.includes(searchTerm);
            let matchesType = typeFilter === '' || true; // Anda bisa tambahkan logic type filter
            
            if (matchesSearch && matchesType) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    function refreshMediaList() {
        const url = new URL(window.location.href);
        url.searchParams.set('refresh', Date.now());
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('mediaPickerContent').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat ulang media');
            });
    }
    
    function openUploadModalInPicker() {
        // Create upload modal within picker
        const uploadModalHTML = `
            <div class="modal fade" id="uploadModalInPicker" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Media</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="file" class="form-control" id="uploadFileInput" multiple>
                            </div>
                            <div id="uploadProgressContainer" style="display: none;">
                                <div class="progress mb-3">
                                    <div class="progress-bar" id="uploadProgressBar" style="width: 0%"></div>
                                </div>
                                <p class="text-muted small" id="uploadStatusText"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="startUpload()">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Append modal to body and show
        document.body.insertAdjacentHTML('beforeend', uploadModalHTML);
        const modal = new bootstrap.Modal(document.getElementById('uploadModalInPicker'));
        modal.show();
    }
    
    // Update parent when ready
    window.parent.postMessage({type: 'picker-ready'}, '*');
</script>