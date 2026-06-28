@extends('frontend.layouts.master')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-container">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('product') }}">Produk</a>
                @if($product->category)
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('product') }}?category={{ $product->category->slug }}">{{ $product->category->name }}</a>
                @endif
                <i class="fas fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </div>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="container">
            <div class="product-detail-container">
                <!-- Product Gallery -->
                <div class="product-gallery">
                    <div class="product-main-image">
                        @if($product->mainMedia)
                            <img src="{{ $product->mainMedia->url }}" alt="{{ $product->name }}" id="mainImage">
                        @else
                            <img src="{{ asset('storage/images/default-product.png') }}" alt="{{ $product->name }}" id="mainImage">
                        @endif
                    </div>
                    <div class="product-thumbnails">
                        @foreach($product->galleryMedia as $media)
                            <div class="thumbnail {{ $loop->first ? 'active' : '' }}" data-image="{{ $media->url }}">
                                <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $product->name }} thumbnail {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="detail-product-info">
                    <span class="product-category">{{ $product->category->name ?? 'Tidak Ada' }}</span>
                    <h1 class="detail-product-title">{{ $product->name }}</h1>
                    
                    <div class="detail-product-price-container">
                         <div class="detail-current-price">
                             @if($product->hasActiveDiscount())
                                 {{ $product->formatted_discount_price }}
                             @else
                                 {{ $product->formatted_price }}
                             @endif
                         </div>
                         @if($product->hasActiveDiscount())
                             <div class="detail-original-price">{{ $product->formatted_price }}</div>
                             <div class="detail-discount-percentage">Hemat {{ round((($product->price - $product->discount_price)/$product->price)*100) }}%</div>
                         @endif
                    </div>
                    
                    <div class="product-stock">
                        <div class="stock-status {{ $product->stock_status }}">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $product->stock_status_text }}</span>
                        </div>
                        @if(!empty($product->quick_infos['stock']))
                            <span class="stock-count">Stok: {{ $product->quick_infos['stock'] }}</span>
                        @endif
                    </div>
                    
                    <!-- Variants (if any) -->
                    @if($product->has_variants && $product->variants->count())
                    <div class="detail-product-variants">
                        <h3 class="detail-variant-title">Pilih Paket:</h3>
                        <div class="detail-variant-options">
                            @foreach($product->variants as $variant)
                                <div class="detail-variant-option {{ $variant->is_default ? 'selected' : '' }}" data-variant="{{ $variant->id }}">
                                    {{ $variant->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="product-warranty">
                        <div class="warranty-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Garansi 100% Revisi & Hak Cipta</span>
                        </div>
                    </div>
                    
                    <div class="detail-product-actions">
                        <div class="detail-action-buttons">
                            <a href="https://wa.me/6281234567890?text=Halo%20Ravaa%20Creative,%20saya%20tertarik%20dengan%20{{ urlencode($product->name) }}" class="btn-whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                            </a>
                            <a href="https://t.me/RavaaCreative" class="btn-telegram" target="_blank">
                                <i class="fab fa-telegram"></i> Pesan via Telegram
                            </a>
                        </div>
                        
                        <div class="quick-info">
                            <div class="info-item"><i class="fas fa-shipping-fast"></i> Gratis Konsultasi</div>
                            <div class="info-item"><i class="fas fa-clock"></i> Pengerjaan 3-7 hari</div>
                            <div class="info-item"><i class="fas fa-undo"></i> Revisi tanpa batas</div>
                            <div class="info-item"><i class="fas fa-file-download"></i> File lengkap semua format</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Tabs -->
            <div class="detail-product-tabs">
                <div class="detail-tab-headers">
                    <button class="detail-tab-header active" data-tab="description">Deskripsi Produk</button>
                    <button class="detail-tab-header" data-tab="specifications">Spesifikasi</button>
                </div>
                
                <div class="detail-tab-content active" id="description">
                    <div class="detail-product-description">
                        {!! $product->description !!}
                    </div>
                </div>
                
                <div class="detail-tab-content" id="specifications">
                    @if($product->specifications)
                        {!! $product->specifications !!}
                    @else
                        <p>Spesifikasi belum tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-products">
        <div class="container">
            <div class="section-title"><h2>Produk Terkait</h2></div>
            <div class="related-grid">
                @foreach($product->relatedProducts()->take(3)->get() as $rel)
                <div class="related-card">
                    <div class="related-image">
                        @if($rel->mainMedia)
                            <img src="{{ $rel->mainMedia->url }}" alt="{{ $rel->name }}">
                        @else
                            <img src="{{ asset('storage/images/default-product.png') }}" alt="{{ $rel->name }}">
                        @endif
                    </div>
                    <div class="related-info">
                        <h3 class="related-title">{{ $rel->name }}</h3>
                        <div class="related-price">{{ $rel->formatted_price }}</div>
                        <a href="{{ route('detail-product', $rel->slug) }}" class="related-btn">Lihat Detail</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        // Gallery switch
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                thumbnails.forEach(t => t.classList.remove('active'));
                thumbnail.classList.add('active');
                const newSrc = thumbnail.dataset.image;
                mainImage.src = newSrc;
            });
        });
        // Tab navigation
        const tabHeaders = document.querySelectorAll('.detail-tab-header');
        const tabContents = document.querySelectorAll('.detail-tab-content');
        tabHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const target = header.dataset.tab;
                tabHeaders.forEach(h => h.classList.remove('active'));
                header.classList.add('active');
                tabContents.forEach(c => c.classList.remove('active'));
                document.getElementById(target).classList.add('active');
            });
        });
    </script>
@endsection