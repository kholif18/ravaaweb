@extends('frontend.layouts.master')

@section('title', $product->name)

@section('meta_desc', strip_tags($product->short_description ?? $product->description ?? ''))

@section('content')

<section class="section" style="padding-top:30px;">
  <div class="container">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">Home</a>
      <span class="breadcrumb-sep">›</span>
      <a href="{{ url('/product') }}">Katalog</a>
      <span class="breadcrumb-sep">›</span>
      @if($product->category)
      <a href="{{ url('/product?category=' . urlencode($product->category->slug)) }}">{{ $product->category->name }}</a>
      <span class="breadcrumb-sep">›</span>
      @endif
      <span class="breadcrumb-current">{{ $product->name }}</span>
    </nav>

    {{-- Product Detail Grid --}}
    <div class="detail-layout">
      {{-- Left: Image Gallery --}}
      <div class="detail-gallery">
        <div class="detail-main-img" id="detailMainImg">
          <img src="{{ $mainImage }}" alt="{{ $product->name }}" id="mainProductImage" data-default="{{ $mainImage }}">
          @if($badge)
            <span class="prod-card-badge badge-{{ $badgeType }}">{{ $badge }}</span>
          @endif
        </div>
        @if(count($galleryImages) > 1)
        <div class="detail-thumbs" id="galleryThumbs">
          @foreach($galleryImages as $index => $img)
          <div class="detail-thumb {{ $loop->first ? 'active' : '' }}" data-src="{{ $img['url'] }}" onclick="changeMainImage('{{ $img['url'] }}', this)">
            <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}">
          </div>
          @endforeach
        </div>
        @endif
      </div>

      {{-- Right: Product Info --}}
      <div class="detail-panel">
        @if($product->category)
        <span class="detail-category">{{ $product->category->name }}</span>
        @endif
        <h1>{{ $product->name }}</h1>

        {{-- Price --}}
        <div class="detail-price" id="detailPriceContainer">
          <span id="detailMainPrice" data-default="{{ $priceDisplay }}">{{ $priceDisplay }}</span>
          @if($originalPrice)
            <span id="detailOriginalPrice" class="original-price" data-default="{{ $originalPrice }}">{{ $originalPrice }}</span>
            @if($product->discount_percent > 0)
            <span id="detailDiscountBadge" class="discount-badge" data-default="Hemat {{ round($product->discount_percent) }}%">Hemat {{ round($product->discount_percent) }}%</span>
            @endif
          @else
            <span id="detailOriginalPrice" class="original-price d-none" data-default=""></span>
            <span id="detailDiscountBadge" class="discount-badge d-none" data-default=""></span>
          @endif
        </div>

        {{-- Stock --}}
        <div class="detail-stock" id="detailStockContainer">
          @if($inStock)
            <span class="stock-dot" style="background:#22c55e;" id="detailStockDot" data-default="#22c55e"></span>
            <span id="detailStockStatus" data-default="Stok tersedia">Stok tersedia</span>
            @if($product->is_service)
              <span class="dimm" id="detailStockInfo" data-default="— Layanan digital">— Layanan digital</span>
            @else
              <span class="dimm" id="detailStockInfo" data-default="— {{ $totalStock }} item tersisa">— {{ $totalStock }} item tersisa</span>
            @endif
          @else
            <span class="stock-dot" style="background:#ef4444;" id="detailStockDot" data-default="#ef4444"></span>
            <span style="color:#ef4444;" id="detailStockStatus" data-default="Stok habis">Stok habis</span>
            <span class="dimm d-none" id="detailStockInfo" data-default=""></span>
          @endif
        </div>

        {{-- Highlights --}}
        @if($badge)
        <div class="detail-highlight">
          <i class="fas fa-medal"></i>
          <span>{{ $badge }}</span>
        </div>
        @endif

        {{-- Feature Chips from product features --}}
        @if(count($features) > 0)
        <div class="detail-chips">
          @foreach(array_slice($features, 0, 5) as $feature)
            <span class="chip">{{ is_array($feature) ? ($feature['title'] ?? $feature['value'] ?? '') : $feature }}</span>
          @endforeach
        </div>
        @endif

        {{-- Variant Selection --}}
        @if(count($variantTypes) > 0)
        <div class="detail-variants">
          @foreach($variantTypes as $typeName => $values)
          <div class="variant-group">
            <span class="variant-label">{{ $typeName }}:</span>
            <div class="variant-options">
              @foreach($values as $value)
                <button class="variant-btn variant-text" data-type="{{ $typeName }}" data-value="{{ $value }}" onclick="selectVariant(this)">{{ $value }}</button>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
        @endif

        {{-- Info Grid --}}
        <div class="detail-info-grid">
          <div class="info-item">
            <span class="info-label">Tipe</span>
            <span class="info-value">{{ $product->is_service ? 'Layanan' : 'Produk' }}</span>
          </div>
          @if($product->category)
          <div class="info-item">
            <span class="info-label">Kategori</span>
            <span class="info-value">{{ $product->category->name }}</span>
          </div>
          @endif
          @if($product->sku)
          <div class="info-item">
            <span class="info-label">SKU</span>
            <span class="info-value">{{ $product->sku }}</span>
          </div>
          @endif
          @if($product->weight)
          <div class="info-item">
            <span class="info-label">Berat</span>
            <span class="info-value">{{ $product->weight }}</span>
          </div>
          @endif
        </div>

        {{-- CTAs --}}
        <div class="detail-ctas">
          @if($settings['whatsapp'] ?? null)
          @php
            $defaultWaUrl = 'https://wa.me/' . $settings['whatsapp'] . '?text=' . urlencode($settings['whatsapp_message'] ?? 'Halo, saya tertarik dengan produk ' . $product->name);
          @endphp
          <a href="{{ $defaultWaUrl }}"
             class="btn btn-whatsapp btn-lg" target="_blank" id="btnWhatsappCTA"
             data-default="{{ $defaultWaUrl }}">
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
        @if(count($features) > 0)
        <button class="tab-btn" data-tab="features">Fitur</button>
        @endif
      </div>
      <div class="tab-panel active" id="tab-desc">
        {!! $product->description !!}
        @if(!$product->description && $product->short_description)
        <p>{{ $product->short_description }}</p>
        @endif
      </div>
      @if(count($features) > 0)
      <div class="tab-panel" id="tab-features">
        <div class="features-grid">
          @foreach($features as $feature)
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <div>
              @if(is_array($feature))
                <strong>{{ $feature['title'] ?? '' }}</strong>
                <p>{{ $feature['value'] ?? '' }}</p>
              @else
                <strong>{{ $feature }}</strong>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
    <div style="margin-top:64px;">
      <div class="detail-section-title" style="margin-bottom:24px;">Produk Terkait</div>
      <div class="product-grid">
        @foreach($relatedProducts as $rp)
        <a href="{{ url('/product/'.$rp->slug) }}" class="prod-card" style="text-decoration:none;color:inherit;">
          <div style="position:relative;">
            <img src="{{ $rp->image }}" class="prod-card-img" alt="{{ $rp->name }}" loading="lazy">
            @if(!empty($rp->badge))
              <span class="prod-card-badge badge-{{ strtolower(explode(' ', $rp->badge)[0]) }}">{{ $rp->badge }}</span>
            @endif
          </div>
          <div class="prod-card-body">
            <div class="prod-card-category">{{ $rp->category }}</div>
            <div class="prod-card-title">{{ $rp->name }}</div>
            <div class="prod-card-price">{{ $rp->effective_price }}</div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>

  <script id="product-variants-json" type="application/json">
    {!! json_encode($variants->map(fn($v) => [
        'id' => $v->id,
        'attributes' => $v->attributes,
        'price' => (float) $v->price,
        'price_formatted' => 'Rp ' . number_format((float) $v->price, 0, ',', '.'),
        'price_discount' => $v->price_discount ? (float) $v->price_discount : null,
        'price_discount_formatted' => $v->price_discount ? 'Rp ' . number_format((float) $v->price_discount, 0, ',', '.') : null,
        'effective_price' => (float) $v->effective_price,
        'effective_price_formatted' => 'Rp ' . number_format((float) $v->effective_price, 0, ',', '.'),
        'discount_active' => $v->discount_active,
        'discount_percent' => $v->discount_percent ? round($v->discount_percent) : null,
        'stock' => (int) $v->stock,
        'is_service' => (bool) $v->is_service,
        'image_url' => $v->image_url,
    ])) !!}
  </script>
</section>
@endsection

@push('scripts')
<script>
function changeMainImage(src, thumbEl) {
    document.getElementById('mainProductImage').src = src;
    document.querySelectorAll('.detail-thumb').forEach(t => t.classList.remove('active'));
    if (thumbEl) thumbEl.classList.add('active');
}

function selectVariant(btn) {
    const group = btn.closest('.variant-group');
    if (btn.classList.contains('active')) {
        btn.classList.remove('active');
    } else {
        group.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }
    
    // Trigger update selected variant
    updateSelectedVariant();
}

function updateSelectedVariant() {
    const variantsEl = document.getElementById('product-variants-json');
    if (!variantsEl) return;
    
    let variants = [];
    try {
        variants = JSON.parse(variantsEl.textContent);
    } catch (e) {
        console.error('Error parsing variants JSON:', e);
        return;
    }
    
    const totalGroups = document.querySelectorAll('.variant-group').length;
    if (variants.length === 0 || totalGroups === 0) {
        return;
    }
    
    // Collect currently selected attributes
    const selectedAttributes = {};
    document.querySelectorAll('.variant-group').forEach(group => {
        const activeBtn = group.querySelector('.variant-btn.active');
        if (activeBtn) {
            const type = activeBtn.dataset.type;
            const value = activeBtn.dataset.value;
            selectedAttributes[type] = value;
        }
    });
    
    const selectedCount = Object.keys(selectedAttributes).length;
    
    const mainPriceEl = document.getElementById('detailMainPrice');
    const originalPriceEl = document.getElementById('detailOriginalPrice');
    const discountBadgeEl = document.getElementById('detailDiscountBadge');
    
    const stockDot = document.getElementById('detailStockDot');
    const stockStatus = document.getElementById('detailStockStatus');
    const stockInfo = document.getElementById('detailStockInfo');
    const btnWhatsapp = document.getElementById('btnWhatsappCTA');
    
    // Revert to default PHP values if selection is incomplete
    if (selectedCount < totalGroups) {
        if (mainPriceEl) mainPriceEl.textContent = mainPriceEl.dataset.default || "";
        
        if (originalPriceEl) {
            const defaultOrig = originalPriceEl.dataset.default || "";
            if (defaultOrig) {
                originalPriceEl.textContent = defaultOrig;
                originalPriceEl.classList.remove('d-none');
            } else {
                originalPriceEl.classList.add('d-none');
                originalPriceEl.textContent = '';
            }
        }
        
        if (discountBadgeEl) {
            const defaultBadge = discountBadgeEl.dataset.default || "";
            if (defaultBadge) {
                discountBadgeEl.textContent = defaultBadge;
                discountBadgeEl.classList.remove('d-none');
            } else {
                discountBadgeEl.classList.add('d-none');
                discountBadgeEl.textContent = '';
            }
        }
        
        if (stockDot) {
            stockDot.style.background = stockDot.dataset.default || '#22c55e';
        }
        
        if (stockStatus) {
            const defaultStatus = stockStatus.dataset.default || "Stok tersedia";
            stockStatus.textContent = defaultStatus;
            if (defaultStatus === 'Stok habis') {
                stockStatus.style.color = '#ef4444';
            } else {
                stockStatus.style.color = '';
            }
        }
        
        if (stockInfo) {
            const defaultInfo = stockInfo.dataset.default || "";
            if (defaultInfo) {
                stockInfo.textContent = defaultInfo;
                stockInfo.classList.remove('d-none');
            } else {
                stockInfo.classList.add('d-none');
                stockInfo.textContent = '';
            }
        }
        
        // Revert Image
        const mainProductImage = document.getElementById('mainProductImage');
        if (mainProductImage) {
            const defaultSrc = mainProductImage.dataset.default || "";
            if (defaultSrc) {
                mainProductImage.src = defaultSrc;
            }
            
            // Revert active thumbnail class to the first thumbnail
            document.querySelectorAll('#galleryThumbs .detail-thumb').forEach((thumb, idx) => {
                thumb.classList.toggle('active', idx === 0);
            });
        }
        
        // Revert WhatsApp Link
        if (btnWhatsapp) {
            btnWhatsapp.href = btnWhatsapp.dataset.default || "";
        }
        return;
    }
    
    // Find matching variant
    const matchedVariant = variants.find(v => {
        return Object.entries(selectedAttributes).every(([type, val]) => {
            return v.attributes[type] === val;
        });
    });
    
    if (matchedVariant) {
        // Update Price
        if (matchedVariant.discount_active && matchedVariant.price_discount_formatted) {
            mainPriceEl.textContent = matchedVariant.price_discount_formatted;
            originalPriceEl.textContent = matchedVariant.price_formatted;
            originalPriceEl.classList.remove('d-none');
            
            if (matchedVariant.discount_percent) {
                discountBadgeEl.textContent = `Hemat ${matchedVariant.discount_percent}%`;
                discountBadgeEl.classList.remove('d-none');
            } else {
                discountBadgeEl.classList.add('d-none');
            }
        } else {
            mainPriceEl.textContent = matchedVariant.price_formatted;
            originalPriceEl.classList.add('d-none');
            originalPriceEl.textContent = '';
            discountBadgeEl.classList.add('d-none');
            discountBadgeEl.textContent = '';
        }
        
        // Update Stock
        const isAvailable = matchedVariant.stock > 0 || matchedVariant.is_service;
        if (isAvailable) {
            if (stockDot) stockDot.style.background = '#22c55e';
            if (stockStatus) {
                stockStatus.textContent = 'Stok tersedia';
                stockStatus.style.color = '';
            }
            if (stockInfo) {
                if (matchedVariant.is_service) {
                    stockInfo.textContent = '— Layanan digital';
                    stockInfo.classList.remove('d-none');
                } else {
                    stockInfo.textContent = `— ${matchedVariant.stock} item tersisa`;
                    stockInfo.classList.remove('d-none');
                }
            }
        } else {
            if (stockDot) stockDot.style.background = '#ef4444';
            if (stockStatus) {
                stockStatus.textContent = 'Stok habis';
                stockStatus.style.color = '#ef4444';
            }
            if (stockInfo) {
                stockInfo.classList.add('d-none');
                stockInfo.textContent = '';
            }
        }
        
        // Update Image
        if (matchedVariant.image_url) {
            changeMainImage(matchedVariant.image_url, null);
            
            // Try to find if there is a matching thumbnail in gallery
            document.querySelectorAll('#galleryThumbs .detail-thumb').forEach(thumb => {
                if (thumb.dataset.src === matchedVariant.image_url) {
                    document.querySelectorAll('#galleryThumbs .detail-thumb').forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                }
            });
        }
        
        // Update WhatsApp CTA Message
        if (btnWhatsapp) {
            const baseText = "{{ $settings['whatsapp_message'] ?? 'Halo, saya tertarik dengan produk ' . $product->name }}";
            const attrList = Object.entries(selectedAttributes).map(([k, v]) => `${k}: ${v}`).join(', ');
            const newText = baseText + (attrList ? ` (${attrList})` : '');
            const phone = "{{ $settings['whatsapp'] ?? '' }}";
            btnWhatsapp.href = `https://wa.me/${phone}?text=${encodeURIComponent(newText)}`;
        }
    } else {
        if (mainPriceEl) mainPriceEl.textContent = 'Kombinasi tidak tersedia';
        if (originalPriceEl) originalPriceEl.classList.add('d-none');
        if (discountBadgeEl) discountBadgeEl.classList.add('d-none');
        if (stockDot) stockDot.style.background = '#ef4444';
        if (stockStatus) {
            stockStatus.textContent = 'Tidak tersedia';
            stockStatus.style.color = '#ef4444';
        }
        if (stockInfo) stockInfo.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tab-' + tabId).classList.add('active');
        });
    });

    // Run variant price updates on load
    updateSelectedVariant();
});
</script>
@endpush
