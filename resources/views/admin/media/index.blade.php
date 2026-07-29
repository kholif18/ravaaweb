@extends('admin.layouts.app')

@section('page-title', 'Media Library')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.media.index') }}">Media Library</a>
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="glass-card">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">Media Library</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" id="btn-upload-media">
                <i class="bi bi-cloud-arrow-up"></i> Upload
            </button>
            <input type="file" id="media-file-input" multiple accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx" style="display: none;">
        </div>
    </div>
    <!--end::Card header-->

    <div class="card-body">
<!-- Table toolbar with search + filter row -->
<div class="table-toolbar" style="display:block !important;">
    <div class="toolbar-group" style="display:block !important;">
        <div style="display:flex !important; align-items:center; gap:8px; flex-wrap:nowrap !important; white-space:nowrap;">
            <div class="input-group input-group-sm" style="width:280px;flex-shrink:0;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control"
                       id="media-search"
                       placeholder="Cari Media..."
                       value="{{ request('search') }}">
            </div>
            <select id="media-type-filter" class="form-select form-select-sm" style="width:150px;flex-shrink:0;">
                <option value="">Semua Tipe</option>
                <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                <option value="audio" {{ request('type') == 'audio' ? 'selected' : '' }}>Audio</option>
                <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
            </select>
            <button type="button" class="btn btn-light btn-sm" id="media-reset-filter" style="flex-shrink:0;">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </button>
        </div>
    </div>
    <div class="toolbar-group">
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-light active" id="btn-view-grid" title="Grid View"><i class="bi bi-grid-3x3-gap"></i></button>
            <button type="button" class="btn btn-light" id="btn-view-list" title="List View"><i class="bi bi-list-ul"></i></button>
        </div>
    </div>
</div>

        <!-- Bulk actions -->
        <div class="bulk-actions" id="media-bulk-actions" style="display: none;">
            <div class="bulk-info">
                <span id="media-selected-count">0</span> item dipilih
            </div>
            <div class="bulk-btns">
                <button type="button" class="btn btn-danger btn-sm" id="btn-bulk-delete-media">
                    <i class="bi bi-trash"></i> Hapus Terpilih
                </button>
                <button type="button" class="btn btn-light btn-sm" id="btn-deselect-all-media">
                    <i class="bi bi-x-circle"></i> Batal Pilih
                </button>
            </div>
        </div>

        <!-- Upload drop zone -->
        <div class="upload-drop-zone" id="upload-drop-zone" style="display: none;">
            <div class="drop-zone-content">
                <i class="bi bi-cloud-arrow-up"></i>
                <p>Seret file ke sini atau klik untuk upload</p>
                <small>Maks. 10MB per file</small>
            </div>
        </div>

        <!-- Media grid view -->
        <div class="media-grid media-view" id="media-grid" data-view="grid">
            @forelse($media as $item)
                <div class="media-item" data-id="{{ $item->id }}">
                    <div class="media-select" data-action="select" title="Pilih">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    @if($item->isImage())
                        <div class="media-preview">
                            <img src="{{ $item->url }}" alt="{{ $item->name }}" loading="lazy">
                        </div>
                    @else
                        <div class="media-preview media-file-preview">
                            @if($item->isVideo())
                                <i class="bi bi-play-circle"></i>
                            @elseif($item->isAudio())
                                <i class="bi bi-music-note"></i>
                            @else
                                <i class="bi bi-file-earmark"></i>
                            @endif
                        </div>
                    @endif
                    <div class="media-info">
                        <span class="media-name" title="{{ $item->file_name }}">{{ $item->name }}</span>
                        <span class="media-meta">{{ $item->human_size }} &middot; {{ strtoupper($item->extension) }}</span>
                    </div>
                    <div class="media-actions">
                        <button type="button" class="btn-icon" data-action="copy-url" data-url="{{ $item->url }}" title="Salin URL">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                        <button type="button" class="btn-icon" data-action="view" data-url="{{ $item->url }}" data-name="{{ $item->file_name }}" title="Lihat">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="btn-icon btn-danger" data-action="delete" data-id="{{ $item->id }}" data-name="{{ $item->file_name }}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="media-empty" id="media-empty-state">
                    <i class="bi bi-image"></i>
                    <p>Belum ada media</p>
                    <small>Klik tombol Upload untuk menambahkan file</small>
                </div>
            @endforelse
        </div>

        <!-- Media list view (compact) -->
        <div class="media-list media-view" id="media-list" data-view="list" style="display: none;">
            @forelse($media as $item)
                <div class="media-list-item" data-id="{{ $item->id }}">
                    <div class="media-list-select" data-action="select">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" data-id="{{ $item->id }}">
                        </div>
                    </div>
                    <div class="media-list-thumb">
                        @if($item->isImage())
                            <img src="{{ $item->url }}" alt="{{ $item->name }}" loading="lazy">
                        @else
                            <div class="media-list-file-icon">
                                @if($item->isVideo())
                                    <i class="bi bi-play-circle"></i>
                                @elseif($item->isAudio())
                                    <i class="bi bi-music-note"></i>
                                @else
                                    <i class="bi bi-file-earmark"></i>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="media-list-info">
                        <span class="media-list-name" title="{{ $item->file_name }}">{{ $item->file_name }}</span>
                        <span class="media-list-meta">{{ $item->human_size }} &middot; {{ strtoupper($item->extension) }} &middot; {{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="media-list-actions">
                        <button type="button" class="btn-icon" data-action="copy-url" data-url="{{ $item->url }}" title="Salin URL">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                        <button type="button" class="btn-icon" data-action="view" data-url="{{ $item->url }}" data-name="{{ $item->file_name }}" title="Lihat">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="btn-icon btn-danger" data-action="delete" data-id="{{ $item->id }}" data-name="{{ $item->file_name }}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="media-empty">
                    <i class="bi bi-image"></i>
                    <p>Belum ada media</p>
                    <small>Klik tombol Upload untuk menambahkan file</small>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-toolbar">
            <x-pagination :paginator="$media" label="media" :perPage="$media->perPage()" />
        </div>
</div>

<!-- Fullscreen Gallery Overlay -->
<div class="gallery-overlay" id="galleryOverlay">
    <button type="button" class="gallery-close" id="galleryClose"><i class="bi bi-x-lg"></i></button>
    <button type="button" class="gallery-nav gallery-prev" id="galleryPrev"><i class="bi bi-chevron-left"></i></button>
    <button type="button" class="gallery-nav gallery-next" id="galleryNext"><i class="bi bi-chevron-right"></i></button>
    <div class="gallery-content" id="galleryContent"></div>
    <div class="gallery-footer">
        <span class="gallery-filename" id="galleryFilename"></span>
        <span class="gallery-counter" id="galleryCounter"></span>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('media-grid');
    const searchInput = document.getElementById('media-search');
    const typeFilter = document.getElementById('media-type-filter');
    const resetBtn = document.getElementById('media-reset-filter');
    const uploadBtn = document.getElementById('btn-upload-media');
    const fileInput = document.getElementById('media-file-input');
    const dropZone = document.getElementById('upload-drop-zone');
    const bulkActions = document.getElementById('media-bulk-actions');
    const selectedCount = document.getElementById('media-selected-count');
    const bulkDeleteBtn = document.getElementById('btn-bulk-delete-media');
    const deselectAllBtn = document.getElementById('btn-deselect-all-media');

    let selectedIds = new Set();
    let searchTimeout;
    let currentView = localStorage.getItem('media-view') || 'grid';

    // ==================== View Toggle ====================
    const btnGrid = document.getElementById('btn-view-grid');
    const btnList = document.getElementById('btn-view-list');
    const gridView = document.getElementById('media-grid');
    const listView = document.getElementById('media-list');

    function setView(view) {
        currentView = view;
        localStorage.setItem('media-view', view);
        if (view === 'grid') {
            gridView.style.display = '';
            listView.style.display = 'none';
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
        } else {
            gridView.style.display = 'none';
            listView.style.display = '';
            btnGrid.classList.remove('active');
            btnList.classList.add('active');
        }
    }

    btnGrid.addEventListener('click', () => setView('grid'));
    btnList.addEventListener('click', () => setView('list'));
    setView(currentView);

    // Search with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => filterMedia(), 400);
    });

    // Type filter
    typeFilter.addEventListener('change', () => filterMedia());

    // Reset
    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        typeFilter.value = '';
        filterMedia();
    });

    function filterMedia() {
        const search = searchInput.value;
        const type = typeFilter.value;
        const params = new URLSearchParams();
        if (search) params.set('search', search);
        if (type) params.set('type', type);
        window.location.href = '{{ route("admin.media.index") }}?' + params.toString();
    }

    // Upload button
    uploadBtn.addEventListener('click', () => fileInput.click());

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) uploadFiles(this.files);
    });

    // Drag & Drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        if (e.dataTransfer.files.length > 0) uploadFiles(e.dataTransfer.files);
    });

    async function uploadFiles(files) {
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        try {
            const response = await fetch('{{ route("admin.media.store.multiple") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                Ravaa.toast(data.message || 'Upload gagal', 'error');
            }
        } catch (err) {
            Ravaa.toast('Upload gagal: ' + err.message, 'error');
        }
    }

    // Select media (grid view)
    grid.addEventListener('click', function(e) {
        const action = e.target.closest('[data-action]');
        if (!action) return;

        const actionType = action.dataset.action;
        const mediaItem = action.closest('.media-item');

        if (actionType === 'select') {
            const id = mediaItem.dataset.id;
            if (selectedIds.has(id)) {
                selectedIds.delete(id);
                mediaItem.classList.remove('selected');
                // Sync list view checkbox
                const listCb = listView.querySelector('input[data-id="' + id + '"]');
                if (listCb) listCb.checked = false;
            } else {
                selectedIds.add(id);
                mediaItem.classList.add('selected');
                const listCb = listView.querySelector('input[data-id="' + id + '"]');
                if (listCb) listCb.checked = true;
            }
            updateBulkUI();
        }

        if (actionType === 'copy-url') {
            navigator.clipboard.writeText(action.dataset.url);
            Ravaa.toast('URL berhasil disalin!', 'success');
        }

        if (actionType === 'view') {
            openGallery(action.dataset.id);
        }

        if (actionType === 'delete') {
            Ravaa.confirm('Hapus Media?', `File "${action.dataset.name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`, 'error').then(function(result) {
                if (result.isConfirmed) {
                    deleteMedia(action.dataset.id);
                }
            });
        }
    });

    // Select media (list view)
    listView.addEventListener('click', function(e) {
        const action = e.target.closest('[data-action]');
        const checkbox = e.target.closest('.form-check-input');

        // Handle checkbox click
        if (checkbox && checkbox.dataset.id) {
            const id = checkbox.dataset.id;
            const item = checkbox.closest('.media-list-item');
            if (checkbox.checked) {
                selectedIds.add(id);
                item.classList.add('selected');
            } else {
                selectedIds.delete(id);
                item.classList.remove('selected');
            }
            // Sync grid view
            const gridItem = gridView.querySelector('.media-item[data-id="' + id + '"]');
            if (gridItem) gridItem.classList.toggle('selected', checkbox.checked);
            updateBulkUI();
            return;
        }

        if (!action) return;

        const actionType = action.dataset.action;
        const mediaItem = action.closest('.media-list-item');

        if (actionType === 'select') {
            const cb = mediaItem.querySelector('.form-check-input');
            cb.checked = !cb.checked;
            cb.dispatchEvent(new Event('change'));
        }

        if (actionType === 'copy-url') {
            navigator.clipboard.writeText(action.dataset.url);
            Ravaa.toast('URL berhasil disalin!', 'success');
        }

        if (actionType === 'view') {
            openGallery(action.dataset.id);
        }

        if (actionType === 'delete') {
            Ravaa.confirm('Hapus Media?', `File "${action.dataset.name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`, 'error').then(function(result) {
                if (result.isConfirmed) {
                    deleteMedia(action.dataset.id);
                }
            });
        }
    });

    // Bulk delete
    bulkDeleteBtn.addEventListener('click', function() {
        if (selectedIds.size === 0) return;
        Ravaa.confirm('Hapus Media Terpilih?', `Anda akan menghapus <strong>${selectedIds.size}</strong> file. Tindakan ini tidak dapat dibatalkan!`, 'error').then(function(result) {
            if (result.isConfirmed) {
                bulkDeleteMedia([...selectedIds]);
            }
        });
    });

    deselectAllBtn.addEventListener('click', function() {
        selectedIds.clear();
        document.querySelectorAll('.media-item.selected, .media-list-item.selected').forEach(el => el.classList.remove('selected'));
        listView.querySelectorAll('.form-check-input:checked').forEach(cb => cb.checked = false);
        updateBulkUI();
    });

    function updateBulkUI() {
        selectedCount.textContent = selectedIds.size;
        bulkActions.style.display = selectedIds.size > 0 ? 'flex' : 'none';
    }

    async function deleteMedia(id) {
        try {
            const response = await fetch('{{ url("admin/media") }}/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            if (response.ok) {
                // Remove from both grid and list views
                const gridItem = document.querySelector('.media-item[data-id="' + id + '"]');
                if (gridItem) gridItem.remove();
                const listItem = document.querySelector('.media-list-item[data-id="' + id + '"]');
                if (listItem) listItem.remove();
                selectedIds.delete(id);
                updateBulkUI();
                Ravaa.toast('File berhasil dihapus!', 'success');
            } else {
                const data = await response.json().catch(() => ({}));
                Ravaa.toast(data.message || 'Gagal menghapus file', 'error');
            }
        } catch (err) {
            Ravaa.toast('Gagal menghapus: ' + err.message, 'error');
        }
    }

    async function bulkDeleteMedia(ids) {
        try {
            const response = await fetch('{{ route("admin.media.bulk.destroy") }}', {
                method: 'DELETE',
                body: JSON.stringify({ ids }),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });
            if (response.ok) {
                ids.forEach(id => {
                    const gridItem = document.querySelector('.media-item[data-id="' + id + '"]');
                    if (gridItem) gridItem.remove();
                    const listItem = document.querySelector('.media-list-item[data-id="' + id + '"]');
                    if (listItem) listItem.remove();
                });
                selectedIds.clear();
                updateBulkUI();
                Ravaa.toast(ids.length + ' file berhasil dihapus!', 'success');
            } else {
                const data = await response.json().catch(() => ({}));
                Ravaa.toast(data.message || 'Gagal menghapus file', 'error');
            }
        } catch (err) {
            Ravaa.toast('Gagal menghapus: ' + err.message, 'error');
        }
    }

    // ==================== Fullscreen Gallery ====================
    let galleryItems = [];
    let galleryIndex = 0;

    function getGalleryItems() {
        const items = [];
        document.querySelectorAll('.media-item').forEach(el => {
            const btn = el.querySelector('[data-action="view"]');
            if (btn) {
                items.push({
                    id: el.dataset.id,
                    url: btn.dataset.url,
                    name: btn.dataset.name,
                });
            }
        });
        return items;
    }

    function openGallery(id) {
        galleryItems = getGalleryItems();
        galleryIndex = galleryItems.findIndex(item => item.id === id);
        if (galleryIndex === -1) galleryIndex = 0;
        renderGallery();
        document.getElementById('galleryOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeGallery() {
        document.getElementById('galleryOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    function navigateGallery(dir) {
        galleryIndex += dir;
        if (galleryIndex < 0) galleryIndex = galleryItems.length - 1;
        if (galleryIndex >= galleryItems.length) galleryIndex = 0;
        renderGallery();
    }

    function renderGallery() {
        const item = galleryItems[galleryIndex];
        if (!item) return;
        const content = document.getElementById('galleryContent');
        const filename = document.getElementById('galleryFilename');
        const counter = document.getElementById('galleryCounter');

        const isImage = /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(item.url);
        if (isImage) {
            content.innerHTML = '<img src="' + item.url + '" alt="' + item.name + '">';
        } else {
            content.innerHTML = '<div class="gallery-file-info"><i class="bi bi-file-earmark"></i><p>' + item.name + '</p><a href="' + item.url + '" target="_blank" class="btn btn-primary btn-sm mt-2"><i class="bi bi-box-arrow-up-right"></i> Buka File</a></div>';
        }
        filename.textContent = item.name;
        counter.textContent = (galleryIndex + 1) + ' / ' + galleryItems.length;
    }

    // Gallery controls
    document.getElementById('galleryClose').addEventListener('click', closeGallery);
    document.getElementById('galleryPrev').addEventListener('click', function() { navigateGallery(-1); });
    document.getElementById('galleryNext').addEventListener('click', function() { navigateGallery(1); });

    // Click outside image to close
    document.getElementById('galleryOverlay').addEventListener('click', function(e) {
        if (e.target === this || e.target.classList.contains('gallery-content')) {
            closeGallery();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const overlay = document.getElementById('galleryOverlay');
        if (!overlay.classList.contains('active')) return;
        if (e.key === 'Escape') closeGallery();
        if (e.key === 'ArrowLeft') navigateGallery(-1);
        if (e.key === 'ArrowRight') navigateGallery(1);
    });
});
</script>
@endpush
@endsection
