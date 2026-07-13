@extends('frontend.layouts.master')

@section('title', $settings['site_name'] ?? 'Home')

@section('content')
    <section class="hero">
        @if($banners->count() > 0)
        <div class="hero-slider" id="heroSlider">
            @foreach($banners as $banner)
            <div class="hero-slide {{ $loop->first ? 'active' : '' }}" data-slide="{{ $loop->index }}">
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-eyebrow"><i class="fas fa-sparkle"></i> {{ $settings['site_name'] ?? 'Ravaa Creative' }}</div>
                        <h1 class="hero-title">{!! $banner->title !!}</h1>
                        @if($banner->subtitle)
                        <p class="hero-subtitle">{{ $banner->subtitle }}</p>
                        @endif
                        <div class="hero-actions">
                            @if($banner->cta_text && $banner->cta_url)
                            <a href="{{ $banner->cta_url }}" class="btn btn-primary btn-lg">{{ $banner->cta_text }}</a>
                            @endif
                            @if($settings['whatsapp'] ?? null)
                            <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya ingin konsultasi.') }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                            @endif
                        </div>
                    </div>
                    <div class="hero-visual">
                        @if($banner->image)
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="hero-visual-img">
                        @else
                            <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" class="hero-visual-img">
                        @endif
                        @if($banner->badge)
                        <div class="hero-badge">
                            <i class="fas fa-tag"></i> {{ $banner->badge }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @if($banners->count() > 1)
            <div class="hero-nav">
                <button class="hero-nav-btn" onclick="changeSlide(-1)"><i class="bi bi-chevron-left"></i></button>
                <div class="hero-dots">
                    @foreach($banners as $banner)
                    <button class="hero-dot {{ $loop->first ? 'active' : '' }}" onclick="goToSlide({{ $loop->index }})"></button>
                    @endforeach
                </div>
                <button class="hero-nav-btn" onclick="changeSlide(1)"><i class="bi bi-chevron-right"></i></button>
            </div>
            @endif
            </div>
        </div>
        @else
        <div class="container">
            <div class="hero-content">
                <div class="hero-eyebrow"><i class="fas fa-sparkle"></i> Desain Grafis &amp; Teknologi</div>
                <h1 class="hero-title">
                    {!! $settings['hero_title'] ?? 'Solusi Kreatif untuk<br>Bisnis &amp; Kebutuhan Anda<br><em>Desain Grafis</em>' !!}
                </h1>
                <p class="hero-subtitle">{{ $settings['hero_subtitle'] ?? $settings['site_description'] ?? 'Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap.' }}</p>
                <div class="hero-actions">
                    <a href="{{ $settings['hero_cta_url'] ?? url('/product') }}" class="btn btn-primary btn-lg">{{ $settings['hero_cta_text'] ?? 'Lihat Katalog' }}</a>
                    @if($settings['whatsapp'] ?? null)
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya ingin konsultasi.') }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                    @endif
                </div>
            </div>
            <div class="hero-visual">
                @if($settings['hero_image'] ?? null)
                    <img src="{{ $settings['hero_image'] }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" class="hero-visual-img">
                @else
                    <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" class="hero-visual-img">
                @endif
                @if($settings['hero_badge'] ?? null)
                <div class="hero-badge">
                    <i class="fas fa-tag"></i> {{ $settings['hero_badge'] ?? '' }}
                </div>
                @endif
            </div>
        </div>
        @endif
    </section>

    <section class="section fade-up">
        <div class="container">
            <span class="section-label">Layanan</span>
            <h2 class="section-title">{{ $content['categories']['title'] ?? 'Kategori Layanan' }}</h2>
            <p class="section-subtitle">{{ $content['categories']['subtitle'] ?? 'Solusi lengkap untuk kebutuhan kreatif bisnis Anda' }}</p>
            <div class="category-grid">
                @foreach($categories as $cat)
                <a href="{{ url('/product?category=' . $cat->slug) }}" class="cat-card">
                    <div class="cat-card-icon">
                        <i class="{{ $cat->icon ?? 'fas fa-tags' }}"></i>
                    </div>
                    <h3>{{ $cat->name }}</h3>
                    <p>{{ $cat->description }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="text-center">
                <span class="section-label">Koleksi</span>
                <h2 class="section-title">{{ $content['products']['title'] ?? 'Produk Unggulan' }}</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">{{ $content['products']['subtitle'] ?? 'Temukan produk terbaik pilihan untuk kebutuhan Anda' }}</p>
            </div>
            @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="prod-card" onclick="if(!event.target.closest('.prod-card-actions')){ window.location='{{ url('/product/' . $product->slug) }}' }" style="cursor:pointer;">
                        <div style="position:relative;">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="prod-card-img" loading="lazy">
                            @if(!empty($product->badge))
                            <span class="prod-card-badge badge-{{ strtolower(explode(' ', $product->badge)[0]) }}">{{ $product->badge }}</span>
                            @endif
                        </div>
                        <div class="prod-card-body">
                            <div class="prod-card-category">{{ $product->category ?: 'Produk' }}</div>
                            <h3 class="prod-card-title">{{ $product->name }}</h3>
                            <div class="prod-card-price">
                                {{ $product->effective_price }}
                                @if($product->original_price)
                                    <span class="original">{{ $product->original_price }}</span>
                                @endif
                            </div>
                            <div class="prod-card-actions">
                                <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-primary btn-sm">Detail</a>
                                @if($settings['whatsapp'] ?? null)
                                <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya tertarik dengan ' . $product->name) }}" class="btn btn-whatsapp btn-sm" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <p class="text-muted">Belum ada produk ungulan.</p>
                <a href="{{ url('/product') }}" class="btn btn-primary">Lihat Semua Produk</a>
            </div>
            @endif
            <div class="text-center mt-4">
                <a href="{{ url('/product') }}" class="btn btn-outline btn-lg">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    @if($content['rich_text']['is_visible'] ?? false)
    <section class="section fade-up">
        <div class="container">
            <div class="glass-card" style="padding:48px;">
                @if(!empty($content['rich_text']['title']))
                    <span class="section-label" style="margin-left: 0; margin-right: auto; text-align: left; display: block;">Informasi</span>
                    <h2 class="section-title" style="margin-left: 0; margin-right: auto; text-align: left; max-width: 100%; margin-bottom: 24px;">{{ $content['rich_text']['title'] }}</h2>
                @endif
                <div class="rich-text-content" style="color: var(--text-muted); line-height: 1.8;">
                    {!! $content['rich_text']['content'] !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="section fade-up">
        <div class="container">
            <div class="glass-card" style="padding:48px;text-align:center;">
                <span class="section-label">Hubungi Kami</span>
                <h2 class="section-title" style="max-width:600px;margin:0 auto 12px;">Siap Mewujudkan Ide Kreatif Anda?</h2>
                <p class="section-subtitle" style="margin:0 auto 32px;max-width:500px;">Konsultasikan kebutuhan desain, cetak, atau software Anda secara gratis bersama tim {{ $settings['site_name'] ?? 'Ravaa Creative' }}.</p>
                <div class="hero-actions" style="justify-content:center;">
                    @if($settings['whatsapp'] ?? null)
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                    @endif
                    <a href="{{ url('/contact') }}" class="btn btn-outline btn-lg">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
@endsection



