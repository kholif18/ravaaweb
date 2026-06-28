@extends('frontend.layouts.master')

@section('title', 'Home')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-eyebrow"><i class="fas fa-sparkle"></i> Desain Grafis &amp; Teknologi</div>
                <h1 class="hero-title">
                    Solusi Kreatif untuk<br>Bisnis &amp; Kebutuhan Anda<br>
                    <em>Desain Grafis</em>
                </h1>
                <p class="hero-subtitle">Desain grafis modern, cetak berkualitas, dan perlengkapan ATK lengkap. Nikmati diskon spesial + free konsultasi!</p>
                <div class="hero-actions">
                    <a href="{{ url('/product') }}" class="btn btn-primary btn-lg">Lihat Katalog</a>
                    <a href="https://wa.me/6282233377661?text=Halo%20Ravaa%20Creative,%20saya%20ingin%20konsultasi%20terkait%20desain%20/%20cetak." class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ravaa Creative" class="hero-visual-img">
                <div class="hero-badge">
                    <i class="fas fa-tag"></i> Paket Desain Logo + Stationery mulai Rp399k
                </div>
            </div>
        </div>
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
                                <a href="https://wa.me/6282233377661?text=Halo%20Ravaa%20Creative,%20saya%20tertarik%20dengan%20{{ urlencode($product->name) }}" class="btn btn-whatsapp btn-sm" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
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
                <p class="section-subtitle" style="margin:0 auto 32px;max-width:500px;">Konsultasikan kebutuhan desain, cetak, atau software Anda secara gratis bersama tim Ravaa Creative.</p>
                <div class="hero-actions" style="justify-content:center;">
                    <a href="https://wa.me/6282233377661" class="btn btn-whatsapp btn-lg" target="_blank"><i class="fab fa-whatsapp"></i> Konsultasi Gratis</a>
                    <a href="{{ url('/contact') }}" class="btn btn-outline btn-lg">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
@endsection
