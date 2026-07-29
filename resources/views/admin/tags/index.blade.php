@extends('admin.layouts.app')

@section('page-title', 'Tag Produk')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.tags.index') }}">Tag Produk</a>
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="glass-card">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">Daftar Tag Produk</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_tag">
                <i class="bi bi-plus-circle"></i> Tambah Tag
            </button>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body">
{{-- Search & Filters --}}
<div class="table-toolbar" style="display:block !important;">
    <div class="toolbar-group" style="display:block !important;">
        <div style="display:flex !important; align-items:center; gap:8px; flex-wrap:nowrap !important; white-space:nowrap;">
            <div class="input-group input-group-sm" style="width:280px;flex-shrink:0;">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control"
                       data-kt-tag-table-filter="search"
                       placeholder="Cari tag..."
                       name="search"
                       value="{{ $filters['search'] ?? '' }}">
            </div>
            <button type="button" class="btn btn-light btn-sm" id="kt_tag_reset_filter" style="flex-shrink:0;">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </button>
        </div>
    </div>
</div>

        {{-- Table --}}
        <div id="table-container">
            @include('admin.tags._table', ['tags' => $tags])
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<!--begin::Modal - Add Tag-->
<div class="modal fade" id="kt_modal_add_tag" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Tag</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            
            <form id="kt_modal_add_tag_form" class="form" action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Nama Tag</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="Masukkan nama tag" 
                               name="name" 
                               id="add_tag_name"
                               required />
                        <div class="text-danger fs-8 mt-1" id="add_name-error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Slug (URL)</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="slug-otomatis-jika-kosong" 
                               name="slug" 
                               id="add_tag_slug" />
                    </div>

                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Warna Badge</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select form-select-sm" name="color" id="add_tag_color" required>
                                <option value="primary" selected>Blue</option>
                                <option value="success">Green</option>
                                <option value="info">Cyan</option>
                                <option value="warning">Yellow</option>
                                <option value="danger">Red</option>
                                <option value="dark">Dark</option>
                            </select>
                            <span style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0,113,227,0.12); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-tag" id="add_tag_color_preview" style="color: #0071e3; font-size: 0.85rem;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="kt_modal_add_tag_submit">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Mohon tunggu...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal - Add Tag-->

<!--begin::Modal - Edit Tag-->
<div class="modal fade" id="kt_modal_edit_tag" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Tag</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            
            <form id="kt_modal_edit_tag_form" class="form" method="POST" data-update-url="{{ route('admin.tags.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_tag_id" />
                <div class="modal-body py-4 px-4">
                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Nama Tag</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="Masukkan nama tag" 
                               name="name" 
                               id="edit_tag_name"
                               required />
                        <div class="text-danger fs-8 mt-1" id="edit_name-error"></div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Slug (URL)</label>
                        <input type="text" class="form-control form-control-sm" 
                               placeholder="slug-tag" 
                               name="slug" 
                               id="edit_tag_slug" />
                    </div>

                    <div class="fv-row mb-3">
                        <label class="required fs-7 fw-semibold mb-1">Warna Badge</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select form-select-sm" name="color" id="edit_tag_color" required>
                                <option value="primary">Blue</option>
                                <option value="success">Green</option>
                                <option value="info">Cyan</option>
                                <option value="warning">Yellow</option>
                                <option value="danger">Red</option>
                                <option value="dark">Dark</option>
                            </select>
                            <span style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0,113,227,0.12); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-tag" id="edit_tag_color_preview" style="color: #0071e3; font-size: 0.85rem;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="kt_modal_edit_tag_submit">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">Mohon tunggu...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal - Edit Tag-->

<!-- Hidden Forms for Actions -->
<form id="delete-form" method="POST" data-delete-url="{{ route('admin.tags.destroy', ':id') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="bulk-delete-form" method="POST" action="{{ route('admin.tags.bulk.destroy') }}" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
const COLOR_MAP_TAG = {
    'primary': '#0071e3',
    'success': '#15803d',
    'info':    '#0891b2',
    'warning': '#b45309',
    'danger':  '#b91c1c',
    'dark':    '#1e293b',
};

const COLOR_RGB_MAP_TAG = {
    'primary': '0,113,227',
    'success': '21,128,61',
    'info':    '8,145,178',
    'warning': '180,83,9',
    'danger':  '185,28,28',
    'dark':    '30,41,59',
};

document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            Ravaa.toast('{{ $error }}', 'error');
        @endforeach
    @endif

    // ===== BULK SELECT & DELETE =====
    const tableContainer = document.getElementById('table-container');

    function updateBulkDeleteButton() {
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        if (!bulkDeleteBtn) return;
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        if (selectedIds.length > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
            bulkDeleteBtn.innerHTML = '<i class="bi bi-trash"></i> Hapus Terpilih (' + selectedIds.length + ')';
        } else {
            bulkDeleteBtn.style.display = 'none';
        }
    }

    function initializeTableEvents() {
        const selectAll = document.getElementById('select-all');
        const selectItems = tableContainer.querySelectorAll('.select-item');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                selectItems.forEach(item => { item.checked = this.checked; });
                updateBulkDeleteButton();
            });
        }
        selectItems.forEach(item => {
            item.addEventListener('change', updateBulkDeleteButton);
        });
        updateBulkDeleteButton();
    }
    initializeTableEvents();

    document.addEventListener('click', function(e) {
        const bulkDeleteBtn = e.target.closest('#bulk-delete-btn');
        if (!bulkDeleteBtn) return;
        const selectedItems = tableContainer.querySelectorAll('.select-item:checked');
        const selectedIds = Array.from(selectedItems).map(item => item.value);
        if (selectedIds.length === 0) {
            Ravaa.toast('Silakan pilih tag yang akan dihapus', 'warning');
            return;
        }
        Ravaa.confirm('Hapus Tag Terpilih?', `Anda akan menghapus <strong>${selectedIds.length}</strong> tag. Tindakan ini tidak dapat dibatalkan!`, 'warning')
        .then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });

    // ===== FILTER =====
    const searchInput = document.querySelector('[data-kt-tag-table-filter="search"]');
    const resetBtn = document.getElementById('kt_tag_reset_filter');

    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (page > 1) url.searchParams.set('page', page); else url.searchParams.delete('page');
        try {
            const response = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            tableContainer.innerHTML = await response.text();
            window.history.pushState({}, '', url.toString());
            initializeTableEvents();
        } catch (e) { Ravaa.toast('Gagal memfilter', 'error'); }
        finally { tableContainer.style.opacity = '1'; }
    }

    let searchTimer;
    if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => applyFilters(), 500); });
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; applyFilters(); });
});

// ---- Color preview sync ----
function syncTagColorPreview(selectId, previewId) {
    const select = document.getElementById(selectId);
    const preview = document.getElementById(previewId);
    if (!select || !preview) return;

    function update() {
        const color = COLOR_MAP_TAG[select.value] || '#0071e3';
        preview.style.color = color;
        preview.closest('span').style.background = `rgba(${COLOR_RGB_MAP_TAG[select.value] || '0,113,227'},0.12)`;
    }

    update();
    select.addEventListener('change', update);
}

document.addEventListener('DOMContentLoaded', () => {
    syncTagColorPreview('add_tag_color', 'add_tag_color_preview');
    syncTagColorPreview('edit_tag_color', 'edit_tag_color_preview');
});

// ---- Add Tag ----
document.addEventListener('DOMContentLoaded', function () {
    const addForm = document.getElementById('kt_modal_add_tag_form');
    const addSubmitButton = document.getElementById('kt_modal_add_tag_submit');

    addForm.addEventListener('submit', function(e) {
        e.preventDefault();

        addSubmitButton.setAttribute('data-kt-indicator', 'on');
        addSubmitButton.disabled = true;

        // Clear previous errors
        document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            addSubmitButton.removeAttribute('data-kt-indicator');
            addSubmitButton.disabled = false;

            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const errorElement = document.getElementById(`add_${key}-error`);
                    if (errorElement) {
                        errorElement.textContent = data.errors[key][0];
                    }
                });
                Ravaa.toast('Terdapat kesalahan validasi', 'error');
            } else if (data.success) {
                bootstrap.Modal.getInstance(
                    document.getElementById('kt_modal_add_tag')
                ).hide();
                Ravaa.toast(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            addSubmitButton.removeAttribute('data-kt-indicator');
            addSubmitButton.disabled = false;
            console.error('Error:', error);
            Ravaa.toast('Terjadi kesalahan saat menyimpan data', 'error');
        });
    });

    document.getElementById('kt_modal_add_tag')
    .addEventListener('shown.bs.modal', () => {
        document.getElementById('add_tag_name').focus();
    });

    document.getElementById('kt_modal_add_tag')
    .addEventListener('hidden.bs.modal', () => {
        addForm.reset();
        document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');
        // Reset color preview
        const preview = document.getElementById('add_tag_color_preview');
        if (preview) {
            preview.style.color = '#0071e3';
            preview.closest('span').style.background = 'rgba(0,113,227,0.12)';
        }
    });
});

// ---- Edit Tag ----
async function editTag(id) {
    try {
        const response = await fetch(`/admin/tags/${id}/edit`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            const tag = data.tag;

            document.getElementById('edit_tag_id').value = tag.id;
            document.getElementById('edit_tag_name').value = tag.name;
            document.getElementById('edit_tag_slug').value = tag.slug;
            document.getElementById('edit_tag_color').value = tag.color;

            // Update preview
            const color = COLOR_MAP_TAG[tag.color] || '#0071e3';
            const preview = document.getElementById('edit_tag_color_preview');
            if (preview) {
                preview.style.color = color;
                preview.closest('span').style.background = `rgba(${COLOR_RGB_MAP_TAG[tag.color] || '0,113,227'},0.12)`;
            }

            const form = document.getElementById('kt_modal_edit_tag_form');
            form.action = form.dataset.updateUrl.replace(':id', tag.id);
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_tag'));
            modal.show();
        } else {
            Ravaa.toast(data.message || 'Gagal memuat data tag', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        Ravaa.toast('Gagal memuat data tag', 'error');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const editForm = document.getElementById('kt_modal_edit_tag_form');
    const editSubmitButton = document.getElementById('kt_modal_edit_tag_submit');

    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        editSubmitButton.setAttribute('data-kt-indicator', 'on');
        editSubmitButton.disabled = true;

        document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            editSubmitButton.removeAttribute('data-kt-indicator');
            editSubmitButton.disabled = false;

            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const errorElement = document.getElementById(`edit_${key}-error`);
                    if (errorElement) {
                        errorElement.textContent = data.errors[key][0];
                    }
                });
                Ravaa.toast('Terdapat kesalahan validasi', 'error');
            } else if (data.success) {
                bootstrap.Modal.getInstance(
                    document.getElementById('kt_modal_edit_tag')
                ).hide();
                Ravaa.toast(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            editSubmitButton.removeAttribute('data-kt-indicator');
            editSubmitButton.disabled = false;
            console.error('Error:', error);
            Ravaa.toast('Terjadi kesalahan saat menyimpan data', 'error');
        });
    });

    document.getElementById('kt_modal_edit_tag')
    .addEventListener('shown.bs.modal', () => {
        document.getElementById('edit_tag_name').focus();
    });

    document.getElementById('kt_modal_edit_tag')
    .addEventListener('hidden.bs.modal', () => {
        document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');
    });
});

// ---- Delete Tag ----
function deleteTag(id, name) {
    Ravaa.confirm('Hapus Tag?', `Tag "${name}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!`).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-form');
            form.action = form.dataset.deleteUrl.replace(':id', id);
            form.submit();
        }
    });
}
</script>
@endpush
