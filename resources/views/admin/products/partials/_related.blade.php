{{-- resources/views/admin/products/partials/_related.blade.php --}}
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Produk Terkait</h4>
    </div>
    <div class="card-body">
        <div class="mb-0">
            <label class="form-label">Cari & Pilih Produk</label>
            <select class="form-select" name="related_products[]" multiple data-control="select2" data-placeholder="Pilih produk terkait">
                @foreach($relatedProducts as $related)
                    <option value="{{ $related->id }}" 
                        {{ in_array($related->id, old('related_products', isset($product) ? ($product->relatedProducts->pluck('id')->toArray() ?? []) : [])) ? 'selected' : '' }}>
                        {{ $related->name }} ({{ $related->sku ?? 'No SKU' }})
                    </option>
                @endforeach
            </select>
            <div class="text-muted fs-7 mt-2">
                <i class="bi bi-info-circle me-1"></i> Produk ini akan direkomendasikan pada halaman detail.
            </div>
        </div>
    </div>
</div>
