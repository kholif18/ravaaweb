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
                                <label class="form-label required">Deskripsi Lengkap</label>
                                <div id="description-editor">
                                    <textarea class="form-control d-none" 
                                              name="description" 
                                              id="description-textarea"
                                              rows="4"
                                              placeholder="Deskripsi lengkap produk">{{ old('description') }}</textarea>
                                </div>
                                <div class="text-muted fs-7 mt-1">
                                    Gunakan toolbar di atas untuk memformat teks. Format HTML akan disimpan.
                                </div>
                                @error('description')
                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                @enderror
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
                    
                    <!-- Product Type & Variants -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Tipe Produk</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           name="has_variants" 
                                           value="1" 
                                           id="has_variants" 
                                           {{ old('has_variants') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="has_variants">
                                        Produk memiliki varian (ukuran, warna, dll)
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Variant Attributes Section -->
                            <div class="mb-10" id="variant-attributes-section" style="display: {{ old('has_variants') ? 'block' : 'none' }}">
                                <label class="form-label">Atribut Varian</label>
                                <div id="variant-attributes-container">
                                    @php
                                        $variantAttrs = old('variant_attributes', []);
                                        if (empty($variantAttrs)) {
                                            $variantAttrs = [''];
                                        }
                                    @endphp
                                    @foreach($variantAttrs as $index => $attribute)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" 
                                               name="variant_attributes[]" 
                                               value="{{ $attribute }}"
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
                    
                    <!-- Pricing Card (Non-Variant Only) -->
                    <div class="card card-bordered mb-10" id="non-variant-pricing" style="display: {{ old('has_variants') ? 'none' : 'block' }}">
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
                                <div class="col-md-3">
                                    <label class="form-label required">Stok Awal</label>
                                    <input type="number" class="form-control" 
                                           name="stock_quantity" 
                                           value="{{ old('stock_quantity', 0) }}"
                                           min="0" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">Stok Minimum</label>
                                    <input type="number" class="form-control" 
                                           name="minimum_stock" 
                                           value="{{ old('minimum_stock', 10) }}"
                                           min="0" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Mulai Diskon</label>
                                    <input type="datetime-local" class="form-control" 
                                           name="discount_start" 
                                           value="{{ old('discount_start') }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Akhir Diskon</label>
                                    <input type="datetime-local" class="form-control" 
                                           name="discount_end" 
                                           value="{{ old('discount_end') }}" />
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label required">Status Stok</label>
                                    <select class="form-select" name="stock_status" required>
                                        <option value="in_stock" {{ old('stock_status', 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="pre_order" {{ old('stock_status') == 'pre_order' ? 'selected' : '' }}>Pre Order</option>
                                        <option value="backorder" {{ old('stock_status') == 'backorder' ? 'selected' : '' }}>Backorder</option>
                                    </select>
                                </div>
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
                            </div>
                            
                            <div class="mb-10">
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
                    
                    <!-- Variants Section -->
                    @include('admin.products.partials.variants-form', ['product' => null])
                    
                    <!-- Images Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Gambar Produk</h4>
                        </div>

                        <div class="card-body">
                            {{-- ================= MAIN IMAGE ================= --}}
                            <div class="mb-10">
                                <label class="form-label fw-bold required">Gambar Utama</label>

                                <div class="d-flex align-items-center gap-4">
                                    <div class="image-preview" id="mainImagePreview">
                                        <span class="text-muted">Belum dipilih</span>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-light" onclick="openMediaPicker('main')">
                                            <i class="bi bi-image"></i> Pilih dari Media
                                        </button>

                                        <button type="button"
                                                class="btn btn-sm btn-danger mt-2"
                                                id="removeMainImage"
                                                style="display: none;">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="main_image_id" id="main_image_id" value="{{ old('main_image_id') }}">
                                @error('main_image_id')
                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ================= GALLERY ================= --}}
                            <div class="mb-10">
                                <label class="form-label fw-bold">Gallery Produk</label>

                                <div class="gallery-grid" id="galleryPreview">
                                    {{-- Gallery items akan muncul di sini via JS --}}
                                </div>

                                <button type="button" class="btn btn-light mt-3" onclick="openMediaPicker('gallery')">
                                    <i class="bi bi-images"></i> Tambah dari Media
                                </button>

                                <input type="hidden" name="gallery_images" id="gallery_images" value="{{ old('gallery_images', '[]') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Specifications & Features Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Spesifikasi & Fitur</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Spesifikasi & Fitur Lengkap</label>
                                <div id="specifications-editor">
                                    <textarea class="form-control d-none" 
                                              name="specifications" 
                                              id="specifications-textarea"
                                              rows="6"
                                              placeholder="Masukkan spesifikasi dan fitur produk dengan format yang rapi">{{ old('specifications') }}</textarea>
                                </div>
                                <div class="text-muted fs-7 mt-1">
                                    Gunakan toolbar di atas untuk memformat teks. Contoh: buat list untuk fitur, table untuk spesifikasi teknis.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Tambahan</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Cara Penggunaan</label>
                                <textarea class="form-control" 
                                          name="usage_instructions" 
                                          rows="2"
                                          placeholder="Petunjuk penggunaan produk">{{ old('usage_instructions') }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Informasi Garansi</label>
                                <textarea class="form-control" 
                                          name="warranty_info" 
                                          rows="2"
                                          placeholder="Informasi garansi produk">{{ old('warranty_info') }}</textarea>
                            </div>

                            <div class="mb-10">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" 
                                          name="additional_notes" 
                                          rows="2"
                                          placeholder="Catatan tambahan untuk produk">{{ old('additional_notes') }}</textarea>
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
                                <select class="form-select" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger fs-7 mt-1">{{ $message }}</div>
                                @enderror
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
                                <label class="form-label">Tanggal Publish</label>
                                <input type="datetime-local" class="form-control" 
                                       name="published_at" 
                                       value="{{ old('published_at') }}" />
                                <div class="text-muted fs-7 mt-1">Kosongkan untuk publish sekarang</div>
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

                            <div class="mb-5">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_pre_order" 
                                           value="1" 
                                           id="is_pre_order" 
                                           {{ old('is_pre_order') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_pre_order">
                                        Pre Order
                                    </label>
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_digital" 
                                           value="1" 
                                           id="is_digital" 
                                           {{ old('is_digital') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_digital">
                                        Produk Digital (Tidak dikirim)
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
                                       placeholder="desain, logo, branding" />
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
                    
                    <!-- Related Products Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Produk Terkait</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label">Pilih Produk Terkait</label>
                                <select class="form-select" name="related_products[]" multiple data-control="select2" data-placeholder="Pilih produk terkait">
                                    @foreach($relatedProducts as $related)
                                        <option value="{{ $related->id }}" {{ in_array($related->id, old('related_products', [])) ? 'selected' : '' }}>
                                            {{ $related->name }} ({{ $related->sku ?? 'No SKU' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7 mt-1">Pilih produk yang terkait dengan produk ini</div>
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
                                <div class="text-muted fs-7 mt-1">Pisahkan dengan koma</div>
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

<!-- Modal Media Picker - SIMPLIFIED VERSION -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="bi bi-images me-2"></i>
                    Pilih Media
                    <span id="pickerTargetBadge" class="badge bg-primary ms-2">Gambar Utama</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-0">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#media-library-tab">
                            <i class="bi bi-grid-3x3-gap me-2"></i> Media Library
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#upload-tab">
                            <i class="bi bi-cloud-upload me-2"></i> Upload
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content p-3">
                    <!-- Tab 1: Media Library -->
                    <div class="tab-pane fade show active" id="media-library-tab">
                        <!-- Search Bar -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" 
                                   id="mediaSearch" 
                                   placeholder="Cari media...">
                            <button class="btn btn-outline-secondary" type="button" 
                                    onclick="searchMediaLibrary()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        
                        <!-- Media Grid - Gunakan class yang sama dengan picker -->
                        <div class="row g-3" id="mediaLibraryGrid">
                            <!-- Loading state -->
                            <div class="col-12 text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-3 text-muted">Memuat media library...</p>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <nav aria-label="Media pagination" id="mediaPagination" class="d-flex justify-content-center mt-3">
                            <!-- Pagination akan diisi via JS -->
                        </nav>
                    </div>
                    
                    <!-- Tab 2: Upload -->
                    <div class="tab-pane fade" id="upload-tab">
                        <div class="text-center p-5 border rounded">
                            <i class="bi bi-cloud-arrow-up text-muted display-5 d-block mb-3"></i>
                            <h5 class="mb-3">Upload File Baru</h5>
                            <p class="text-muted mb-4">
                                Seret file ke sini atau klik untuk memilih
                            </p>
                            <input type="file" id="fileUpload" class="d-none" 
                                   multiple accept="image/*" onchange="handleFileSelection(this.files)">
                            <button type="button" class="btn btn-primary" 
                                    onclick="document.getElementById('fileUpload').click()">
                                <i class="bi bi-folder2-open me-2"></i> Pilih File
                            </button>
                            <div class="mt-3 text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Ukuran maks: 5MB • Format: JPG, PNG, GIF, WebP, SVG
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <div id="selectionInfo" class="me-auto" style="display: none;">
                    <span class="text-muted">
                        <span id="selectedCount">0</span> gambar dipilih
                    </span>
                </div>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn btn-primary" id="insertMediaBtn" 
                        onclick="insertSelectedMedia()" disabled>
                    <i class="bi bi-check-circle me-1"></i> Pilih
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ========== STYLING UNTUK FORM PRODUK ========== */
/* Gallery Preview */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 12px;
    margin-bottom: 16px;
}

.gallery-item {
    position: relative;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1/1;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-item .remove-gallery-item {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 28px;
    height: 28px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 2;
}

.gallery-item:hover .remove-gallery-item {
    opacity: 1;
}

/* Main Image Preview */
.image-preview {
    width: 200px;
    height: 200px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #f8f9fa;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Toolbar (jika ada) */
.toolbar {
    background-color: #f8f9fa;
}

/* Responsive untuk form */
@media (max-width: 768px) {
    .image-preview {
        width: 150px;
        height: 150px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
    }
}
</style>
@endpush

@push('scripts')
<!-- TinyMCE -->
{{-- <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script>
    // ========== MEDIA PICKER FUNCTIONS ==========
    let selectedMediaItems = [];
    let currentPickerTarget = 'main';
    let currentPage = 1;
    let totalPages = 1;
    let searchQuery = '';

    function openMediaPicker(target) {
        currentPickerTarget = target;
        selectedMediaItems = [];

        // Update UI
        const badge = document.getElementById('pickerTargetBadge');
        const modalTitle = document.getElementById('modalTitle');
        const insertBtn = document.getElementById('insertMediaBtn');
        const selectionInfo = document.getElementById('selectionInfo');

        if (badge && modalTitle && insertBtn) {
            if (target === 'main') {
                badge.textContent = 'Gambar Utama';
                badge.className = 'badge bg-primary ms-2';
                modalTitle.textContent = 'Pilih Gambar Utama';
                insertBtn.textContent = 'Pilih Gambar';
                if (selectionInfo) selectionInfo.style.display = 'none';
            } else {
                badge.textContent = 'Gallery';
                badge.className = 'badge bg-success ms-2';
                modalTitle.textContent = 'Pilih Gambar Gallery';
                insertBtn.textContent = 'Tambah ke Gallery';
                if (selectionInfo) selectionInfo.style.display = 'block';
            }
        }

        // Show modal
        const modalElement = document.getElementById('mediaPickerModal');
        if (!modalElement) {
            console.error('Modal element not found!');
            return;
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        modal.show();

        // Load media library when modal is shown
        loadMediaLibrary(1);
    }

    // Load media library via AJAX
    function loadMediaLibrary(page = 1) {
        currentPage = page;

        const grid = document.getElementById('mediaLibraryGrid');
        if (!grid) {
            console.error('Media library grid not found!');
            return;
        }

        // Loading state
        grid.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-3 text-muted">Memuat media library...</p>
            </div>
        `;

        fetch(`/admin/media/picker?page=${page}&search=${encodeURIComponent(searchQuery)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Media data received:', data);
            
            // Update grid dengan HTML dari server
            grid.innerHTML = data.html;
            
            // Setup click events untuk semua media items
            setupMediaClickEvents();
            
            // Update pagination
            currentPage = data.currentPage || 1;
            totalPages = data.totalPages || 1;
            
            // Update pagination controls
            updatePaginationControls();
            
        })
        .catch(error => {
            console.error('Error loading media:', error);
            grid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 48px;"></i>
                    <p class="mt-3 text-danger">Gagal memuat media library</p>
                </div>
            `;
        });
    }

    // Update pagination controls
    function updatePaginationControls() {
        const paginationContainer = document.querySelector('.pagination');
        if (!paginationContainer || totalPages <= 1) return;
        
        const paginationLinks = paginationContainer.querySelectorAll('a.page-link');
        
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const href = this.getAttribute('href');
                if (!href) return;
                
                // Extract page number from URL
                const match = href.match(/page=(\d+)/);
                if (match) {
                    const page = parseInt(match[1]);
                    loadMediaLibrary(page);
                    
                    // Scroll to top of grid
                    const grid = document.getElementById('mediaLibraryGrid');
                    if (grid) {
                        grid.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
    }

    // Update pagination links untuk handle AJAX
    function updatePaginationLinks() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const href = this.getAttribute('href');
                if (!href) return;
                
                // Extract page number from URL
                const match = href.match(/page=(\d+)/);
                if (match) {
                    const page = parseInt(match[1]);
                    loadMediaLibrary(page);
                }
            });
        });
    }

    // Setup click events untuk media items
    function setupMediaClickEvents() {
        const mediaItems = document.querySelectorAll('.media-item');
        
        mediaItems.forEach(item => {
            // Setup single click untuk pilih
            item.addEventListener('click', function(e) {
                // Skip jika klik pada child tertentu
                if (e.target.tagName === 'BUTTON' || 
                    e.target.closest('.btn-select-media')) {
                    return;
                }
                
                toggleMediaSelection(this);
            });
        });
    }

    // Render media cards
    function renderMediaCards(mediaItems) {
        const grid = document.getElementById('mediaLibraryGrid');
        if (!grid) return;
        
        console.log('Rendering media cards:', mediaItems); // Debug log
        
        let html = '';
        
        mediaItems.forEach(item => {
            const isSelected = selectedMediaItems.some(sel => sel.id === item.id);
            
            html += `
                <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="media-card-item ${isSelected ? 'selected' : ''}"
                        data-id="${item.id}"
                        data-url="${item.url}"
                        data-thumbnail="${item.thumbnail_url || item.url}"
                        data-name="${item.name}">
                        
                        <div class="media-card-img position-relative">
                            <img src="${item.thumbnail_url || item.url}" 
                                alt="${item.name}"
                                class="img-fluid"
                                loading="lazy">
                            
                            ${isSelected ? '<div class="media-check-badge"><i class="bi bi-check"></i></div>' : ''}
                            
                            <div class="media-card-overlay">
                                <button type="button" class="btn btn-primary btn-select-media"
                                        data-media-id="${item.id}">
                                    <i class="bi bi-check-lg me-1"></i> Pilih
                                </button>
                            </div>
                        </div>
                        
                        <div class="media-card-body">
                            <h6 class="media-card-title" title="${item.name}">
                                ${item.name.length > 20 ? item.name.substring(0, 20) + '...' : item.name}
                            </h6>
                            <p class="media-card-meta">
                                ${item.extension ? item.extension.toUpperCase() : ''} 
                                ${item.formatted_size ? '• ' + item.formatted_size : ''}
                            </p>
                        </div>
                    </div>
                </div>
            `;
        });
        
        grid.innerHTML = html;
        setupMediaCardEvents();
    }

    // Function untuk tampilan kosong
    function renderNoMediaFound() {
        const grid = document.getElementById('mediaLibraryGrid');
        if (!grid) return;
        
        grid.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="bi bi-image text-muted" style="font-size: 48px;"></i>
                <h5 class="text-muted mt-3">Tidak ada media ditemukan</h5>
                <p class="text-muted">
                    ${searchQuery ? `Tidak ada hasil untuk "${searchQuery}"` : 'Upload file baru menggunakan tab upload'}
                </p>
            </div>
        `;
    }

    // Function untuk error state
    function renderErrorState(errorMessage) {
        const grid = document.getElementById('mediaLibraryGrid');
        if (!grid) return;
        
        grid.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Gagal memuat media: ${errorMessage}
                </div>
            </div>
        `;
    }

// Setup event listeners untuk media cards
function setupMediaCardEvents() {
    console.log('Setting up media card events...');
    
    // Karena server mengembalikan HTML dengan class yang berbeda,
    // kita perlu menyesuaikan selector
    
    // CARA 1: Coba selector untuk HTML dari server
    document.querySelectorAll('.media-card-item, .media-item, .media-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Skip if clicking on button inside
            if (e.target.closest('.btn-select-media, .btn-select')) return;
            
            // Cari data-id dari berbagai kemungkinan atribut
            const mediaId = this.dataset.id || this.getAttribute('data-id');
            const mediaUrl = this.dataset.url || this.getAttribute('data-url');
            const mediaThumbnail = this.dataset.thumbnail || this.getAttribute('data-thumbnail') || mediaUrl;
            const mediaName = this.dataset.name || this.getAttribute('data-name') || '';
            
            if (!mediaId) {
                console.warn('No media ID found on element:', this);
                return;
            }
            
            toggleMediaSelection({
                id: parseInt(mediaId),
                url: mediaUrl,
                thumbnail: mediaThumbnail,
                name: mediaName
            }, this);
        });
    });
    
    // CARA 2: Handle semua select buttons
    document.querySelectorAll('.btn-select-media, .btn-select, [data-media-id]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Cari card parent
            const mediaCard = this.closest('.media-card-item, .media-item, .media-card, [data-id]');
            if (!mediaCard) {
                console.warn('No media card found for button:', this);
                return;
            }
            
            // Ambil data dari berbagai sumber
            const mediaId = mediaCard.dataset.id || mediaCard.getAttribute('data-id') || 
                           this.dataset.mediaId || this.getAttribute('data-media-id');
            const mediaUrl = mediaCard.dataset.url || mediaCard.getAttribute('data-url');
            const mediaThumbnail = mediaCard.dataset.thumbnail || mediaCard.getAttribute('data-thumbnail') || mediaUrl;
            const mediaName = mediaCard.dataset.name || mediaCard.getAttribute('data-name') || '';
            
            if (!mediaId) {
                console.warn('No media ID found for button:', this);
                return;
            }
            
            if (currentPickerTarget === 'main') {
                // Single selection for main image
                selectSingleMedia({
                    id: parseInt(mediaId),
                    url: mediaUrl,
                    thumbnail: mediaThumbnail,
                    name: mediaName
                });
            } else {
                // Toggle selection for gallery
                toggleMediaSelection({
                    id: parseInt(mediaId),
                    url: mediaUrl,
                    thumbnail: mediaThumbnail,
                    name: mediaName
                }, mediaCard);
            }
        });
    });
    
    console.log(`Found ${document.querySelectorAll('.media-card-item, .media-item, .media-card').length} media cards`);
    console.log(`Found ${document.querySelectorAll('.btn-select-media, .btn-select, [data-media-id]').length} select buttons`);
}

    // Toggle media selection
    function toggleMediaSelection(element) {
        const mediaId = parseInt(element.dataset.id);
        const mediaUrl = element.dataset.url;
        const mediaThumbnail = element.dataset.thumbnail || mediaUrl;
        const mediaName = element.dataset.name;
        
        const media = {
            id: mediaId,
            url: mediaUrl,
            thumbnail: mediaThumbnail,
            name: mediaName
        };
        
        if (currentPickerTarget === 'main') {
            // Untuk main image: hanya satu yang bisa dipilih
            // Hapus selection dari yang lain
            document.querySelectorAll('.media-item.selected').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Select yang baru
            element.classList.add('selected');
            selectedMediaItems = [media];
        } else {
            // Untuk gallery: multiple selection
            if (element.classList.contains('selected')) {
                // Unselect
                element.classList.remove('selected');
                selectedMediaItems = selectedMediaItems.filter(item => item.id !== mediaId);
            } else {
                // Select
                element.classList.add('selected');
                selectedMediaItems.push(media);
            }
        }
        
        updateSelectionUI();
    }
    // Select single media (for main image)
    function selectSingleMedia(media) {
        selectedMediaItems = [media];
        
        // Close modal and insert immediately for main image
        insertSelectedMedia();
    }

    // Update selection UI
    function updateSelectionUI() {
        const selectedCount = selectedMediaItems.length;
        const insertBtn = document.getElementById('insertMediaBtn');
        const selectionInfo = document.getElementById('selectionInfo');
        const selectedCountEl = document.getElementById('selectedCount');
        
        if (selectedCountEl) {
            selectedCountEl.textContent = selectedCount;
        }
        
        if (selectionInfo) {
            selectionInfo.style.display = selectedCount > 0 && currentPickerTarget === 'gallery' ? 'block' : 'none';
        }
        
        if (insertBtn) {
            insertBtn.disabled = selectedCount === 0;
        }
    }


    // Insert selected media to form
    function insertSelectedMedia() {
        if (selectedMediaItems.length === 0) return;
        
        if (currentPickerTarget === 'main') {
            // Insert main image
            const media = selectedMediaItems[0];
            insertMainImageToForm(media);
        } else {
            // Insert gallery images
            insertGalleryImagesToForm(selectedMediaItems);
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('mediaPickerModal'));
        if (modal) modal.hide();
    }

    // Insert main image to form
    function insertMainImageToForm(media) {
        const previewDiv = document.getElementById('mainImagePreview');
        const mainImageInput = document.getElementById('main_image_id');
        const removeBtn = document.getElementById('removeMainImage');
        
        if (previewDiv) {
            previewDiv.innerHTML = `
                <img src="${media.url}" alt="${media.name}" 
                    class="img-fluid rounded" 
                    style="max-height: 200px; object-fit: contain;">
            `;
        }
        
        if (mainImageInput) {
            mainImageInput.value = media.id;
        }
        
        if (removeBtn) {
            removeBtn.style.display = 'block';
        }
    }

    // Insert gallery images to form
    function insertGalleryImagesToForm(mediaList) {
        const galleryContainer = document.getElementById('galleryPreview');
        const galleryInput = document.getElementById('gallery_images');
        
        if (!galleryContainer || !galleryInput) return;
        
        // Parse existing images
        let existingImages = [];
        try {
            existingImages = JSON.parse(galleryInput.value || '[]');
        } catch (e) {
            console.error('Error parsing gallery images:', e);
            existingImages = [];
        }
        
        // Add new images
        mediaList.forEach(media => {
            if (!existingImages.includes(media.id)) {
                existingImages.push(media.id);
                
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';
                galleryItem.setAttribute('data-id', media.id);
                galleryItem.innerHTML = `
                    <img src="${media.thumbnail}" alt="${media.name}" 
                        class="img-fluid rounded"
                        style="width: 100%; height: 120px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger remove-gallery-item"
                            onclick="removeGalleryImage(${media.id})">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                galleryContainer.appendChild(galleryItem);
            }
        });
        
        // Update hidden input
        galleryInput.value = JSON.stringify(existingImages);
    }

    // Search media library
    function searchMediaLibrary() {
        const searchInput = document.getElementById('mediaSearch');
        const query = searchInput ? searchInput.value.trim() : '';
        
        fetch(`/admin/media/picker?search=${encodeURIComponent(query)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const modalBody = document.querySelector('#media-library-tab .tab-content');
            if (modalBody) {
                modalBody.innerHTML = html;
                setupMediaClickEvents();
                updatePaginationLinks();
            }
        })
        .catch(error => {
            console.error('Error searching media:', error);
            showToast('error', 'Gagal mencari media');
        });
    }

    // Update pagination
    function updatePagination() {
        const paginationContainer = document.getElementById('mediaPagination');
        if (!paginationContainer || totalPages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }
        
        let paginationHTML = '<ul class="pagination justify-content-center mb-0">';
        
        // Previous button
        if (currentPage > 1) {
            paginationHTML += `
                <li class="page-item">
                    <button class="page-link" onclick="loadMediaLibrary(${currentPage - 1})">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                </li>
            `;
        }
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <button class="page-link" onclick="loadMediaLibrary(${i})">${i}</button>
                    </li>
                `;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        // Next button
        if (currentPage < totalPages) {
            paginationHTML += `
                <li class="page-item">
                    <button class="page-link" onclick="loadMediaLibrary(${currentPage + 1})">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </li>
            `;
        }
        
        paginationHTML += '</ul>';
        paginationContainer.innerHTML = paginationHTML;
    }

    // Remove main image
    function removeMainImage() {
        const previewDiv = document.getElementById('mainImagePreview');
        const mainImageInput = document.getElementById('main_image_id');
        const removeBtn = document.getElementById('removeMainImage');
        
        if (previewDiv) {
            previewDiv.innerHTML = '<span class="text-muted">Belum dipilih</span>';
        }
        
        if (mainImageInput) {
            mainImageInput.value = '';
        }
        
        if (removeBtn) {
            removeBtn.style.display = 'none';
        }
    }

    // Remove gallery image
    function removeGalleryImage(mediaId) {
        const galleryInput = document.getElementById('gallery_images');
        const galleryItem = document.querySelector(`.gallery-item[data-id="${mediaId}"]`);
        
        if (galleryItem) {
            galleryItem.remove();
        }
        
        if (galleryInput) {
            try {
                let galleryImages = JSON.parse(galleryInput.value || '[]');
                galleryImages = galleryImages.filter(id => id !== mediaId);
                galleryInput.value = JSON.stringify(galleryImages);
            } catch (e) {
                console.error('Error removing gallery image:', e);
            }
        }
    }

    // Initialize gallery from old data
    function initializeGalleryFromOldData() {
        const galleryInput = document.getElementById('gallery_images');
        if (!galleryInput || !galleryInput.value) return;
        
        try {
            const galleryImages = JSON.parse(galleryInput.value);
            if (galleryImages.length > 0) {
                // Fetch images data from server
                fetch(`/admin/media/get-batch?ids=${galleryImages.join(',')}`)
                    .then(response => response.json())
                    .then(images => {
                        const galleryContainer = document.getElementById('galleryPreview');
                        if (galleryContainer && images.length > 0) {
                            galleryContainer.innerHTML = '';
                            images.forEach(image => {
                                const galleryItem = document.createElement('div');
                                galleryItem.className = 'gallery-item';
                                galleryItem.setAttribute('data-id', image.id);
                                galleryItem.innerHTML = `
                                    <img src="${image.thumbnail || image.url}" alt="${image.name}" 
                                        class="img-fluid rounded"
                                        style="width: 100%; height: 120px; object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-danger remove-gallery-item"
                                            onclick="removeGalleryImage(${image.id})">
                                        <i class="bi bi-x"></i>
                                    </button>
                                `;
                                galleryContainer.appendChild(galleryItem);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading gallery images:', error);
                    });
            }
        } catch (e) {
            console.error('Error parsing gallery images:', e);
        }
    }

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
            <div id="${toastId}" class="toast mb-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi ${icon} ${color} me-2"></i>
                    <strong class="me-auto">${title || type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;

        const container = document.getElementById('toastContainer');
        if (container) {
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
    }


    // Initialize ketika DOM siap
    document.addEventListener('DOMContentLoaded', function() {     
        initializeGalleryFromOldData();
        
        // Setup remove main image button
        const removeMainImageBtn = document.getElementById('removeMainImage');
        if (removeMainImageBtn) {
            removeMainImageBtn.addEventListener('click', removeMainImage);
        }
        
        // Cek jika ada main image dari old data
        const mainImageId = document.getElementById('main_image_id').value;
        if (mainImageId && mainImageId !== '') {
            const removeBtn = document.getElementById('removeMainImage');
            if (removeBtn) {
                removeBtn.style.display = 'block';
            }
        }

        const form = document.getElementById('product-form');
        const submitBtn = document.getElementById('submit-btn');
        
        // Initialize Select2 for related products
        if ($('[data-control="select2"]').length) {
            $('[data-control="select2"]').select2({
                minimumResultsForSearch: 10,
                placeholder: "Pilih produk terkait",
                allowClear: true,
                width: '100%'
            });
        }
        
        // Toggle product type (variant/non-variant)
        const hasVariantsCheckbox = document.getElementById('has_variants');
        const variantAttributesSection = document.getElementById('variant-attributes-section');
        const variantsContainer = document.getElementById('variants-container');
        const nonVariantPricing = document.getElementById('non-variant-pricing');
        
        if (hasVariantsCheckbox) {
            hasVariantsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    variantAttributesSection.style.display = 'block';
                    variantsContainer.style.display = 'block';
                    nonVariantPricing.style.display = 'none';
                    
                    // Set required for variant fields
                    const variantNameInputs = variantsContainer.querySelectorAll('input[name*="[name]"]');
                    const variantPriceInputs = variantsContainer.querySelectorAll('input[name*="[price]"]');
                    const variantStockInputs = variantsContainer.querySelectorAll('input[name*="[stock_quantity]"]');
                    
                    variantNameInputs.forEach(input => input.required = true);
                    variantPriceInputs.forEach(input => input.required = true);
                    variantStockInputs.forEach(input => input.required = true);
                    
                    // Remove required from non-variant fields
                    form.querySelector('input[name="price"]').required = false;
                    form.querySelector('input[name="stock_quantity"]').required = false;
                    form.querySelector('select[name="stock_status"]').required = false;
                } else {
                    variantAttributesSection.style.display = 'none';
                    variantsContainer.style.display = 'none';
                    nonVariantPricing.style.display = 'block';
                    
                    // Remove required from variant fields
                    const variantNameInputs = variantsContainer.querySelectorAll('input[name*="[name]"]');
                    const variantPriceInputs = variantsContainer.querySelectorAll('input[name*="[price]"]');
                    const variantStockInputs = variantsContainer.querySelectorAll('input[name*="[stock_quantity]"]');
                    
                    variantNameInputs.forEach(input => input.required = false);
                    variantPriceInputs.forEach(input => input.required = false);
                    variantStockInputs.forEach(input => input.required = false);
                    
                    // Add required to non-variant fields
                    form.querySelector('input[name="price"]').required = true;
                    form.querySelector('input[name="stock_quantity"]').required = true;
                    form.querySelector('select[name="stock_status"]').required = true;
                }
            });
        }
        
        // Add attribute
        const addAttributeBtn = document.getElementById('add-attribute');
        if (addAttributeBtn) {
            addAttributeBtn.addEventListener('click', function() {
                const container = document.getElementById('variant-attributes-container');
                const newAttribute = document.createElement('div');
                newAttribute.className = 'input-group mb-2';
                newAttribute.innerHTML = `
                    <input type="text" class="form-control" 
                        name="variant_attributes[]" 
                        placeholder="Contoh: ukuran" />
                    <button type="button" class="btn btn-light-danger remove-attribute">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                container.appendChild(newAttribute);
            });
        }
        
        // Remove attribute
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-attribute')) {
                const inputGroup = e.target.closest('.input-group');
                if (inputGroup) {
                    inputGroup.remove();
                }
            }
        });
        
        form.addEventListener('submit', function(e) {
            // Save TinyMCE content before submit
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            // Validation
            const name = form.querySelector('input[name="name"]').value.trim();
            const categoryId = form.querySelector('select[name="category_id"]').value;
            const mainImageId = form.querySelector('input[name="main_image_id"]').value;
            const description = form.querySelector('#description-textarea').value;
            
            if (!name) {
                e.preventDefault();
                showToast('error', 'Nama produk wajib diisi', 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            if (!categoryId) {
                e.preventDefault();
                showToast('error', 'Kategori produk wajib dipilih', 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            if (!mainImageId) {
                e.preventDefault();
                showToast('error', 'Gambar utama produk wajib dipilih', 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            if (!description || description.trim() === '') {
                e.preventDefault();
                showToast('error', 'Deskripsi produk wajib diisi', 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            // Validate non-variant product
            if (!hasVariantsCheckbox.checked) {
                const price = form.querySelector('input[name="price"]').value;
                const stockQuantity = form.querySelector('input[name="stock_quantity"]').value;
                
                if (!price || parseFloat(price) < 0) {
                    e.preventDefault();
                    showToast('error', 'Harga produk tidak valid', 'Validasi Error!');
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                    return;
                }
                
                if (!stockQuantity || parseInt(stockQuantity) < 0) {
                    e.preventDefault();
                    showToast('error', 'Stok awal tidak valid', 'Validasi Error!');
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                    return;
                }
                
                // Validate discount dates
                const discountStart = form.querySelector('input[name="discount_start"]');
                const discountEnd = form.querySelector('input[name="discount_end"]');
                const discountPrice = form.querySelector('input[name="discount_price"]');
                
                if (discountPrice && discountPrice.value && discountStart && discountStart.value && discountEnd && discountEnd.value) {
                    const startDate = new Date(discountStart.value);
                    const endDate = new Date(discountEnd.value);
                    
                    if (endDate < startDate) {
                        e.preventDefault();
                        showToast('error', 'Tanggal akhir diskon tidak boleh lebih awal dari tanggal mulai', 'Validasi Error!');
                        submitBtn.removeAttribute('data-kt-indicator');
                        submitBtn.disabled = false;
                        return;
                    }
                }
            }
            
            // Validate variant product
            if (hasVariantsCheckbox.checked) {
                const variants = form.querySelectorAll('.variant-item');
                
                if (variants.length === 0) {
                    e.preventDefault();
                    showToast('error', 'Produk varian minimal harus memiliki 1 varian', 'Validasi Error!');
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                    return;
                }
                
                let hasDefaultVariant = false;
                let variantErrors = [];
                
                variants.forEach((variant, index) => {
                    const variantName = variant.querySelector('input[name*="[name]"]').value.trim();
                    const variantPrice = variant.querySelector('input[name*="[price]"]').value;
                    const variantStock = variant.querySelector('input[name*="[stock_quantity]"]').value;
                    const isDefault = variant.querySelector('input[name*="[is_default]"]').checked;
                    
                    if (!variantName) {
                        variantErrors.push(`Varian #${index + 1}: Nama varian wajib diisi`);
                    }
                    
                    if (!variantPrice || parseFloat(variantPrice) < 0) {
                        variantErrors.push(`Varian #${index + 1}: Harga varian tidak valid`);
                    }
                    
                    if (!variantStock || parseInt(variantStock) < 0) {
                        variantErrors.push(`Varian #${index + 1}: Stok varian tidak valid`);
                    }
                    
                    if (isDefault) {
                        hasDefaultVariant = true;
                    }
                });
                
                if (variantErrors.length > 0) {
                    e.preventDefault();
                    variantErrors.forEach(error => {
                        showToast('error', error, 'Validasi Varian Error!');
                    });
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                    return;
                }
                
                if (!hasDefaultVariant) {
                    e.preventDefault();
                    showToast('error', 'Harus ada 1 varian yang ditandai sebagai default', 'Validasi Error!');
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                    return;
                }
            }
            
            // Jika semua valid, form akan submit
        });

        const galleryInput = document.getElementById('gallery_images');
        if (galleryInput && galleryInput.value) {
            try {
                const galleryImages = JSON.parse(galleryInput.value);
                galleryImages.forEach(imageId => {
                    // Anda bisa load image dari server jika diperlukan
                    // Atau biarkan kosong, nanti di-backend akan di-handle
                });
            } catch (e) {
                console.error('Error parsing gallery images:', e);
            }
        }
        
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
                        .replace(/-+/g, '-')
                        .replace(/^-+|-+$/g, '');
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
                    this.value = 'PRD-' + timestamp + '-' + random;
                }
            });
        }
    });

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
</script>
@endpush