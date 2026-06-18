{{-- resources/views/admin/products/partials/_settings.blade.php --}}
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Pengaturan</h4>
    </div>
    <div class="card-body">
        <div class="mb-5">
            <label class="form-label required">Kategori</label>
            <select class="form-select" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($formattedCategories as $id => $name)
                    <option value="{{ $id }}" 
                        {{ old('category_id', $product->category_id ?? '') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-5">
            <label class="form-label required">Status</label>
            <select class="form-select" name="status" required>
                <option value="draft" {{ old('status', $product->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $product->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ old('status', $product->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>
        
        <div class="mb-0">
            <label class="form-label">Tanggal Publish</label>
            <input type="datetime-local" class="form-control" 
                   name="published_at" 
                   value="{{ old('published_at', isset($product) && $product->published_at ? $product->published_at->format('Y-m-d\TH:i') : '') }}" />
            <div class="text-muted fs-7 mt-1">Kosongkan untuk publish sekarang</div>
        </div>
    </div>
</div>

<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Fitur Produk</h4>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column gap-3">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" 
                       name="is_featured" 
                       value="1" 
                       id="is_featured" 
                       {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} />
                <label class="form-check-label" for="is_featured">
                    Produk Unggulan (Featured)
                </label>
            </div>
            
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" 
                       name="is_best_seller" 
                       value="1" 
                       id="is_best_seller" 
                       {{ old('is_best_seller', $product->is_best_seller ?? false) ? 'checked' : '' }} />
                <label class="form-check-label" for="is_best_seller">
                    Best Seller
                </label>
            </div>
            
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" 
                       name="is_new_arrival" 
                       value="1" 
                       id="is_new_arrival" 
                       {{ old('is_new_arrival', $product->is_new_arrival ?? false) ? 'checked' : '' }} />
                <label class="form-check-label" for="is_new_arrival">
                    New Arrival
                </label>
            </div>

            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" 
                       name="is_digital" 
                       value="1" 
                       id="is_digital" 
                       {{ old('is_digital', $product->is_digital ?? false) ? 'checked' : '' }} />
                <label class="form-check-label" for="is_digital">
                    Produk Digital (Tanpa Pengiriman)
                </label>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Dimensi Produk (cm)</h4>
    </div>
    <div class="card-body">
        <div class="row g-5">
            <div class="col-6">
                <label class="form-label">Panjang</label>
                <input type="number" class="form-control" 
                       name="length" 
                       value="{{ old('length', $product->length ?? '') }}"
                       min="0" step="0.01" />
            </div>
            <div class="col-6">
                <label class="form-label">Lebar</label>
                <input type="number" class="form-control" 
                       name="width" 
                       value="{{ old('width', $product->width ?? '') }}"
                       min="0" step="0.01" />
            </div>
            <div class="col-12 mt-5">
                <label class="form-label">Tinggi</label>
                <input type="number" class="form-control" 
                       name="height" 
                       value="{{ old('height', $product->height ?? '') }}"
                       min="0" step="0.01" />
            </div>
        </div>
    </div>
</div>
