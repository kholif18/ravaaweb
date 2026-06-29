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
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 280px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               id="media-search"
                               placeholder="Cari Media..."
                               value="{{ request('search') }}">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="media-reset-filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
            <div class="toolbar-group">
                <select id="media-type-filter" class="form-select form-select-sm" style="min-width: 130px;">
                    <option value="">Semua Tipe</option>
                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="audio" {{ request('type') == 'audio' ? 'selected' : '' }}>Audio</option>
                    <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                </select>
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

        <!-- Media grid -->
        <div class="media-grid" id="media-grid">
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

        <!-- Pagination -->
        <div class="pagination-toolbar">
            <x-pagination :paginator="$media" label="media" :perPage="$media->perPage()" />
        </div>
    </div>
</div>

<!-- View Media Modal -->
<div class="modal fade" id="modal-view-media" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card">
            <div class="card-header">
                <div class="card-title" id="modal-view-media-title">Preview</div>
                <div class="card-header-btns">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="card-body text-center" id="modal-view-media-body">
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* ==============================
       MEDIA LIBRARY GRID
    ============================== */
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
        padding: 4px 0;
    }

    .media-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: var(--bg-surface);
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .media-item:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .media-item.selected {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-light);
    }

    .media-select {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .media-item:hover .media-select,
    .media-item.selected .media-select {
        opacity: 1;
    }

    .media-item.selected .media-select {
        background: var(--accent);
    }

    .media-preview {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-surface-alt);
    }

    .media-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .media-file-preview {
        font-size: 48px;
        color: var(--text-muted);
    }

    .media-info {
        padding: 8px 10px;
    }

    .media-name {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .media-meta {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .media-actions {
        position: absolute;
        bottom: 8px;
        right: 8px;
        display: flex;
        gap: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .media-item:hover .media-actions {
        opacity: 1;
    }

    .btn-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--bg-surface);
        color: var(--text-primary);
        backdrop-filter: blur(10px);
    }

    .btn-icon:hover {
        background: var(--accent);
        color: #fff;
    }

    .btn-icon.btn-danger:hover {
        background: var(--danger);
        color: #fff;
    }

    .media-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }

    .media-empty i {
        font-size: 48px;
        margin-bottom: 12px;
        display: block;
    }

    /* Upload drop zone */
    .upload-drop-zone {
        border: 2px dashed var(--accent);
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        margin-bottom: 16px;
        background: var(--accent-light);
        transition: all 0.3s ease;
    }

    .upload-drop-zone.dragover {
        background: var(--accent);
        color: #fff;
    }

    .drop-zone-content i {
        font-size: 48px;
        color: var(--accent);
        margin-bottom: 8px;
    }

    .upload-drop-zone.dragover .drop-zone-content i,
    .upload-drop-zone.dragover .drop-zone-content p,
    .upload-drop-zone.dragover .drop-zone-content small {
        color: #fff;
    }

    /* Bulk actions */
    .bulk-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        background: var(--accent-light);
        border-radius: 10px;
        margin-bottom: 16px;
        border: 1px solid var(--accent);
    }

    .bulk-info {
        font-size: 14px;
        font-weight: 500;
        color: var(--accent);
    }

    .bulk-btns {
        display: flex;
        gap: 8px;
    }
</style>
@endpush

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

    // Select media
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
            } else {
                selectedIds.add(id);
                mediaItem.classList.add('selected');
            }
            updateBulkUI();
        }

        if (actionType === 'copy-url') {
            navigator.clipboard.writeText(action.dataset.url);
            Ravaa.toast('URL berhasil disalin!', 'success');
        }

        if (actionType === 'view') {
            const modal = new bootstrap.Modal(document.getElementById('modal-view-media'));
            const title = document.getElementById('modal-view-media-title');
            const body = document.getElementById('modal-view-media-body');
            title.textContent = action.dataset.name;
            if (action.dataset.url.match(/\.(jpg|jpeg|png|gif|webp|svg)$/i)) {
                body.innerHTML = '<img src="' + action.dataset.url + '" style="max-width:100%;border-radius:8px;">';
            } else {
                body.innerHTML = '<a href="' + action.dataset.url + '" target="_blank" class="btn btn-primary">Buka File</a>';
            }
            modal.show();
        }

        if (actionType === 'delete') {
            if (confirm('Yakin ingin menghapus "' + action.dataset.name + '"?')) {
                deleteMedia(action.dataset.id);
            }
        }
    });

    // Bulk delete
    bulkDeleteBtn.addEventListener('click', function() {
        if (selectedIds.size === 0) return;
        if (confirm('Yakin ingin menghapus ' + selectedIds.size + ' file?')) {
            bulkDeleteMedia([...selectedIds]);
        }
    });

    deselectAllBtn.addEventListener('click', function() {
        selectedIds.clear();
        document.querySelectorAll('.media-item.selected').forEach(el => el.classList.remove('selected'));
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
                document.querySelector('.media-item[data-id="' + id + '"]').remove();
                Ravaa.toast('File berhasil dihapus!', 'success');
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
                    const el = document.querySelector('.media-item[data-id="' + id + '"]');
                    if (el) el.remove();
                });
                selectedIds.clear();
                updateBulkUI();
                Ravaa.toast(ids.length + ' file berhasil dihapus!', 'success');
            }
        } catch (err) {
            Ravaa.toast('Gagal menghapus: ' + err.message, 'error');
        }
    }

});
</script>
@endpush
@endsection
