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
<div class="row g-5">
    <!-- Main Content -->
    <div class="col-lg-8">
        <div class="glass-card">
            <div class="card-header">
                <div class="card-title">Informasi Produk</div>
            </div>
            <div class="card-body">
                <form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="fv-row mb-4">
                        <label class="required fs-7 fw-semibold mb-2">Nama Produk</label>
                        <input type="text" class="form-control form-control-sm"
                               name="name" id="product-name"
                               placeholder="Masukkan nama produk" required
                               value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fv-row mb-4">
                        <label class="fs-7 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-sm"
                                  name="description" rows="5"
                                  placeholder="Deskripsi produk...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
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
                            <label class="fs-7 fw-semibold mb-2">Harga Diskon (Rp)</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="price_discount" min="0" step="100"
                                   placeholder="0"
                                   value="{{ old('price_discount') }}">
                            @error('price_discount')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-2">Stok</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="stock" min="0"
                                   placeholder="0" required
                                   value="{{ old('stock', 0) }}">
                            @error('stock')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">SKU</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="sku" placeholder="Kode unik produk"
                                   value="{{ old('sku') }}">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Berat</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="weight" placeholder="Contoh: 500g"
                                   value="{{ old('weight') }}">
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="border rounded p-3 mb-4" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-7 mb-2" style="color: var(--text-secondary);">
                            <i class="bi bi-search me-1"></i> SEO Settings
                        </div>
                        <div class="row g-3">
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm"
                                       name="meta_title"
                                       placeholder="Meta title untuk SEO"
                                       value="{{ old('meta_title') }}">
                            </div>
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm"
                                          name="meta_description" rows="2"
                                          placeholder="Meta description untuk SEO">{{ old('meta_description') }}</textarea>
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Keywords</label>
                                <input type="text" class="form-control form-control-sm"
                                       name="meta_keywords"
                                       placeholder="Keyword1, Keyword2, Keyword3"
                                       value="{{ old('meta_keywords') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Variants -->
                    <div class="border rounded p-3 mb-4" style="background: rgba(0,0,0,0.01);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-semibold fs-7" style="color: var(--text-secondary);">
                                <i class="bi bi-palette me-1"></i> Varian Produk
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-variant">
                                <i class="bi bi-plus"></i> Tambah Varian
                            </div>
                        </div>
                        <div id="variants-container"></div>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-lg"></i> Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status & Category -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Pengaturan</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Status</label>
                    <select class="form-select form-select-sm" name="status" id="product-status" form="product-form" required>
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Kategori</label>
                    <select class="form-select form-select-sm" name="category_id" id="product-category" form="product-form" required>
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

                <div class="fv-row mb-0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                               id="product-featured" form="product-form"
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label fs-7 fw-semibold" for="product-featured">Produk Unggulan</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Tag</div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2" id="tags-container">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="tag_ids[]" value="{{ $tag->id }}"
                                   id="tag-{{ $tag->id }}" form="product-form"
                                   {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}>
                            <label class="form-check-label fs-8" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                    @if($tags->isEmpty())
                        <div class="text-muted fs-8">Belum ada tag. <a href="{{ route('admin.tags.create') }}">Buat tag</a></div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Media from Library -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Media</div>
            </div>
            <div class="card-body">
                <x-media-picker name="media_ids" :multiple="true" type="image" label="Pilih dari Library" />

                <input type="hidden" name="primary_media_id" id="primary-media-id" form="product-form" value="{{ old('primary_media_id') }}">
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .variant-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 100px 80px 40px;
        gap: 8px;
        align-items: end;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
    }
    .variant-row:last-child { border-bottom: none; }
    .variant-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 100px 80px 40px;
        gap: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 4px;
    }
    .variant-header span {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
    }
    .btn-remove-variant {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: var(--danger-light, rgba(239,68,68,0.1));
        color: var(--danger, #ef4444);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .btn-remove-variant:hover {
        background: var(--danger, #ef4444);
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let variantIndex = 0;
    const variantsContainer = document.getElementById('variants-container');

    // Add variant
    document.getElementById('btn-add-variant').addEventListener('click', function() {
        addVariant();
    });

    function addVariant(color = '', size = '', sku = '', stock = 0, priceAddition = 0, status = 'active') {
        const row = document.createElement('div');
        row.className = 'variant-row';
        row.innerHTML = `
            <div class="fv-row">
                <input type="text" class="form-control form-control-sm" name="variants[${variantIndex}][color]" placeholder="Warna" value="${color}">
            </div>
            <div class="fv-row">
                <input type="text" class="form-control form-control-sm" name="variants[${variantIndex}][size]" placeholder="Ukuran" value="${size}">
            </div>
            <div class="fv-row">
                <input type="text" class="form-control form-control-sm" name="variants[${variantIndex}][sku]" placeholder="SKU" value="${sku}">
            </div>
            <div class="fv-row">
                <input type="number" class="form-control form-control-sm" name="variants[${variantIndex}][stock]" placeholder="Stok" min="0" value="${stock}">
            </div>
            <div class="fv-row">
                <input type="number" class="form-control form-control-sm" name="variants[${variantIndex}][price_addition]" placeholder="+Rp" min="0" value="${priceAddition}">
            </div>
            <div class="fv-row">
                <button type="button" class="btn-remove-variant" onclick="this.closest('.variant-row').remove()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <input type="hidden" name="variants[${variantIndex}][status]" value="${status}">
        `;
        variantsContainer.appendChild(row);
        variantIndex++;
    }

    // Slug auto-generation from name
    const nameInput = document.getElementById('product-name');
    nameInput.addEventListener('input', function() {
        // Could auto-generate slug preview if needed
    });
});
</script>
@endpush
@endsection
