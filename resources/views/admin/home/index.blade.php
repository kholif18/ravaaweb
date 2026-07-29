@extends('admin.layouts.app')

@section('page-title', 'Home Page Builder (CMS)')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="text-muted">Home Builder</span>
    </li>
@endsection

@section('content')
<form action="{{ route('admin.home.store') }}" method="POST" id="home-builder-form">
    @csrf

    @if ($errors->any())
    <div class="col-12 mb-3">
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

    <div class="row g-4">
        <!-- Kiri: Pengaturan Section -->
        <div class="col-lg-8">

            <!-- Section 1: Hero Section (Slider Banners) -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-images me-1"></i> Section Hero (Slider)
                    </div>
                </div>
                <div class="card-body">
                    <p class="fs-8 text-muted mb-3">Pilih banner aktif yang ingin ditampilkan di slider halaman depan. Jika tidak ada banner yang dipilih, maka akan menggunakan banner/hero default dari halaman Pengaturan Umum.</p>
                    
                    <div class="row g-3">
                        @if($banners->count() > 0)
                            @foreach($banners as $banner)
                            <div class="col-md-6">
                                <div class="p-3 rounded border bg-glass-element d-flex align-items-start gap-2 h-100">
                                    <div class="form-check pt-1">
                                        <input class="form-check-input" type="checkbox" name="hero[banner_ids][]" 
                                               value="{{ $banner->id }}" id="banner-{{ $banner->id }}"
                                               {{ in_array($banner->id, $content['hero']['banner_ids'] ?? []) ? 'checked' : '' }}>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <label class="form-check-label fs-7 fw-semibold d-block text-truncate" for="banner-{{ $banner->id }}">
                                            {{ $banner->title }}
                                        </label>
                                        <span class="fs-8 text-muted d-block text-truncate">{{ $banner->subtitle ?? 'Tidak ada subtitle' }}</span>
                                        @if($banner->image_url)
                                            <img src="{{ $banner->image_url }}" class="mt-2 rounded border" style="height: 40px; width: 80px; object-fit: cover;">
                                        @endif
                                        <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }} fs-9 mt-2 d-inline-block">
                                            {{ $banner->is_active ? 'Aktif' : 'Non-aktif' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-images fs-1 d-block mb-2"></i>
                                    Belum ada banner yang terdaftar. <a href="{{ route('admin.banners.index') }}" class="fw-semibold">Kelola Banner di sini</a>.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section 2: Kategori Terpopuler -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-folder-check me-1"></i> Section Kategori Terpopuler
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Judul Section</label>
                            <input type="text" class="form-control form-control-sm" name="categories[title]"
                                   value="{{ $content['categories']['title'] ?? 'Kategori Layanan' }}" placeholder="Kategori Layanan">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Subtitle Section</label>
                            <input type="text" class="form-control form-control-sm" name="categories[subtitle]"
                                   value="{{ $content['categories']['subtitle'] ?? 'Solusi lengkap untuk kebutuhan kreatif bisnis Anda' }}" 
                                   placeholder="Deskripsi singkat section">
                        </div>
                    </div>

                    <p class="fs-8 text-muted mb-3">Pilih kategori aktif yang ingin ditampilkan di halaman depan. Jika tidak ada kategori yang dipilih, maka semua kategori aktif akan ditampilkan.</p>

                    <div class="row g-3">
                        @if($categories->count() > 0)
                            @foreach($categories as $category)
                            <div class="col-md-4">
                                <div class="p-2 rounded border bg-glass-element d-flex align-items-center gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[category_ids][]" 
                                               value="{{ $category->id }}" id="category-{{ $category->id }}"
                                               {{ in_array($category->id, $content['categories']['category_ids'] ?? []) ? 'checked' : '' }}>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <label class="form-check-label fs-7 fw-semibold d-block text-truncate" for="category-{{ $category->id }}">
                                            <i class="{{ $category->icon ?? 'bi bi-tag' }} me-1" style="color: var(--accent);"></i>
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-tag fs-1 d-block mb-2"></i>
                                    Belum ada kategori aktif. <a href="{{ route('admin.categories.index') }}" class="fw-semibold">Kelola Kategori di sini</a>.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section 3: Produk Terbaru / Unggulan -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-box-seam me-1"></i> Section Produk / Layanan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Judul Section</label>
                            <input type="text" class="form-control form-control-sm" name="products[title]"
                                   value="{{ $content['products']['title'] ?? 'Produk Unggulan' }}" placeholder="Produk Unggulan">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Subtitle Section</label>
                            <input type="text" class="form-control form-control-sm" name="products[subtitle]"
                                   value="{{ $content['products']['subtitle'] ?? 'Temukan produk terbaik pilihan untuk kebutuhan Anda' }}" 
                                   placeholder="Deskripsi singkat section">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Tipe Produk yang Ditampilkan</label>
                            <select class="form-select form-select-sm" name="products[type]" id="product-display-type" onchange="toggleProductSelector(this.value)">
                                <option value="featured" {{ ($content['products']['type'] ?? '') == 'featured' ? 'selected' : '' }}>Hanya Produk Unggulan (is_featured = true)</option>
                                <option value="latest" {{ ($content['products']['type'] ?? '') == 'latest' ? 'selected' : '' }}>Produk Terbaru (Berdasarkan tanggal buat)</option>
                                <option value="selected" {{ ($content['products']['type'] ?? '') == 'selected' ? 'selected' : '' }}>Pilih Produk Manual / Kustom</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Limit Jumlah Tampilan</label>
                            <input type="number" class="form-control form-control-sm" name="products[limit]"
                                   value="{{ $content['products']['limit'] ?? 8 }}" min="1" max="50">
                        </div>
                    </div>

                    <!-- Custom Product Selector (Only visible if type is 'selected') -->
                    <div id="custom-product-selector" class="d-none">
                        <p class="fs-8 text-muted mb-3">Pilih beberapa produk secara spesifik yang ingin ditampilkan di halaman depan:</p>
                        <div class="row g-3" style="max-height: 250px; overflow-y: auto; padding: 5px;">
                            @if($products->count() > 0)
                                @foreach($products as $prod)
                                <div class="col-md-6">
                                    <div class="p-2 rounded border bg-glass-element d-flex align-items-center gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="products[product_ids][]" 
                                                   value="{{ $prod->id }}" id="product-{{ $prod->id }}"
                                                   {{ in_array($prod->id, $content['products']['product_ids'] ?? []) ? 'checked' : '' }}>
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <label class="form-check-label fs-7 fw-semibold d-block text-truncate" for="product-{{ $prod->id }}">
                                                {{ $prod->name }}
                                            </label>
                                            <span class="fs-9 text-muted d-block">{{ $prod->category?->name ?? 'Tanpa Kategori' }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="text-center py-4 text-muted">
                                        Belum ada produk aktif yang terdaftar.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Rich Text Block (WYSIWYG) -->
            <div class="glass-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <i class="bi bi-file-richtext me-1"></i> Section Konten Kustom (Rich Text)
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="rich_text[is_visible]" id="rich-text-is-visible"
                               value="1" {{ ($content['rich_text']['is_visible'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fs-7 fw-semibold" for="rich-text-is-visible">Aktifkan Section</label>
                    </div>
                </div>
                <div class="card-body">
                    <p class="fs-8 text-muted mb-3">Tampilkan blok informasi/promosi khusus dengan format Rich Text (WYSIWYG) di halaman depan website.</p>

                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Judul Blok</label>
                        <input type="text" class="form-control form-control-sm" name="rich_text[title]"
                               value="{{ $content['rich_text']['title'] ?? '' }}" placeholder="Tentang Ravaa Creative">
                    </div>
                    
                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-2">Konten</label>
                        <div id="rich-content-editor" style="min-height: 200px;">{!! $content['rich_text']['content'] ?? '' !!}</div>
                        <input type="hidden" name="rich_text[content]" id="rich-content-input">
                    </div>
                </div>
            </div>

        </div>

        <!-- Kanan: Preview & Actions -->
        <div class="col-lg-4">
            
            <!-- Tombol Simpan -->
            <div class="glass-card mb-4 position-sticky" style="top: 2rem;">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-check-circle me-1"></i> Publikasikan</div>
                </div>
                <div class="card-body">
                    <p class="fs-8 text-muted mb-4">Simpan seluruh konfigurasi halaman beranda Anda. Perubahan akan segera diterapkan pada tampilan halaman depan (Home Page) pengunjung.</p>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-1"></i> Simpan Konfigurasi
                    </button>
                    
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary w-100 mt-2 btn-sm">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Depan
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">

@push('scripts')
{{-- Quill Rich Text Editor JS --}}
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
    function toggleProductSelector(type) {
        const selector = document.getElementById('custom-product-selector');
        if (type === 'selected') {
            selector.classList.remove('d-none');
        } else {
            selector.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Init Product Selector Visibility
        const currentType = document.getElementById('product-display-type').value;
        toggleProductSelector(currentType);

        // Toast messages
        @if(session('success'))
            Ravaa.toast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            Ravaa.toast('{{ session('error') }}', 'error');
        @endif

        // Quill WYSIWYG Editor
        var quillToolbar = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link', 'image'],
            ['clean']
        ];
        
        var richEditor = new Quill('#rich-content-editor', {
            theme: 'snow',
            modules: { toolbar: quillToolbar },
            placeholder: 'Tulis deskripsi atau promosi khusus di sini...'
        });

        // Sync Quill HTML on form submit
        const form = document.getElementById('home-builder-form');
        form.addEventListener('submit', function() {
            document.getElementById('rich-content-input').value = richEditor.root.innerHTML;
        });
    });
</script>
@endpush
