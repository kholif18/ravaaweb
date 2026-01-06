@extends('admin.layouts.app')

@section('page-title', 'Edit Produk: ' . $product->name)
@section('page-description', 'Edit Produk — Ravaa Creative')

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
        Edit Produk: {{ Str::limit($product->name, 30) }}
    </li>
@endsection

@section('content')
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastContainer"></div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Edit Produk: {{ $product->name }}</h3>
            <div class="d-flex align-items-center">
                @if($product->status == 'published')
                    <span class="badge badge-light-success me-2">Published</span>
                @elseif($product->status == 'draft')
                    <span class="badge badge-light-warning me-2">Draft</span>
                @else
                    <span class="badge badge-light-danger me-2">Archived</span>
                @endif
                <span class="text-muted fs-7">SKU: {{ $product->sku ?? '-' }}</span>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf
            @method('PUT')
            
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
                                       value="{{ old('name', $product->name) }}"
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
                                           value="{{ old('sku', $product->sku) }}"
                                           placeholder="SKU-001" />
                                    <div class="text-muted fs-7 mt-1">Kosongkan untuk generate otomatis</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Barcode</label>
                                    <input type="text" class="form-control" 
                                           name="barcode" 
                                           value="{{ old('barcode', $product->barcode) }}"
                                           placeholder="123456789012" />
                                </div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Deskripsi Pendek</label>
                                <textarea class="form-control" 
                                          name="short_description" 
                                          rows="2"
                                          placeholder="Deskripsi singkat produk (max 500 karakter)">{{ old('short_description', $product->short_description) }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea class="form-control" 
                                          name="description" 
                                          rows="4"
                                          placeholder="Deskripsi lengkap produk">{{ old('description', $product->description) }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Slug (URL)</label>
                                <input type="text" class="form-control" 
                                       name="slug" 
                                       value="{{ old('slug', $product->slug) }}"
                                       placeholder="nama-produk-url" />
                                <div class="text-muted fs-7 mt-1">Kosongkan untuk generate otomatis dari nama</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Harga & Stok</h4>
                            <div class="card-toolbar">
                                <span class="badge badge-light-primary">
                                    Terjual: {{ $product->sold_count }} | Dilihat: {{ $product->view_count }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label required">Harga Normal (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="price" 
                                           value="{{ old('price', $product->price) }}"
                                           min="0" step="0.01" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Diskon (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="discount_price" 
                                           value="{{ old('discount_price', $product->discount_price) }}"
                                           min="0" step="0.01" />
                                    <div class="text-muted fs-7 mt-1">Kosongkan jika tidak ada diskon</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Modal (Rp)</label>
                                    <input type="number" class="form-control" 
                                           name="cost_price" 
                                           value="{{ old('cost_price', $product->cost_price) }}"
                                           min="0" step="0.01" />
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label required">Stok Saat Ini</label>
                                    <input type="number" class="form-control" 
                                           name="stock_quantity" 
                                           value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                           min="0" required />
                                    @if($product->isLowStock())
                                        <div class="text-warning fs-7 mt-1">
                                            <i class="bi bi-exclamation-triangle"></i> Stok hampir habis!
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Stok Minimum</label>
                                    <input type="number" class="form-control" 
                                           name="minimum_stock" 
                                           value="{{ old('minimum_stock', $product->minimum_stock) }}"
                                           min="0" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Status Stok</label>
                                    <select class="form-select" name="stock_status" required>
                                        <option value="in_stock" {{ old('stock_status', $product->stock_status) == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="pre_order" {{ old('stock_status', $product->stock_status) == 'pre_order' ? 'selected' : '' }}>Pre Order</option>
                                        <option value="backorder" {{ old('stock_status', $product->stock_status) == 'backorder' ? 'selected' : '' }}>Backorder</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-10">
                                <div class="col-md-4">
                                    <label class="form-label">Berat (kg)</label>
                                    <input type="number" class="form-control" 
                                           name="weight" 
                                           value="{{ old('weight', $product->weight) }}"
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control" 
                                           name="unit" 
                                           value="{{ old('unit', $product->unit) }}"
                                           placeholder="pcs, kg, meter, dll" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Manage Stock?</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="manage_stock" 
                                               value="1" 
                                               id="manage_stock" 
                                               {{ old('manage_stock', $product->manage_stock) ? 'checked' : '' }} />
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
                            <!-- Current Main Image -->
                            <div class="mb-10">
                                <label class="form-label">Gambar Utama Saat Ini</label>
                                @if($product->main_image_url)
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-100px me-5">
                                            <img src="{{ $product->main_image_url }}" 
                                                 class="rounded" 
                                                 alt="{{ $product->name }}"
                                                 style="max-height: 100px; object-fit: cover;" />
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ $product->main_image_url }}" 
                                               target="_blank" 
                                               class="btn btn-light btn-sm mb-2">
                                                <i class="bi bi-eye"></i> Lihat Full
                                            </a>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="remove_main_image" 
                                                       value="1" 
                                                       id="remove_main_image" />
                                                <label class="form-check-label text-danger" for="remove_main_image">
                                                    Hapus gambar ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-light">
                                        <i class="bi bi-image text-muted"></i> Belum ada gambar utama
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Upload New Main Image -->
                            <div class="mb-10">
                                <label class="form-label">Upload Gambar Utama Baru</label>
                                <input type="file" class="form-control" 
                                       name="main_image" 
                                       accept="image/*" />
                                <div class="text-muted fs-7 mt-1">Ukuran maksimal 2MB. Format: JPG, PNG, GIF</div>
                            </div>
                            
                            <!-- Current Additional Images -->
                            <div class="mb-10">
                                <label class="form-label">Gambar Tambahan Saat Ini</label>
                                @if(!empty($product->images) && count($product->images) > 0)
                                    <div class="row g-3">
                                        @foreach($product->images as $index => $image)
                                            @if($image && $image != $product->main_image)
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-body p-2 text-center">
                                                        <img src="{{ asset('storage/products/' . $image) }}" 
                                                             class="rounded mb-2" 
                                                             style="width: 100%; height: 80px; object-fit: cover;"
                                                             alt="Gambar {{ $index + 1 }}" />
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="remove_images[]" 
                                                                   value="{{ $image }}" 
                                                                   id="remove_image_{{ $index }}" />
                                                            <label class="form-check-label text-danger fs-7" for="remove_image_{{ $index }}">
                                                                Hapus
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-light">
                                        <i class="bi bi-image text-muted"></i> Belum ada gambar tambahan
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Upload New Additional Images -->
                            <div class="mb-10">
                                <label class="form-label">Upload Gambar Tambahan Baru</label>
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
                                          placeholder="Spesifikasi teknis produk">{{ old('specifications', $product->specifications) }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Fitur Unggulan</label>
                                <textarea class="form-control" 
                                          name="features" 
                                          rows="3"
                                          placeholder="Fitur-fitur unggulan produk">{{ old('features', $product->features) }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Cara Penggunaan</label>
                                <textarea class="form-control" 
                                          name="usage_instructions" 
                                          rows="2"
                                          placeholder="Petunjuk penggunaan">{{ old('usage_instructions', $product->usage_instructions) }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Informasi Garansi</label>
                                <textarea class="form-control" 
                                          name="warranty_info" 
                                          rows="2"
                                          placeholder="Informasi garansi produk">{{ old('warranty_info', $product->warranty_info) }}</textarea>
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
                                        <option value="{{ $related->id }}" 
                                            {{ in_array($related->id, old('related_products', $product->relatedProducts->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                            {{ $related->name }} ({{ $related->sku ?? 'No SKU' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7 mt-1">Pilih produk yang terkait dengan produk ini (Ctrl+Click untuk multiple selection)</div>
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
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category_id">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label required">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Tanggal Publish</label>
                                <input type="datetime-local" class="form-control" 
                                       name="published_at" 
                                       value="{{ old('published_at', $product->published_at ? $product->published_at->format('Y-m-d\TH:i') : '') }}" />
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
                                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} />
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
                                           {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }} />
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
                                           {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }} />
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
                                           value="{{ old('length', $product->length) }}"
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Lebar</label>
                                    <input type="number" class="form-control" 
                                           name="width" 
                                           value="{{ old('width', $product->width) }}"
                                           min="0" step="0.01" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tinggi</label>
                                    <input type="number" class="form-control" 
                                           name="height" 
                                           value="{{ old('height', $product->height) }}"
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
                                       value="{{ old('tags', !empty($product->tags) ? implode(', ', $product->tags) : '') }}"
                                       placeholder="tag1, tag2, tag3" />
                                <div class="text-muted fs-7 mt-1">Pisahkan dengan koma</div>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Warna Tersedia</label>
                                <input type="text" class="form-control" 
                                       name="colors" 
                                       value="{{ old('colors', !empty($product->colors) ? implode(', ', $product->colors) : '') }}"
                                       placeholder="Merah, Biru, Hijau" />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Ukuran Tersedia</label>
                                <input type="text" class="form-control" 
                                       name="sizes" 
                                       value="{{ old('sizes', !empty($product->sizes) ? implode(', ', $product->sizes) : '') }}"
                                       placeholder="S, M, L, XL" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Card -->
                    <div class="card card-bordered mb-10">
                        <div class="card-header">
                            <h4 class="card-title">Statistik</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Total Penjualan:</span>
                                    <span class="fw-bold">{{ $product->sold_count }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Total Views:</span>
                                    <span class="fw-bold">{{ $product->view_count }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Total Pesanan:</span>
                                    <span class="fw-bold">{{ $product->order_count }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Rating Rata-rata:</span>
                                    <span class="fw-bold">{{ number_format($product->rating_average, 1) }} ({{ $product->rating_count }})</span>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Dibuat:</span>
                                    <span class="fw-bold">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Diupdate:</span>
                                    <span class="fw-bold">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
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
                                       value="{{ old('meta_title', $product->meta_title) }}"
                                       placeholder="Meta title untuk SEO" />
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" 
                                          name="meta_description" 
                                          rows="2"
                                          placeholder="Meta description untuk SEO">{{ old('meta_description', $product->meta_description) }}</textarea>
                            </div>
                            
                            <div class="mb-10">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" 
                                       name="meta_keywords" 
                                       value="{{ old('meta_keywords', $product->meta_keywords) }}"
                                       placeholder="Keyword1, Keyword2, Keyword3" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-10">
                <div>
                    <button type="button" class="btn btn-light-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash"></i> Hapus Produk
                    </button>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light me-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <span class="indicator-label">
                            <i class="bi bi-save"></i> Update Produk
                        </span>
                        <span class="indicator-progress">
                            Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Delete Form -->
        <form id="delete-form" method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: none;">
            @csrf
            @method('DELETE')
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
    .symbol-100px {
        width: 100px;
        height: 100px;
    }
    .symbol-100px img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Toast Styles */
    .toast {
        border: 0;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .toast-success {
        background-color: #d1fae5;
        border-left: 4px solid #10b981;
    }
    .toast-error {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
    }
    .toast-warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
    }
    .toast-info {
        background-color: #e0f2fe;
        border-left: 4px solid #0ea5e9;
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

// Confirm Delete Function
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Produk?',
        html: `Produk <strong>"{{ $product->name }}"</strong> akan dihapus permanen beserta semua gambarnya.`,
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}

// Form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('product-form');
    const submitBtn = document.getElementById('submit-btn');
    
    // Initialize Select2 for related products
    if ($('[data-control="select2"]').length) {
        $('[data-control="select2"]').select2({
            minimumResultsForSearch: 10,
            placeholder: "Pilih produk terkait",
            allowClear: true
        });
    }
    
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
        
        // Validate related products - prevent self-reference
        const relatedProducts = form.querySelector('select[name="related_products[]"]');
        if (relatedProducts) {
            const selectedOptions = Array.from(relatedProducts.selectedOptions);
            const currentProductId = {{ $product->id }};
            
            const hasSelfReference = selectedOptions.some(option => {
                return parseInt(option.value) === currentProductId;
            });
            
            if (hasSelfReference) {
                e.preventDefault();
                showToast('error', 'Produk tidak dapat dihubungkan dengan dirinya sendiri', 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
        }
        
        // Validate images
        const mainImage = form.querySelector('input[name="main_image"]');
        if (mainImage && mainImage.files.length > 0) {
            const file = mainImage.files[0];
            if (file.size > 2 * 1024 * 1024) { // 2MB
                e.preventDefault();
                showToast('error', 'Gambar utama maksimal 2MB', 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
        }
        
        // Additional images validation
        const additionalImages = form.querySelector('input[name="images[]"]');
        if (additionalImages && additionalImages.files.length > 0) {
            const files = Array.from(additionalImages.files);
            const maxSize = 2 * 1024 * 1024; // 2MB
            const maxCount = 10;
            
            if (files.length > maxCount) {
                e.preventDefault();
                showToast('error', `Maksimal ${maxCount} gambar tambahan`, 'Validasi Error!');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            for (const file of files) {
                if (file.size > maxSize) {
                    e.preventDefault();
                    showToast('error', `Gambar "${file.name}" melebihi 2MB`, 'Validasi Error!');
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                    return;
                }
            }
        }
        
        // Jika semua valid, form akan submit
    });
    
    // Auto-generate slug from name if empty
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
    
    // Preview image before upload
    const mainImageInput = document.querySelector('input[name="main_image"]');
    if (mainImageInput) {
        mainImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create preview if needed
                    console.log('Main image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Confirm before removing main image
    const removeMainImageCheckbox = document.getElementById('remove_main_image');
    if (removeMainImageCheckbox) {
        removeMainImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                Swal.fire({
                    title: 'Hapus Gambar Utama?',
                    text: 'Gambar utama akan dihapus saat produk diupdate.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) {
                        this.checked = false;
                    }
                });
            }
        });
    }
});
</script>
@endpush