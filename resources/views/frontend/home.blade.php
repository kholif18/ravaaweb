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
                            @if($settings['whatsapp'])
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
                    @if($settings['whatsapp'])
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya ingin konsultasi.') }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                    @endif
                </div>
            </div>
            <div class="hero-visual">
                @if($settings['hero_image'])
                    <img src="{{ $settings['hero_image'] }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" class="hero-visual-img">
                @else
                    <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" class="hero-visual-img">
                @endif
                @if($settings['hero_badge'])
                <div class="hero-badge">
                    <i class="fas fa-tag"></i> {{ $settings['hero_badge'] }}
                </div>
                @endif
            </div>
        </div>
        @endif
    </section>

    <section class="section fade-up">
        <div class="container">
            <span class="section-label">Layanan</span>
            <h2 class="section-title">Kategori Layanan</h2>
            <p class="section-subtitle">Solusi lengkap untuk kebutuhan kreatif bisnis Anda</p>
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
                <h2 class="section-title">Produk Unggulan</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Temukan produk terbaik pilihan untuk kebutuhan Anda</p>
            </div>
            <div class="product-grid">
                @foreach($products as $product)
                    @if($loop->iteration > 4) @break @endif
                    <div class="prod-card">
                        <div style="position:relative;">
                            <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $product->name }}" class="prod-card-img">
                            @if($product->badge ?? null)
                            <span class="prod-card-badge badge-{{ strtolower(explode(' ', $product->badge)[0]) }}">{{ $product->badge }}</span>
                            @endif
                        </div>
                        <div class="prod-card-body">
                            <div class="prod-card-category">{{ $product->category ?? 'Produk' }}</div>
                            <h3 class="prod-card-title">{{ $product->name }}</h3>
                            <div class="prod-card-price">{{ $product->price }}</div>
                            <div class="prod-card-actions">
                                <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-primary btn-sm">Detail</a>
                                @if($settings['whatsapp'])
                                <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya tertarik dengan ' . $product->name) }}" class="btn btn-whatsapp btn-sm" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="glass-card" style="padding:48px;text-align:center;">
                <span class="section-label">Hubungi Kami</span>
                <h2 class="section-title" style="max-width:600px;margin:0 auto 12px;">Siap Mewujudkan Ide Kreatif Anda?</h2>
                <p class="section-subtitle" style="margin:0 auto 32px;max-width:500px;">Konsultasikan kebutuhan desain, cetak, atau software Anda secara gratis bersama tim {{ $settings['site_name'] ?? 'Ravaa Creative' }}.</p>
                <div class="hero-actions" style="justify-content:center;">
                    @if($settings['whatsapp'])
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                    @endif
                    <a href="{{ url('/contact') }}" class="btn btn-outline btn-lg">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .hero-slider { position: relative; overflow: hidden; }
    .hero-slide { display: none; animation: fadeIn 0.5s ease; }
    .hero-slide.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .hero-nav { position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); display: flex; align-items: center; gap: 12px; z-index: 10; }
    .hero-nav-btn { width: 36px; height: 36px; border-radius: 50%; border: none; background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); color: #fff; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
    .hero-nav-btn:hover { background: rgba(255,255,255,0.35); }
    .hero-dots { display: flex; gap: 8px; }
    .hero-dot { width: 8px; height: 8px; border-radius: 50%; border: none; background: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s; padding: 0; }
    .hero-dot.active { background: #fff; width: 24px; border-radius: 4px; }
</style>
@endpush

@push('scripts')
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.hero-dot');
let slideInterval;

function goToSlide(index) {
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    currentSlide = index;
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
    resetInterval();
}

function changeSlide(dir) {
    let next = currentSlide + dir;
    if (next >= slides.length) next = 0;
    if (next < 0) next = slides.length - 1;
    goToSlide(next);
}

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(() => changeSlide(1), 5000);
}

if (slides.length > 1) {
    resetInterval();
}
</script>
@endpush
