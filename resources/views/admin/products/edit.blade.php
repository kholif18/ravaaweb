@extends('admin.layouts.app')

@section('page-title', 'Edit Produk')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.products.index') }}">Produk</a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="text-muted">{{ $product->name }}</span>
    </li>
@endsection

@section('content')
<form id="product-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
<div class="row g-4">
    <!-- Global Error Display -->
    @if ($errors->any())
    <div class="col-12">
        <div class="alert alert-danger mb-0">
            <div class="fw-bold mb-1">Terjadi kesalahan validasi:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- ========== MAIN CONTENT (80%) ========== -->
    <div class="col-lg-8">
        <!-- Nama & Slug -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Informasi Dasar</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Nama Produk</label>
                    <input type="text" class="form-control form-control-sm"
                           name="name" id="product-name"
                           placeholder="Masukkan nama produk" required
                           value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="fv-row mb-0">
                    <label class="fs-7 fw-semibold mb-2">Slug</label>
                    <input type="text" class="form-control form-control-sm"
                           name="slug" id="product-slug"
                           placeholder="otomatis dari nama produk"
                           value="{{ old('slug', $product->slug) }}">
                    <div class="form-text fs-8">Kosongkan untuk auto-generate dari nama produk</div>
                </div>
            </div>
        </div>

        <!-- Deskripsi Singkat -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Deskripsi Singkat</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-0">
                    <div id="short-description-editor">{!! old('short_description', $product->short_description) !!}</div>
                    <input type="hidden" name="short_description" id="short-description-input">
                    @error('short_description')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tanpa Varian - Form Utama -->
        <div class="glass-card mb-4" id="no-variant-form" style="{{ $product->variant_types ? 'display:none' : '' }}">
            <div class="card-header">
                <div class="card-title">Harga & Stok</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4 fv-row">
                        <label class="required fs-7 fw-semibold mb-2">SKU</label>
                        <input type="text" class="form-control form-control-sm"
                               name="sku" placeholder="Kode unik produk"
                               value="{{ old('sku', $product->sku) }}">
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="required fs-7 fw-semibold mb-2">Harga (Rp)</label>
                        <input type="number" class="form-control form-control-sm"
                               name="price" min="0" step="100"
                               placeholder="0" required
                               value="{{ old('price', $product->price) }}">
                        @error('price')
                            <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Berat</label>
                        <input type="text" class="form-control form-control-sm"
                               name="weight" placeholder="Contoh: 500g"
                               value="{{ old('weight', $product->weight) }}">
                    </div>
                </div>

                <!-- Diskon -->
                <div class="row g-3 mt-1">
                    <div class="col-md-12">
                        @php
                            $hasDiscount = old('discount_percent', $product->discount_percent);
                        @endphp
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="no_discount_switch" id="no-discount-switch"
                                   {{ $hasDiscount ? 'checked' : '' }}
                                   onchange="toggleNoVariantDiscount(this)">
                            <label class="form-check-label fs-7 fw-semibold" for="no-discount-switch">Aktifkan Diskon</label>
                        </div>
                    </div>
                    <div id="no-variant-discount-fields" class="{{ $hasDiscount ? '' : 'd-none' }} w-100">
                        <div class="row g-3">
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Persen Diskon (%)</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="discount_percent" min="0" max="100"
                                       placeholder="0" id="no-discount-percent"
                                       oninput="calcNoVariantDiscount(this)"
                                       value="{{ old('discount_percent', $product->discount_percent) }}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Harga Diskon (Rp)</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="price_discount" min="0" step="100"
                                       placeholder="0" id="no-price-discount"
                                       value="{{ old('price_discount', $product->price_discount) }}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Mulai Diskon</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="discount_start"
                                       value="{{ old('discount_start', $product->discount_start ? $product->discount_start->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-7 fw-semibold mb-2">Akhir Diskon</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="discount_end"
                                       value="{{ old('discount_end', $product->discount_end ? $product->discount_end->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dimensi -->
                <div class="row g-3 mt-1">
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Panjang</label>
                        <input type="text" class="form-control form-control-sm"
                               name="length" placeholder="cm"
                               value="{{ old('length', $product->length) }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Lebar</label>
                        <input type="text" class="form-control form-control-sm"
                               name="width" placeholder="cm"
                               value="{{ old('width', $product->width) }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Tinggi</label>
                        <input type="text" class="form-control form-control-sm"
                               name="height" placeholder="cm"
                               value="{{ old('height', $product->height) }}">
                    </div>
                    <div class="col-md-3 fv-row">
                        <label class="fs-7 fw-semibold mb-2">Stok</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="stock" value="1"
                                   id="no-stock"
                                   {{ old('stock', $product->stock) ? 'checked' : '' }}>
                            <label class="form-check-label fs-8" for="no-stock">Tersedia</label>
                        </div>
                    </div>
                </div>

                <!-- Service Toggle -->
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_service" value="1"
                           id="no-service-switch" {{ old('is_service', $product->is_service) ? 'checked' : '' }}
                           onchange="toggleNoVariantService(this)">
                    <label class="form-check-label fs-7 fw-semibold" for="no-service-switch">
                        <i class="bi bi-gear me-1"></i> Produk ini adalah layanan (service)
                    </label>
                </div>
                <div class="fs-8 text-muted mt-1" id="no-service-hint" style="{{ old('is_service', $product->is_service) ? '' : 'display:none' }}">
                    Layanan tidak memerlukan stok.
                </div>
            </div>
        </div>

        <!-- Varian Produk -->
        <div class="glass-card mb-4" id="variant-section">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-palette me-1"></i> Varian Produk</div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-variant-type">
                    <i class="bi bi-plus"></i> Tambah Tipe
                </button>
            </div>
            <div class="card-body">
                <div id="variant-types-container"></div>

                <div id="generate-variant-wrapper" class="d-none mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-generate-variants">
                        <i class="bi bi-magic"></i> Generate Varian
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm ms-2" id="btn-clear-variants">
                        <i class="bi bi-trash"></i> Hapus Semua
                    </button>
                </div>

                <!-- Generated Variant Forms -->
                <div id="generated-variants" class="mt-3">
                    @foreach($product->variants as $vIndex => $variant)
                        <div class="variant-card" data-index="{{ $vIndex }}" data-variant-id="{{ $variant->id }}">
                            <div class="variant-card-header">
                                <div class="variant-label">
                                    <span class="variant-badge">#{{ $vIndex + 1 }}</span>
                                    @if($variant->attributes)
                                        @foreach($variant->attributes as $attrName => $attrValue)
                                            {{ $attrName }}: {{ $attrValue }}{{ !$loop->last ? ' / ' : '' }}
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm" style="font-size:0.72rem;padding:2px 8px;"
                                        onclick="removeExistingVariant(this, {{ $variant->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <input type="hidden" name="variants[{{ $vIndex }}][id]" value="{{ $variant->id }}">
                            @foreach($variant->attributes as $attrKey => $attrValue)
                                <input type="hidden" name="variants[{{ $vIndex }}][attributes][{{ $attrKey }}]" value="{{ $attrValue }}">
                            @endforeach

                            <div class="d-flex gap-3 align-items-start">
                                <!-- Image Preview -->
                                <div class="media-picker-wrapper" data-multiple="false" data-type="image">
                                    <div class="media-picker-selected" id="variant_media_{{ $vIndex }}-selected">
                                        @if($variant->image && $variant->media)
                                            <div class="media-picker-thumb">
                                                @if($variant->media->isImage())
                                                    <img src="{{ $variant->media->url }}" alt="">
                                                @else
                                                    <div class="media-thumb-icon">
                                                        @if(str_starts_with($variant->media->mime_type ?? '', 'video/'))
                                                            <i class="bi bi-play-circle"></i>
                                                        @elseif(str_starts_with($variant->media->mime_type ?? '', 'audio/'))
                                                            <i class="bi bi-music-note"></i>
                                                        @else
                                                            <i class="bi bi-file-earmark"></i>
                                                        @endif
                                                    </div>
                                                @endif
                                                <button type="button" class="remove-media" onclick="removePickerItem('variant_media_{{ $vIndex }}', '{{ $variant->image }}')"><i class="bi bi-x"></i></button>
                                            </div>
                                        @else
                                            <div class="media-picker-empty">
                                                <i class="bi bi-image"></i>
                                                <span>Belum ada gambar</span>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            onclick="openMediaPicker('variant_media_{{ $vIndex }}', false, 'image')">
                                        <i class="bi bi-images"></i> Pilih Gambar
                                    </button>
                                    <input type="hidden"
                                           name="variant_images[{{ $vIndex }}]"
                                           id="variant_media_{{ $vIndex }}-input"
                                           value="{{ old('variant_images.'.$vIndex, $variant->image) }}">
                                </div>

                                <div class="flex-fill">
                                    <div class="row g-2">
                                        <div class="col-md-3 fv-row">
                                            <label class="fs-8 fw-semibold mb-1">SKU</label>
                                            <input type="text" class="form-control form-control-sm"
                                                   name="variants[{{ $vIndex }}][sku]" placeholder="SKU varian"
                                                   value="{{ old('variants.'.$vIndex.'.sku', $variant->sku) }}">
                                        </div>
                                        <div class="col-md-3 fv-row">
                                            <label class="required fs-8 fw-semibold mb-1">Harga (Rp)</label>
                                            <input type="number" class="form-control form-control-sm"
                                                   name="variants[{{ $vIndex }}][price]" min="0" step="100"
                                                   placeholder="0" required
                                                   value="{{ old('variants.'.$vIndex.'.price', $variant->price) }}">
                                        </div>
                                        <div class="col-md-3 fv-row">
                                            <label class="fs-8 fw-semibold mb-1">Berat</label>
                                            <input type="text" class="form-control form-control-sm"
                                                   name="variants[{{ $vIndex }}][weight]" placeholder="250g"
                                                   value="{{ old('variants.'.$vIndex.'.weight', $variant->weight) }}">
                                        </div>
                                        <div class="col-md-3 fv-row">
                                            <label class="fs-8 fw-semibold mb-1">Stok</label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox"
                                                       name="variants[{{ $vIndex }}][stock]" value="1"
                                                       id="variant-stock-{{ $vIndex }}"
                                                       {{ old('variants.'.$vIndex.'.stock', $variant->stock) ? 'checked' : '' }}>
                                                <label class="form-check-label fs-8" for="variant-stock-{{ $vIndex }}">Tersedia</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Diskon -->
                                    @php
                                        $vHasDiscount = old('variants.'.$vIndex.'.discount_percent', $variant->discount_percent);
                                    @endphp
                                    <div class="form-check form-switch mt-2 mb-1">
                                        <input class="form-check-input" type="checkbox"
                                               id="variant-discount-switch-{{ $vIndex }}"
                                               {{ $vHasDiscount ? 'checked' : '' }}
                                               onchange="toggleVariantDiscount({{ $vIndex }}, this)">
                                        <label class="form-check-label fs-8 fw-semibold" for="variant-discount-switch-{{ $vIndex }}">Diskon</label>
                                    </div>
                                    <div id="variant-discount-fields-{{ $vIndex }}" class="{{ $vHasDiscount ? '' : 'd-none' }}">
                                        <div class="row g-2">
                                            <div class="col-md-3 fv-row">
                                                <label class="fs-8 fw-semibold mb-1">Persen (%)</label>
                                                <input type="number" class="form-control form-control-sm"
                                                       name="variants[{{ $vIndex }}][discount_percent]" min="0" max="100"
                                                       placeholder="0" oninput="calcVariantDiscount({{ $vIndex }}, this)"
                                                       value="{{ old('variants.'.$vIndex.'.discount_percent', $variant->discount_percent) }}">
                                            </div>
                                            <div class="col-md-3 fv-row">
                                                <label class="fs-8 fw-semibold mb-1">Harga Diskon</label>
                                                <input type="number" class="form-control form-control-sm"
                                                       name="variants[{{ $vIndex }}][price_discount]" min="0" step="100"
                                                       placeholder="0" id="variant-price-discount-{{ $vIndex }}"
                                                       value="{{ old('variants.'.$vIndex.'.price_discount', $variant->price_discount) }}">
                                            </div>
                                            <div class="col-md-3 fv-row">
                                                <label class="fs-8 fw-semibold mb-1">Mulai</label>
                                                <input type="datetime-local" class="form-control form-control-sm"
                                                       name="variants[{{ $vIndex }}][discount_start]"
                                                       value="{{ old('variants.'.$vIndex.'.discount_start', $variant->discount_start ? $variant->discount_start->format('Y-m-d\TH:i') : '') }}">
                                            </div>
                                            <div class="col-md-3 fv-row">
                                                <label class="fs-8 fw-semibold mb-1">Akhir</label>
                                                <input type="datetime-local" class="form-control form-control-sm"
                                                       name="variants[{{ $vIndex }}][discount_end]"
                                                       value="{{ old('variants.'.$vIndex.'.discount_end', $variant->discount_end ? $variant->discount_end->format('Y-m-d\TH:i') : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dimensi -->
                                    <div class="row g-2 mt-1">
                                        <div class="col-md-3 fv-row">
                                            <label class="fs-8 fw-semibold mb-1">Panjang</label>
                                            <input type="text" class="form-control form-control-sm"
                                                   name="variants[{{ $vIndex }}][length]" placeholder="cm"
                                                   value="{{ old('variants.'.$vIndex.'.length', $variant->length) }}">
                                        </div>
                                        <div class="col-md-3 fv-row">
                                            <label class="fs-8 fw-semibold mb-1">Lebar</label>
                                            <input type="text" class="form-control form-control-sm"
                                                   name="variants[{{ $vIndex }}][width]" placeholder="cm"
                                                   value="{{ old('variants.'.$vIndex.'.width', $variant->width) }}">
                                        </div>
                                        <div class="col-md-3 fv-row">
                                            <label class="fs-8 fw-semibold mb-1">Tinggi</label>
                                            <input type="text" class="form-control form-control-sm"
                                                   name="variants[{{ $vIndex }}][height]" placeholder="cm"
                                                   value="{{ old('variants.'.$vIndex.'.height', $variant->height) }}">
                                        </div>
                                    </div>

                                    <!-- Toggles -->
                                    <div class="d-flex gap-3 mt-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                   name="variants[{{ $vIndex }}][is_service]" value="1"
                                                   id="variant-service-{{ $vIndex }}"
                                                   {{ old('variants.'.$vIndex.'.is_service', $variant->is_service) ? 'checked' : '' }}
                                                   onchange="toggleVariantService({{ $vIndex }}, this)">
                                            <label class="form-check-label fs-8" for="variant-service-{{ $vIndex }}">Service</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                   name="variants[{{ $vIndex }}][is_active]" value="1"
                                                   id="variant-active-{{ $vIndex }}"
                                                   {{ old('variants.'.$vIndex.'.is_active', $variant->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label fs-8" for="variant-active-{{ $vIndex }}">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Deskripsi Lengkap -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Deskripsi Lengkap</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-0">
                    <div id="description-editor">{!! old('description', $product->description) !!}</div>
                    <input type="hidden" name="description" id="description-input">
                    @error('description')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Fitur Produk</div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-feature">
                    <i class="bi bi-plus"></i> Tambah
                </button>
            </div>
            <div class="card-body">
                <div id="features-container">
                    @if($product->features)
                        @foreach($product->features as $fIndex => $feature)
                            <div class="feature-row">
                                <div class="fv-row flex-fill">
                                    <input type="text" class="form-control form-control-sm"
                                           name="features[{{ $fIndex }}][title]" placeholder="Judul fitur"
                                           value="{{ old('features.'.$fIndex.'.title', $feature['title'] ?? '') }}">
                                </div>
                                <div class="fv-row flex-fill">
                                    <input type="text" class="form-control form-control-sm"
                                           name="features[{{ $fIndex }}][value]" placeholder="Nilai"
                                           value="{{ old('features.'.$fIndex.'.value', $feature['value'] ?? '') }}">
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.feature-row').remove(); checkFeaturesEmpty();" title="Hapus Fitur">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div id="no-features-msg" class="text-muted fs-8" style="{{ $product->features ? 'display:none' : '' }}">Belum ada fitur ditambahkan.</div>
            </div>
        </div>

        <!-- SEO -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">SEO Settings</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="fs-7 fw-semibold mb-2">Meta Title</label>
                    <input type="text" class="form-control form-control-sm"
                           name="meta_title" placeholder="Meta title untuk SEO"
                           value="{{ old('meta_title', $product->meta_title) }}">
                </div>
                <div class="fv-row mb-3">
                    <label class="fs-7 fw-semibold mb-2">Meta Description</label>
                    <textarea class="form-control form-control-sm"
                              name="meta_description" rows="2"
                              placeholder="Meta description untuk SEO">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
                <div class="fv-row mb-0">
                    <label class="fs-7 fw-semibold mb-2">Meta Keywords</label>
                    <input type="text" class="form-control form-control-sm"
                           name="meta_keywords"
                           placeholder="Keyword1, Keyword2, Keyword3"
                           value="{{ old('meta_keywords', $product->meta_keywords) }}">
                </div>
            </div>
        </div>
    </div>

    <!-- ========== SIDEBAR (20%) ========== -->
    <div class="col-lg-4">
        <!-- Publish -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Publish</div>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="status" value="active">
                        <i class="bi bi-check-lg"></i> Update & Publish
                    </button>
                    <button type="submit" class="btn btn-light btn-sm" name="status" value="inactive">
                        <i class="bi bi-file-earmark"></i> Save as Draft
                    </button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm" name="status" value="archived"
                            onclick="return confirm('Arsipkan produk ini?')">
                        <i class="bi bi-archive"></i> Archive
                    </button>
                </div>
            </div>
        </div>

        <!-- Gambar Utama -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Gambar Utama</div>
            </div>
            <div class="card-body">
                <x-media-picker name="primary_media_id" :multiple="false" type="image" label="Pilih Gambar Utama"
                    :value="$product->thumbnail_id"
                    :media="$product->thumbnail ? collect([$product->thumbnail]) : collect()" />
            </div>
        </div>

        <!-- Gallery -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Gallery</div>
            </div>
            <div class="card-body">
                <x-media-picker name="media_ids" :multiple="true" type="image" label="Pilih dari Library"
                    :value="$product->media->pluck('id')"
                    :media="$product->media" />
            </div>
        </div>

        <!-- Kategori -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Kategori</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-0">
                    <select class="form-select form-select-sm" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger fs-8 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tag -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Tag</div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="tag_ids[]" value="{{ $tag->id }}"
                                   id="tag-{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tag_ids', $product->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="form-check-label fs-8" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                    @if($tags->isEmpty())
                        <div class="text-muted fs-8">Belum ada tag.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pengaturan Lain -->
        <div class="glass-card mb-4">
            <div class="card-header">
                <div class="card-title">Pengaturan</div>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                           id="product-featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fs-7 fw-semibold" for="product-featured">
                        <i class="bi bi-star me-1"></i> Produk Unggulan
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<!-- ========== VARIANT TYPE MODAL ========== -->
<div class="modal fade" id="variant-type-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card">
            <div class="card-header">
                <div class="card-title" id="variant-modal-title">Tambah Tipe Varian</div>
<div class="card-header-btns">
    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
        <i class="bi bi-x-lg"></i>
    </div>
</div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-3">
                    <label class="required fs-7 fw-semibold mb-2">Nama Tipe</label>
                    <input type="text" class="form-control form-control-sm"
                           id="variant-type-name" placeholder="Contoh: Ukuran, Warna">
                </div>
                <div class="fv-row mb-0">
                    <label class="required fs-7 fw-semibold mb-2">Values (pisah dengan |)</label>
                    <input type="text" class="form-control form-control-sm"
                           id="variant-type-values" placeholder="Contoh: S | M | L | XL">
                    <div class="form-text fs-8">Pisahkan setiap nilai dengan tanda pipe ( | )</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn-save-variant-type">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">

@push('scripts')
{{-- Quill Rich Text Editor JS --}}
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('product-form');
    const nameInput = document.getElementById('product-name');
    const slugInput = document.getElementById('product-slug');
    const variantTypesContainer = document.getElementById('variant-types-container');
    const generatedVariants = document.getElementById('generated-variants');
    const noVariantForm = document.getElementById('no-variant-form');
    const variantSection = document.getElementById('variant-section');
    const generateWrapper = document.getElementById('generate-variant-wrapper');

    // ==========================================
    // QUILL RICH TEXT EDITORS
    // ==========================================
    var quillToolbar = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'align': [] }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        ['blockquote', 'code-block'],
        ['link', 'image'],
        ['clean']
    ];

    var shortDescQuill = new Quill('#short-description-editor', {
        theme: 'snow',
        modules: { toolbar: quillToolbar },
        placeholder: 'Deskripsi singkat produk (ditampilkan di list/preview)...'
    });

    var descQuill = new Quill('#description-editor', {
        theme: 'snow',
        modules: { toolbar: quillToolbar },
        placeholder: 'Deskripsi lengkap produk...'
    });

    // Sync before form submit
    form.addEventListener('submit', function() {
        document.getElementById('short-description-input').value = shortDescQuill.root.innerHTML;
        document.getElementById('description-input').value = descQuill.root.innerHTML;
    });

    // ==========================================
    // AUTO-GENERATE SLUG
    // ==========================================
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto === 'true') {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            slugInput.dataset.auto = 'true';
        }
    });
    slugInput.addEventListener('input', function() {
        this.dataset.auto = 'false';
    });

    // ==========================================
    // VARIANT TYPES MANAGEMENT
    // ==========================================
    let variantTypes = {!! json_encode($product->variant_types ?? []) !!};
    let variantTypeIndex = variantTypes.length;

    // Render existing variant types
    renderVariantTypes();

    document.getElementById('btn-add-variant-type').addEventListener('click', function() {
        openVariantTypeModal();
    });

    function openVariantTypeModal(editIndex = null) {
        const modal = document.getElementById('variant-type-modal');
        const nameInput = document.getElementById('variant-type-name');
        const valuesInput = document.getElementById('variant-type-values');
        const title = document.getElementById('variant-modal-title');

        if (editIndex !== null) {
            title.textContent = 'Edit Tipe Varian';
            nameInput.value = variantTypes[editIndex].name;
            valuesInput.value = variantTypes[editIndex].values.join(' | ');
            modal.dataset.editIndex = editIndex;
        } else {
            title.textContent = 'Tambah Tipe Varian';
            nameInput.value = '';
            valuesInput.value = '';
            delete modal.dataset.editIndex;
        }

        const bsModal = new bootstrap.Modal(modal);
        modal.addEventListener('shown.bs.modal', function focusHandler() {
            const focusInput = modal.querySelector('#variant-type-name');
            if (focusInput) focusInput.focus();
            modal.removeEventListener('shown.bs.modal', focusHandler);
        });
        bsModal.show();
    }

    document.getElementById('btn-save-variant-type').addEventListener('click', function() {
        const name = document.getElementById('variant-type-name').value.trim();
        const valuesRaw = document.getElementById('variant-type-values').value.trim();

        if (!name) {
            Ravaa.alert('Peringatan', 'Nama tipe wajib diisi.', 'warning');
            return;
        }
        if (!valuesRaw) {
            Ravaa.alert('Peringatan', 'Values wajib diisi.', 'warning');
            return;
        }

        const values = valuesRaw.split('|').map(v => v.trim()).filter(v => v);
        if (values.length < 1) {
            Ravaa.alert('Peringatan', 'Minimal 1 value.', 'warning');
            return;
        }

        const modal = document.getElementById('variant-type-modal');
        const editIndex = modal.dataset.editIndex;

        if (editIndex !== undefined && editIndex !== '') {
            variantTypes[parseInt(editIndex)] = { name, values };
        } else {
            variantTypes.push({ name, values });
        }

        renderVariantTypes();
        bootstrap.Modal.getInstance(modal).hide();
    });

    function renderVariantTypes() {
        variantTypesContainer.innerHTML = '';

        if (variantTypes.length === 0) {
            // Show no-variant form, keep variant section visible (button "Tambah Tipe" is inside it)
            noVariantForm.style.display = '';
            noVariantForm.querySelectorAll('input, select, textarea').forEach(el => el.disabled = false);
            generateWrapper.classList.add('d-none');
            generatedVariants.innerHTML = '';
            return;
        }

        // Hide no-variant form, variant section is always visible
        noVariantForm.style.display = 'none';
        noVariantForm.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);

        variantTypes.forEach(function(type, index) {
            const div = document.createElement('div');
            div.className = 'mb-3';
            div.innerHTML = `
                <input type="hidden" name="variant_types[${index}][name]" value="${escapeHtml(type.name)}">
                ${type.values.map((v, vIndex) => `<input type="hidden" name="variant_types[${index}][values][${vIndex}]" value="${escapeHtml(v)}">`).join('')}
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="variant-type-tag">
                        <i class="bi bi-tag"></i> ${escapeHtml(type.name)}
                        <button type="button" class="remove-type" onclick="removeVariantType(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" style="font-size:0.72rem;padding:2px 8px;"
                            onclick="openVariantTypeModal(${index})">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                <div class="variant-type-values">
                    ${type.values.map(v => `<span class="value-chip">${escapeHtml(v)}</span>`).join('')}
                </div>
            `;
            variantTypesContainer.appendChild(div);
        });

        if (variantTypes.length >= 1) {
            generateWrapper.classList.remove('d-none');
        } else {
            generateWrapper.classList.add('d-none');
        }
    }

    window.removeVariantType = function(index) {
        variantTypes.splice(index, 1);
        renderVariantTypes();
    };

    window.openVariantTypeModal = openVariantTypeModal;

    // ==========================================
    // GENERATE VARIANT COMBINATIONS
    // ==========================================
    document.getElementById('btn-generate-variants').addEventListener('click', function() {
        generateVariantForms();
    });

    document.getElementById('btn-clear-variants').addEventListener('click', function() {
        Ravaa.confirm('Hapus Semua', 'Hapus semua varian yang sudah di-generate?', 'warning').then(ok => {
            if (ok) {
                generatedVariants.innerHTML = '';
            }
        });
    });

    function generateVariantForms() {
        if (variantTypes.length === 0) return;

        const combinations = cartesianProduct(variantTypes);
        generatedVariants.innerHTML = '';

        combinations.forEach(function(combo, index) {
            const comboLabel = Object.entries(combo).map(([k, v]) => `${k}: ${v}`).join(' / ');
            const card = createVariantCard(combo, index, comboLabel);
            generatedVariants.appendChild(card);
        });
    }

    function cartesianProduct(types) {
        if (types.length === 0) return [[]];
        const [first, ...rest] = types;
        const restProduct = cartesianProduct(rest);
        const result = [];
        first.values.forEach(function(value) {
            restProduct.forEach(function(combo) {
                result.push({ [first.name]: value, ...combo });
            });
        });
        return result;
    }

    function createVariantCard(attributes, index, label) {
        const card = document.createElement('div');
        card.className = 'variant-card';
        card.dataset.index = index;

        let attrInputs = '';
        for (const key in attributes) {
            attrInputs += `<input type="hidden" name="variants[${index}][attributes][${escapeHtml(key)}]" value="${escapeHtml(attributes[key])}">`;
        }

        card.innerHTML = `
            <div class="variant-card-header">
                <div class="variant-label">
                    <span class="variant-badge">#${index + 1}</span>
                    ${escapeHtml(label)}
                </div>
            </div>
            ${attrInputs}

            <div class="d-flex gap-3 align-items-start">
                <div class="media-picker-wrapper">
                    <div class="media-picker-selected" id="variant_media_${index}-selected">
                        <div class="media-picker-empty"><i class="bi bi-image"></i><span>Belum ada media dipilih</span></div>
                    </div>
                    <button type="button"
                            class="btn btn-outline-primary btn-sm"
                            onclick="openMediaPicker('variant_media_${index}', false, 'image')">
                        <i class="bi bi-images"></i> Pilih Gambar
                    </button>
                    <input type="hidden"
                           name="variant_images[${index}]"
                           id="variant_media_${index}-input"
                           value="">
                </div>

                <div class="flex-fill">
                    <div class="row g-2">
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">SKU</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][sku]" placeholder="SKU varian">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="required fs-8 fw-semibold mb-1">Harga (Rp)</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="variants[${index}][price]" min="0" step="100"
                                   placeholder="0" required>
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Berat</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][weight]" placeholder="250g">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Stok</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       name="variants[${index}][stock]" value="1"
                                       id="variant-stock-${index}">
                                <label class="form-check-label fs-8" for="variant-stock-${index}">Tersedia</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-2 mb-1">
                        <input class="form-check-input" type="checkbox"
                               id="variant-discount-switch-${index}"
                               onchange="toggleVariantDiscount(${index}, this)">
                        <label class="form-check-label fs-8 fw-semibold" for="variant-discount-switch-${index}">Diskon</label>
                    </div>
                    <div id="variant-discount-fields-${index}" class="d-none">
                        <div class="row g-2">
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Persen (%)</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="variants[${index}][discount_percent]" min="0" max="100"
                                       placeholder="0" oninput="calcVariantDiscount(${index}, this)">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Harga Diskon</label>
                                <input type="number" class="form-control form-control-sm"
                                       name="variants[${index}][price_discount]" min="0" step="100"
                                       placeholder="0" id="variant-price-discount-${index}">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Mulai</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="variants[${index}][discount_start]">
                            </div>
                            <div class="col-md-3 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Akhir</label>
                                <input type="datetime-local" class="form-control form-control-sm"
                                       name="variants[${index}][discount_end]">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Panjang</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][length]" placeholder="cm">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Lebar</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][width]" placeholder="cm">
                        </div>
                        <div class="col-md-3 fv-row">
                            <label class="fs-8 fw-semibold mb-1">Tinggi</label>
                            <input type="text" class="form-control form-control-sm"
                                   name="variants[${index}][height]" placeholder="cm">
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   name="variants[${index}][is_service]" value="1"
                                   id="variant-service-${index}"
                                   onchange="toggleVariantService(${index}, this)">
                            <label class="form-check-label fs-8" for="variant-service-${index}">Service</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   name="variants[${index}][is_active]" value="1" checked
                                   id="variant-active-${index}">
                            <label class="form-check-label fs-8" for="variant-active-${index}">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
        `;

        return card;
    }

    // ==========================================
    // REMOVE EXISTING VARIANT
    // ==========================================
    window.removeExistingVariant = function(btn, variantId) {
        Ravaa.confirm('Hapus Varian', 'Yakin ingin menghapus varian ini?', 'warning').then(ok => {
            if (ok) {
                const card = btn.closest('.variant-card');
                // Add to delete list
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_variant_ids[]';
                deleteInput.value = variantId;
                form.appendChild(deleteInput);
                card.remove();
            }
        });
    };

    // ==========================================
    // VARIANT DISCOUNT TOGGLE
    // ==========================================
    window.toggleVariantDiscount = function(index, checkbox) {
        const fields = document.getElementById('variant-discount-fields-' + index);
        fields.classList.toggle('d-none', !checkbox.checked);
    };

    window.calcVariantDiscount = function(index, input) {
        const card = input.closest('.variant-card');
        const priceInput = card.querySelector('input[name="variants[' + index + '][price]"]');
        const priceDiscount = card.querySelector('#variant-price-discount-' + index);
        const percent = parseFloat(input.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        if (percent > 0 && price > 0) {
            priceDiscount.value = Math.round(price * (1 - percent / 100));
        } else {
            priceDiscount.value = '';
        }
    };

    // ==========================================
    // VARIANT SERVICE TOGGLE
    // ==========================================
    window.toggleVariantService = function(index, checkbox) {
        const card = checkbox.closest('.variant-card');
        const stockCheckbox = card.querySelector('input[name="variants[' + index + '][stock]"]');
        if (checkbox.checked) {
            stockCheckbox.checked = false;
            stockCheckbox.disabled = true;
        } else {
            stockCheckbox.disabled = false;
        }
    };

    // ==========================================
    // NO-VARIANT DISCOUNT
    // ==========================================
    window.toggleNoVariantDiscount = function(checkbox) {
        const fields = document.getElementById('no-variant-discount-fields');
        fields.classList.toggle('d-none', !checkbox.checked);
    };

    window.calcNoVariantDiscount = function(input) {
        const priceInput = document.querySelector('#no-variant-form input[name="price"]');
        const priceDiscount = document.getElementById('no-price-discount');
        const percent = parseFloat(input.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        if (percent > 0 && price > 0) {
            priceDiscount.value = Math.round(price * (1 - percent / 100));
        } else {
            priceDiscount.value = '';
        }
    };

    // ==========================================
    // NO-VARIANT SERVICE TOGGLE
    // ==========================================
    window.toggleNoVariantService = function(checkbox) {
        const stockCheckbox = document.getElementById('no-stock');
        const hint = document.getElementById('no-service-hint');
        if (checkbox.checked) {
            stockCheckbox.checked = false;
            stockCheckbox.disabled = true;
            hint.style.display = 'block';
        } else {
            stockCheckbox.disabled = false;
            hint.style.display = 'none';
        }
    };

    // ==========================================
    // FEATURES MANAGEMENT
    // ==========================================
    let featureIndex = {{ $product->features ? count($product->features) : 0 }};

    document.getElementById('btn-add-feature').addEventListener('click', function() {
        addFeatureRow();
    });

    function addFeatureRow(title = '', value = '') {
        const container = document.getElementById('features-container');
        const noMsg = document.getElementById('no-features-msg');
        noMsg.style.display = 'none';

        const row = document.createElement('div');
        row.className = 'feature-row';
        row.innerHTML = `
            <div class="fv-row flex-fill">
                <input type="text" class="form-control form-control-sm"
                       name="features[${featureIndex}][title]" placeholder="Judul fitur"
                       value="${escapeHtml(title)}">
            </div>
            <div class="fv-row flex-fill">
                <input type="text" class="form-control form-control-sm"
                       name="features[${featureIndex}][value]" placeholder="Nilai"
                       value="${escapeHtml(value)}">
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.feature-row').remove(); checkFeaturesEmpty();" title="Hapus Fitur">
                <i class="bi bi-x"></i>
            </button>
        `;
        container.appendChild(row);
        featureIndex++;
    }

    window.checkFeaturesEmpty = function() {
        const container = document.getElementById('features-container');
        const noMsg = document.getElementById('no-features-msg');
        noMsg.style.display = container.children.length === 0 ? 'block' : 'none';
    };

    // Init existing media preview from preloaded values
    initExistingMediaPreview();

    function initExistingMediaPreview() {
        const input = document.getElementById('media_ids-input');
        const preview = document.getElementById('media_ids-selected');
        if (!input || !preview) return;

        const ids = input.value.split(',').filter(Boolean);
        if (ids.length === 0) return;

        // Preview is already populated by server-side Blade for existing items;
        // only rebuild if the container still shows the empty placeholder.
        const emptyMsg = preview.querySelector('.media-picker-empty');
        if (!emptyMsg) return;

        // We don't have thumbnail URLs in JS, so leave the "Current Media
        // Preview" section below to display them.  Remove the empty placeholder
        // so the picker area looks correct.
        preview.innerHTML = '<div class="text-muted fs-8"><i class="bi bi-info-circle me-1"></i> ' + ids.length + ' gambar dipilih. Klik "Pilih dari Library" untuk mengubah.</div>';
    }

    // ==========================================
    // UTILS
    // ==========================================
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
@endpush
@endsection
