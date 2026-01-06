{{-- resources/views/admin/products/partials/variants-form.blade.php --}}
<div class="card card-bordered mb-10" id="variants-container" 
     style="display: {{ old('has_variants', $product->has_variants ?? false) ? 'block' : 'none' }}">
    <div class="card-header">
        <h4 class="card-title">Varian Produk</h4>
        <div class="card-toolbar">
            <button type="button" class="btn btn-light-primary" id="add-variant">
                <i class="bi bi-plus"></i> Tambah Varian
            </button>
            <button type="button" class="btn btn-light-success ms-2" id="generate-variants">
                <i class="bi bi-magic"></i> Generate Varian
            </button>
        </div>
    </div>
    <div class="card-body">
        <div id="variants-list">
            @php
                $variants = old('variants', isset($product) && $product->variants ? 
                    $product->variants->toArray() : []);
                if (empty($variants)) {
                    $variants = [[]];
                }
            @endphp
            
            @foreach($variants as $index => $variant)
            <div class="variant-item card mb-5" data-variant-index="{{ $index }}">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Varian #{{ $index + 1 }}</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-variant"
                            data-variant-id="{{ $variant['id'] ?? '' }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    @if(isset($variant['id']))
                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant['id'] }}">
                    @endif
                    
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <label class="form-label required">Nama Varian</label>
                            <input type="text" class="form-control" 
                                   name="variants[{{ $index }}][name]" 
                                   value="{{ $variant['name'] ?? '' }}"
                                   placeholder="Contoh: Merah M" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SKU Varian</label>
                            <input type="text" class="form-control" 
                                   name="variants[{{ $index }}][sku]" 
                                   value="{{ $variant['sku'] ?? '' }}"
                                   placeholder="SKU-VARIAN-001" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Atribut (JSON)</label>
                            <input type="text" class="form-control variant-attributes-input" 
                                   name="variants[{{ $index }}][attribute_options]" 
                                   value="{{ isset($variant['attribute_options']) ? 
                                           (is_array($variant['attribute_options']) ? 
                                            json_encode($variant['attribute_options']) : 
                                            $variant['attribute_options']) : '' }}"
                                   placeholder='{"color": "Merah", "size": "M"}' />
                            <small class="text-muted">Format JSON: {"attribute": "value"}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-md-3">
                            <label class="form-label required">Harga Normal (Rp)</label>
                            <input type="number" class="form-control" 
                                   name="variants[{{ $index }}][price]" 
                                   value="{{ $variant['price'] ?? '' }}"
                                   min="0" step="0.01" required />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Diskon (Rp)</label>
                            <input type="number" class="form-control" 
                                   name="variants[{{ $index }}][discount_price]" 
                                   value="{{ $variant['discount_price'] ?? '' }}"
                                   min="0" step="0.01" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Mulai Diskon</label>
                            <input type="datetime-local" class="form-control" 
                                   name="variants[{{ $index }}][discount_start]" 
                                   value="{{ isset($variant['discount_start']) && $variant['discount_start'] ? 
                                           \Carbon\Carbon::parse($variant['discount_start'])->format('Y-m-d\TH:i') : '' }}" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Akhir Diskon</label>
                            <input type="datetime-local" class="form-control" 
                                   name="variants[{{ $index }}][discount_end]" 
                                   value="{{ isset($variant['discount_end']) && $variant['discount_end'] ? 
                                           \Carbon\Carbon::parse($variant['discount_end'])->format('Y-m-d\TH:i') : '' }}" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label required">Stok</label>
                            <input type="number" class="form-control" 
                                   name="variants[{{ $index }}][stock_quantity]" 
                                   value="{{ $variant['stock_quantity'] ?? 0 }}"
                                   min="0" required />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" class="form-control" 
                                   name="variants[{{ $index }}][weight]" 
                                   value="{{ $variant['weight'] ?? '' }}"
                                   min="0" step="0.01" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Gambar Varian</label>
                            <input type="file" class="form-control" 
                                   name="variant_images[{{ $index }}]" 
                                   accept="image/*" />
                            @if(isset($variant['image']) && $variant['image'])
                            <div class="mt-2">
                                <img src="{{ asset('storage/variants/' . $variant['image']) }}" 
                                     class="img-thumbnail" 
                                     style="max-height: 50px;">
                            </div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-5">
                                <input class="form-check-input" type="checkbox" 
                                       name="variants[{{ $index }}][is_default]" 
                                       value="1" 
                                       id="variant_default_{{ $index }}"
                                       {{ ($variant['is_default'] ?? false) ? 'checked' : '' }} />
                                <label class="form-check-label" for="variant_default_{{ $index }}">
                                    Varian Default
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Hidden input for deleted variants -->
<input type="hidden" name="deleted_variants" id="deleted_variants" value="">

<!-- Generate Variants Modal -->
<div class="modal fade" id="generateVariantsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Varian Otomatis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="variant-options-container">
                    <!-- Dynamic form for variant options will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirm-generate">Generate Varian</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let variantCount = {{ count($variants) }};
    const deletedVariants = [];
    
    // Add variant button
    const addVariantBtn = document.getElementById('add-variant');
    if (addVariantBtn) {
        addVariantBtn.addEventListener('click', function() {
            const variantsList = document.getElementById('variants-list');
            const variantIndex = variantCount;
            
            const template = `
                <div class="variant-item card mb-5" data-variant-index="${variantIndex}">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Varian Baru #${variantIndex + 1}</h5>
                        <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-new-variant">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-4">
                                <label class="form-label required">Nama Varian</label>
                                <input type="text" class="form-control" 
                                       name="variants[${variantIndex}][name]" 
                                       placeholder="Contoh: Merah M" required />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">SKU Varian</label>
                                <input type="text" class="form-control" 
                                       name="variants[${variantIndex}][sku]" 
                                       placeholder="SKU-VARIAN-001" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Atribut (JSON)</label>
                                <input type="text" class="form-control variant-attributes-input" 
                                       name="variants[${variantIndex}][attribute_options]" 
                                       placeholder='{"color": "Merah", "size": "M"}' />
                                <small class="text-muted">Format JSON: {"attribute": "value"}</small>
                            </div>
                        </div>
                        
                        <div class="row mb-5">
                            <div class="col-md-3">
                                <label class="form-label required">Harga Normal (Rp)</label>
                                <input type="number" class="form-control" 
                                       name="variants[${variantIndex}][price]" 
                                       min="0" step="0.01" required />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Harga Diskon (Rp)</label>
                                <input type="number" class="form-control" 
                                       name="variants[${variantIndex}][discount_price]" 
                                       min="0" step="0.01" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mulai Diskon</label>
                                <input type="datetime-local" class="form-control" 
                                       name="variants[${variantIndex}][discount_start]" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Akhir Diskon</label>
                                <input type="datetime-local" class="form-control" 
                                       name="variants[${variantIndex}][discount_end]" />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label required">Stok</label>
                                <input type="number" class="form-control" 
                                       name="variants[${variantIndex}][stock_quantity]" 
                                       min="0" required />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Berat (kg)</label>
                                <input type="number" class="form-control" 
                                       name="variants[${variantIndex}][weight]" 
                                       min="0" step="0.01" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gambar Varian</label>
                                <input type="file" class="form-control" 
                                       name="variant_images[${variantIndex}]" 
                                       accept="image/*" />
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" 
                                           name="variants[${variantIndex}][is_default]" 
                                           value="1" 
                                           id="variant_default_new_${variantIndex}" />
                                    <label class="form-check-label" for="variant_default_new_${variantIndex}">
                                        Varian Default
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            variantsList.insertAdjacentHTML('beforeend', template);
            variantCount++;
        });
    }
    
    // Remove existing variant
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-variant')) {
            const button = e.target.closest('.remove-variant');
            const variantId = button.dataset.variantId;
            const variantItem = button.closest('.variant-item');
            
            if (variantId) {
                Swal.fire({
                    title: 'Hapus Varian?',
                    text: "Varian ini akan dihapus dari produk.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deletedVariants.push(variantId);
                        document.getElementById('deleted_variants').value = JSON.stringify(deletedVariants);
                        variantItem.remove();
                        showToast('success', 'Varian berhasil dihapus');
                    }
                });
            } else {
                variantItem.remove();
            }
        }
        
        // Remove new variant (belum disimpan)
        if (e.target.closest('.remove-new-variant')) {
            const variantItem = e.target.closest('.variant-item');
            variantItem.remove();
        }
    });
    
    // Ensure only one variant is marked as default
    document.addEventListener('change', function(e) {
        if (e.target.name && e.target.name.includes('is_default') && e.target.checked) {
            const currentVariantItem = e.target.closest('.variant-item');
            const currentVariantIndex = currentVariantItem.dataset.variantIndex;
            
            // Uncheck all other default checkboxes
            document.querySelectorAll('.variant-item').forEach(item => {
                if (item.dataset.variantIndex !== currentVariantIndex) {
                    const checkbox = item.querySelector('input[name*="is_default"]');
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }
            });
        }
    });
    
    // Generate variants modal
    const generateVariantsBtn = document.getElementById('generate-variants');
    if (generateVariantsBtn) {
        generateVariantsBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('generateVariantsModal'));
            const optionsContainer = document.getElementById('variant-options-container');
            
            // Get attribute inputs
            const attributeInputs = document.querySelectorAll('input[name="variant_attributes[]"]');
            const attributes = Array.from(attributeInputs)
                .map(input => input.value.trim())
                .filter(value => value !== '');
            
            if (attributes.length === 0) {
                showToast('error', 'Tidak ada atribut varian yang ditentukan', 'Generate Varian');
                return;
            }
            
            // Clear previous options
            optionsContainer.innerHTML = '';
            
            // Create form for each attribute
            attributes.forEach((attribute, index) => {
                const attributeDiv = document.createElement('div');
                attributeDiv.className = 'mb-3';
                attributeDiv.innerHTML = `
                    <label class="form-label">${attribute.charAt(0).toUpperCase() + attribute.slice(1)}</label>
                    <input type="text" class="form-control attribute-values-input" 
                           data-attribute="${attribute}" 
                           placeholder="Masukkan nilai, pisahkan dengan koma. Contoh: Merah, Biru, Hijau" />
                    <small class="text-muted">Pisahkan nilai dengan koma</small>
                `;
                optionsContainer.appendChild(attributeDiv);
            });
            
            modal.show();
        });
    }
    
    // Confirm generate variants
    const confirmGenerateBtn = document.getElementById('confirm-generate');
    if (confirmGenerateBtn) {
        confirmGenerateBtn.addEventListener('click', function() {
            const attributeValuesInputs = document.querySelectorAll('.attribute-values-input');
            const attributeValues = {};
            
            // Collect attribute values
            attributeValuesInputs.forEach(input => {
                const attribute = input.dataset.attribute;
                const values = input.value.split(',')
                    .map(value => value.trim())
                    .filter(value => value !== '');
                
                if (values.length > 0) {
                    attributeValues[attribute] = values;
                }
            });
            
            // Generate all combinations
            const combinations = generateCombinations(attributeValues);
            
            if (combinations.length === 0) {
                showToast('error', 'Tidak ada kombinasi varian yang dihasilkan', 'Generate Varian');
                return;
            }
            
            // Clear existing variants
            document.getElementById('variants-list').innerHTML = '';
            
            // Add generated variants
            combinations.forEach((combination, index) => {
                const variantName = Object.values(combination).join(' ');
                const attributeOptions = JSON.stringify(combination);
                
                const variantHTML = `
                    <div class="variant-item card mb-5" data-variant-index="${index}">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Varian #${index + 1}</h5>
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-new-variant">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-md-4">
                                    <label class="form-label required">Nama Varian</label>
                                    <input type="text" class="form-control" 
                                           name="variants[${index}][name]" 
                                           value="${variantName}" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">SKU Varian</label>
                                    <input type="text" class="form-control" 
                                           name="variants[${index}][sku]" 
                                           placeholder="SKU-VARIAN-${index + 1}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Atribut (JSON)</label>
                                    <input type="text" class="form-control variant-attributes-input" 
                                           name="variants[${index}][attribute_options]" 
                                           value='${attributeOptions}' />
                                </div>
                            </div>
                            
                            <div class="row mb-5">
                                <div class="col-md-3">
                                    <label class="form-label required">Harga Normal (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="variants[${index}][price]" 
                                           min="0" step="0.01" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Harga Diskon (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="variants[${index}][discount_price]" 
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Mulai Diskon</label>
                                    <input type="datetime-local" class="form-control" 
                                           name="variants[${index}][discount_start]" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Akhir Diskon</label>
                                    <input type="datetime-local" class="form-control" 
                                           name="variants[${index}][discount_end]" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label required">Stok</label>
                                    <input type="number" class="form-control" 
                                           name="variants[${index}][stock_quantity]" 
                                           value="0" min="0" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Berat (kg)</label>
                                    <input type="number" class="form-control" 
                                           name="variants[${index}][weight]" 
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gambar Varian</label>
                                    <input type="file" class="form-control" 
                                           name="variant_images[${index}]" 
                                           accept="image/*" />
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check mt-5">
                                        <input class="form-check-input" type="checkbox" 
                                               name="variants[${index}][is_default]" 
                                               value="1" 
                                               id="variant_default_gen_${index}" 
                                               ${index === 0 ? 'checked' : ''} />
                                        <label class="form-check-label" for="variant_default_gen_${index}">
                                            Varian Default
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('variants-list').insertAdjacentHTML('beforeend', variantHTML);
            });
            
            variantCount = combinations.length;
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('generateVariantsModal'));
            modal.hide();
            
            showToast('success', `${combinations.length} varian berhasil digenerate`, 'Generate Varian');
        });
    }
    
    // Helper function to generate combinations
    function generateCombinations(attributeValues) {
        const attributes = Object.keys(attributeValues);
        if (attributes.length === 0) return [];
        
        let combinations = [{}];
        
        attributes.forEach(attribute => {
            const values = attributeValues[attribute];
            const newCombinations = [];
            
            combinations.forEach(combination => {
                values.forEach(value => {
                    newCombinations.push({
                        ...combination,
                        [attribute]: value
                    });
                });
            });
            
            combinations = newCombinations;
        });
        
        return combinations;
    }
});
</script>
@endpush