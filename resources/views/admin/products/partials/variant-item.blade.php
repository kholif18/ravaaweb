{{-- resources/views/admin/products/partials/variant-item.blade.php --}}
@php
    $variantId = $variant['id'] ?? '';
    $name = $variant['name'] ?? '';
    $sku = $variant['sku'] ?? '';
    $stockStatus = $variant['stock_status'] ?? 'in_stock';
    $isDefault = $variant['is_default'] ?? false;
    $price = $variant['price'] ?? '';
    $discountPrice = $variant['discount_price'] ?? '';
    $hasDiscount = $discountPrice && $discountPrice > 0;
    $discountStartAt = isset($variant['discount_start_at']) ? 
        \Illuminate\Support\Carbon::parse($variant['discount_start_at'])->format('Y-m-d\TH:i') : '';
    $discountEndAt = isset($variant['discount_end_at']) ? 
        \Illuminate\Support\Carbon::parse($variant['discount_end_at'])->format('Y-m-d\TH:i') : '';
    $weight = $variant['weight'] ?? '';
    $unit = $variant['unit'] ?? 'pcs';
    $imageId = $variant['image_id'] ?? '';
    $attributeOptions = isset($variant['attribute_options']) ? 
        (is_array($variant['attribute_options']) ? json_encode($variant['attribute_options']) : $variant['attribute_options']) : '{}';
    
    $imageUrl = '';
    if ($imageId && isset($variant['image_url'])) {
        $imageUrl = $variant['image_url'];
    } elseif ($imageId) {
        $media = \App\Models\Media::find($imageId);
        if ($media) $imageUrl = $media->url;
    }
    
    $stockBadgeClass = $stockStatus === 'in_stock' ? 'bg-success' : ($stockStatus === 'out_of_stock' ? 'bg-danger' : 'bg-warning');
    $stockText = $stockStatus === 'in_stock' ? '✓ Tersedia' : ($stockStatus === 'out_of_stock' ? '✗ Habis' : '⏱ Pre Order');
@endphp

<div class="variant-item card mb-3" data-variant-index="{{ $index }}" data-variant-id="{{ $variantId }}">
    <!-- Header -->
    <div class="card-header bg-light py-2">
        <div class="row align-items-center">
            <div class="col-md-5 col-lg-4">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-link p-0 toggle-detail" title="Detail">
                        <i class="bi bi-chevron-down toggle-icon"></i>
                    </button>
                    <strong class="variant-name-display">{{ $name ?: 'Varian Baru' }}</strong>
                </div>
            </div>
            <div class="col-md-3 col-lg-3">
                <small class="text-muted">SKU:</small>
                <span class="variant-sku-display">{{ $sku ?: '-' }}</span>
            </div>
            <div class="col-md-2 col-lg-3">
                <span class="badge {{ $stockBadgeClass }} variant-stock-badge">
                    {{ $stockText }}
                </span>
            </div>
            <div class="col-md-2 col-lg-2 text-end">
                <div class="btn-group btn-group-sm">
                    <div class="form-check me-2 mt-2">
                        <input class="form-check-input variant-default-checkbox" 
                               type="checkbox" 
                               name="variants[{{ $index }}][is_default]" 
                               value="1" 
                               id="variant_default_{{ $index }}"
                               {{ $isDefault ? 'checked' : '' }}>
                        <label class="form-check-label small" for="variant_default_{{ $index }}">
                            Default
                        </label>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-variant"
                            data-variant-id="{{ $variantId }}" title="Hapus Varian">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Detail Section (Collapsible) -->
    <div class="variant-detail-collapse collapse">
        <div class="card-body">
            @if($variantId)
                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variantId }}">
            @endif
            
            <!-- Basic Info Row -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label required">Nama Varian</label>
                    <input type="text" class="form-control variant-name" 
                           name="variants[{{ $index }}][name]" 
                           value="{{ old("variants.{$index}.name", $name) }}"
                           placeholder="Contoh: Merah - Ukuran L" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">SKU Varian</label>
                    <input type="text" class="form-control variant-sku" 
                           name="variants[{{ $index }}][sku]" 
                           value="{{ old("variants.{$index}.sku", $sku) }}"
                           placeholder="SKU-VARIAN-001" />
                </div>
            </div>
            
            <!-- Pricing Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3 border-bottom pb-2">Harga & Diskon</h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label required">Harga Normal (Rp)</label>
                    <input type="number" class="form-control variant-price" 
                           name="variants[{{ $index }}][price]" 
                           value="{{ old("variants.{$index}.price", $price) }}"
                           min="0" step="0.01" required />
                </div>
                <div class="col-md-8">
                    <div class="form-check mb-2">
                        <input class="form-check-input discount-toggle" type="checkbox" 
                               id="discount_toggle_{{ $index }}" {{ $hasDiscount ? 'checked' : '' }}>
                        <label class="form-check-label" for="discount_toggle_{{ $index }}">
                            <i class="bi bi-tag"></i> Aktifkan Diskon
                        </label>
                    </div>
                    <div class="discount-fields" style="display: {{ $hasDiscount ? 'block' : 'none' }}">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label">Harga Diskon (Rp)</label>
                                <input type="number" class="form-control" 
                                       name="variants[{{ $index }}][discount_price]" 
                                       value="{{ old("variants.{$index}.discount_price", $discountPrice) }}"
                                       min="0" step="0.01" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mulai Diskon</label>
                                <input type="datetime-local" class="form-control" 
                                       name="variants[{{ $index }}][discount_start_at]" 
                                       value="{{ old("variants.{$index}.discount_start_at", $discountStartAt) }}" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Akhir Diskon</label>
                                <input type="datetime-local" class="form-control" 
                                       name="variants[{{ $index }}][discount_end_at]" 
                                       value="{{ old("variants.{$index}.discount_end_at", $discountEndAt) }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stock & Shipping Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3 border-bottom pb-2">Stok & Pengiriman</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Status Stok</label>
                    <select class="form-select variant-stock-status" name="variants[{{ $index }}][stock_status]">
                        <option value="in_stock" {{ old("variants.{$index}.stock_status", $stockStatus) == 'in_stock' ? 'selected' : '' }}>✓ Tersedia (In Stock)</option>
                        <option value="out_of_stock" {{ old("variants.{$index}.stock_status", $stockStatus) == 'out_of_stock' ? 'selected' : '' }}>✗ Habis (Out of Stock)</option>
                        <option value="pre_order" {{ old("variants.{$index}.stock_status", $stockStatus) == 'pre_order' ? 'selected' : '' }}>⏱ Pre Order</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" class="form-control" 
                           name="variants[{{ $index }}][weight]" 
                           value="{{ old("variants.{$index}.weight", $weight) }}"
                           min="0" step="0.01" placeholder="0.00" />
                </div>
                <div class="col-md-2">
                    <label class="form-label">Unit</label>
                    <input type="text" class="form-control" 
                           name="variants[{{ $index }}][unit]" 
                           value="{{ old("variants.{$index}.unit", $unit) }}"
                           placeholder="pcs" />
                </div>
            </div>
            
            <!-- Attributes Section (Hidden by default, used for data storage) -->
            <div class="row mb-4" style="display: none;">
                <div class="col-12">
                    <h6 class="mb-3 border-bottom pb-2 text-muted">Atribut Varian (Otomatis)</h6>
                    <div class="variant-attr-fields mb-2">
                        <!-- Dynamic attribute rows will be inserted here -->
                    </div>
                    <button type="button" class="btn btn-sm btn-light-primary add-attr-btn">
                        <i class="bi bi-plus"></i> Tambah Atribut
                    </button>
                    <input type="hidden" name="variants[{{ $index }}][attribute_options]" class="variant-attr-json" value="{{ $attributeOptions }}">
                </div>
            </div>
            
            <!-- Media Section -->
            <div class="row">
                <div class="col-12">
                    <h6 class="mb-3 border-bottom pb-2">Gambar Varian</h6>
                    <div class="d-flex align-items-center gap-3">
                        <input type="hidden" name="variants[{{ $index }}][image_id]" class="variant-image-id" value="{{ $imageId }}">
                        <button type="button" class="btn btn-outline-secondary select-variant-image" data-index="{{ $index }}">
                            <i class="bi bi-image"></i> Pilih Gambar
                        </button>
                        <div class="variant-image-preview">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" class="img-thumbnail" style="max-height:100px">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>