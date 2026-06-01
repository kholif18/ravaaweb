{{-- resources/views/admin/products/partials/_media.blade.php --}}
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title">Gambar Produk</h4>
    </div>
    <div class="card-body">
        <!-- Main Image Picker -->
        <div class="mb-10">
            <label class="form-label fw-bold required">Gambar Utama</label>
            <div class="d-flex align-items-center gap-5">
                <div class="image-preview border border-dashed rounded" id="mainImagePreview" style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; overflow: hidden;">
                    @if(isset($product) && $product->main_media_id)
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    @else
                        <span class="text-muted fs-7">Belum dipilih</span>
                    @endif
                </div>

                <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn btn-light-primary btn-sm" onclick="openMediaPicker('main')">
                        <i class="bi bi-image"></i> Pilih Gambar
                    </button>

                    <button type="button" class="btn btn-light-danger btn-sm" id="removeMainImage" style="display: {{ (isset($product) && $product->main_media_id) ? 'block' : 'none' }};" onclick="removeMainImage()">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>
            <input type="hidden" name="main_media_id" id="main_media_id" value="{{ old('main_media_id', $product->main_media_id ?? '') }}">
            @error('main_media_id')
                <div class="text-danger fs-7 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Gallery Picker -->
        <div class="mb-0">
            <label class="form-label fw-bold">Gallery Produk</label>
            <div class="gallery-grid d-flex flex-wrap gap-3 mb-5" id="galleryPreview">
                @php
                    $galleryMedia = [];
                    if (isset($product)) {
                        $galleryMedia = $product->galleryMedia()->orderBy('product_media.sort_order')->get();
                    }
                @endphp
                
                @foreach($galleryMedia as $media)
                    <div class="gallery-item position-relative border rounded overflow-hidden" data-id="{{ $media->id }}" style="width: 100px; height: 100px;">
                        <img src="{{ $media->thumbnail_url }}" alt="{{ $media->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <button type="button" class="btn btn-icon btn-bg-light btn-color-danger btn-active-color-danger btn-sm position-absolute top-0 end-0 m-1" style="width: 20px; height: 20px;" onclick="removeGalleryImage({{ $media->id }})">
                            <i class="bi bi-x fs-7"></i>
                        </button>
                    </div>
                @endforeach
                
                <div id="galleryPlaceholder" style="display: {{ count($galleryMedia) > 0 ? 'none' : 'block' }}">
                    <div class="border border-dashed rounded p-5 text-center bg-light">
                        <i class="bi bi-images text-muted fs-2x mb-2 d-block"></i>
                        <span class="text-muted fs-7">Belum ada gambar gallery</span>
                    </div>
                </div>
            </div>
            
            <button type="button" class="btn btn-light-primary btn-sm" onclick="openMediaPicker('gallery')">
                <i class="bi bi-images"></i> Tambah ke Gallery
            </button>
            <input type="hidden" name="gallery_images" id="gallery_images" value="{{ old('gallery_images', isset($product) ? json_encode($product->galleryMedia->pluck('id')) : '[]') }}">
        </div>
    </div>
</div>
