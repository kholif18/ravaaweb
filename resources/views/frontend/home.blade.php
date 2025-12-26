@extends('frontend.layouts.master')

@section('title', 'Home')

@section('content')
    <!-- Banner -->
    <section class="banner">
        <div class="container banner-content">
            <div class="banner-text">
                <h1>Solusi Kreatif untuk Desain, Print & ATK Anda</h1>
                <p>Ravaa Creative menyediakan layanan desain grafis, percetakan, dan alat tulis kantor berkualitas tinggi dengan harga kompetitif. Hasil kreatif yang memukau untuk kebutuhan bisnis Anda.</p>
                <a href="{{ url('/layanan') }}" class="btn">Lihat Layanan</a>
                <a href="{{ url('/portofolio') }}" class="btn btn-outline">Portfolio Kami</a>
            </div>
            <div class="banner-image">
                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Kreatif">
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Kami</h2>
            </div>
            
            <div class="category-grid">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Desain Grafis</h3>
                    <p>Logo, brosur, banner, kartu nama, dan desain kreatif lainnya untuk bisnis Anda.</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3>Percetakan</h3>
                    <p>Cetak offset dan digital dengan kualitas tinggi untuk segala kebutuhan percetakan.</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <h3>Alat Tulis Kantor</h3>
                    <p>Berbagai kebutuhan ATK dengan kualitas terbaik untuk mendukung produktivitas.</p>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3>Sablon & Merchandise</h3>
                    <p>Sablon kaos, mug, tumbler, dan merchandise custom untuk branding perusahaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="container">
        <div class="promo-banner">
            <h2>Promo Spesial Bulan Ini!</h2>
            <p>Dapatkan diskon 20% untuk semua layanan desain dan 15% untuk produk percetakan.</p>
            <p>Gunakan kode promo:</p>
            <div class="promo-code">RAVAA20</div>
            <p>Promo berlaku hingga 30 November 2023</p>
        </div>
    </section>

    <!-- Products -->
    <section class="products">
        <div class="container">
            <div class="section-title">
                <h2>Produk & Layanan Terbaru</h2>
            </div>
            
            <div class="product-tabs">
                <button class="tab-btn active" data-tab="new">Produk Terbaru</button>
                <button class="tab-btn" data-tab="discount">Sedang Diskon</button>
                <button class="tab-btn" data-tab="popular">Paling Laris</button>
            </div>
            
            <div class="product-grid" id="new-products">
                <!-- Produk 1 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Logo Profesional">
                        <span class="product-badge">Baru</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Desain Grafis</div>
                        <h3 class="product-title">Paket Desain Logo Profesional</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 499.000</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 2 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Cetak Brosur">
                        <span class="product-badge discount">Diskon 15%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Percetakan</div>
                        <h3 class="product-title">Cetak Brosur A4 Full Color</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 1.200/lembar</span>
                            <span class="original-price">Rp 1.400/lembar</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 3 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Notebook Custom">
                    </div>
                    <div class="product-info">
                        <div class="product-category">ATK</div>
                        <h3 class="product-title">Notebook Custom Logo Perusahaan</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 25.000/buku</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <!-- Produk 4 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Sablon Kaos">
                        <span class="product-badge">Baru</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Sablon & Merchandise</div>
                        <h3 class="product-title">Sablon Kaos Polo Custom</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 85.000/pcs</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produk diskon (hidden by default) -->
            <div class="product-grid" id="discount-products" style="display: none;">
                <!-- Produk diskon akan ditampilkan di sini -->
            </div>
            
            <!-- Produk populer (hidden by default) -->
            <div class="product-grid" id="popular-products" style="display: none;">
                <!-- Produk populer akan ditampilkan di sini -->
            </div>
        </div>
    </section>


<script>
        // Tab produk
        const tabBtns = document.querySelectorAll('.tab-btn');
        const productGrids = {
            'new': document.getElementById('new-products'),
            'discount': document.getElementById('discount-products'),
            'popular': document.getElementById('popular-products')
        };
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Hapus class active dari semua tab
                tabBtns.forEach(b => b.classList.remove('active'));
                // Tambah class active ke tab yang diklik
                btn.classList.add('active');
                
                // Sembunyikan semua produk
                Object.values(productGrids).forEach(grid => {
                    if(grid) grid.style.display = 'none';
                });
                
                // Tampilkan produk sesuai tab
                const tabId = btn.getAttribute('data-tab');
                if(productGrids[tabId]) {
                    productGrids[tabId].style.display = 'grid';
                }
            });
        });
        
        // Tambah ke keranjang
        const addToCartBtns = document.querySelectorAll('.btn-add-to-cart');
        const cartCount = document.querySelector('.cart-count');
        
        addToCartBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                let currentCount = parseInt(cartCount.textContent);
                cartCount.textContent = currentCount + 1;
                
                // Animasi sederhana
                cartCount.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    cartCount.style.transform = 'scale(1)';
                }, 300);
                
                alert('Produk telah ditambahkan ke keranjang!');
            });
        });
                
        // Simulasi data produk diskon dan populer
        function loadDiscountProducts() {
            const discountGrid = document.getElementById('discount-products');
            discountGrid.innerHTML = `
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Logo">
                        <span class="product-badge discount">Diskon 20%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Desain Grafis</div>
                        <h3 class="product-title">Paket Desain Logo + Kartu Nama</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 799.000</span>
                            <span class="original-price">Rp 999.000</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Cetak Brosur">
                        <span class="product-badge discount">Diskon 15%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Percetakan</div>
                        <h3 class="product-title">Cetak Brosur A4 Full Color</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 1.200/lembar</span>
                            <span class="original-price">Rp 1.400/lembar</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Stiker Vinyl">
                        <span class="product-badge discount">Diskon 10%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Percetakan</div>
                        <h3 class="product-title">Stiker Vinyl Outdoor</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 45.000/m²</span>
                            <span class="original-price">Rp 50.000/m²</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Amplop Custom">
                        <span class="product-badge discount">Diskon 5%</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">ATK</div>
                        <h3 class="product-title">Amplop Custom Logo Perusahaan</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 1.500/buah</span>
                            <span class="original-price">Rp 1.600/buah</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
            `;
            
            // Tambah event listener ke tombol baru
            discountGrid.querySelectorAll('.btn-add-to-cart').forEach(btn => {
                btn.addEventListener('click', () => {
                    let currentCount = parseInt(cartCount.textContent);
                    cartCount.textContent = currentCount + 1;
                    
                    cartCount.style.transform = 'scale(1.3)';
                    setTimeout(() => {
                        cartCount.style.transform = 'scale(1)';
                    }, 300);
                    
                    alert('Produk telah ditambahkan ke keranjang!');
                });
            });
        }
        
        function loadPopularProducts() {
            const popularGrid = document.getElementById('popular-products');
            popularGrid.innerHTML = `
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Logo">
                        <span class="product-badge">Terlaris</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Desain Grafis</div>
                        <h3 class="product-title">Desain Logo Profesional</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 499.000</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Notebook Custom">
                        <span class="product-badge">Terlaris</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">ATK</div>
                        <h3 class="product-title">Notebook Custom Logo Perusahaan</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 25.000/buku</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Sablon Kaos">
                        <span class="product-badge">Terlaris</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Sablon & Merchandise</div>
                        <h3 class="product-title">Sablon Kaos Polo Custom</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 85.000/pcs</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Cetak Brosur">
                        <span class="product-badge">Terlaris</span>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Percetakan</div>
                        <h3 class="product-title">Cetak Brosur A4 Full Color</h3>
                        <div class="product-price">
                            <span class="current-price">Rp 1.400/lembar</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">+ Keranjang</button>
                            <button class="btn-detail">Detail</button>
                        </div>
                    </div>
                </div>
            `;
            
            // Tambah event listener ke tombol baru
            popularGrid.querySelectorAll('.btn-add-to-cart').forEach(btn => {
                btn.addEventListener('click', () => {
                    let currentCount = parseInt(cartCount.textContent);
                    cartCount.textContent = currentCount + 1;
                    
                    cartCount.style.transform = 'scale(1.3)';
                    setTimeout(() => {
                        cartCount.style.transform = 'scale(1)';
                    }, 300);
                    
                    alert('Produk telah ditambahkan ke keranjang!');
                });
            });
        }
        
        // Load data produk saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            loadDiscountProducts();
            loadPopularProducts();
        });
    </script>
@endsection