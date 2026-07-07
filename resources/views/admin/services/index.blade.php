@extends('admin.layouts.app')

@section('page-title', 'Layanan')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.services.index') }}">Layanan</a>
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="glass-card">
    <div class="card-header">
        <div class="card-title">Daftar Layanan</div>
        <div class="card-header-btns">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_service">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-toolbar">
            <div class="toolbar-group">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 280px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control"
                               data-kt-service-table-filter="search"
                               placeholder="Cari Layanan..."
                               name="search"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="kt_service_reset_filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                </div>
            </div>
            <div class="toolbar-group">
                <select name="status" class="form-select form-select-sm" style="min-width: 110px;">
                    <option value="">Semua Status</option>
                    <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div id="kt_service_table_container">
            @include('admin.services._table')
        </div>
    </div>
</div>

<!-- Modal Add Service -->
<div class="modal fade" id="kt_modal_add_service" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Tambah Layanan</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_add_service_form" action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Nama Layanan</label>
                            <input type="text" class="form-control form-control-sm" name="name" placeholder="Desain Grafis" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Icon</label>
                            <select class="form-select form-select-sm" name="icon" id="add_service_icon">
                                <option value="">Pilih Icon...</option>
                                <optgroup label="Desain &amp; Percetakan">
                                    <option value="fas fa-paint-brush">🎨 Paint Brush</option>
                                    <option value="fas fa-palette">🎨 Palette</option>
                                    <option value="fas fa-print">🖨️ Print</option>
                                    <option value="fas fa-tshirt">👕 T-Shirt</option>
                                    <option value="fas fa-pen-fancy">🖊️ Pen</option>
                                    <option value="fas fa-pencil-ruler">📐 Pencil Ruler</option>
                                    <option value="fas fa-camera">📷 Camera</option>
                                    <option value="fas fa-video">🎥 Video</option>
                                    <option value="fas fa-film">🎬 Film</option>
                                    <option value="fas fa-music">🎵 Music</option>
                                    <option value="fas fa-magic">✨ Magic</option>
                                </optgroup>
                                <optgroup label="Teknologi">
                                    <option value="fas fa-code">💻 Code</option>
                                    <option value="fas fa-laptop-code">🖥️ Laptop Code</option>
                                    <option value="fas fa-desktop">🖥️ Desktop</option>
                                    <option value="fas fa-mobile-alt">📱 Mobile</option>
                                    <option value="fas fa-tablet-alt">📱 Tablet</option>
                                    <option value="fas fa-database">🗄️ Database</option>
                                    <option value="fas fa-cloud">☁️ Cloud</option>
                                    <option value="fas fa-server">🖧 Server</option>
                                    <option value="fas fa-shield-alt">🛡️ Shield</option>
                                    <option value="fas fa-robot">🤖 Robot</option>
                                    <option value="fas fa-cogs">⚙️ Cogs</option>
                                </optgroup>
                                <optgroup label="Bisnis &amp; Pemasaran">
                                    <option value="fas fa-bullhorn">📢 Bullhorn</option>
                                    <option value="fas fa-chart-line">📈 Chart Line</option>
                                    <option value="fas fa-chart-bar">📊 Chart Bar</option>
                                    <option value="fas fa-globe">🌐 Globe</option>
                                    <option value="fas fa-shopping-cart">🛒 Shopping Cart</option>
                                    <option value="fas fa-tags">🏷️ Tags</option>
                                    <option value="fas fa-rocket">🚀 Rocket</option>
                                    <option value="fas fa-star">⭐ Star</option>
                                    <option value="fas fa-gem">💎 Gem</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="fas fa-wrench">🔧 Wrench</option>
                                    <option value="fas fa-tools">🛠️ Tools</option>
                                    <option value="fas fa-lightbulb">💡 Lightbulb</option>
                                    <option value="fas fa-bolt">⚡ Bolt</option>
                                    <option value="fas fa-heart">❤️ Heart</option>
                                    <option value="fas fa-handshake">🤝 Handshake</option>
                                    <option value="fas fa-phone-alt">📞 Phone</option>
                                    <option value="fas fa-envelope">📧 Envelope</option>
                                    <option value="fas fa-comments">💬 Comments</option>
                                </optgroup>
                            </select>
                            <div class="form-text fs-8 mt-1">
                                Preview: <i class="fas fa-paint-brush" id="add_icon_preview"></i>
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Fitur (satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="4" name="features_text" placeholder="Logo & Brand Identity&#10;Brosur & Flyer&#10;Banner & Billboard"></textarea>
                        <div class="form-text fs-8">Setiap baris = satu fitur</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Urutan</label>
                            <input type="number" class="form-control form-control-sm" name="order" min="0" value="0">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1">
                                <label class="form-check-label fs-8">Featured</label>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);"><i class="bi bi-search me-1"></i> SEO</div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" name="meta_title" placeholder="Meta title untuk SEO">
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" rows="2" name="meta_description" placeholder="Meta description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Service -->
<div class="modal fade" id="kt_modal_edit_service" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h3 class="fw-bold">Edit Layanan</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></div>
            </div>
            <form id="kt_modal_edit_service_form" method="POST" data-update-url="{{ route('admin.services.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_service_id">
                <div class="modal-body py-4 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Nama Layanan</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="edit_service_name" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Icon</label>
                            <select class="form-select form-select-sm" name="icon" id="edit_service_icon">
                                <option value="">Pilih Icon...</option>
                                <optgroup label="Desain &amp; Percetakan">
                                    <option value="fas fa-paint-brush">🎨 Paint Brush</option>
                                    <option value="fas fa-palette">🎨 Palette</option>
                                    <option value="fas fa-print">🖨️ Print</option>
                                    <option value="fas fa-tshirt">👕 T-Shirt</option>
                                    <option value="fas fa-pen-fancy">🖊️ Pen</option>
                                    <option value="fas fa-pencil-ruler">📐 Pencil Ruler</option>
                                    <option value="fas fa-camera">📷 Camera</option>
                                    <option value="fas fa-video">🎥 Video</option>
                                    <option value="fas fa-film">🎬 Film</option>
                                    <option value="fas fa-music">🎵 Music</option>
                                    <option value="fas fa-magic">✨ Magic</option>
                                </optgroup>
                                <optgroup label="Teknologi">
                                    <option value="fas fa-code">💻 Code</option>
                                    <option value="fas fa-laptop-code">🖥️ Laptop Code</option>
                                    <option value="fas fa-desktop">🖥️ Desktop</option>
                                    <option value="fas fa-mobile-alt">📱 Mobile</option>
                                    <option value="fas fa-tablet-alt">📱 Tablet</option>
                                    <option value="fas fa-database">🗄️ Database</option>
                                    <option value="fas fa-cloud">☁️ Cloud</option>
                                    <option value="fas fa-server">🖧 Server</option>
                                    <option value="fas fa-shield-alt">🛡️ Shield</option>
                                    <option value="fas fa-robot">🤖 Robot</option>
                                    <option value="fas fa-cogs">⚙️ Cogs</option>
                                </optgroup>
                                <optgroup label="Bisnis &amp; Pemasaran">
                                    <option value="fas fa-bullhorn">📢 Bullhorn</option>
                                    <option value="fas fa-chart-line">📈 Chart Line</option>
                                    <option value="fas fa-chart-bar">📊 Chart Bar</option>
                                    <option value="fas fa-globe">🌐 Globe</option>
                                    <option value="fas fa-shopping-cart">🛒 Shopping Cart</option>
                                    <option value="fas fa-tags">🏷️ Tags</option>
                                    <option value="fas fa-rocket">🚀 Rocket</option>
                                    <option value="fas fa-star">⭐ Star</option>
                                    <option value="fas fa-gem">💎 Gem</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="fas fa-wrench">🔧 Wrench</option>
                                    <option value="fas fa-tools">🛠️ Tools</option>
                                    <option value="fas fa-lightbulb">💡 Lightbulb</option>
                                    <option value="fas fa-bolt">⚡ Bolt</option>
                                    <option value="fas fa-heart">❤️ Heart</option>
                                    <option value="fas fa-handshake">🤝 Handshake</option>
                                    <option value="fas fa-phone-alt">📞 Phone</option>
                                    <option value="fas fa-envelope">📧 Envelope</option>
                                    <option value="fas fa-comments">💬 Comments</option>
                                </optgroup>
                            </select>
                            <div class="form-text fs-8 mt-1">
                                Preview: <i class="fas fa-paint-brush" id="edit_icon_preview"></i>
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Fitur (satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="4" name="features_text" id="edit_service_features"></textarea>
                        <div class="form-text fs-8">Setiap baris = satu fitur</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Urutan</label>
                            <input type="number" class="form-control form-control-sm" name="order" id="edit_service_order" min="0">
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_service_status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="edit_service_featured">
                                <label class="form-check-label fs-8">Featured</label>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);"><i class="bi bi-search me-1"></i> SEO</div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" name="meta_title" id="edit_service_meta_title">
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" rows="2" name="meta_description" id="edit_service_meta_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" data-delete-url="{{ route('admin.services.destroy', ':id') }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="bulk-delete-form" method="POST" action="{{ route('admin.services.bulk.destroy') }}" style="display:none;">
    @csrf @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('styles')
<style>
    .input-group.input-group-sm .input-group-text { background: transparent; border-color: rgba(0,0,0,0.1); color: var(--text-muted); padding: 0.2rem 0.5rem; }
    .input-group.input-group-sm .form-control { border-left: 0; }
    .input-group.input-group-sm:focus-within .input-group-text,
    .input-group.input-group-sm:focus-within .form-control { border-color: var(--accent); }
    .input-group.input-group-sm:focus-within .form-control { box-shadow: 0 0 0 2px var(--accent-light); }
    .card-header-btns { display: flex; align-items: center; gap: 0.35rem; }
    .pagination { margin: 0 !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif

    // Helper: update icon preview element
    function updateIconPreview(elementId, iconClass) {
        const preview = document.getElementById(elementId);
        if (preview) {
            // Remove all existing classes and add the new icon class
            preview.className = iconClass || 'fas fa-paint-brush';
        }
    }

    // Icon preview on select change
    document.getElementById('add_service_icon')?.addEventListener('change', function() {
        updateIconPreview('add_icon_preview', this.value);
    });
    document.getElementById('edit_service_icon')?.addEventListener('change', function() {
        updateIconPreview('edit_icon_preview', this.value);
    });

    // Helper: convert features array to newline-separated text
    function featuresToText(features) {
        if (!features || !Array.isArray(features)) return '';
        return features.join('\n');
    }

    // Helper: convert newline-separated text to features array
    function textToFeatures(text) {
        if (!text) return [];
        return text.split('\n').map(s => s.trim()).filter(Boolean);
    }

    // Add form submit
    const addForm = document.getElementById('kt_modal_add_service_form');
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Convert features_text to features[] array
        const featuresText = this.querySelector('textarea[name="features_text"]').value;
        const features = textToFeatures(featuresText);
        // Remove old dynamic inputs
        this.querySelectorAll('input[name="features[]"]').forEach(el => el.remove());
        features.forEach(f => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'features[]';
            input.value = f;
            this.appendChild(input);
        });
        this.querySelector('textarea[name="features_text"]').remove();
        this.submit();
    });

    // Edit form submit
    const editForm = document.getElementById('kt_modal_edit_service_form');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const featuresText = this.querySelector('textarea[name="features_text"]').value;
        const features = textToFeatures(featuresText);
        this.querySelectorAll('input[name="features[]"]').forEach(el => el.remove());
        features.forEach(f => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'features[]';
            input.value = f;
            this.appendChild(input);
        });
        this.querySelector('textarea[name="features_text"]').remove();
        this.submit();
    });

    // Edit service function
    window.editService = async function(id) {
        const response = await fetch(`/admin/services/${id}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const s = data.service;
            document.getElementById('edit_service_id').value = s.id;
            document.getElementById('edit_service_name').value = s.name;
            document.getElementById('edit_service_icon').value = s.icon || '';
            document.getElementById('edit_service_features').value = featuresToText(s.features);
            document.getElementById('edit_service_order').value = s.order;
            document.getElementById('edit_service_status').value = s.status;
            document.getElementById('edit_service_featured').checked = s.is_featured;
            document.getElementById('edit_service_meta_title').value = s.meta_title || '';
            document.getElementById('edit_service_meta_description').value = s.meta_description || '';
            // Update icon preview
            updateIconPreview('edit_icon_preview', s.icon || '');
            const form = document.getElementById('kt_modal_edit_service_form');
            form.action = form.dataset.updateUrl.replace(':id', s.id);
            // Tampilkan modal edit
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_service'));
            modal.show();
        }
    };

    // Delete
    window.deleteService = function(id, name) {
        Ravaa.confirm('Hapus Layanan?', `Layanan "${name}" akan dihapus permanen!`).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // Status toggle
    window.toggleStatus = function(id, status, name) {
        const action = status === 'active' ? 'Aktifkan' : 'Nonaktifkan';
        Ravaa.confirm(`${action} Layanan?`, `Layanan "${name}" akan di${action.toLowerCase()}.`, 'question').then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/services/${id}/status`;
                form.innerHTML = `@csrf @method('PUT') <input type="hidden" name="status" value="${status}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    // Filters
    const tableContainer = document.getElementById('kt_service_table_container');
    const searchInput = document.querySelector('[data-kt-service-table-filter="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const resetBtn = document.getElementById('kt_service_reset_filter');

    async function applyFilters(page = 1) {
        tableContainer.style.opacity = '0.5';
        const url = new URL(window.location.href);
        const search = searchInput.value;
        const status = statusFilter.value;
        if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
        if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
        if (page > 1) url.searchParams.set('page', page); else url.searchParams.delete('page');
        try {
            const response = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            tableContainer.innerHTML = await response.text();
            window.history.pushState({}, '', url.toString());
        } catch (e) { Ravaa.toast('Gagal memfilter', 'error'); }
        finally { tableContainer.style.opacity = '1'; }
    }

    let searchTimer;
    if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => applyFilters(), 500); });
    if (statusFilter) statusFilter.addEventListener('change', () => applyFilters());
    if (resetBtn) resetBtn.addEventListener('click', () => { searchInput.value = ''; statusFilter.value = ''; applyFilters(); });
});
</script>
@endpush
