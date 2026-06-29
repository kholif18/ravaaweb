@extends('admin.layouts.app')

@section('page-title', 'Tambah Produk')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.products.index') }}">Produk</a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="text-muted">Tambah Produk</span>
    </li>
@endsection

@section('content')
<form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row g-4">
    <!-- ========== MAIN CONTENT (80%) ========== -->
    <div class="col-md-8">
        <!-- Nama & Slug -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Informasi Dasar</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Nama Produk</label>
                    <input type="text" class="form-control form-control-sm"
                           name="name" id="product-name"
                           placeholder="Masukkan nama produk" required
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="fv-row mb-0">
                    <label class="fs-7 fw-semibold mb-2">Slug</label>
                    <input type="text" class="form-control form-control-sm"
                           name="slug" id="product-slug"
                           placeholder="otomatis dari nama produk"
                           value="{{ old('slug') }}">
                    <div class="form-text fs-8">Kosongkan untuk auto-generate dari nama produk</div>
                </div>
            </div>
        </div>

        <!-- Deskripsi Singkat -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Deskripsi Singkat</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-0">
                    <textarea class="form-control form-control-sm"
                              name="short_description" rows="3"
                              placeholder="Deskripsi singkat produk (ditampilkan di list/preview)...">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Varian Produk -->
        <div class="glass-card mb-4" id="variant-section">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-palette me-1"></i> Varian Produk</div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-variant-type">
                    <i class="bi bi-plus"></i> Tambah Tipe
                </button>
            </div>
            <div class="card-body">
                <div id="variant-types-container">
                    <!-- Variant types will be added here by JS -->
                </div>

                <div id="generate-variant-wrapper" class="d-none mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-generate-variants">
                        <i class="bi bi-magic"></i> Generate Varian
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm ms-2" id="btn-clear-variants">
                        <i class="bi bi-trash"></i> Hapus Semua
                    </button>
                </div>

                <!-- Generated Variant Forms -->
                <div id="generated-variants" class="mt-3">
                    <!-- Will be filled by JS -->
                </div>
            </div>
        </div>

        <!-- Tanpa Varian - Form Utama (shown when no variant types) -->
        <div class="glass-card mb-4" id="no-variant-form">
            <div class="card-header">
                <div class="card-title">Harga & Stok</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4 fv-row">
                        <label class="required fs-7 fw-semibold mb-2">SKU</label>
                        <input type="text" class="form-control form-control-sm"
                               name="sku" placeholder="Kode unik produk"
                               value="{{ old('sku') }}">
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="required fs-7 fw-semibold mb-2">Harga (Rp)</label>
                        <input type="number" class="form-control form-control-sm"
                               name="price" min="0" step="100"
                               placeholder="0" required
                               value="{{ old('price') }}">
                        @error('price')
                            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Berat</label>
                        <input type="text" class="form-control form-control-sm"
                               name="weight" placeholder="Contoh: 500g"
                               value="{{ old('weight') }}">
                    </div>
                </div>

                <!-- Diskon -->
                <div class="row g-3 mt-1">
                    <div class="col-md-12">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="no_discount_switch" id="no-discount-switch"
                                   onchange="toggleNoVariantDiscount(this)">
                            <label class="form-check-label fs-7 fw-semibold" for="no-discount-switch">Aktifkan Diskon</label>
                        </div>
                    </div>
                    <div id="no-variant-discount-fields" class="d-none w-100">
                        <div class="row g-3">
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Persen Diskon (%)</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="discount_percent" min="0" max="100"
                                       placeholder="0" id="no-discount-percent"
                                       oninput="calcNoVariantDiscount(this)"
                                       value="{{ old('discount_percent') }}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Harga Diskon (Rp)</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="price_discount" min="0" step="100"
                                       placeholder="0" id="no-price-discount"
                                       value="{{ old('price_discount') }}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Mulai Diskon</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="discount_start"
                                       value="{{ old('discount_start') }}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Akhir Diskon</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="discount_end"
                                       value="{{ old('discount_end') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dimensi -->
                <div class="row g-3 mt-1">
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Panjang</label>
                        <input type="text" class="form-control form-control-sm"
                               name="length" placeholder="cm"
                               value="{{ old('length') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Lebar</label>
                        <input type="text" class="form-control form-control-sm"
                               name="width" placeholder="cm"
                               value="{{ old('width') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Tinggi</label>
                        <input type="text" class="form-control form-control-sm"
                               name="height" placeholder="cm"
                               value="{{ old('height') }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Stok (Ready)</label>
                        <input type="number" class="form-control form-control-sm"
                               name="stock" min="0"
                               placeholder="0" id="no-stock"
                               value="{{ old('stock', 0) }}">
                    </div>
                </div>

                <!-- Service Toggle -->
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_service" value="1"
                           id="no-service-switch" {{ old('is_service') ? 'checked' : '' }}
                           onchange="toggleNoVariantService(this)">
                    <label class="form-check-label fs-7 fw-semibold" for="no-service-switch">
                        <i class="bi bi-gear me-1"></i> Produk ini adalah layanan (service)
                    </label>
                </div>
                <div class="fs-8 text-muted mt-1" id="no-service-hint" style="display:none;">
                    Layanan tidak memerlukan stok.
                </div>
            </div>
        </div>

        <!-- Deskripsi Lengkap -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Deskripsi Lengkap</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-0">
                    <textarea class="form-control form-control-sm"
                              name="description" rows="8"
                              placeholder="Deskripsi lengkap produk...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Fitur Produk</div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-feature">
                    <i class="bi bi-plus"></i> Tambah
                </button>
            </div>
            <div class="card-body">
                <div id="features-container">
                    <!-- Features will be added here by JS -->
                </div>
                <div id="no-features-msg" class="text-muted fs-8">Belum ada fitur ditambahkan.</div>
            </div>
        </div>

        <!-- SEO -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">SEO Settings</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="fs-7 fw-semibold mb-2">Meta Title</label>
                    <input type="text" class="form-control form-control-sm"
                           name="meta_title" placeholder="Meta title untuk SEO"
                           value="{{ old('meta_title') }}">
                </div>
                <div class="fv-row mb-3">
                    <label class="fs-7 fw-semibold mb-2">Meta Description</label>
                    <textarea class="form-control form-control-sm"
                              name="meta_description" rows="2"
                              placeholder="Meta description untuk SEO">{{ old('meta_description') }}</textarea>
                </div>
                <div class="fv-row mb-0">
                    <label class="fs-7 fw-semibold mb-2">Meta Keywords</label>
                    <input type="text" class="form-control form-control-sm"
                           name="meta_keywords"
                           placeholder="Keyword1, Keyword2, Keyword3"
                           value="{{ old('meta_keywords') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- ========== SIDEBAR (20%) ========== -->
    <div class="col-md-4">
        <!-- Publish -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Publish</div>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="status" value="active">
                        <i class="bi bi-check-lg"></i> Publish
                    </button>
                    <button type="submit" class="btn btn-light btn-sm" name="status" value="inactive">
                        <i class="bi bi-file-earmark"></i> Draft
                    </button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm" name="status" value="archived"
                            onclick="return confirm('Arsipkan produk ini?')">
                        <i class="bi bi-archive"></i> Archive
                    </button>
                </div>
            </div>
        </div>

        <!-- Gambar Utama -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Gambar Utama</div>
            </div>
            <div class="card-body">
                <x-media-picker name="primary_media_id" :multiple="false" type="image" label="Pilih Gambar Utama" />
            </div>
        </div>

        <!-- Gallery -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Gallery</div>
            </div>
            <div class="card-body">
                <x-media-picker name="media_ids" :multiple="true" type="image" label="Pilih dari Library" />
            </div>
        </div>

        <!-- Kategori -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Kategori</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-0">
                    <select class="form-select form-select-sm" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tag -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Tag</div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="tag_ids[]" value="{{ $tag->id }}"
                                   id="tag-{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}>
                            <label class="form-check-label fs-8" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                    @if($tags->isEmpty())
                        <div class="text-muted fs-8">Belum ada tag.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pengaturan Lain -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Pengaturan</div>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                           id="product-featured" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label fs-7 fw-semibold" for="product-featured">
                        <i class="bi bi-star me-1"></i> Produk Unggulan
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<!-- ========== VARIANT TYPE MODAL ========== -->
<div class="modal fade" id="variant-type-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card">
            <div class="card-header">
                <div class="card-title" id="variant-modal-title">Tambah Tipe Varian</div>
<div class="card-header-btns">
    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
        <i class="bi bi-x-lg"></i>
    </div>
</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Nama Tipe</label>
                    <input type="text" class="form-control form-control-sm"
                           id="variant-type-name" placeholder="Contoh: Ukuran, Warna">
                </div>
                <div class="fv-row mb-0">
                    <label class="required fs-7 fw-semibold mb-2">Values (pisah dengan |)</label>
                    <input type="text" class="form-control form-control-sm"
                           id="variant-type-values" placeholder="Contoh: S | M | L | XL">
                    <div class="form-text fs-8">Pisahkan setiap nilai dengan tanda pipe ( | )</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn-save-variant-type">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .variant-type-tag {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; background: var(--accent-light); color: var(--accent);
        border-radius: var(--r-full); font-size: 0.78rem; font-weight: 500;
    }
    .variant-type-tag .remove-type {
        width: 18px; height: 18px; border-radius: 50%;
        border: none; background: rgba(0,0,0,0.08); color: var(--text-muted);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 10px; transition: all 0.15s;
    }
    .variant-type-tag .remove-type:hover {
        background: var(--danger); color: #fff;
    }
    .variant-type-values {
        display: flex; flex-wrap: wrap; gap: 4px; margin-top: 6px;
    }
    .variant-type-values .value-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; background: rgba(0,0,0,0.04); color: var(--text-secondary);
        border-radius: var(--r-sm); font-size: 0.72rem;
    }
    .variant-card {
        border: 1px solid var(--glass-border); border-radius: var(--r-md);
        padding: 12px; margin-bottom: 10px; background: rgba(0,0,0,0.01);
    }
    .variant-card-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 8px;
    }
    .variant-card-header .variant-label {
        font-size: 0.78rem; font-weight: 600; color: var(--text-secondary);
        display: flex; align-items: center; gap: 6px;
    }
    .variant-card-header .variant-label .variant-badge {
        padding: 1px 6px; background: var(--accent-light); color: var(--accent);
        border-radius: var(--r-sm); font-size: 0.68rem;
    }
    .variant-image-preview {
        width: 60px; height: 60px; border-radius: 8px; overflow: hidden;
        border: 1px solid var(--glass-border); flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--bg-surface-hover); cursor: pointer; position: relative;
    }
    .variant-image-preview img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .variant-image-preview .placeholder-icon {
        font-size: 20px; color: var(--text-muted);
    }
    .variant-image-preview input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer;
    }
    .feature-row {
        display: flex; gap: 8px; align-items: end; margin-bottom: 8px;
    }
    .feature-row .fv-row { margin-bottom: 0; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('product-form');
    const productNameInput = document.getElementById('product-name');
    const slugInput = document.getElementById('product-slug');
    const variantTypesContainer = document.getElementById('variant-types-container');
    const generatedVariants = document.getElementById('generated-variants');
    const noVariantForm = document.getElementById('no-variant-form');
    const variantSection = document.getElementById('variant-section');
    const generateWrapper = document.getElementById('generate-variant-wrapper');

    // ==========================================
    // AUTO-GENERATE SLUG
    // ==========================================
    productNameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto === 'true') {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            slugInput.dataset.auto = 'true';
        }
    });
    slugInput.addEventListener('input', function() {
        this.dataset.auto = 'false';
    });

    // ==========================================
    // VARIANT TYPES MANAGEMENT
    // ==========================================
    let variantTypes = [];
    let variantTypeIndex = 0;

    document.getElementById('btn-add-variant-type').addEventListener('click', function() {
        openVariantTypeModal();
    });

    function openVariantTypeModal(editIndex = null) {
        const modal = document.getElementById('variant-type-modal');
        const nameInput = document.getElementById('variant-type-name');
        const valuesInput = document.getElementById('variant-type-values');
        const title = document.getElementById('variant-modal-title');

        if (editIndex !== null) {
            title.textContent = 'Edit Tipe Varian';
            nameInput.value = variantTypes[editIndex].name;
            valuesInput.value = variantTypes[editIndex].values.join(' | ');
            modal.dataset.editIndex = editIndex;
        } else {
            title.textContent = 'Tambah Tipe Varian';
            nameInput.value = '';
            valuesInput.value = '';
            delete modal.dataset.editIndex;
        }

        const bsModal = new bootstrap.Modal(modal);
        modal.addEventListener('shown.bs.modal', function focusHandler() {
            const focusInput = modal.querySelector('#variant-type-name');
            if (focusInput) focusInput.focus();
            modal.removeEventListener('shown.bs.modal', focusHandler);
        });
        bsModal.show();
    }

    document.getElementById('btn-save-variant-type').addEventListener('click', function() {
        const name = document.getElementById('variant-type-name').value.trim();
        const valuesRaw = document.getElementById('variant-type-values').value.trim();

        if (!name) {
            Ravaa.alert('Peringatan', 'Nama tipe wajib diisi.', 'warning');
            return;
        }
        if (!valuesRaw) {
            Ravaa.alert('Peringatan', 'Values wajib diisi.', 'warning');
            return;
        }

        const values = valuesRaw.split('|').map(v => v.trim()).filter(v => v);
        if (values.length < 1) {
            Ravaa.alert('Peringatan', 'Minimal 1 value.', 'warning');
            return;
        }

        const modal = document.getElementById('variant-type-modal');
        const editIndex = modal.dataset.editIndex;

        if (editIndex !== undefined && editIndex !== '') {
            variantTypes[parseInt(editIndex)] = { name, values };
        } else {
            variantTypes.push({ name, values });
        }

        renderVariantTypes();
        bootstrap.Modal.getInstance(modal).hide();
    });

    // Save variant type on Enter key in inputs
    const variantModalNameInput = document.getElementById('variant-type-name');
    const variantModalValuesInput = document.getElementById('variant-type-values');
    [variantModalNameInput, variantModalValuesInput].forEach(inp => {
        inp.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('btn-save-variant-type').click();
            }
        });
    });

    function renderVariantTypes() {
        variantTypesContainer.innerHTML = '';

if (variantTypes.length === 0) {
    variantSection.classList.add('d-none');
    noVariantForm.classList.remove('d-none');
    // re‑enable required fields in the no‑variant form
    const priceInput = document.querySelector('#no-variant-form input[name="price"]');
    if (priceInput) priceInput.required = true;
    generatedVariants.innerHTML = '';
    return;
}

variantSection.classList.remove('d-none');
                noVariantForm.classList.add('d-none');
                // disable required fields in the hidden no‑variant form
                const priceInput = document.querySelector('#no-variant-form input[name="price"]');
                if (priceInput) priceInput.required = false;

        variantTypes.forEach(function(type, index) {
            const div = document.createElement('div');
            div.className = 'mb-3';
            div.innerHTML = `
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="variant-type-tag">
                        <i class="bi bi-tag"></i> ${escapeHtml(type.name)}
                        <button type="button" class="remove-type" onclick="removeVariantType(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" style="font-size:0.72rem;padding:2px 8px;"
                            onclick="openVariantTypeModal(${index})">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                <div class="variant-type-values">
                    ${type.values.map(v => `<span class="value-chip">${escapeHtml(v)}</span>`).join('')}
                </div>
            `;
            variantTypesContainer.appendChild(div);
        });

        if (variantTypes.length >= 1) {
            generateWrapper.classList.remove('d-none');
        } else {
            generateWrapper.classList.add('d-none');
        }
    }

    window.removeVariantType = function(index) {
        variantTypes.splice(index, 1);
        renderVariantTypes();
    };

    window.openVariantTypeModal = openVariantTypeModal;

    // ==========================================
    // GENERATE VARIANT COMBINATIONS
    // ==========================================
    document.getElementById('btn-generate-variants').addEventListener('click', function() {
        generateVariantForms();
    });

    document.getElementById('btn-clear-variants').addEventListener('click', function() {
        Ravaa.confirm('Hapus Semua', 'Hapus semua varian yang sudah di-generate?', 'warning').then(ok => {
            if (ok) {
                generatedVariants.innerHTML = '';
            }
        });
    });

    function generateVariantForms() {
        if (variantTypes.length === 0) return;

        const combinations = cartesianProduct(variantTypes);
        generatedVariants.innerHTML = '';

        combinations.forEach(function(combo, index) {
            const comboLabel = Object.entries(combo).map(([k, v]) => `${k}: ${v}`).join(' / ');
            const card = createVariantCard(combo, index, comboLabel);
            generatedVariants.appendChild(card);
        });
    }

    function cartesianProduct(types) {
        if (types.length === 0) return [[]];

        const [first, ...rest] = types;
        const restProduct = cartesianProduct(rest);
        const result = [];

        first.values.forEach(function(value) {
            restProduct.forEach(function(combo) {
                result.push({ [first.name]: value, ...combo });
            });
        });

        return result;
    }

    function createVariantCard(attributes, index, label) {
        const card = document.createElement('div');
        card.className = 'variant-card';
        card.dataset.index = index;

        const attrJson = JSON.stringify(attributes).replace(/"/g, '&quot;');

        card.innerHTML = `
            <div class="variant-card-header">
                <div class="variant-label">
                    <span class="variant-badge">#${index + 1}</span>
                    ${escapeHtml(label)}
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeGeneratedVariant(this)" title="Hapus Variant">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <input type="hidden" name="variants[${index}][attributes]" value='${attrJson}'>

                <div class="d-flex gap-3 align-items-start">
                    <div class="media-picker-wrapper">
                        <div class="media-picker-selected" id="variant_media_${index}-selected">
                            <div class="media-picker-empty"><i class="bi bi-image"></i><span>Belum ada media dipilih</span></div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="openMediaPicker('variant_media_${index}', false, 'image')">
                            <i class="bi bi-images"></i> Pilih Gambar
                        </button>
                        <input type="hidden" name="variant_images[${index}]" id="variant_media_${index}-input" value="">
                    </div>

                    <div class="flex-fill">
                    <div class="row g-2">
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">SKU</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][sku]" placeholder="SKU varian">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="required fs-8 fw-semibold mb-1">Harga (Rp)</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="variants[${index}][price]" min="0" step="100"
                                   placeholder="0" required>
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Berat</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][weight]" placeholder="250g">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Stok</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="variants[${index}][stock]" min="0" placeholder="0">
                        </div>
                    </div>

                    <!-- Diskon -->
                    <div class="form-check form-switch mt-2 mb-1">
                        <input class="form-check-input" type="checkbox"
                               id="variant-discount-switch-${index}"
                               onchange="toggleVariantDiscount(${index}, this)">
                        <label class="form-check-label fs-8 fw-semibold" for="variant-discount-switch-${index}">Diskon</label>
                    </div>
                    <div id="variant-discount-fields-${index}" class="d-none">
                        <div class="row g-2">
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Persen (%)</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="variants[${index}][discount_percent]" min="0" max="100"
                                       placeholder="0" oninput="calcVariantDiscount(${index}, this)">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Harga Diskon</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="variants[${index}][price_discount]" min="0" step="100"
                                       placeholder="0" id="variant-price-discount-${index}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Mulai</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="variants[${index}][discount_start]">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Akhir</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="variants[${index}][discount_end]">
                            </div>
                        </div>
                    </div>

                    <!-- Dimensi -->
                    <div class="row g-2 mt-1">
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Panjang</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][length]" placeholder="cm">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Lebar</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][width]" placeholder="cm">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Tinggi</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][height]" placeholder="cm">
                        </div>
                    </div>

                    <!-- Toggles -->
                    <div class="d-flex gap-3 mt-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   name="variants[${index}][is_service]" value="1"
                                   id="variant-service-${index}"
                                   onchange="toggleVariantService(${index}, this)">
                            <label class="form-check-label fs-8" for="variant-service-${index}">Service</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   name="variants[${index}][is_active]" value="1" checked
                                   id="variant-active-${index}">
                            <label class="form-check-label fs-8" for="variant-active-${index}">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
        `;

        return card;
    }

    // ==========================================
    // VARIANT DISCOUNT TOGGLE
    // ==========================================
    window.toggleVariantDiscount = function(index, checkbox) {
        const fields = document.getElementById('variant-discount-fields-' + index);
        fields.classList.toggle('d-none', !checkbox.checked);
    };

    // Remove a generated variant card (only removes the UI, not persisted until form submit)
    window.removeGeneratedVariant = function(btn) {
        const card = btn.closest('.variant-card');
        if (card) card.remove();
    };

    window.calcVariantDiscount = function(index, input) {
        const card = input.closest('.variant-card');
        const priceInput = card.querySelector('input[name="variants[' + index + '][price]"]');
        const priceDiscount = card.querySelector('#variant-price-discount-' + index);
        const percent = parseFloat(input.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        if (percent > 0 && price > 0) {
            priceDiscount.value = Math.round(price * (1 - percent / 100));
        } else {
            priceDiscount.value = '';
        }
    };

    // ==========================================
    // VARIANT SERVICE TOGGLE
    // ==========================================
    window.toggleVariantService = function(index, checkbox) {
        const card = checkbox.closest('.variant-card');
        const stockInput = card.querySelector('input[name="variants[' + index + '][stock]"]');
        if (checkbox.checked) {
            stockInput.disabled = true;
            stockInput.value = '0';
        } else {
            stockInput.disabled = false;
        }
    };

    // ==========================================
    // NO-VARIANT DISCOUNT
    // ==========================================
    window.toggleNoVariantDiscount = function(checkbox) {
        const fields = document.getElementById('no-variant-discount-fields');
        fields.classList.toggle('d-none', !checkbox.checked);
    };

    window.calcNoVariantDiscount = function(input) {
        const priceInput = document.querySelector('#no-variant-form input[name="price"]');
        const priceDiscount = document.getElementById('no-price-discount');
        const percent = parseFloat(input.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        if (percent > 0 && price > 0) {
            priceDiscount.value = Math.round(price * (1 - percent / 100));
        } else {
            priceDiscount.value = '';
        }
    };

    // ==========================================
    // NO-VARIANT SERVICE TOGGLE
    // ==========================================
    window.toggleNoVariantService = function(checkbox) {
        const stockInput = document.getElementById('no-stock');
        const hint = document.getElementById('no-service-hint');
        if (checkbox.checked) {
            stockInput.disabled = true;
            stockInput.value = '0';
            hint.style.display = 'block';
        } else {
            stockInput.disabled = false;
            hint.style.display = 'none';
        }
    };

    // ==========================================
    // VARIANT IMAGE PREVIEW
    // ==========================================
    window.previewVariantImage = function(input, index) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = input.closest('.variant-image-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">
                    <input type="file" name="variant_images[${index}]" accept="image/*"
                           onchange="previewVariantImage(this, ${index})">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // ==========================================
    // FEATURES MANAGEMENT
    // ==========================================
    let featureIndex = 0;

    document.getElementById('btn-add-feature').addEventListener('click', function() {
        addFeatureRow();
    });

    function addFeatureRow(title = '', value = '') {
        const container = document.getElementById('features-container');
        const noMsg = document.getElementById('no-features-msg');
        noMsg.style.display = 'none';

        const row = document.createElement('div');
        row.className = 'feature-row';
        row.innerHTML = `
            <div class="fv-row flex-fill">
                <input type="text" class="form-control form-control-sm"
                       name="features[${featureIndex}][title]" placeholder="Judul fitur"
                       value="${escapeHtml(title)}">
            </div>
            <div class="fv-row flex-fill">
                <input type="text" class="form-control form-control-sm"
                       name="features[${featureIndex}][value]" placeholder="Nilai"
                       value="${escapeHtml(value)}">
            </div>
            <button type="button" class="btn-remove-variant" onclick="this.closest('.feature-row').remove(); checkFeaturesEmpty();">
                <i class="bi bi-x-lg"></i>
            </button>
        `;
        container.appendChild(row);
        featureIndex++;
    }

    window.checkFeaturesEmpty = function() {
        const container = document.getElementById('features-container');
        const noMsg = document.getElementById('no-features-msg');
        noMsg.style.display = container.children.length === 0 ? 'block' : 'none';
    };

    // ==========================================
    // UTILS
    // ==========================================
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
@endpush
@endsection
