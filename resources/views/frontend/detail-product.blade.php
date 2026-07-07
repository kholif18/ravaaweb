@extends('frontend.layouts.master')

@section('title', $product->name)

@section('meta_desc', $product->description)

@section('content')

@php
$highlights = [
    'Baru' => 'Produk Terbaru',
    'Diskon 15%' => 'Harga Spesial',
    'Terlaris' => 'Best Seller',
    'Popular' => 'Paling Diminati',
];
$badgeText = $product->badge ?? '';
$highlightLabel = $highlights[$badgeText] ?? null;

$features = $product->type === 'service'
    ? ['Konsultasi Gratis', 'Desain Custom', 'Revisi Unlimited', 'File Siap Pakai', 'Garansi Kepuasan']
    : ['Kualitas Premium', 'Harga Terjangkau', 'Pengiriman Cepat', 'Garansi 100%'];

$allFeatures = $product->type === 'service'
    ? [
        ['label' => 'Konsultasi Awal', 'desc' => 'Diskusi kebutuhan untuk hasil yang tepat sasaran.'],
        ['label' => 'Desain Custom', 'desc' => 'Desain eksklusif sesuai brand & preferensi Anda.'],
        ['label' => 'Revisi Unlimited', 'desc' => 'Bebas revisi sampai benar-benar puas.'],
        ['label' => 'File Siap Pakai', 'desc' => 'Output siap cetak/unggah dalam berbagai format.'],
        ['label' => 'Garansi Kepuasan', 'desc' => '100% puas atau kami revisi sampai sesuai.'],
    ]
    : [
        ['label' => 'Bahan Premium', 'desc' => 'Menggunakan material berkualitas tinggi dan tahan lama.'],
        ['label' => 'Cetak Tajam', 'desc' => 'Hasil cetak dengan resolusi tinggi dan warna akurat.'],
        ['label' => 'Pengiriman Cepat', 'desc' => 'Diproses cepat dan dikirim via ekspedisi terpercaya.'],
        ['label' => 'Garansi 100%', 'desc' => 'Garansi kualitas atau uang kembali dalam 7 hari.'],
    ];
@endphp

<section class="section" style="padding-top:30px;">
  <div class="container">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">Home</a>
      <span class="breadcrumb-sep">›</span>
      <a href="{{ url('/product') }}">Katalog</a>
      <span class="breadcrumb-sep">›</span>
      <a href="{{ url('/product?category=' . urlencode($product->category)) }}">{{ $product->category }}</a>
      <span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current">{{ $product->name }}</span>
    </nav>

    {{-- Product Detail Grid --}}
    <div class="detail-layout">
      {{-- Left: Image Gallery --}}
      <div class="detail-gallery">
        <div class="detail-main-img" id="detailMainImg">
          <img src="{{ $product->image }}" alt="{{ $product->name }}">
          @if(!empty($product->badge))
            <span class="prod-card-badge badge-{{ strtolower(explode(' ', $product->badge)[0]) }}">{{ $product->badge }}</span>
          @endif
        </div>
        <div class="detail-thumbs" id="galleryThumbs">
          <div class="detail-thumb active" data-src="{{ $product->image }}">
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
          </div>
          <div class="detail-thumb" data-src="https://images.unsplash.com/photo-1545235617-9465d2a55698?w=800&q=80">
            <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?w=200&q=60" alt="Thumbnail">
          </div>
          <div class="detail-thumb" data-src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&q=80">
            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200&q=60" alt="Thumbnail">
          </div>
          <div class="detail-thumb" data-src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80">
            <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=200&q=60" alt="Thumbnail">
          </div>
        </div>
      </div>

      {{-- Right: Product Info --}}
      <div class="detail-panel">
        <span class="detail-category">{{ $product->category }}</span>
        <h1>{{ $product->name }}</h1>

        {{-- Price --}}
        <div class="detail-price">
          {{ $product->price }}
          @if(!empty($product->original_price))
            <span class="original-price">{{ $product->original_price }}</span>
            <span class="discount-badge">Hemat sampai 15%</span>
          @endif
        </div>

        {{-- Stock --}}
        <div class="detail-stock">
          <span class="stock-dot"></span>
          <span>Stok tersedia</span>
          <span class="dimm">— Pesan sekarang, siap dalam 2-3 hari</span>
        </div>

        {{-- Highlights --}}
        @if($highlightLabel)
        <div class="detail-highlight">
          <i class="fas fa-medal"></i>
          <span>{{ $highlightLabel }}</span>
        </div>
        @endif

        {{-- Feature Chips --}}
        <div class="detail-chips">
          @foreach($features as $feature)
            <span class="chip">{{ $feature }}</span>
          @endforeach
        </div>

        {{-- Variant: Warna --}}
        <div class="detail-variants">
          <div class="variant-group">
            <span class="variant-label">Warna:</span>
            <div class="variant-options">
              <button class="variant-btn active" style="background:#1D1D1F" title="Hitam"></button>
              <button class="variant-btn" style="background:#FFFFFF;border-color:#D4D4D8;" title="Putih"></button>
              <button class="variant-btn" style="background:#2563EB" title="Biru"></button>
              <button class="variant-btn" style="background:#DC2626" title="Merah"></button>
            </div>
          </div>
          <div class="variant-group">
            <span class="variant-label">Ukuran:</span>
            <div class="variant-options">
              <button class="variant-btn variant-text active">S</button>
              <button class="variant-btn variant-text">M</button>
              <button class="variant-btn variant-text">L</button>
              <button class="variant-btn variant-text">XL</button>
            </div>
          </div>
        </div>

        {{-- Info Grid --}}
        <div class="detail-info-grid">
          <div class="info-item">
            <span class="info-label">Tipe</span>
            <span class="info-value">{{ ucfirst($product->type) }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Kategori</span>
            <span class="info-value">{{ $product->category }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Estimasi</span>
            <span class="info-value">2-3 Hari</span>
          </div>
          <div class="info-item">
            <span class="info-label">Min. Pesan</span>
            <span class="info-value">1 Item</span>
          </div>
        </div>

        {{-- CTAs --}}
        <div class="detail-ctas">
          @if($settings['whatsapp'] ?? null)
          <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya tertarik dengan produk ' . $product->name) }}"
             class="btn btn-whatsapp btn-lg" target="_blank">
            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
          </a>
          @endif
          <a href="{{ url('/product') }}" class="btn btn-outline btn-lg">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        {{-- Share --}}
        <div class="detail-share">
          <span>Bagikan:</span>
          <a href="https://wa.me/?text={{ urlencode('Lihat produk ini: ' . $product->name . ' - ' . url()->current()) }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
          <a href="#" onclick="navigator.clipboard?.writeText(window.location.href);alert('Link disalin!');return false;"><i class="fas fa-link"></i></a>
        </div>
      </div>
    </div>

    {{-- Tab: Deskripsi & Fitur --}}
    <div class="detail-tabs">
      <div class="tabs-header">
        <button class="tab-btn active" data-tab="desc">Deskripsi</button>
        <button class="tab-btn" data-tab="features">Fitur</button>
      </div>
      <div class="tab-panel active" id="tab-desc">
        <p>{{ $product->description }}</p>
        <p style="margin-top:16px;">Kami menggunakan bahan-bahan berkualitas tinggi dan teknologi terkini untuk memastikan setiap produk yang kami hasilkan memenuhi standar terbaik. Setiap tahap produksi melalui quality control ketat sehingga Anda mendapatkan hasil yang memuaskan.</p>
        <p style="margin-top:12px;">Ravaa Creative berkomitmen untuk memberikan solusi kreatif terbaik bagi bisnis dan kebutuhan personal Anda. Dengan pengalaman bertahun-tahun di industri kreatif dan teknologi, kami siap membantu mewujudkan ide Anda menjadi kenyataan.</p>
      </div>
      <div class="tab-panel" id="tab-features">
        <div class="features-grid">
          @foreach($allFeatures as $f)
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <div>
              <strong>{{ $f['label'] }}</strong>
              <p>{{ $f['desc'] }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Related Products --}}
    @if(count($relatedProducts) > 0)
    <div style="margin-top:64px;">
      <div class="detail-section-title" style="margin-bottom:24px;">Produk Terkait</div>
      <div class="product-grid">
        @foreach($relatedProducts as $rp)
        <a href="{{ url('/product/'.$rp->slug) }}" class="prod-card" style="text-decoration:none;color:inherit;">
          <div style="position:relative;">
            <img src="{{ $rp->image }}" class="prod-card-img" alt="{{ $rp->name }}">
            @if(!empty($rp->badge))
              <span class="prod-card-badge badge-{{ strtolower(explode(' ', $rp->badge)[0]) }}">{{ $rp->badge }}</span>
            @endif
          </div>
          <div class="prod-card-body">
            <div class="prod-card-category">{{ $rp->category }}</div>
            <div class="prod-card-title">{{ $rp->name }}</div>
            <div class="prod-card-price">{{ $rp->price }}</div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>
@endsection
