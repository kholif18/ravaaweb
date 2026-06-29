@extends('admin.layouts.app')

@section('page-title', 'Edit Produk')

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
        <span class="text-muted">{{ $product->name }}</span>
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
                <form id="product-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="fv-row mb-4">
                        <label class="required fs-7 fw-semibold mb-2">Nama Produk</label>
                        <input type="text" class="form-control form-control-sm"
                               name="name" id="product-name"
                               placeholder="Masukkan nama produk" required
                               value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fv-row mb-4">
                        <label class="fs-7 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-sm"
                                  name="description" rows="5"
                                  placeholder="Deskripsi produk...">{{ old('description', $product->description) }}</textarea>
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
                                   value="{{ old('price', $product->price) }}">
                            @error('price')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Harga Diskon (Rp)</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="price_discount" min="0" step="100"
                                   placeholder="0"
                                   value="{{ old('price_discount', $product->price_discount) }}">
                            @error('price_discount')
                                <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-2">Stok</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="stock" min="0"
                                   placeholder="0" required
                                   value="{{ old('stock', $product->stock) }}">
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
                                   value="{{ old('sku', $product->sku) }}">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Berat</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="weight" placeholder="Contoh: 500g"
                                   value="{{ old('weight', $product->weight) }}">
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
                                       value="{{ old('meta_title', $product->meta_title) }}">
                            </div>
                            <div class="col-12 fv-row">
                                <label class="fs-7 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm"
                                          name="meta_description" rows="2"
                                          placeholder="Meta description untuk SEO">{{ old('meta_description', $product->meta_description) }}</textarea>
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-7 fw-semibold mb-1">Meta Keywords</label>
                                <input type="text" class="form-control form-control-sm"
                                       name="meta_keywords"
                                       placeholder="Keyword1, Keyword2, Keyword3"
                                       value="{{ old('meta_keywords', $product->meta_keywords) }}">
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
                            </button>
                        </div>
                        <div id="variants-container">
                            @foreach($product->variants as $variant)
                                <div class="variant-row" data-variant-id="{{ $variant->id }}">
                                    <div class="fv-row">
                                        <input type="text" class="form-control form-control-sm" name="variants[{{ $loop->index }}][color]" placeholder="Warna" value="{{ $variant->color }}">
                                    </div>
                                    <div class="fv-row">
                                        <input type="text" class="form-control form-control-sm" name="variants[{{ $loop->index }}][size]" placeholder="Ukuran" value="{{ $variant->size }}">
                                    </div>
                                    <div class="fv-row">
                                        <input type="text" class="form-control form-control-sm" name="variants[{{ $loop->index }}][sku]" placeholder="SKU" value="{{ $variant->sku }}">
                                    </div>
                                    <div class="fv-row">
                                        <input type="number" class="form-control form-control-sm" name="variants[{{ $loop->index }}][stock]" placeholder="Stok" min="0" value="{{ $variant->stock }}">
                                    </div>
                                    <div class="fv-row">
                                        <input type="number" class="form-control form-control-sm" name="variants[{{ $loop->index }}][price_addition]" placeholder="+Rp" min="0" value="{{ $variant->price_addition }}">
                                    </div>
                                    <div class="fv-row d-flex gap-1">
                                        <input type="hidden" name="variants[{{ $loop->index }}][id]" value="{{ $variant->id }}">
                                        <input type="hidden" name="variants[{{ $loop->index }}][status]" value="{{ $variant->status }}">
                                        <button type="button" class="btn-remove-variant" onclick="removeVariant(this, {{ $variant->id }})">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-lg"></i> Update Produk
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
                        <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Kategori</label>
                    <select class="form-select form-select-sm" name="category_id" id="product-category" form="product-form" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
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
                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
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
                                   {{ in_array($tag->id, old('tag_ids', $product->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
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

                <input type="hidden" name="primary_media_id" id="primary-media-id" form="product-form"
                       value="{{ old('primary_media_id', $product->thumbnail_id) }}">
            </div>
        </div>

        <!-- Current Media Preview -->
        @if($product->media->count() > 0)
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Media Terpilih</div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product->media as $media)
                        <div class="product-media-thumb {{ $media->pivot->is_primary ? 'is-primary' : '' }}">
                            @if($media->isImage())
                                <img src="{{ $media->url }}" alt="{{ $media->name }}">
                            @else
                                <div class="media-file-icon"><i class="bi bi-file-earmark"></i></div>
                            @endif
                            <span class="media-badge">{{ $media->pivot->is_primary ? 'Utama' : '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
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
    .btn-remove-variant {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: rgba(239,68,68,0.1);
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .btn-remove-variant:hover {
        background: #ef4444;
        color: #fff;
    }
    .product-media-thumb {
        position: relative;
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid var(--border-color);
    }
    .product-media-thumb.is-primary {
        border-color: var(--accent);
    }
    .product-media-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .media-file-icon {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-surface-alt);
        font-size: 24px;
        color: var(--text-muted);
    }
    .media-badge {
        position: absolute;
        bottom: 2px;
        left: 2px;
        right: 2px;
        text-align: center;
        font-size: 9px;
        font-weight: 600;
        background: var(--accent);
        color: #fff;
        border-radius: 4px;
        padding: 1px 2px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let variantIndex = {{ $product->variants->count() }};
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
                <button type="button" class="btn-remove-variant" onclick="removeVariant(this)">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <input type="hidden" name="variants[${variantIndex}][status]" value="${status}">
        `;
        variantsContainer.appendChild(row);
        variantIndex++;
    }

    // Initialize existing media preview from library picker
    initExistingMediaPreview();
});

function removeVariant(btn, variantId = null) {
    const row = btn.closest('.variant-row');
    if (variantId) {
        // Mark for deletion by adding to delete_variant_ids
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_variant_ids[]';
        deleteInput.value = variantId;
        document.getElementById('product-form').appendChild(deleteInput);
    }
    row.remove();
}

function initExistingMediaPreview() {
    const input = document.getElementById('media_ids-input');
    const preview = document.getElementById('media_ids-selected');
    if (input && input.value && preview) {
        // Trigger the media picker to show existing selections
        const state = { selected: input.value.split(',').filter(Boolean) };
        if (state.selected.length > 0) {
            preview.innerHTML = '';
            state.selected.forEach(id => {
                // Create placeholder thumbnails - actual images will be loaded by the picker
                const thumb = document.createElement('div');
                thumb.className = 'media-picker-thumb';
                thumb.innerHTML = `<div class="media-thumb-icon"><i class="bi bi-image"></i></div>`;
                preview.appendChild(thumb);
            });
        }
    }
}
</script>
@endsection
