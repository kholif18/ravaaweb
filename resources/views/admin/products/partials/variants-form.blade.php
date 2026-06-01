{{-- resources/views/admin/products/partials/variants-form.blade.php --}}
<div class="card mb-5" id="variants-container" 
     style="display: {{ old('has_variants', $product->has_variants ?? false) ? 'block' : 'none' }}">
    <div class="card-header">
        <h4 class="card-title">Varian Produk</h4>
        <div class="card-toolbar">
            <button type="button" class="btn btn-light-primary btn-sm" id="add-variant">
                <i class="bi bi-plus"></i> Tambah Varian
            </button>
            <button type="button" class="btn btn-light-success btn-sm ms-2" id="generate-variants">
                <i class="bi bi-magic"></i> Generate Varian
            </button>
        </div>
    </div>
    <div class="card-body">
        <div id="variants-list">
            @php
                $variants = old('variants', isset($product) && $product->variants ? 
                    $product->variants->toArray() : []);
                if (empty($variants) && !old('variants')) {
                    $variants = [[]];
                }
            @endphp
            
            @foreach($variants as $index => $variant)
                @include('admin.products.partials.variant-item', [
                    'index' => $index, 
                    'variant' => $variant
                ])
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
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Masukkan nilai untuk setiap atribut, pisahkan dengan koma. Sistem akan membuat kombinasi varian secara otomatis.
                </div>
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
// ============================================
// VARIANT MANAGER MODULE
// ============================================
const VariantManager = (function() {
    // Private variables
    let variantCount = {{ count($variants) > 0 ? count($variants) : 1 }};
    let deletedVariants = [];
    let currentVariantPickerIndex = null;
    
    // ============================================
    // Helper Functions
    // ============================================
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    function showToast(type, message, title = '') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: title || (type === 'success' ? 'Berhasil' : 'Error'),
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            alert(message);
        }
    }
    
    function getStockBadgeClass(status) {
        const classes = {
            'in_stock': 'bg-success',
            'out_of_stock': 'bg-danger',
            'pre_order': 'bg-warning'
        };
        return classes[status] || 'bg-secondary';
    }
    
    function getStockText(status) {
        const texts = {
            'in_stock': '✓ Tersedia',
            'out_of_stock': '✗ Habis',
            'pre_order': '⏱ Pre Order'
        };
        return texts[status] || '-';
    }
    
    // ============================================
    // Attribute Management
    // ============================================
    function updateAttributeJSON(variantItem) {
        const attrFields = variantItem.querySelector('.variant-attr-fields');
        const jsonInput = variantItem.querySelector('.variant-attr-json');
        if (!attrFields || !jsonInput) return;
        
        const data = {};
        attrFields.querySelectorAll('.attr-row').forEach(row => {
            const key = row.querySelector('.attr-key')?.value.trim();
            const value = row.querySelector('.attr-value')?.value.trim();
            if (key && value) {
                data[key] = value;
            }
        });
        
        jsonInput.value = JSON.stringify(data);
    }
    
    function addAttributeRow(variantItem, key = '', value = '') {
        const attrFields = variantItem.querySelector('.variant-attr-fields');
        if (!attrFields) return;
        
        const row = document.createElement('div');
        row.className = 'input-group mb-2 attr-row';
        row.innerHTML = `
            <input type="text" class="form-control attr-key" placeholder="Atribut (contoh: Warna)" value="${escapeHtml(key)}" style="flex: 1;">
            <span class="input-group-text">:</span>
            <input type="text" class="form-control attr-value" placeholder="Nilai (contoh: Merah)" value="${escapeHtml(value)}" style="flex: 1;">
            <button type="button" class="btn btn-sm btn-outline-danger remove-attr-row" title="Hapus Atribut">
                <i class="bi bi-trash"></i>
            </button>
        `;
        
        // Add event listeners
        row.querySelector('.attr-key')?.addEventListener('input', () => updateAttributeJSON(variantItem));
        row.querySelector('.attr-value')?.addEventListener('input', () => updateAttributeJSON(variantItem));
        row.querySelector('.remove-attr-row')?.addEventListener('click', () => {
            row.remove();
            updateAttributeJSON(variantItem);
            if (attrFields.querySelectorAll('.attr-row').length === 0) {
                addAttributeRow(variantItem);
            }
        });
        
        attrFields.appendChild(row);
        updateAttributeJSON(variantItem);
    }
    
    function loadAttributes(variantItem, jsonValue) {
        const attrFields = variantItem.querySelector('.variant-attr-fields');
        if (!attrFields) return;
        
        attrFields.innerHTML = '';
        
        let attrs = {};
        if (typeof jsonValue === 'object' && jsonValue !== null) {
            attrs = jsonValue;
        } else if (typeof jsonValue === 'string' && jsonValue.trim() !== '') {
            try {
                let sanitized = jsonValue.trim();
                if (sanitized === '{}' || sanitized === '') {
                    attrs = {};
                } else {
                    // Handle &quot; if it's coming from HTML attribute
                    sanitized = sanitized.replace(/&quot;/g, '"');
                    attrs = JSON.parse(sanitized);
                }
            } catch (e) {
                console.error('Error parsing attributes JSON:', e, 'Value:', jsonValue);
                attrs = {};
            }
        }

        if (attrs && typeof attrs === 'object' && !Array.isArray(attrs)) {
            const entries = Object.entries(attrs);
            if (entries.length > 0) {
                entries.forEach(([key, value]) => {
                    addAttributeRow(variantItem, key, value);
                });
            } else {
                addAttributeRow(variantItem);
            }
        } else {
            addAttributeRow(variantItem);
        }
    }
    
    // ============================================
    // Discount Management
    // ============================================
    function toggleDiscountFields(variantItem, show) {
        const discountFields = variantItem.querySelector('.discount-fields');
        if (discountFields) {
            discountFields.style.display = show ? 'block' : 'none';
        }
    }
    
    // ============================================
    // Header Display Update
    // ============================================
    function updateHeaderDisplay(variantItem) {
        const nameInput = variantItem.querySelector('.variant-name');
        const skuInput = variantItem.querySelector('.variant-sku');
        const stockSelect = variantItem.querySelector('.variant-stock-status');
        const nameDisplay = variantItem.querySelector('.variant-name-display');
        const skuDisplay = variantItem.querySelector('.variant-sku-display');
        const stockBadge = variantItem.querySelector('.variant-stock-badge');
        
        if (nameDisplay && nameInput) {
            nameDisplay.textContent = nameInput.value.trim() || 'Varian Baru';
        }
        if (skuDisplay && skuInput) {
            skuDisplay.textContent = skuInput.value.trim() || '-';
        }
        if (stockBadge && stockSelect) {
            const status = stockSelect.value;
            stockBadge.textContent = getStockText(status);
            stockBadge.className = `badge ${getStockBadgeClass(status)} variant-stock-badge`;
        }
    }
    
    // ============================================
    // Collapse Toggle
    // ============================================
    function setupCollapseToggle(variantItem) {
        const toggleBtn = variantItem.querySelector('.toggle-detail');
        const collapseDiv = variantItem.querySelector('.variant-detail-collapse');
        const icon = variantItem.querySelector('.toggle-icon');
        
        if (toggleBtn && collapseDiv) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const isExpanded = collapseDiv.classList.contains('show');
                
                if (isExpanded) {
                    collapseDiv.classList.remove('show');
                    if (icon) icon.className = 'bi bi-chevron-down toggle-icon';
                } else {
                    collapseDiv.classList.add('show');
                    if (icon) icon.className = 'bi bi-chevron-up toggle-icon';
                }
            });
        }
    }
    
    // ============================================
    // Variant Initialization
    // ============================================
    function initializeVariantEvents(variantItem) {
        // Setup collapse
        setupCollapseToggle(variantItem);
        
        // Real-time header update
        const nameInput = variantItem.querySelector('.variant-name');
        const skuInput = variantItem.querySelector('.variant-sku');
        const stockSelect = variantItem.querySelector('.variant-stock-status');
        
        if (nameInput) nameInput.addEventListener('input', () => updateHeaderDisplay(variantItem));
        if (skuInput) skuInput.addEventListener('input', () => updateHeaderDisplay(variantItem));
        if (stockSelect) stockSelect.addEventListener('change', () => updateHeaderDisplay(variantItem));
        
        // Discount toggle
        const discountToggle = variantItem.querySelector('.discount-toggle');
        if (discountToggle) {
            discountToggle.addEventListener('change', function() {
                toggleDiscountFields(variantItem, this.checked);
            });
        }
        
        // Add attribute button
        const addAttrBtn = variantItem.querySelector('.add-attr-btn');
        if (addAttrBtn) {
            addAttrBtn.addEventListener('click', () => addAttributeRow(variantItem));
        }
        
        // Image picker
        const selectImageBtn = variantItem.querySelector('.select-variant-image');
        if (selectImageBtn) {
            selectImageBtn.addEventListener('click', function() {
                const index = variantItem.dataset.variantIndex;
                if (typeof window.openMediaPicker === 'function') {
                    window.openMediaPicker('variant', index);
                }
            });
        }
        
        // Default variant logic (only one can be default)
        const defaultCheckbox = variantItem.querySelector('.variant-default-checkbox');
        if (defaultCheckbox) {
            defaultCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll('.variant-item').forEach(item => {
                        if (item !== variantItem) {
                            const cb = item.querySelector('.variant-default-checkbox');
                            if (cb) cb.checked = false;
                        }
                    });
                }
            });
        }
        
        // Load attributes
        const attrJson = variantItem.querySelector('.variant-attr-json')?.value || '{}';
        loadAttributes(variantItem, attrJson);
        
        // Initial update
        updateHeaderDisplay(variantItem);
        const isDiscountActive = variantItem.querySelector('.discount-toggle')?.checked || false;
        toggleDiscountFields(variantItem, isDiscountActive);
    }
    
    // ============================================
    // Create Variant HTML Template
    // ============================================
    function createVariantHTML(index, variantData = {}) {
        const variantId = variantData.id || '';
        const name = variantData.name || '';
        const sku = variantData.sku || '';
        const stockStatus = variantData.stock_status || 'in_stock';
        const isDefault = variantData.is_default ?? false;
        const price = variantData.price || '';
        const discountPrice = variantData.discount_price || '';
        const hasDiscount = discountPrice && discountPrice > 0;
        const discountStartAt = variantData.discount_start_at || '';
        const discountEndAt = variantData.discount_end_at || '';
        const weight = variantData.weight || '';
        const unit = variantData.unit || 'pcs';
        const imageId = variantData.image_id || '';
        const attributeOptions = typeof variantData.attribute_options === 'object' ? 
            JSON.stringify(variantData.attribute_options) : (variantData.attribute_options || '{}');
        const escapedAttrOptions = attributeOptions.replace(/"/g, '&quot;');
        
        return `
            <div class="variant-item card mb-3" data-variant-index="${index}" data-variant-id="${variantId}">
                <!-- Header -->
                <div class="card-header bg-light py-2">
                    <div class="row align-items-center">
                        <div class="col-md-5 col-lg-4">
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-link p-0 toggle-detail" title="Detail">
                                    <i class="bi bi-chevron-down toggle-icon"></i>
                                </button>
                                <strong class="variant-name-display">${escapeHtml(name) || 'Varian Baru'}</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <small class="text-muted">SKU:</small>
                            <span class="variant-sku-display">${escapeHtml(sku) || '-'}</span>
                        </div>
                        <div class="col-md-2 col-lg-3">
                            <span class="badge ${getStockBadgeClass(stockStatus)} variant-stock-badge">
                                ${getStockText(stockStatus)}
                            </span>
                        </div>
                        <div class="col-md-2 col-lg-2 text-end">
                            <div class="btn-group btn-group-sm">
                                <div class="form-check me-2 mt-2">
                                    <input class="form-check-input variant-default-checkbox" 
                                           type="checkbox" 
                                           name="variants[${index}][is_default]" 
                                           value="1" 
                                           id="variant_default_${index}"
                                           ${isDefault ? 'checked' : ''}>
                                    <label class="form-check-label small" for="variant_default_${index}">
                                        Default
                                    </label>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-variant"
                                        data-variant-id="${variantId}" title="Hapus Varian">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Detail Section (Collapsible) -->
                <div class="variant-detail-collapse collapse">
                    <div class="card-body">
                        ${variantId ? `<input type="hidden" name="variants[${index}][id]" value="${variantId}">` : ''}
                        
                        <!-- Basic Info Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Nama Varian</label>
                                <input type="text" class="form-control variant-name" 
                                       name="variants[${index}][name]" 
                                       value="${escapeHtml(name)}"
                                       placeholder="Contoh: Merah - Ukuran L" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">SKU Varian</label>
                                <input type="text" class="form-control variant-sku" 
                                       name="variants[${index}][sku]" 
                                       value="${escapeHtml(sku)}"
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
                                       name="variants[${index}][price]" 
                                       value="${price}"
                                       min="0" step="0.01" required />
                            </div>
                            <div class="col-md-8">
                                <div class="form-check mb-2">
                                    <input class="form-check-input discount-toggle" type="checkbox" 
                                           id="discount_toggle_${index}" ${hasDiscount ? 'checked' : ''}>
                                    <label class="form-check-label" for="discount_toggle_${index}">
                                        <i class="bi bi-tag"></i> Aktifkan Diskon
                                    </label>
                                </div>
                                <div class="discount-fields" style="display: ${hasDiscount ? 'block' : 'none'}">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Harga Diskon (Rp)</label>
                                            <input type="number" class="form-control" 
                                                   name="variants[${index}][discount_price]" 
                                                   value="${discountPrice}"
                                                   min="0" step="0.01" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Mulai Diskon</label>
                                            <input type="datetime-local" class="form-control" 
                                                   name="variants[${index}][discount_start_at]" 
                                                   value="${discountStartAt}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Akhir Diskon</label>
                                            <input type="datetime-local" class="form-control" 
                                                   name="variants[${index}][discount_end_at]" 
                                                   value="${discountEndAt}" />
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
                                <select class="form-select variant-stock-status" name="variants[${index}][stock_status]">
                                    <option value="in_stock" ${stockStatus === 'in_stock' ? 'selected' : ''}>✓ Tersedia (In Stock)</option>
                                    <option value="out_of_stock" ${stockStatus === 'out_of_stock' ? 'selected' : ''}>✗ Habis (Out of Stock)</option>
                                    <option value="pre_order" ${stockStatus === 'pre_order' ? 'selected' : ''}>⏱ Pre Order</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Berat (kg)</label>
                                <input type="number" class="form-control" 
                                       name="variants[${index}][weight]" 
                                       value="${weight}"
                                       min="0" step="0.01" placeholder="0.00" />
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" 
                                       name="variants[${index}][unit]" 
                                       value="${unit}"
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
                                <input type="hidden" name="variants[${index}][attribute_options]" class="variant-attr-json" value="${escapedAttrOptions}">
                            </div>
                        </div>
                        
                        <!-- Media Section -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 border-bottom pb-2">Gambar Varian</h6>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="hidden" name="variants[${index}][image_id]" class="variant-image-id" value="${imageId}">
                                    <button type="button" class="btn btn-outline-secondary select-variant-image" data-index="${index}">
                                        <i class="bi bi-image"></i> Pilih Gambar
                                    </button>
                                    <div class="variant-image-preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // ============================================
    // Public Methods
    // ============================================
    function addVariant(variantData = {}) {
        const variantsList = document.getElementById('variants-list');
        const index = variantCount;
        const html = createVariantHTML(index, variantData);
        variantsList.insertAdjacentHTML('beforeend', html);
        
        const newVariant = variantsList.lastElementChild;
        initializeVariantEvents(newVariant);
        variantCount++;
        
        return newVariant;
    }
    
    function removeVariant(variantItem, variantId) {
        if (variantId) {
            deletedVariants.push(variantId);
            document.getElementById('deleted_variants').value = JSON.stringify(deletedVariants);
        }
        variantItem.remove();
        showToast('success', 'Varian berhasil dihapus');
    }
    
    function generateCombinations(attributeValues) {
        const attributes = Object.keys(attributeValues);
        if (attributes.length === 0) return [];
        
        let combinations = [{}];
        attributes.forEach(attribute => {
            const values = attributeValues[attribute];
            const newCombinations = [];
            combinations.forEach(combination => {
                values.forEach(value => {
                    newCombinations.push({ ...combination, [attribute]: value });
                });
            });
            combinations = newCombinations;
        });
        return combinations;
    }
    
    function getCurrentVariantPickerIndex() {
        return currentVariantPickerIndex;
    }
    
    function setCurrentVariantPickerIndex(index) {
        currentVariantPickerIndex = index;
    }
    
    // Return public API
    return {
        addVariant,
        removeVariant,
        generateCombinations,
        getCurrentVariantPickerIndex,
        setCurrentVariantPickerIndex,
        initializeVariantEvents
    };
})();

// ============================================
// DOM Ready Initialization
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all existing variants
    document.querySelectorAll('.variant-item').forEach(variantItem => {
        VariantManager.initializeVariantEvents(variantItem);
    });
    
    // Add variant button
    const addVariantBtn = document.getElementById('add-variant');
    if (addVariantBtn) {
        addVariantBtn.addEventListener('click', () => VariantManager.addVariant());
    }
    
    // Remove variant (delegation)
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-variant');
        if (removeBtn) {
            e.preventDefault();
            const variantItem = removeBtn.closest('.variant-item');
            const variantId = removeBtn.dataset.variantId;
            
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
                        VariantManager.removeVariant(variantItem, variantId);
                    }
                });
            } else {
                VariantManager.removeVariant(variantItem, null);
            }
        }
    });
    
    // Generate variants button
    const generateVariantsBtn = document.getElementById('generate-variants');
    if (generateVariantsBtn) {
        generateVariantsBtn.addEventListener('click', function() {
            const attributeInputs = document.querySelectorAll('input[name="variant_attributes[]"]');
            const attributes = Array.from(attributeInputs)
                .map(input => input.value.trim())
                .filter(value => value !== '');
            
            if (attributes.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Generate Varian',
                    text: 'Tidak ada atribut varian yang ditentukan. Silakan tambahkan atribut varian terlebih dahulu.'
                });
                return;
            }
            
            const modal = new bootstrap.Modal(document.getElementById('generateVariantsModal'));
            const optionsContainer = document.getElementById('variant-options-container');
            optionsContainer.innerHTML = '';
            
            attributes.forEach(attribute => {
                const attributeDiv = document.createElement('div');
                attributeDiv.className = 'mb-3';
                attributeDiv.innerHTML = `
                    <label class="form-label fw-bold">${attribute.charAt(0).toUpperCase() + attribute.slice(1)}</label>
                    <input type="text" class="form-control attribute-values-input" 
                           data-attribute="${attribute}" 
                           placeholder="Contoh: Merah, Biru, Hijau" />
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
            
            attributeValuesInputs.forEach(input => {
                const attribute = input.dataset.attribute;
                const values = input.value.split(',')
                    .map(v => v.trim())
                    .filter(v => v !== '');
                if (values.length > 0) {
                    attributeValues[attribute] = values;
                }
            });
            
            const combinations = VariantManager.generateCombinations(attributeValues);
            
            if (combinations.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Generate Varian',
                    text: 'Tidak ada kombinasi varian yang dihasilkan'
                });
                return;
            }
            
            // Clear existing variants
            document.getElementById('variants-list').innerHTML = '';
            
            // Add generated variants
            combinations.forEach((combination, index) => {
                const variantName = Object.values(combination).join(' / ');
                VariantManager.addVariant({
                    name: variantName,
                    attribute_options: combination,
                    is_default: index === 0
                });
            });
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('generateVariantsModal'));
            modal.hide();
            
            Swal.fire({
                icon: 'success',
                title: 'Generate Varian',
                text: `${combinations.length} varian berhasil digenerate`
            });
        });
    }
});
</script>
@endpush