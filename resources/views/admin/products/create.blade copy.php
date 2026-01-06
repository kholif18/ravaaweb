@extends('admin.layouts.app')

@section('page-title', 'Tambah Produk Baru')
@section('page-description', 'Tambah Produk Baru — Ravaa Creative')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}"
           class="text-muted text-hover-primary">
            Dashboard
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.products.index') }}"
           class="text-muted text-hover-primary">
            Semua Produk
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Tambah Produk Baru
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Produk Baru</h3>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf
            
            <div class="row">
                <!-- Left Column - Basic Information -->
                <div class="col-lg-8">
                    <!-- Basic Information Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Dasar</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Nama Produk</label>
                                <input type="text" class="form-control" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       placeholder="Masukkan nama produk"
                                       required />
                                @error('name')
                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    <label class="form-label">SKU (Stock Keeping Unit)</label>
                                    <input type="text" class="form-control" 
                                           name="sku" 
                                           value="{{ old('sku') }}"
                                           placeholder="SKU-001" />
                                    <div class="text-muted fs-7 mt-1">Kosongkan untuk generate otomatis</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Barcode</label>
                                    <input type="text" class="form-control" 
                                           name="barcode" 
                                           value="{{ old('barcode') }}"
                                           placeholder="123456789012" />
                                </div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Deskripsi Pendek</label>
                                <textarea class="form-control" 
                                          name="short_description" 
                                          rows="2"
                                          placeholder="Deskripsi singkat produk (max 500 karakter)">{{ old('short_description') }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea class="form-control" 
                                          name="description" 
                                          rows="4"
                                          placeholder="Deskripsi lengkap produk">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Harga & Stok</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label required">Harga Normal (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="price" 
                                           value="{{ old('price', 0) }}"
                                           min="0" step="0.01" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Diskon (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="discount_price" 
                                           value="{{ old('discount_price') }}"
                                           min="0" step="0.01" />
                                    <div class="text-muted fs-7 mt-1">Kosongkan jika tidak ada diskon</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Modal (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="cost_price" 
                                           value="{{ old('cost_price') }}"
                                           min="0" step="0.01" />
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label required">Stok Awal</label>
                                    <input type="number" class="form-control" 
                                           name="stock_quantity" 
                                           value="{{ old('stock_quantity', 0) }}"
                                           min="0" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Stok Minimum</label>
                                    <input type="number" class="form-control" 
                                           name="minimum_stock" 
                                           value="{{ old('minimum_stock', 10) }}"
                                           min="0" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Status Stok</label>
                                    <select class="form-select" name="stock_status" required>
                                        <option value="in_stock" {{ old('stock_status', 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="pre_order" {{ old('stock_status') == 'pre_order' ? 'selected' : '' }}>Pre Order</option>
                                        <option value="backorder" {{ old('stock_status') == 'backorder' ? 'selected' : '' }}>Backorder</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label">Berat (kg)</label>
                                    <input type="number" class="form-control" 
                                           name="weight" 
                                           value="{{ old('weight') }}"
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control" 
                                           name="unit" 
                                           value="{{ old('unit', 'pcs') }}"
                                           placeholder="pcs, kg, meter, dll" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Manage Stock?</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="manage_stock" 
                                               value="1" 
                                               id="manage_stock" 
                                               {{ old('manage_stock', true) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="manage_stock">
                                            Ya, kelola stok
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Images Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Gambar Produk</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Gambar Utama</label>
                                <input type="file" class="form-control" 
                                       name="main_image" 
                                       accept="image/*" />
                                <div class="text-muted fs-7 mt-1">Ukuran maksimal 2MB. Format: JPG, PNG, GIF</div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Gambar Tambahan</label>
                                <input type="file" class="form-control" 
                                       name="images[]" 
                                       multiple 
                                       accept="image/*" />
                                <div class="text-muted fs-7 mt-1">Pilih beberapa gambar sekaligus (maks 10 gambar)</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Specifications Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Spesifikasi & Fitur</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Spesifikasi Teknis</label>
                                <textarea class="form-control" 
                                          name="specifications" 
                                          rows="3"
                                          placeholder="Spesifikasi teknis produk">{{ old('specifications') }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Fitur Unggulan</label>
                                <textarea class="form-control" 
                                          name="features" 
                                          rows="3"
                                          placeholder="Fitur-fitur unggulan produk">{{ old('features') }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Cara Penggunaan</label>
                                <textarea class="form-control" 
                                          name="usage_instructions" 
                                          rows="2"
                                          placeholder="Petunjuk penggunaan">{{ old('usage_instructions') }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Informasi Garansi</label>
                                <textarea class="form-control" 
                                          name="warranty_info" 
                                          rows="2"
                                          placeholder="Informasi garansi produk">{{ old('warranty_info') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Settings & Options -->
                <div class="col-lg-4">
                    <!-- Settings Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Pengaturan</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Kategori</label>
                                <select class="form-select" name="category_id">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Slug (URL)</label>
                                <input type="text" class="form-control" 
                                       name="slug" 
                                       value="{{ old('slug') }}"
                                       placeholder="nama-produk-url" />
                                <div class="text-muted fs-7 mt-1">Kosongkan untuk generate otomatis dari nama</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Features Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Fitur Produk</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_featured" 
                                           value="1" 
                                           id="is_featured" 
                                           {{ old('is_featured') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_featured">
                                        Produk Unggulan (Featured)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-5">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_best_seller" 
                                           value="1" 
                                           id="is_best_seller" 
                                           {{ old('is_best_seller') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_best_seller">
                                        Best Seller
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-5">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_new_arrival" 
                                           value="1" 
                                           id="is_new_arrival" 
                                           {{ old('is_new_arrival') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_new_arrival">
                                        New Arrival
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dimensions Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Dimensi Produk (cm)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-md-4">
                                    <label class="form-label">Panjang</label>
                                    <input type="number" class="form-control" 
                                           name="length" 
                                           value="{{ old('length') }}"
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Lebar</label>
                                    <input type="number" class="form-control" 
                                           name="width" 
                                           value="{{ old('width') }}"
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tinggi</label>
                                    <input type="number" class="form-control" 
                                           name="height" 
                                           value="{{ old('height') }}"
                                           min="0" step="0.01" />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tags & Attributes Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Tags & Atribut</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Tags</label>
                                <input type="text" class="form-control" 
                                       name="tags" 
                                       value="{{ old('tags') }}"
                                       placeholder="tag1, tag2, tag3" />
                                <div class="text-muted fs-7 mt-1">Pisahkan dengan koma</div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Warna Tersedia</label>
                                <input type="text" class="form-control" 
                                       name="colors" 
                                       value="{{ old('colors') }}"
                                       placeholder="Merah, Biru, Hijau" />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Ukuran Tersedia</label>
                                <input type="text" class="form-control" 
                                       name="sizes" 
                                       value="{{ old('sizes') }}"
                                       placeholder="S, M, L, XL" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- SEO Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">SEO Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" 
                                       name="meta_title" 
                                       value="{{ old('meta_title') }}"
                                       placeholder="Meta title untuk SEO" />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" 
                                          name="meta_description" 
                                          rows="2"
                                          placeholder="Meta description untuk SEO">{{ old('meta_description') }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" 
                                       name="meta_keywords" 
                                       value="{{ old('meta_keywords') }}"
                                       placeholder="Keyword1, Keyword2, Keyword3" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-10">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light me-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    <span class="indicator-label">
                        <i class="bi bi-save"></i> Simpan Produk
                    </span>
                    <span class="indicator-progress">
                        Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-check-input:checked {
        background-color: #009ef7;
        border-color: #009ef7;
    }
    .card-bordered {
        border: 1px solid #e4e6ef;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e4e6ef;
    }
</style>
@endpush

@push('scripts')
<script>
// Toast Notification Function
function showToast(type, message, title = '') {
    const toastId = 'toast-' + Date.now();
    const icon = {
        'success': 'bi-check-circle',
        'error': 'bi-x-circle',
        'warning': 'bi-exclamation-triangle',
        'info': 'bi-info-circle'
    }[type] || 'bi-info-circle';

    const color = {
        'success': 'text-success',
        'error': 'text-danger',
        'warning': 'text-warning',
        'info': 'text-info'
    }[type] || 'text-info';

    const toastHTML = `
        <div id="${toastId}" class="toast toast-${type} mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi ${icon} ${color} me-2"></i>
                <strong class="me-auto">${title || type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                <small class="text-muted">baru saja</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    const container = document.getElementById('toastContainer');
    if (!container) {
        console.error('Toast container not found');
        return;
    }
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        delay: 5000,
        autohide: true
    });
    toast.show();

    toastElement.addEventListener('hidden.bs.toast', function () {
        this.remove();
    });
}

// Show session messages as toast
@if(session('success'))
    showToast('success', '{{ session('success') }}', 'Sukses!');
@endif

@if(session('error'))
    showToast('error', '{{ session('error') }}', 'Error!');
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        showToast('error', '{{ $error }}', 'Validasi Error!');
    @endforeach
@endif

// Form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('product-form');
    const submitBtn = document.getElementById('submit-btn');
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.setAttribute('data-kt-indicator', 'on');
        submitBtn.disabled = true;
        
        // Validation
        const name = form.querySelector('input[name="name"]').value.trim();
        const price = form.querySelector('input[name="price"]').value;
        
        if (!name) {
            e.preventDefault();
            showToast('error', 'Nama produk wajib diisi', 'Validasi Error!');
            submitBtn.removeAttribute('data-kt-indicator');
            submitBtn.disabled = false;
            return;
        }
        
        if (!price || parseFloat(price) < 0) {
            e.preventDefault();
            showToast('error', 'Harga produk tidak valid', 'Validasi Error!');
            submitBtn.removeAttribute('data-kt-indicator');
            submitBtn.disabled = false;
            return;
        }
        
        // Jika semua valid, form akan submit
    });
    
    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function() {
            if (!slugInput.value) {
                // Simple slug generation
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s]/gi, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                slugInput.value = slug;
            }
        });
    }
    
    // Auto-generate SKU if empty
    const skuInput = document.querySelector('input[name="sku"]');
    if (skuInput && !skuInput.value) {
        skuInput.addEventListener('blur', function() {
            if (!this.value) {
                // Generate simple SKU
                const timestamp = Date.now().toString().slice(-6);
                const random = Math.random().toString(36).substring(2, 6).toUpperCase();
                this.value = 'SKU-' + timestamp + '-' + random;
            }
        });
    }
    
    // Calculate profit margin
    const priceInput = document.querySelector('input[name="price"]');
    const costInput = document.querySelector('input[name="cost_price"]');
    const discountInput = document.querySelector('input[name="discount_price"]');
    
    function calculateProfit() {
        if (priceInput && costInput && parseFloat(costInput.value) > 0) {
            const price = parseFloat(priceInput.value) || 0;
            const cost = parseFloat(costInput.value) || 0;
            const discount = parseFloat(discountInput?.value) || 0;
            
            const sellingPrice = discount > 0 ? discount : price;
            const profit = sellingPrice - cost;
            const margin = cost > 0 ? (profit / cost) * 100 : 0;
            
            // You can display this info somewhere
            console.log(`Profit: Rp ${profit.toLocaleString()}, Margin: ${margin.toFixed(2)}%`);
        }
    }
    
    if (priceInput) priceInput.addEventListener('input', calculateProfit);
    if (costInput) costInput.addEventListener('input', calculateProfit);
    if (discountInput) discountInput.addEventListener('input', calculateProfit);
});
</script>
@endpush