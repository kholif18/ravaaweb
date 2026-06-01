{{-- resources/views/admin/products/partials/_pricing_inventory.blade.php --}}
<div class="card mb-5" id="non-variant-pricing" style="display: {{ old('has_variants', $product->has_variants ?? false) ? 'none' : 'block' }}">
    <div class="card-header">
        <h4 class="card-title">Harga & Stok</h4>
        @if(isset($product))
        <div class="card-toolbar">
            <span class="badge badge-light-primary">
                Terjual: {{ $product->sold_count }} | Dilihat: {{ $product->view_count }}
            </span>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-6">
                <label class="form-label required">Harga Normal (Rp)</label>
                <input type="number" class="form-control" 
                    name="price" 
                    id="normal_price"
                    value="{{ old('price', $product->price ?? '') }}"
                    min="0" step="0.01" {{ !old('has_variants', $product->has_variants ?? false) ? 'required' : '' }} />
            </div>
            <div class="col-md-6">
                <label class="form-label">Harga Diskon (Rp)</label>
                <input type="number" class="form-control" 
                    name="discount_price" 
                    id="discount_price"
                    value="{{ old('discount_price', $product->discount_price ?? '') }}"
                    min="0" step="0.01" />
                <div class="text-muted fs-7 mt-1">Kosongkan jika tidak ada diskon</div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <label class="form-label">Mulai Diskon</label>
                <input type="datetime-local" class="form-control" 
                    name="discount_start_at" 
                    value="{{ old('discount_start_at', isset($product) && $product->discount_start_at ? $product->discount_start_at->format('Y-m-d\TH:i') : '') }}" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Akhir Diskon</label>
                <input type="datetime-local" class="form-control" 
                    name="discount_end_at" 
                    value="{{ old('discount_end_at', isset($product) && $product->discount_end_at ? $product->discount_end_at->format('Y-m-d\TH:i') : '') }}" />
            </div>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-4">
                <label class="form-label required">Status Stok</label>
                <div class="d-flex flex-column gap-2 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="stock_status" value="in_stock" id="stock_in" {{ old('stock_status', $product->stock_status ?? 'in_stock') == 'in_stock' ? 'checked' : '' }}>
                        <label class="form-check-label" for="stock_in">In Stock</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="stock_status" value="out_of_stock" id="stock_out" {{ old('stock_status', $product->stock_status ?? '') == 'out_of_stock' ? 'checked' : '' }}>
                        <label class="form-check-label" for="stock_out">Out of Stock</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="stock_status" value="pre_order" id="stock_pre" {{ old('stock_status', $product->stock_status ?? '') == 'pre_order' ? 'checked' : '' }}>
                        <label class="form-check-label" for="stock_pre">Pre Order</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Berat (grm)</label>
                <input type="number" class="form-control" 
                    name="weight" 
                    value="{{ old('weight', $product->weight ?? '') }}"
                    min="0" step="0.01" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Satuan</label>
                <input type="text" class="form-control" 
                    name="unit" 
                    value="{{ old('unit', $product->unit ?? '') }}"
                    placeholder="pcs, kg, meter, dll" />
            </div>
        </div>
    </div>
</div>
