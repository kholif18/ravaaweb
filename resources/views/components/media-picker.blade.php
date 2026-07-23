@props([
    'name' => 'media_ids',
    'multiple' => false,
    'type' => 'image',
    'label' => 'Pilih dari Library',
    'value' => '',
    'media' => null, // Collection/array of Media objects for pre-rendering thumbnails
])

@php
    // Normalize value: accept array, Collection, or comma-separated string
    $mediaValue = '';
    if ($value) {
        if (is_array($value)) {
            $mediaValue = implode(',', $value);
        } elseif ($value instanceof \Illuminate\Support\Collection) {
            $mediaValue = $value->implode(',');
        } else {
            $mediaValue = (string) $value;
        }
    }

    // Normalize media objects for pre-rendering — always a Collection
    $mediaObjects = collect();
    if ($media) {
        if ($media instanceof \Illuminate\Support\Collection) {
            $mediaObjects = $media->values();
        } elseif (is_array($media)) {
            $mediaObjects = collect($media);
        }
    }
@endphp

<div class="media-picker-wrapper" data-multiple="{{ $multiple ? 'true' : 'false' }}" data-type="{{ $type }}">
    <!-- Selected media preview -->
    <div class="media-picker-selected" id="{{ $name }}-selected">
        @if($mediaObjects->count() > 0)
            @foreach($mediaObjects as $item)
                <div class="media-picker-thumb">
                    @if($item->isImage())
                        <img src="{{ $item->url }}" alt="{{ $item->name }}">
                    @else
                        <div class="media-thumb-icon">
                            @if(str_starts_with($item->mime_type ?? '', 'video/'))
                                <i class="bi bi-play-circle"></i>
                            @elseif(str_starts_with($item->mime_type ?? '', 'audio/'))
                                <i class="bi bi-music-note"></i>
                            @else
                                <i class="bi bi-file-earmark"></i>
                            @endif
                        </div>
                    @endif
                    <button type="button" class="remove-media" onclick="removePickerItem('{{ $name }}', '{{ $item->id }}')"><i class="bi bi-x"></i></button>
                </div>
            @endforeach
        @else
            <div class="media-picker-empty">
                <i class="bi bi-image"></i>
                <span>Belum ada media dipilih</span>
            </div>
        @endif
    </div>

    <!-- Open picker button -->
    <button type="button" class="btn btn-outline-primary btn-sm" onclick="openMediaPicker('{{ $name }}', {{ $multiple ? 'true' : 'false' }}, '{{ $type }}')">
        <i class="bi bi-images"></i> {{ $label }}
    </button>

    @if($multiple)
    <div class="gallery-reorder-hint"><i class="bi bi-arrows-move"></i> Seret gambar untuk mengubah urutan</div>
    @endif

    <input type="hidden" name="{{ $name }}" id="{{ $name }}-input" value="{{ $mediaValue }}">
    <!-- Dynamic array inputs for multi-select will be created by JS -->
    @if($multiple && $mediaValue)
        @foreach(explode(',', $mediaValue) as $mediaId)
            @if(trim($mediaId) !== '')
                <input type="hidden" name="{{ $name }}[]" value="{{ trim($mediaId) }}" class="dynamic-media-id">
            @endif
        @endforeach
    @endif
    @if($multiple)
        <input type="hidden" name="{{ $name }}_order" id="{{ $name }}-order-input" value="">
    @endif
</div>

@push('styles')
    <link href="{{ asset('admin/css/media-picker.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
<script>
// Media picker state
window.mediaPickerState = window.mediaPickerState || {};
window.currentPickerFieldName = null;

/**
 * Register a new target for the media‑picker.
 *
 * When variant cards are generated dynamically we need to make sure the
 * preview container (`${fieldName}-selected`) exists before the picker
 * tries to write the preview. The component normally renders the preview
 * container statically; for dynamic cards we create a dummy element if it
 * is missing.
 */
window.registerMediaPickerTarget = function (fieldName) {
    const preview = document.getElementById(fieldName + '-selected');
    if (!preview) {
        const wrapper = document.createElement('div');
        wrapper.id = fieldName + '-selected';
        wrapper.className = 'media-picker-selected';
        document.body.appendChild(wrapper);
    }
};

/**
 * Initialize media picker state from pre-rendered DOM thumbnails.
 * Called on page load for edit pages that already have selected media.
 */
window.initMediaPickerFromDOM = function (fieldName, multiple, type) {
    if (mediaPickerState[fieldName]) return; // Already initialized

    const preview = document.getElementById(fieldName + '-selected');
    if (!preview) return;

    const thumbs = preview.querySelectorAll('.media-picker-thumb');
    if (thumbs.length === 0) return;

    mediaPickerState[fieldName] = {
        multiple: multiple,
        type: type || '',
        selected: [],
        selectedItems: {},
        currentSearch: '',
    };

    thumbs.forEach(thumb => {
        const btn = thumb.querySelector('.remove-media');
        if (btn) {
            const onclick = btn.getAttribute('onclick');
            const match = onclick ? onclick.match(/'([^']+)'\)$/) : null;
            if (match && match[1]) {
                const id = match[1];
                mediaPickerState[fieldName].selected.push(id);

                // Clone thumb without the remove button for stored preview
                const thumbClone = thumb.cloneNode(true);
                const btnClone = thumbClone.querySelector('.remove-media');
                if (btnClone) btnClone.remove();
                mediaPickerState[fieldName].selectedItems[id] = thumbClone.innerHTML;
            }
        }
    });

    // Sync hidden input
    const input = document.getElementById(fieldName + '-input');
    if (input) {
        input.value = mediaPickerState[fieldName].selected.join(',');
    }
};

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    // Find all media picker wrappers and init from DOM
    document.querySelectorAll('.media-picker-wrapper').forEach(wrapper => {
        const input = wrapper.querySelector('input[type="hidden"][id$="-input"]');
        if (!input) return;
        const fieldName = input.id.replace('-input', '');
        const preview = document.getElementById(fieldName + '-selected');
        if (!preview) return;
        const hasThumbs = preview.querySelectorAll('.media-picker-thumb').length > 0;
        if (hasThumbs && !mediaPickerState[fieldName]) {
            const isMultiple = wrapper.dataset.multiple === 'true';
            const pickerType = wrapper.dataset.type || '';
            initMediaPickerFromDOM(fieldName, isMultiple, pickerType);
        }
    });

    // Init gallery reorder for existing multi-select pickers
    document.querySelectorAll('.media-picker-wrapper[data-multiple="true"]').forEach(wrapper => {
        const input = wrapper.querySelector('input[type="hidden"][id$="-input"]');
        if (input) {
            const fieldName = input.id.replace('-input', '');
            setTimeout(function() { initGalleryReorder(fieldName); }, 100);
        }
    });
});

function openMediaPicker(fieldName, multiple, type) {
    window.currentPickerFieldName = fieldName;
    
    if (!mediaPickerState[fieldName]) {
        mediaPickerState[fieldName] = {
            multiple,
            type,
            selected: [],
            selectedItems: {},
            currentSearch: '',
        };

        // Load existing values from hidden inputs
        const wrapper = document.getElementById(fieldName + '-input')
            ? document.getElementById(fieldName + '-input').closest('.media-picker-wrapper')
            : null;

        let existingIds = [];

        // Prefer dynamic array inputs (new format) if present
        if (wrapper) {
            const arrInputs = wrapper.querySelectorAll('input.dynamic-media-id');
            if (arrInputs.length > 0) {
                arrInputs.forEach(inp => { if (inp.value) existingIds.push(inp.value); });
            }
        }

        // Fallback to legacy single comma-separated input
        if (existingIds.length === 0) {
            const input = document.getElementById(fieldName + '-input');
            if (input && input.value) {
                existingIds = input.value.split(',').filter(Boolean);
            }
        }

        if (existingIds.length > 0) {
            mediaPickerState[fieldName].selected = existingIds;
            
            // Scrape existing HTML for these items from the DOM
            const thumbs = document.querySelectorAll(`#${fieldName}-selected .media-picker-thumb`);
            thumbs.forEach(thumb => {
                const btn = thumb.querySelector('.remove-media');
                if (btn) {
                    const match = btn.getAttribute('onclick').match(/'([^']+)'\)$/);
                    if (match && match[1]) {
                        const id = match[1];
                        const thumbContent = thumb.cloneNode(true);
                        const btnToRemove = thumbContent.querySelector('.remove-media');
                        if (btnToRemove) btnToRemove.remove();
                        mediaPickerState[fieldName].selectedItems[id] = thumbContent.innerHTML;
                    }
                }
            });
        }
    } else {
        mediaPickerState[fieldName].multiple = multiple;
        mediaPickerState[fieldName].type = type;
    }

    // Create or show modal
    let modal = document.getElementById('media-picker-modal');
    if (!modal) {
        modal = createMediaPickerModal();
        document.body.appendChild(modal);
    }

    document.getElementById('picker-search').value = mediaPickerState[fieldName].currentSearch || '';
    document.getElementById('picker-type-filter').value = mediaPickerState[fieldName].type || '';

    // Reset infinite scroll state for this load
    const grid = document.getElementById('picker-grid');
    grid.innerHTML = '';
    window._pickerInfiniteState = { page: 1, lastPage: 1, loading: false, total: 0 };

    loadPickerPage(1);
    new bootstrap.Modal(modal).show();
}

function createMediaPickerModal() {
    const modal = document.createElement('div');
    modal.id = 'media-picker-modal';
    modal.className = 'modal fade media-picker-modal';
    modal.tabIndex = -1;
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered media-picker-dialog">
            <div class="modal-content glass-card media-picker-content">
                <div class="card-header">
                    <div class="card-title">Pilih Media</div>
                    <div class="card-header-btns">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="card-body media-picker-body">
                    <div class="upload-zone" id="picker-upload-zone">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Klik atau seret file untuk upload</span>
                        <input type="file" id="picker-file-input" multiple accept="image/*,video/*,audio/*,.pdf,.doc,.docx" style="display:none;">
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="input-group input-group-sm media-picker-search">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="picker-search" placeholder="Cari media...">
                        </div>
                        <select class="form-select form-select-sm media-picker-type-filter" id="picker-type-filter">
                            <option value="">Semua Tipe</option>
                            <option value="image">Gambar</option>
                            <option value="video">Video</option>
                            <option value="audio">Audio</option>
                            <option value="document">Dokumen</option>
                        </select>
                    </div>
                    <div class="media-grid-picker" id="picker-grid"></div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <small class="text-muted" id="picker-count">0 item</small>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary btn-sm" id="picker-confirm-btn" onclick="confirmMediaPicker()">
                                <i class="bi bi-check-lg"></i> Pilih
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Search with debounce — reset infinite scroll and reload
    let searchTimeout;
    modal.querySelector('#picker-search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        if (window.currentPickerFieldName) {
            mediaPickerState[window.currentPickerFieldName].currentSearch = this.value;
            searchTimeout = setTimeout(() => {
                const grid = document.getElementById('picker-grid');
                grid.innerHTML = '';
                window._pickerInfiniteState = { page: 1, lastPage: 1, loading: false, total: 0 };
                loadPickerPage(1);
            }, 400);
        }
    });

    modal.querySelector('#picker-type-filter').addEventListener('change', function() {
        if (window.currentPickerFieldName) {
            mediaPickerState[window.currentPickerFieldName].type = this.value;
            const grid = document.getElementById('picker-grid');
            grid.innerHTML = '';
            window._pickerInfiniteState = { page: 1, lastPage: 1, loading: false, total: 0 };
            loadPickerPage(1);
        }
    });

    // Upload zone
    const uploadZone = modal.querySelector('#picker-upload-zone');
    const fileInput = modal.querySelector('#picker-file-input');

    uploadZone.addEventListener('click', () => fileInput.click());
    uploadZone.addEventListener('dragover', (e) => { e.preventDefault(); uploadZone.style.background = 'var(--accent)'; });
    uploadZone.addEventListener('dragleave', () => { uploadZone.style.background = ''; });
    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.style.background = '';
        if (e.dataTransfer.files.length && window.currentPickerFieldName) {
            pickerUploadFiles(window.currentPickerFieldName, e.dataTransfer.files);
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length && window.currentPickerFieldName) {
            pickerUploadFiles(window.currentPickerFieldName, this.files);
        }
    });

    // Infinite scroll: load more when user scrolls near bottom
    const grid = modal.querySelector('#picker-grid');
    grid.addEventListener('scroll', function() {
        const inf = window._pickerInfiniteState;
        if (!inf || inf.loading || inf.page >= inf.lastPage) return;

        // Trigger when within 200px of the bottom
        if (grid.scrollTop + grid.clientHeight >= grid.scrollHeight - 200) {
            loadPickerPage(inf.page + 1);
        }
    });

    return modal;
}

async function pickerUploadFiles(fieldName, files) {
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
            // Reload from page 1 after upload
            const grid = document.getElementById('picker-grid');
            grid.innerHTML = '';
            window._pickerInfiniteState = { page: 1, lastPage: 1, loading: false, total: 0 };
            loadPickerPage(1);
        } else {
            const data = await response.json();
            alert(data.message || 'Upload gagal');
        }
    } catch (err) {
        alert('Upload gagal: ' + err.message);
    }
}

/**
 * Load a page of media items and append to the grid (infinite scroll).
 * Page 1 clears the grid; page > 1 appends items.
 */
async function loadPickerPage(page) {
    const fieldName = window.currentPickerFieldName;
    if (!fieldName) return;
    const state = mediaPickerState[fieldName];
    const grid = document.getElementById('picker-grid');
    const countEl = document.getElementById('picker-count');
    const inf = window._pickerInfiniteState;

    if (inf.loading) return;
    inf.loading = true;

    // Show loading indicator (only when appending)
    let loadingEl = null;
    if (page > 1) {
        loadingEl = document.createElement('div');
        loadingEl.className = 'picker-loading-more';
        loadingEl.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
        grid.appendChild(loadingEl);
    }

    const params = new URLSearchParams({ page, per_page: 25 });
    if (state.currentSearch) params.set('search', state.currentSearch);
    if (state.type) params.set('type', state.type);

    try {
        const response = await fetch('{{ route("admin.media.picker") }}?' + params.toString(), {
            headers: { 'Accept': 'application/json' },
        });
        const result = await response.json();

        // Remove loading indicator
        if (loadingEl) loadingEl.remove();

        // Update infinite scroll state
        inf.page = result.pagination.current_page;
        inf.lastPage = result.pagination.last_page;
        inf.total = result.pagination.total;
        inf.loading = false;

        // Update count
        countEl.textContent = inf.total + ' item';

        // Page 1: clear grid. Page > 1: append.
        if (page === 1) {
            grid.innerHTML = '';
        }

        // Empty state
        if (result.data.length === 0 && page === 1) {
            grid.innerHTML = '<div class="text-center text-muted py-5" style="grid-column:1/-1;">Tidak ada media ditemukan</div>';
            return;
        }

        // Render items
        result.data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'media-picker-item' + (state.selected.includes(String(item.id)) ? ' selected' : '');
            div.dataset.id = item.id;
            div.dataset.url = item.url;
            div.dataset.name = item.file_name;
            div.onclick = () => togglePickerItem(item.id);

            if (item.mime_type && item.mime_type.startsWith('image/')) {
                div.innerHTML = `<div class="picker-thumb"><img src="${item.url}" alt="${item.file_name}"></div><div class="pick-icon"><i class="bi bi-check-lg"></i></div>`;
            } else {
                let icon = 'bi-file-earmark';
                if (item.mime_type && item.mime_type.startsWith('video/')) icon = 'bi-play-circle';
                else if (item.mime_type && item.mime_type.startsWith('audio/')) icon = 'bi-music-note';
                div.innerHTML = `<div class="picker-thumb"><div class="file-icon"><i class="bi ${icon}"></i></div></div><div class="pick-icon"><i class="bi bi-check-lg"></i></div>`;
            }

            grid.appendChild(div);
        });

    } catch (err) {
        if (loadingEl) loadingEl.remove();
        inf.loading = false;
        if (page === 1) {
            grid.innerHTML = '<div class="text-center text-danger py-5" style="grid-column:1/-1;">Gagal memuat media</div>';
        }
    }
}

function togglePickerItem(id) {
    const fieldName = window.currentPickerFieldName;
    if (!fieldName) return;
    const state = mediaPickerState[fieldName];
    const idStr = String(id);
    const itemEl = document.querySelector(`#picker-grid .media-picker-item[data-id="${idStr}"]`);

    if (state.multiple) {
        const idx = state.selected.indexOf(idStr);
        if (idx > -1) {
            state.selected.splice(idx, 1);
        } else {
            state.selected.push(idStr);
            if (itemEl) {
                let previewHtml = '';
                const img = itemEl.querySelector('img');
                if (img) {
                    previewHtml = `<img src="${img.src}" alt="">`;
                } else {
                    const icon = itemEl.querySelector('.file-icon i');
                    previewHtml = `<div class="media-thumb-icon"><i class="${icon ? icon.className : 'bi bi-file'}"></i></div>`;
                }
                state.selectedItems[idStr] = previewHtml;
            }
        }
    } else {
        state.selected = [idStr];
        if (itemEl) {
            let previewHtml = '';
            const img = itemEl.querySelector('img');
            if (img) {
                previewHtml = `<img src="${img.src}" alt="">`;
            } else {
                const icon = itemEl.querySelector('.file-icon i');
                previewHtml = `<div class="media-thumb-icon"><i class="${icon ? icon.className : 'bi bi-file'}"></i></div>`;
            }
            state.selectedItems[idStr] = previewHtml;
        }
    }

    // Update visual selection
    document.querySelectorAll('#picker-grid .media-picker-item').forEach(el => {
        el.classList.toggle('selected', state.selected.includes(el.dataset.id));
    });
}

function confirmMediaPicker(overrideFieldName) {
    const fieldName = overrideFieldName || window.currentPickerFieldName;
    if (!fieldName) return;
    const state = mediaPickerState[fieldName];
    const input = document.getElementById(fieldName + '-input');
    const selectedContainer = document.getElementById(fieldName + '-selected');
    const wrapper = input ? input.closest('.media-picker-wrapper') : null;

    // Determine if this picker is in multiple mode
    const isMultiple = state.multiple;

    if (isMultiple && wrapper) {
        // Remove existing dynamic array inputs
        wrapper.querySelectorAll('input.dynamic-media-id').forEach(el => el.remove());
        // Create individual hidden inputs for each selected ID so Laravel receives an array
        state.selected.forEach(id => {
            const arrInput = document.createElement('input');
            arrInput.type = 'hidden';
            arrInput.name = fieldName + '[]';
            arrInput.value = id;
            arrInput.className = 'dynamic-media-id';
            wrapper.appendChild(arrInput);
        });
        // Keep the original input empty (used only for state restoration)
        input.value = state.selected.join(',');
    } else if (input) {
        // Single mode: keep original behavior
        input.value = state.selected.join(',');
    }

    // Update preview
    if (selectedContainer) {
        if (state.selected.length === 0) {
            selectedContainer.innerHTML = `
                <div class="media-picker-empty">
                    <i class="bi bi-image"></i>
                    <span>Belum ada media dipilih</span>
                </div>
            `;
        } else {
            selectedContainer.innerHTML = '';
            state.selected.forEach(id => {
                const thumb = document.createElement('div');
                thumb.className = 'media-picker-thumb';
                
                let content = state.selectedItems[id] || `<div class="media-thumb-icon"><i class="bi bi-check2"></i></div>`;
                
                thumb.innerHTML = content + `<button type="button" class="remove-media" onclick="removePickerItem('${fieldName}', '${id}')"><i class="bi bi-x"></i></button>`;
                selectedContainer.appendChild(thumb);
            });
        }
    }

    // Close modal if called from the "Pilih" button (i.e. overrideFieldName is undefined)
    if (!overrideFieldName) {
        const modalEl = document.getElementById('media-picker-modal');
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }
    }

    // Init drag-and-drop reorder after rendering
    setTimeout(function() { initGalleryReorder(fieldName); }, 50);
}

function removePickerItem(fieldName, id) {
    const state = mediaPickerState[fieldName];
    if (state) {
        state.selected = state.selected.filter(i => i !== String(id));
        confirmMediaPicker(fieldName);
    }
}

// ===== GALLERY REORDER (drag-and-drop) =====
function initGalleryReorder(fieldName) {
    const container = document.getElementById(fieldName + '-selected');
    if (!container) return;
    const wrapper = container.closest('.media-picker-wrapper');
    if (!wrapper || wrapper.dataset.multiple !== 'true') return;

    // Remove old listeners by cloning
    container.querySelectorAll('.media-picker-thumb').forEach(thumb => {
        if (thumb._galleryDragHandlers) return;
        thumb._galleryDragHandlers = true;
        thumb.draggable = true;

        thumb.addEventListener('dragstart', function(e) {
            window._galleryDraggedEl = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', '');
        });

        thumb.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            if (this !== window._galleryDraggedEl) {
                this.classList.add('drag-over');
            }
        });

        thumb.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });

        thumb.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            const dragged = window._galleryDraggedEl;
            if (dragged && dragged !== this) {
                const allThumbs = [...container.querySelectorAll('.media-picker-thumb')];
                const draggedIdx = allThumbs.indexOf(dragged);
                const droppedIdx = allThumbs.indexOf(this);
                if (draggedIdx < droppedIdx) {
                    container.insertBefore(dragged, this.nextSibling);
                } else {
                    container.insertBefore(dragged, this);
                }
                syncGalleryOrder(fieldName);
            }
        });

        thumb.addEventListener('dragend', function() {
            this.classList.remove('dragging');
            container.querySelectorAll('.media-picker-thumb').forEach(t => t.classList.remove('drag-over'));
            window._galleryDraggedEl = null;
        });
    });
}

function syncGalleryOrder(fieldName) {
    const container = document.getElementById(fieldName + '-selected');
    const state = mediaPickerState[fieldName];
    if (!container) return;

    const thumbs = container.querySelectorAll('.media-picker-thumb');
    const newOrder = [];
    const newItems = {};

    thumbs.forEach(thumb => {
        const btn = thumb.querySelector('.remove-media');
        if (btn) {
            const match = btn.getAttribute('onclick') ? btn.getAttribute('onclick').match(/'([^']+)'\)$/) : null;
            if (match) {
                const id = match[1];
                newOrder.push(id);
                if (state && state.selectedItems[id]) newItems[id] = state.selectedItems[id];
            }
        }
    });

    if (state) {
        state.selected = newOrder;
        state.selectedItems = newItems;
    }

    const input = document.getElementById(fieldName + '-input');
    if (input) input.value = newOrder.join(',');

    const wrapper = input ? input.closest('.media-picker-wrapper') : null;
    if (wrapper) {
        wrapper.querySelectorAll('input.dynamic-media-id').forEach(el => el.remove());
        newOrder.forEach(id => {
            const arrInput = document.createElement('input');
            arrInput.type = 'hidden';
            arrInput.name = fieldName + '[]';
            arrInput.value = id;
            arrInput.className = 'dynamic-media-id';
            wrapper.appendChild(arrInput);
        });
    }
}
</script>
@endpush
