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

<!-- Modal Media Picker -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0">
            <!-- Modal Header -->
            <div class="modal-header border-bottom">
                <h5 class="modal-title">
                    <i class="bi bi-images me-2"></i>
                    Pilih Media
                    <span id="pickerTargetBadge" class="badge bg-primary ms-2">Gambar Utama</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-0">
                <!-- Bulk selection info -->
                <div id="bulkSelectionInfo" class="bulk-selection-info" style="display: none;">
                    <div>
                        <strong id="selectedCount">0</strong> media dipilih
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="clearSelection()">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="insertSelectedMedia()">
                            <i class="bi bi-check-circle me-1"></i> Pilih Media
                        </button>
                    </div>
                </div>
                
                <!-- Tabs -->
                <ul class="nav nav-tabs nav-tabs-wordpress px-3 pt-2 mb-0" id="mediaPickerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="media-library-tab" data-bs-toggle="tab" 
                                data-bs-target="#media-library" type="button" role="tab">
                            <i class="bi bi-grid me-1"></i> Media Library
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upload-tab" data-bs-toggle="tab" 
                                data-bs-target="#upload" type="button" role="tab">
                            <i class="bi bi-cloud-upload me-1"></i> Upload Files
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content p-3" id="mediaPickerTabContent">
                    <!-- Tab 1: Media Library -->
                    <div class="tab-pane fade show active" id="media-library" role="tabpanel">
                        <div id="mediaLibraryContent">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-3 text-muted">Memuat media...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 2: Upload -->
                    <div class="tab-pane fade" id="upload" role="tabpanel">
                        <div class="upload-tab-content">
                            <div class="upload-dropzone" id="uploadDropzone">
                                <i class="bi bi-cloud-arrow-up" style="font-size: 48px; color: #6c757d; margin-bottom: 16px;"></i>
                                <h4>Drop files to upload</h4>
                                <p class="text-muted mb-4">or</p>
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                    <i class="bi bi-folder2-open me-2"></i> Select Files
                                </button>
                                <p class="text-muted mt-3 mb-1">Maximum upload file size: 5MB</p>
                                <p class="text-muted">Allowed: JPG, JPEG, PNG, GIF, WebP, SVG</p>
                            </div>
                            
                            <input type="file" id="fileInput" class="d-none" multiple accept="image/*">
                            
                            <!-- Upload Progress -->
                            <div id="uploadProgressContainer" class="mt-4" style="display: none;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Uploading...</span>
                                    <span class="text-muted" id="uploadProgressText">0%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                         style="width: 0%"></div>
                                </div>
                            </div>
                            
                            <!-- Upload Queue -->
                            <div id="uploadQueue" class="mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    .image-preview {
        width: 160px;
        height: 160px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f8f9fa;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px,1fr));
        gap: 10px;
        margin-bottom: 15px;
    }

    .gallery-item {
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #ddd;
    }

    .gallery-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .gallery-item button {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .tox-tinymce {
        border-radius: 6px !important;
        border: 1px solid #e4e6ef !important;
    }

    .required:after {
        content: " *";
        color: #f1416c;
    }
    
    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .gallery-item {
        position: relative;
        border: 1px solid #e4e6ef;
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

    .gallery-item .btn {
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
    }

    .gallery-item:hover .btn {
        opacity: 1;
    }

    /* Main Image Preview */
    .image-preview {
        width: 200px;
        height: 200px;
        border: 2px dashed #e4e6ef;
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

    .image-preview .text-muted {
        color: #a1a5b7;
    }

    /* Style untuk modal media picker */
    #mediaPickerModal .modal-dialog {
        max-width: 1200px;
    }

    #mediaPickerModal .modal-body {
        min-height: 600px;
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Bulk selection info */
    .bulk-selection-info {
        background: #e7f1ff;
        border: 1px solid #b6d4fe;
        border-radius: 6px;
        padding: 12px 16px;
        margin: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Selected state */
    .media-item.selected .card {
        border-color: #198754;
        box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2);
    }

    .media-item.selected .card::after {
        content: "✓";
        position: absolute;
        top: 10px;
        right: 10px;
        width: 24px;
        height: 24px;
        background: #198754;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        z-index: 10;
    }

      .gallery-item.loading .placeholder {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Selected state untuk media picker */
    .media-item.selected {
        position: relative;
    }

    .media-item.selected::after {
        content: "✓";
        position: absolute;
        top: 10px;
        right: 10px;
        width: 24px;
        height: 24px;
        background: #198754;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        z-index: 2;
    }

        /* Style untuk modal picker */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .nav-tabs-wordpress {
        border-bottom: 2px solid #dee2e6;
    }
    
    .nav-tabs-wordpress .nav-link {
        border: none;
        border-radius: 0;
        color: #495057;
        padding: 12px 20px;
        font-weight: 500;
    }
    
    .nav-tabs-wordpress .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: transparent;
    }
    
    .nav-tabs-wordpress .nav-link:hover {
        border-color: transparent;
    }
    
    /* Media grid dalam modal */
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        max-height: 500px;
        overflow-y: auto;
        padding: 5px;
    }
    
    .media-item {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .media-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .media-item.selected .card {
        border-color: #198754;
        box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2);
    }
    
    .fixed-thumbnail {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    /* Pagination dalam modal */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border: none;
        color: #495057;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    /* Upload area */
    .upload-dropzone {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 60px 20px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .upload-dropzone:hover {
        border-color: #0d6efd;
        background: #e7f1ff;
    }
    
    .upload-dropzone i {
        font-size: 48px;
        color: #6c757d;
        margin-bottom: 16px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .media-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
        
        .fixed-thumbnail {
            height: 120px;
        }
    }

    /* Style untuk bulk selection info */
    .bulk-selection-info {
        background: #e7f1ff;
        border: 1px solid #b6d4fe;
        border-radius: 6px;
        padding: 12px 16px;
        margin: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Gallery preview style */
    #galleryImages .card {
        transition: transform 0.2s;
    }

    #galleryImages .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Button styles */
    #selectMainImageBtn .btn {
        min-width: 200px;
        padding: 10px 20px;
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE -->
{{-- <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script>
    function loadPage(page) {
        const search = document.getElementById('searchInput')?.value || '';
        let url = `{{ route('admin.media.picker') }}?page=${page}&ajax=true&embedded=true`;
        
        if (search) {
            url += `&search=${encodeURIComponent(search)}`;
        }
        
        // Show loading
        const content = document.getElementById('mediaLibraryContent');
        if (content) {
            content.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 text-muted">Memuat media...</p>
                </div>
            `;
            
            // Load page via AJAX
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    content.innerHTML = html;
                    initializeMediaPickerEvents();
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    content.innerHTML = `
                        <div class="alert alert-danger">
                            Gagal memuat halaman
                        </div>
                    `;
                });
        }
    }

    function refreshMediaList() {
        const search = document.getElementById('searchInput')?.value || '';
        let url = `{{ route('admin.media.picker') }}?ajax=true&embedded=true`;
        
        if (search) {
            url += `&search=${encodeURIComponent(search)}`;
        }
        
        // Show loading
        const content = document.getElementById('mediaLibraryContent');
        if (content) {
            content.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 text-muted">Memuat media...</p>
                </div>
            `;
            
            // Load via AJAX
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    content.innerHTML = html;
                    initializeMediaPickerEvents();
                })
                .catch(error => {
                    console.error('Error refreshing media:', error);
                    content.innerHTML = `
                        <div class="alert alert-danger">
                            Gagal memuat media
                        </div>
                    `;
                });
        }
    }

    function searchMedia() {
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        const mediaItems = document.querySelectorAll('.media-item');
        
        mediaItems.forEach(item => {
            const searchData = item.dataset.search || '';
            if (searchTerm === '' || searchData.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function selectAllMedia() {
        const btn = document.getElementById('selectAllBtn');
        if (!btn) return;
        
        const mediaItems = document.querySelectorAll('.media-item:not([style*="display: none"])');
        const allSelected = Array.from(mediaItems).every(item => 
            item.classList.contains('selected')
        );
        
        if (allSelected) {
            // Deselect all
            mediaItems.forEach(item => {
                item.classList.remove('selected');
            });
            btn.innerHTML = '<i class="bi bi-check-square me-1"></i> Pilih Semua';
        } else {
            // Select all visible
            mediaItems.forEach(item => {
                item.classList.add('selected');
            });
            btn.innerHTML = '<i class="bi bi-square me-1"></i> Batal Semua';
        }
        
        // Update selection count
        updateSelectionCount();
    }

    function updateSelectionCount() {
        const selectedCount = document.querySelectorAll('.media-item.selected').length;
        const bulkInfo = document.getElementById('bulkSelectionInfo');
        const countElement = document.getElementById('selectedCount');
        
        if (countElement) {
            countElement.textContent = selectedCount;
        }
        
        if (bulkInfo) {
            if (selectedCount > 0) {
                bulkInfo.style.display = 'flex';
            } else {
                bulkInfo.style.display = 'none';
            }
        }
    }

    let selectedMediaItems = [];
    let currentPickerTarget = 'main';

    // Function untuk membuka media picker
    function openMediaPicker(target) {
        currentPickerTarget = target;
        
        // Update UI
        const badge = document.getElementById('pickerTargetBadge');
        const bulkInfo = document.getElementById('bulkSelectionInfo');
        
        if (target === 'main') {
            badge.textContent = 'Gambar Utama (Klik untuk Pilih)';
            badge.className = 'badge bg-primary ms-2';
            if (bulkInfo) {
                bulkInfo.style.display = 'none';
            }
        } else if (target === 'gallery') {
            badge.textContent = 'Gallery Produk (Pilih Banyak)';
            badge.className = 'badge bg-success ms-2';
            if (bulkInfo) {
                bulkInfo.style.display = 'flex';
            }
        }
        
        // Clear selection sebelumnya
        selectedMediaItems = [];
        updateSelectionUI();
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('mediaPickerModal'));
        modal.show();
        
        // Reset ke tab media library setiap kali modal dibuka
        setTimeout(() => {
            const mediaTab = document.getElementById('media-library-tab');
            if (mediaTab) {
                // Active tab media library
                mediaTab.classList.add('active');
                mediaTab.setAttribute('aria-selected', 'true');
                
                // Remove active dari tab upload
                const uploadTab = document.getElementById('upload-tab');
                if (uploadTab) {
                    uploadTab.classList.remove('active');
                    uploadTab.setAttribute('aria-selected', 'false');
                }
                
                // Show media library content, hide upload content
                const mediaContent = document.getElementById('media-library');
                if (mediaContent) {
                    mediaContent.classList.add('show', 'active');
                }
                
                const uploadContent = document.getElementById('upload');
                if (uploadContent) {
                    uploadContent.classList.remove('show', 'active');
                }
                
                // Load media library
                loadMediaLibrary();
            }
        }, 100);
    }

    // Function untuk handle select button click
    function handleSelectButtonClick(button) {
        const mediaId = parseInt(button.dataset.mediaId);
        const mediaUrl = button.dataset.mediaUrl;
        const mediaThumbnail = button.dataset.mediaThumbnail || mediaUrl;
        const mediaName = button.dataset.mediaName;
        
        if (currentPickerTarget === 'main') {
            // Untuk main image, langsung insert dan close modal
            const mediaData = {
                id: mediaId,
                url: mediaUrl,
                thumbnail: mediaThumbnail,
                name: mediaName
            };
            
            insertMainImageToForm(mediaData);
            
            // Close modal
            const modalElement = document.getElementById('mediaPickerModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            }
            
        } else if (currentPickerTarget === 'gallery') {
            // Untuk gallery, toggle selection
            const mediaCard = button.closest('.media-item');
            if (mediaCard) {
                toggleMediaSelection(mediaCard);
            }
        }
    }

    // Function untuk insert main image langsung ke form
    function insertMainImageToForm(media) {
        console.log('Inserting main image:', media);
        
        // Update preview
        const previewDiv = document.getElementById('mainImagePreview');
        if (previewDiv) {
            previewDiv.innerHTML = `
                <img src="${media.url}" alt="${media.name}" class="img-fluid" style="max-height: 200px; object-fit: contain;">
            `;
        }
        
        // Update hidden input
        const mainImageInput = document.getElementById('main_image_id');
        if (mainImageInput) {
            mainImageInput.value = media.id;
        }
        
        // Show remove button
        const removeBtn = document.getElementById('removeMainImage');
        if (removeBtn) {
            removeBtn.style.display = 'block';
        }
    }
    
    // Load media library via AJAX
    function loadMediaLibrary() {
        fetch(`{{ route('admin.media.picker') }}?ajax=true&embedded=true`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('mediaLibraryContent').innerHTML = html;
                initializeMediaPickerEvents();
            })
            .catch(error => {
                console.error('Error loading media:', error);
                document.getElementById('mediaLibraryContent').innerHTML = `
                    <div class="alert alert-danger">
                        Gagal memuat media library
                    </div>
                `;
            });
    }

    // Initialize events setelah load media
    function initializeMediaPickerEvents() {
        // Handle select button click
        document.querySelectorAll('.btn-select-media').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                handleSelectButtonClick(this);
            });
        });
        
        // Handle media item click
        document.getElementById('mediaLibraryContent')?.addEventListener('click', function(e) {
            const mediaCard = e.target.closest('.media-item');
            if (!mediaCard) return;
            
            // Skip jika klik tombol langsung
            if (e.target.closest('.btn-select-media')) return;
            
            toggleMediaSelection(mediaCard);
        });
        
        // Setup search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    refreshMediaList();
                } else {
                    searchMedia();
                }
            });
        }
        
        // Setup select all button
        const selectAllBtn = document.getElementById('selectAllBtn');
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                selectAllMedia();
            });
        }
        
        // Setup upload (jika ada)
        setupUpload();
    }
    // Function untuk toggle selection
    function toggleMediaSelection(mediaCard) {
        const mediaId = parseInt(mediaCard.dataset.id);
        const mediaUrl = mediaCard.dataset.url;
        const mediaThumbnail = mediaCard.dataset.thumbnail || mediaUrl;
        const mediaName = mediaCard.dataset.name;
        const isSelected = mediaCard.classList.contains('selected');
        
        if (currentPickerTarget === 'gallery') {
            // Multiple selection mode (untuk gallery)
            if (isSelected) {
                // Remove from selection
                mediaCard.classList.remove('selected');
                selectedMediaItems = selectedMediaItems.filter(item => item.id !== mediaId);
            } else {
                // Add to selection
                mediaCard.classList.add('selected');
                selectedMediaItems.push({
                    id: mediaId,
                    url: mediaUrl,
                    thumbnail: mediaThumbnail,
                    name: mediaName
                });
            }
            updateSelectionUI();
        }
    }

    // Update selection UI
    function updateSelectionUI() {
        const selectedCount = selectedMediaItems.length;
        const bulkInfo = document.getElementById('bulkSelectionInfo');
        const countElement = document.getElementById('selectedCount');
        
        if (countElement) {
            countElement.textContent = selectedCount;
        }
        
        // Untuk gallery, tampilkan bulk info
        if (bulkInfo && currentPickerTarget === 'gallery') {
            if (selectedCount > 0) {
                bulkInfo.style.display = 'flex';
            } else {
                bulkInfo.style.display = 'none';
            }
        }
    }

    // Clear selection
    function clearSelection() {
        selectedMediaItems = [];
        document.querySelectorAll('.media-item').forEach(item => {
            item.classList.remove('selected');
        });
        updateSelectionUI();
    }

    // Insert selected media ke form
    function insertSelectedMedia() {
        console.log('Inserting media for:', currentPickerTarget, selectedMediaItems);
        
        if (currentPickerTarget === 'main') {
            // Untuk gambar utama (single) - seharusnya tidak sampai sini
            if (selectedMediaItems.length > 0) {
                const media = selectedMediaItems[0];
                insertMainImageToForm(media);
            }
        } else if (currentPickerTarget === 'gallery') {
            // Untuk gallery (multiple)
            if (selectedMediaItems.length === 0) {
                alert('Pilih media terlebih dahulu');
                return;
            }
            
            const galleryContainer = document.getElementById('galleryPreview');
            const galleryInput = document.getElementById('gallery_images');
            
            if (!galleryContainer || !galleryInput) {
                console.error('Gallery elements not found!');
                return;
            }
            
            // Parse existing gallery images
            let existingImages = [];
            try {
                existingImages = JSON.parse(galleryInput.value || '[]');
            } catch (e) {
                console.error('Error parsing gallery images:', e);
                existingImages = [];
            }
            
            selectedMediaItems.forEach(media => {
                // Cek apakah sudah ada
                if (existingImages.includes(media.id)) {
                    console.log('Image already exists:', media.id);
                    return;
                }
                
                // Add to array
                existingImages.push(media.id);
                
                // Add to preview
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';
                galleryItem.setAttribute('data-id', media.id);
                galleryItem.innerHTML = `
                    <img src="${media.thumbnail}" alt="${media.name}" style="width: 100%; height: 120px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeGalleryImage(${media.id})">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                galleryContainer.appendChild(galleryItem);
            });
            
            // Update hidden input
            galleryInput.value = JSON.stringify(existingImages);
            console.log('Updated gallery images:', existingImages);
        }
        
        // Close modal
        const modalElement = document.getElementById('mediaPickerModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
        
        // Reset selection
        clearSelection();
    }

    // Function untuk menghapus gambar utama
    function removeMainImage() {
        console.log('Removing main image...');
        
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

    // Function untuk menghapus gambar gallery
    function removeGalleryImage(mediaId) {
        console.log('Removing gallery image:', mediaId);
        
        // Hapus dari preview
        const galleryItem = document.querySelector(`.gallery-item[data-id="${mediaId}"]`);
        if (galleryItem) {
            galleryItem.remove();
        }
        
        // Update hidden input
        const galleryInput = document.getElementById('gallery_images');
        try {
            let galleryImages = JSON.parse(galleryInput.value || '[]');
            galleryImages = galleryImages.filter(id => id !== mediaId);
            galleryInput.value = JSON.stringify(galleryImages);
            console.log('Updated gallery after removal:', galleryImages);
        } catch (e) {
            console.error('Error removing gallery image:', e);
        }
    }

    // Setup upload functionality
    function setupUpload() {
        const dropzone = document.getElementById('uploadDropzone');
        const fileInput = document.getElementById('fileInput');
        
        if (!dropzone || !fileInput) return;
        
        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.add('dragover');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.remove('dragover');
            }, false);
        });
        
        dropzone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        fileInput.addEventListener('change', function(e) {
            handleFiles(e.target.files);
        });
        
        function handleFiles(files) {
            if (files.length === 0) return;
            
            // Switch to upload tab
            const uploadTab = document.getElementById('upload-tab');
            if (uploadTab) {
                const tab = new bootstrap.Tab(uploadTab);
                tab.show();
            }
            
            // Start upload
            uploadFiles(files);
        }
    }

    // Upload files
    async function uploadFiles(files) {
        const formData = new FormData();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Add files - gunakan field 'file' untuk single file
        Array.from(files).forEach((file, index) => {
            formData.append(`file`, file); // Ganti dari files[${index}] menjadi file
        });
        
        formData.append('_token', csrfToken);
        
        // Show progress
        const progressContainer = document.getElementById('uploadProgressContainer');
        const progressBar = document.getElementById('uploadProgressBar');
        const progressText = document.getElementById('uploadProgressText');
        const queueElement = document.getElementById('uploadQueue');
        
        if (progressContainer) progressContainer.style.display = 'block';
        if (progressBar) progressBar.style.width = '0%';
        if (progressText) progressText.textContent = '0%';
        if (queueElement) queueElement.innerHTML = '';
        
        try {
            const response = await fetch('{{ route("admin.media.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Show success message
                if (queueElement) {
                    queueElement.innerHTML = `
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            ${result.message || 'File berhasil diupload'}
                        </div>
                    `;
                }
                
                // Refresh media library setelah 1.5 detik
                setTimeout(() => {
                    // Kembali ke tab media library
                    const mediaTab = document.getElementById('media-library-tab');
                    if (mediaTab) {
                        mediaTab.click();
                        loadMediaLibrary();
                    }
                }, 1500);
            } else {
                throw new Error(result.message || 'Upload failed');
            }
        } catch (error) {
            if (queueElement) {
                queueElement.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle me-2"></i>
                        Gagal mengupload file: ${error.message}
                    </div>
                `;
            }
        } finally {
            if (progressContainer) {
                setTimeout(() => {
                    progressContainer.style.display = 'none';
                }, 1000);
            }
        }
    }
    
    // Initialize gallery dari data lama
    function initializeGalleryFromOldData() {
        const galleryInput = document.getElementById('gallery_images');
        if (galleryInput && galleryInput.value) {
            try {
                const galleryImages = JSON.parse(galleryInput.value);
                const galleryContainer = document.getElementById('galleryPreview');
                
                if (galleryContainer && galleryImages.length > 0) {
                    // Hapus loading atau placeholder jika ada
                    galleryContainer.innerHTML = '';
                    
                    // Tambahkan loading state
                    galleryImages.forEach(imageId => {
                        const galleryItem = document.createElement('div');
                        galleryItem.className = 'gallery-item loading';
                        galleryItem.setAttribute('data-id', imageId);
                        galleryItem.innerHTML = `
                            <div class="placeholder" style="width: 100%; height: 120px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        `;
                        galleryContainer.appendChild(galleryItem);
                    });
                    
                    // Load images dari server (optional)
                    // Anda bisa menambahkan AJAX request untuk mendapatkan URL gambar
                }
            } catch (e) {
                console.error('Error parsing gallery images:', e);
            }
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

    
    // Initialize ketika DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize gallery dari old data
        initializeGalleryFromOldData();
        
        // Setup tombol hapus main image
        const removeMainImageBtn = document.getElementById('removeMainImage');
        if (removeMainImageBtn) {
            removeMainImageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                removeMainImage();
            });
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
</script>
@endpush