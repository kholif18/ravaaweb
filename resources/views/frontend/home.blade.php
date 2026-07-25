@extends('frontend.layouts.master')

@section('title', $settings['site_name'] ?? 'Home')

@section('content')
    {{-- ═══════════════════════════════════════════════
         ① BANNER CAROUSEL — Full-width, image-first
         ═══════════════════════════════════════════════ --}}
    <section class="home-banner">
        @if($banners->count() > 0)
        <div class="banner-carousel" id="bannerCarousel">
            <div class="banner-track" id="bannerTrack">
                @foreach($banners as $banner)
                <div class="banner-slide {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}">
                    <div class="banner-slide-img">
                        @if($banner->image_url)
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=1200&h=500&fit=crop" alt="{{ $banner->title }}" loading="lazy">
                        @endif
                        <div class="banner-overlay"></div>
                    </div>
                    <div class="banner-slide-content container">
                        @if($banner->badge)
                        <span class="banner-badge"><i class="fas fa-tag"></i> {{ $banner->badge }}</span>
                        @endif
                        <h2 class="banner-title">{!! $banner->title !!}</h2>
                        @if($banner->subtitle)
                        <p class="banner-subtitle">{{ $banner->subtitle }}</p>
                        @endif
                        @if($banner->cta_text && $banner->cta_url)
                        <a href="{{ $banner->cta_url }}" class="btn btn-primary btn-lg">{{ $banner->cta_text }}</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @if($banners->count() > 1)
            <div class="banner-nav">
                <button class="banner-nav-btn banner-prev" aria-label="Sebelumnya"><i class="fas fa-chevron-left"></i></button>
                <div class="banner-dots" id="bannerDots">
                    @foreach($banners as $banner)
                    <button class="banner-dot {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}" aria-label="Slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
                <button class="banner-nav-btn banner-next" aria-label="Selanjutnya"><i class="fas fa-chevron-right"></i></button>
            </div>
            @endif
        </div>
        @else
        <div class="banner-static">
            <div class="container">
                <div class="banner-static-content">
                    <span class="banner-badge"><i class="fas fa-sparkle"></i> {{ $settings['site_name'] ?? 'Ravaa Creative' }}</span>
                    <h1 class="banner-title">{!! $settings['hero_title'] ?? 'Solusi Kreatif untuk<br>Bisnis &amp; Kebutuhan Anda' !!}</h1>
                    <p class="banner-subtitle">{{ $settings['hero_subtitle'] ?? $settings['site_description'] ?? 'Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap.' }}</p>
                    <div class="banner-actions">
                        <a href="{{ $settings['hero_cta_url'] ?? url('/product') }}" class="btn btn-primary btn-lg">{{ $settings['hero_cta_text'] ?? 'Lihat Katalog' }}</a>
                        @if($settings['whatsapp'] ?? null)
                        <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya ingin konsultasi.') }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                        @endif
                    </div>
                </div>
                <div class="banner-static-visual">
                    @if($settings['hero_image'] ?? null)
                        <img src="{{ $settings['hero_image'] }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=800&h=600&fit=crop" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}">
                    @endif
                </div>
            </div>
        </div>
        @endif
    </section>

    {{-- ═══════════════════════════════════════════════
         ② KATEGORI — Horizontal scroll pills
         ═══════════════════════════════════════════════ --}}
    @if($categories->count() > 0)
    <section class="home-categories">
        <div class="container">
            <div class="home-section-header">
                <div>
                    <span class="section-label">Layanan</span>
                    <h2 class="section-title">{{ $content['categories']['title'] ?? 'Kategori Layanan' }}</h2>
                </div>
                <a href="{{ url('/product') }}" class="home-section-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="cat-scroll" id="catScroll">
                @foreach($categories as $cat)
                <a href="{{ url('/product?category=' . $cat->slug) }}" class="cat-pill">
                    <span class="cat-pill-icon"><i class="{{ $cat->icon ?? 'fas fa-tags' }}"></i></span>
                    <span class="cat-pill-label">{{ $cat->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════
         ③ PRODUK UNGGULAN — Image-first grid
         ═══════════════════════════════════════════════ --}}
    <section class="home-products">
        <div class="container">
            <div class="home-section-header">
                <div>
                    <span class="section-label">Koleksi</span>
                    <h2 class="section-title">{{ $content['products']['title'] ?? 'Produk Unggulan' }}</h2>
                </div>
                <a href="{{ url('/product') }}" class="home-section-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            @if($products->count() > 0)
            <div class="home-product-grid">
                @foreach($products as $product)
                <a href="{{ url('/product/' . $product->slug) }}" class="home-prod-card">
                    <div class="home-prod-img-wrap">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="home-prod-img" loading="lazy">
                        @if(!empty($product->badge))
                        <span class="home-prod-badge badge-{{ strtolower(explode(' ', $product->badge)[0]) }}">{{ $product->badge }}</span>
                        @endif
                    </div>
                    <div class="home-prod-body">
                        <span class="home-prod-category">{{ $product->category ?: 'Produk' }}</span>
                        <h3 class="home-prod-name">{{ $product->name }}</h3>
                        @if($product->has_variants)
                            <span class="home-prod-price">{{ $product->effective_price }}</span>
                            <span class="home-prod-variant-label">Tersedia dalam beberapa varian</span>
                        @else
                            <span class="home-prod-price {{ $product->original_price ? 'has-discount' : '' }}">{{ $product->effective_price }}</span>
                            @if($product->original_price)
                            <span class="home-prod-original">{{ $product->original_price }}</span>
                            @endif
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="home-empty">
                <p>Belum ada produk unggulan.</p>
                <a href="{{ url('/product') }}" class="btn btn-primary">Lihat Semua Produk</a>
            </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         ④ LAYANAN KAMI — Horizontal scroll cards
         ═══════════════════════════════════════════════ --}}
    @if($services->count() > 0)
    <section class="home-services">
        <div class="container">
            <div class="home-section-header">
                <div>
                    <span class="section-label">Layanan</span>
                    <h2 class="section-title">Layanan Kami</h2>
                    <p class="section-subtitle">Solusi lengkap untuk kebutuhan kreatif bisnis Anda</p>
                </div>
                <a href="{{ url('/layanan') }}" class="home-section-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="home-service-scroll">
                @foreach($services as $service)
                <a href="{{ url('/layanan#' . $service->slug) }}" class="home-service-card">
                    <div class="home-service-icon">
                        <i class="{{ $service->icon ?? 'fas fa-cog' }}"></i>
                    </div>
                    <h3 class="home-service-name">{{ $service->name }}</h3>
                    <p class="home-service-desc">{{ Str::limit(strip_tags($service->description ?? ''), 80) }}</p>
                    <span class="home-service-link">Selengkapnya <i class="fas fa-arrow-right"></i></span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════
         ⑤ PROMO / RICH TEXT
         ═══════════════════════════════════════════════ --}}
    @if($content['rich_text']['is_visible'] ?? false)
    <section class="home-promo">
        <div class="container">
            <div class="promo-card">
                <div class="promo-card-glow"></div>
                <div class="promo-card-body">
                    <div class="promo-card-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    @if(!empty($content['rich_text']['title']))
                        <h2 class="promo-title">{{ $content['rich_text']['title'] }}</h2>
                    @endif
                    <div class="promo-content">
                        {!! $content['rich_text']['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════
         ⑥ CTA — WhatsApp
         ═══════════════════════════════════════════════ --}}
    <section class="home-cta">
        <div class="container">
            <div class="home-cta-card">
                <span class="section-label">Hubungi Kami</span>
                <h2 class="section-title">Siap Mewujudkan Ide Kreatif Anda?</h2>
                <p class="section-subtitle">Konsultasikan kebutuhan desain, cetak, atau software Anda secara gratis bersama tim {{ $settings['site_name'] ?? 'Ravaa Creative' }}.</p>
                <div class="home-cta-actions">
                    @if($settings['whatsapp'] ?? null)
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                    @endif
                    <a href="{{ url('/contact') }}" class="btn btn-outline btn-lg">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
@endsection
