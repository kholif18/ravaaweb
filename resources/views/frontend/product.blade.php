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
                    <div class="category-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <h3>Semua Produk</h3>
                    <div class="category-count">48 produk</div>
                </div>
                
                <div class="category-card" data-category="design">
                    <div class="category-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Desain Grafis</h3>
                    <div class="category-count">12 produk</div>
                </div>
                
                <div class="category-card" data-category="printing">
                    <div class="category-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3>Percetakan</h3>
                    <div class="category-count">18 produk</div>
                </div>
                
                <div class="category-card" data-category="atk">
                    <div class="category-icon">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <h3>ATK & Perlengkapan</h3>
                    <div class="category-count">10 produk</div>
                </div>
                
                <div class="category-card" data-category="merchandise">
                    <div class="category-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3>Sablon & Merchandise</h3>
                    <div class="category-count">6 produk</div>
                </div>
                
                <div class="category-card" data-category="digital">
                    <div class="category-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Digital Printing</h3>
                    <div class="category-count">8 produk</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-grid-section">
        <div class="container">
            <div class="products-header">
                <div>
                    <h3>Semua Produk <span class="product-count">(48 produk)</span></h3>
                </div>
                                
                <div class="view-options">
                    <div class="sort-options">
                        <span style="margin-right: 10px;">Tampilan:</span>
                        <button class="view-btn active" data-view="grid">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="view-btn" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="products-grid" id="productsGrid">
                <!-- Produk 1 -->
                <div class="product-card" data-category="design" data-price="499000" data-name="Paket Desain Logo Profesional" data-popular="true">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Logo Profesional">
                        <span class="product-badge new">Baru</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Desain Grafis</div>
                        <h3 class="product-title">Paket Desain Logo Profesional</h3>
                        <div class="product-price">
                            <span class="price">Rp 499.000</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 2 -->
                <div class="product-card" data-category="printing" data-price="1200" data-name="Cetak Brosur A4 Full Color" data-popular="true">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Cetak Brosur">
                        <span class="product-badge discount">Diskon 15%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Percetakan</div>
                        <h3 class="product-title">Cetak Brosur A4 Full Color</h3>
                        <div class="product-price">
                            <span class="price">Rp 1.200/lembar</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 3 -->
                <div class="product-card" data-category="atk" data-price="25000" data-name="Notebook Custom Logo Perusahaan" data-popular="false">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Notebook Custom">
                    </div>
                    <div class="product-info">
                        <div class="product-category">ATK & Perlengkapan</div>
                        <h3 class="product-title">Notebook Custom Logo Perusahaan</h3>
                        <div class="product-price">
                            <span class="price">Rp 25.000/buku</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 4 -->
                <div class="product-card" data-category="merchandise" data-price="85000" data-name="Sablon Kaos Polo Custom" data-popular="true">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Sablon Kaos">
                        <span class="product-badge popular">Populer</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Sablon & Merchandise</div>
                        <h3 class="product-title">Sablon Kaos Polo Custom</h3>
                        <div class="product-price">
                            <span class="price">Rp 85.000/pcs</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 5 -->
                <div class="product-card" data-category="digital" data-price="45000" data-name="Stiker Vinyl Outdoor" data-popular="false">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Stiker Vinyl">
                        <span class="product-badge discount">Diskon 10%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Digital Printing</div>
                        <h3 class="product-title">Stiker Vinyl Outdoor</h3>
                        <div class="product-price">
                            <span class="price">Rp 45.000/m²</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 6 -->
                <div class="product-card" data-category="design" data-price="1299000" data-name="Paket Branding Lengkap" data-popular="false">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Paket Branding">
                    </div>
                    <div class="product-info">
                        <div class="product-category">Desain Grafis</div>
                        <h3 class="product-title">Paket Branding Lengkap</h3>
                        <div class="product-price">
                            <span class="price">Rp 1.299.000</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 7 -->
                <div class="product-card" data-category="printing" data-price="350000" data-name="Cetak Banner Flexi 3x1 Meter" data-popular="true">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Cetak Banner">
                        <span class="product-badge popular">Populer</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Percetakan</div>
                        <h3 class="product-title">Cetak Banner Flexi 3x1 Meter</h3>
                        <div class="product-price">
                            <span class="price">Rp 350.000</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 8 -->
                <div class="product-card" data-category="atk" data-price="1500" data-name="Amplop Custom Logo Perusahaan" data-popular="false">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Amplop Custom">
                        <span class="product-badge discount">Diskon 5%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">ATK & Perlengkapan</div>
                        <h3 class="product-title">Amplop Custom Logo Perusahaan</h3>
                        <div class="product-price">
                            <span class="price">Rp 1.500/buah</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ url('/detail-product') }}" class="btn-detail">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="page-item disabled">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item">4</div>
                <div class="page-item">5</div>
                <div class="page-item">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="container">
        <div class="promo-banner">
            <h2>Gratis Konsultasi Desain!</h2>
            <p>Dapatkan konsultasi desain gratis untuk 5 project pertama Anda. Hubungi kami sekarang untuk mendiskusikan kebutuhan kreatif bisnis Anda.</p>
            <a href="kontak.html" class="btn" style="background-color: white; color: #7209b7; margin-top: 15px;">Hubungi Sekarang</a>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const categoryCards = document.querySelectorAll('.category-card');
            const productsGrid  = document.getElementById('productsGrid');
            const productCards  = document.querySelectorAll('.product-card');
            const viewButtons   = document.querySelectorAll('.view-btn');

            /* ==========================
            FILTER KATEGORI (CARD)
            ========================== */
            categoryCards.forEach(card => {
                card.addEventListener('click', () => {

                    // active state category
                    categoryCards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');

                    const selectedCategory = card.dataset.category;

                    let visibleCount = 0;

                    productCards.forEach(product => {
                        const productCategory = product.dataset.category;

                        if (
                            selectedCategory === 'all' ||
                            productCategory === selectedCategory
                        ) {
                            product.style.display = 'block';
                            visibleCount++;
                        } else {
                            product.style.display = 'none';
                        }
                    });

                    // update jumlah produk
                    const countEl = document.querySelector('.product-count');
                    if (countEl) {
                        countEl.textContent = `(${visibleCount} produk)`;
                    }
                });
            });

            /* ==========================
            TOGGLE GRID / LIST VIEW
            ========================== */
            viewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const view = button.dataset.view;

                    viewButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    productsGrid.classList.toggle('list-view', view === 'list');

                    productCards.forEach(card => {
                        card.classList.toggle('list-view', view === 'list');
                    });
                });
            });

        });
    </script>

@endsection