@extends('frontend.layouts.master')

@section('title', 'Produk Kami')

@section('content')
    <!-- Hero Section -->
    <section class="hero-products">
        <div class="container">
            <h1>Katalog Produk</h1>
            <p>Temukan berbagai produk desain, percetakan, dan alat tulis kantor berkualitas tinggi dari Ravaa Creative. Solusi lengkap untuk kebutuhan kreatif dan bisnis Anda.</p>
        </div>
    </section>

    <!-- Product Categories -->
    <section class="product-categories">
        <div class="container">
            <div class="section-title">
                <h2>Kategori Produk</h2>
            </div>
            <div class="category-grid">
                <div class="category-card active" data-category="all">
                    <div class="category-icon"><i class="fas fa-th-large"></i></div>
                    <h3>Semua Produk</h3>
                    <div class="category-count">{{ $products->total() }} produk</div>
                </div>
                @foreach($categories as $cat)
                <div class="category-card" data-category="{{ $cat->slug }}">
                    <div class="category-icon"><i class="{{ $cat->icon ?? 'fas fa-tags' }}"></i></div>
                    <h3>{{ $cat->name }}</h3>
                    <div class="category-count">{{ $cat->products()->count() }} produk</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-grid-section">
        <div class="container">
            <div class="products-header">
                <div>
                    <h3>Semua Produk <span class="product-count">({{ $products->total() }} produk)</span></h3>
                </div>
                <div class="view-options">
                    <div class="sort-options">
                        <span style="margin-right: 10px;">Tampilan:</span>
                        <button class="view-btn active" data-view="grid"><i class="fas fa-th-large"></i></button>
                        <button class="view-btn" data-view="list"><i class="fas fa-list"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="products-grid" id="productsGrid">
                @foreach($products as $product)
                <div class="product-card" 
                     data-category="{{ $product->category->slug ?? 'uncategorized' }}" 
                     data-price="{{ $product->selling_price }}" 
                     data-name="{{ $product->name }}" 
                     data-popular="{{ $product->is_featured ? 'true' : 'false' }}">
                    <div class="product-image">
                        @if($product->mainMedia)
                            <img src="{{ $product->mainMedia->url }}" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('storage/images/default-product.png') }}" alt="{{ $product->name }}">
                        @endif
                        @if($product->is_new_arrival)
                            <span class="product-badge new">Baru</span>
                        @endif
                        @if($product->hasActiveDiscount())
                            <span class="product-badge discount">Diskon {{ round((($product->price - $product->discount_price)/$product->price)*100) }}%</span>
                        @endif
                        @if($product->is_featured)
                            <span class="product-badge popular">Populer</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name ?? 'Tidak Ada' }}</div>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div class="product-price">
                            @if($product->hasActiveDiscount())
                                <span class="price">{{ $product->formatted_discount_price }}</span>
                                <span class="original-price" style="text-decoration: line-through;">{{ $product->formatted_price }}</span>
                            @else
                                <span class="price">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                        <div class="product-actions">
                            <a href="{{ route('detail-product', $product->slug) }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </section>

    <!-- Optional Promo Banner -->
    <section class="container">
        <div class="promo-banner">
            <h2>Gratis Konsultasi Desain!</h2>
            <p>Dapatkan konsultasi desain gratis untuk 5 project pertama Anda. Hubungi kami sekarang untuk mendiskusikan kebutuhan kreatif bisnis Anda.</p>
            <a href="{{ route('contact') }}" class="btn" style="background-color: white; color: #7209b7; margin-top: 15px;">Hubungi Sekarang</a>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categoryCards = document.querySelectorAll('.category-card');
            const productCards = document.querySelectorAll('.product-card');
            const viewButtons = document.querySelectorAll('.view-btn');
            const productCountEl = document.querySelector('.product-count');

            // Category filter
            categoryCards.forEach(card => {
                card.addEventListener('click', () => {
                    categoryCards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');
                    const selected = card.dataset.category;
                    let visible = 0;
                    productCards.forEach(p => {
                        const cat = p.dataset.category;
                        if (selected === 'all' || cat === selected) {
                            p.style.display = 'block';
                            visible++;
                        } else {
                            p.style.display = 'none';
                        }
                    });
                    if (productCountEl) productCountEl.textContent = `(${visible} produk)`;
                });
            });

            // View toggle
            viewButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const view = btn.dataset.view;
                    viewButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const grid = document.getElementById('productsGrid');
                    grid.classList.toggle('list-view', view === 'list');
                });
            });
        });
    </script>

@endsection