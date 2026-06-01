{{-- resources/views/admin/products/partials/_basic_info.blade.php --}}
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Informasi Dasar</h4>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <label class="form-label required">Nama Produk</label>
            <input type="text" class="form-control" 
                name="name" 
                id="product_name"
                value="{{ old('name', $product->name ?? '') }}"
                placeholder="Masukkan nama produk"
                required />
            @error('name')
                <div class="text-danger fs-7 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-5">
            <label class="form-label mb-0">Permalink</label>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="text-muted">
                    {{ url('/product') }}/
                </span>

                <input type="text"
                    class="form-control form-control-sm"
                    style="width: 250px"
                    name="slug"
                    id="product_slug"
                    value="{{ old('slug', $product->slug ?? '') }}">

                <button type="button"
                        class="btn btn-sm btn-light-primary">
                    Edit
                </button>
            </div>
        </div>
        
        <div class="mb-5">
            <label class="form-label">SKU (Stock Keeping Unit)</label>
            <input type="text" class="form-control" 
                name="sku" 
                id="product_sku"
                value="{{ old('sku', $product->sku ?? '') }}"
                placeholder="SKU-001" />
            <div class="text-muted fs-7 mt-1">Kosongkan untuk generate otomatis</div>
        </div>
        
    </div>
</div>

<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Tipe Produk</h4>
    </div>
    <div class="card-body">
        <div class="mb-5">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" 
                    name="has_variants" 
                    value="1" 
                    id="has_variants" 
                    {{ old('has_variants', $product->has_variants ?? false) ? 'checked' : '' }} />
                <label class="form-check-label fw-bold" for="has_variants">
                    Produk memiliki varian (ukuran, warna, dll)
                </label>
            </div>
        </div>
        
        {{-- Variant Attributes Section --}}
        <div class="mb-0" id="variant-attributes-section" style="display: {{ old('has_variants', $product->has_variants ?? false) ? 'block' : 'none' }}">
            <label class="form-label">Atribut Varian</label>
            <div id="variant-attributes-container">
                @php
                    $variantAttrs = old('variant_attributes', []);
                    if (empty($variantAttrs) && isset($product)) {
                        $variantAttrs = is_array($product->variant_attributes) ? $product->variant_attributes : json_decode($product->variant_attributes, true) ?? [];
                    }
                    if (empty($variantAttrs)) {
                        $variantAttrs = [''];
                    }
                @endphp
                
                @foreach($variantAttrs as $index => $attribute)
                <div class="input-group mb-2">
                    <input type="text" class="form-control" 
                        name="variant_attributes[]" 
                        value="{{ is_array($attribute) ? ($attribute['name'] ?? '') : $attribute }}"
                        placeholder="Contoh: warna, ukuran, bahan" />
                    <button type="button" class="btn btn-light-danger remove-attribute">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-light-primary btn-sm mt-2" id="add-attribute">
                <i class="bi bi-plus"></i> Tambah Atribut
            </button>
        </div>
    </div>
</div>
