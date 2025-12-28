@extends('frontend.layouts.master')

@section('title', 'Detail Produk')

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-container">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ url('/product') }}">Produk</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ url('/product?category=design') }}">Desain Grafis</a>
                <i class="fas fa-chevron-right"></i>
                <span>Paket Desain Logo Profesional</span>
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
                        <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Paket Desain Logo Profesional" id="mainImage">
                    </div>
                    
                    <div class="product-thumbnails">
                        <div class="thumbnail active" data-image="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80">
                            <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Logo Design 1">
                        </div>
                        <div class="thumbnail" data-image="https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80">
                            <img src="https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Logo Design 2">
                        </div>
                        <div class="thumbnail" data-image="https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80">
                            <img src="https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Logo Design 3">
                        </div>
                        <div class="thumbnail" data-image="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80">
                            <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Logo Design 4">
                        </div>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="detail-product-info">
                    <span class="product-category">Desain Grafis</span>
                    <h1 class="detail-product-title">Paket Desain Logo Profesional</h1>
                    
                    <div class="detail-product-price-container">
                        <div class="detail-current-price">Rp 499.000</div>
                        <div class="detail-original-price">Rp 624.000</div>
                        <div class="detail-discount-percentage">Hemat 20%</div>
                    </div>
                    
                    <div class="product-stock">
                        <div class="stock-status in-stock">
                            <i class="fas fa-check-circle"></i>
                            <span>Tersedia</span>
                        </div>
                        <span class="stock-count">Stok: 15 paket</span>
                    </div>
                    
                    <div class="detail-product-variants">
                        <h3 class="detail-variant-title">Pilih Paket:</h3>
                        <div class="detail-variant-options">
                            <div class="detail-variant-option selected" data-variant="basic">Paket Dasar</div>
                            <div class="detail-variant-option" data-variant="professional">Paket Profesional</div>
                            <div class="detail-variant-option" data-variant="enterprise">Paket Enterprise</div>
                        </div>
                    </div>
                    
                    <div class="product-warranty">
                        <div class="warranty-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Garansi 100% Revisi & Hak Cipta</span>
                        </div>
                    </div>
                    
                    <div class="detail-product-actions">
                        <div class="detail-action-buttons">
                            <a href="https://wa.me/6281234567890?text=Halo%20Ravaa%20Creative,%20saya%20tertarik%20dengan%20Paket%20Desain%20Logo%20Profesional" class="btn-whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                            </a>
                            <a href="https://t.me/RavaaCreative" class="btn-telegram" target="_blank">
                                <i class="fab fa-telegram"></i> Pesan via Telegram
                            </a>
                        </div>
                        
                        <div class="quick-info">
                            <div class="info-item">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Gratis Konsultasi</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <span>Pengerjaan 3-7 hari</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-undo"></i>
                                <span>Revisi tanpa batas</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-file-download"></i>
                                <span>File lengkap semua format</span>
                            </div>
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
                        <h3>Tentang Paket Desain Logo Profesional</h3>
                        <p>Paket Desain Logo Profesional dari Ravaa Creative adalah solusi lengkap untuk membangun identitas visual bisnis Anda. Tim desainer berpengalaman kami akan membuat logo yang tidak hanya menarik secara visual, tetapi juga mencerminkan nilai dan visi bisnis Anda.</p>
                        
                        <p>Dengan paket ini, Anda akan mendapatkan:</p>
                        
                        <h4>Proses Pengerjaan:</h4>
                        <ol>
                            <li><strong>Konsultasi Awal:</strong> Diskusi mendalam tentang bisnis, target pasar, dan preferensi desain.</li>
                            <li><strong>Research & Konsep:</strong> Analisis kompetitor dan industri untuk menciptakan konsep yang unik.</li>
                            <li><strong>Presentasi Konsep:</strong> 3 konsep desain logo yang berbeda untuk Anda pilih.</li>
                            <li><strong>Revisi & Penyempurnaan:</strong> Revisi tanpa batas hingga Anda puas dengan hasilnya.</li>
                            <li><strong>Finalisasi:</strong> Penyediaan file final dalam berbagai format untuk semua kebutuhan.</li>
                        </ol>
                        
                        <h4>Mengapa Memilih Paket Ini?</h4>
                        <ul>
                            <li><strong>Desain Original 100%:</strong> Logo unik yang dibuat khusus untuk bisnis Anda.</li>
                            <li><strong>Tim Profesional:</strong> Desainer berpengalaman dengan portofolio terbukti.</li>
                            <li><strong>Proses Kolaboratif:</strong> Anda terlibat aktif dalam setiap tahap pengerjaan.</li>
                            <li><strong>Garansi Hak Cipta:</strong> Hak cipta logo sepenuhnya menjadi milik Anda.</li>
                            <li><strong>Dukungan Pasca-Penyelesaian:</strong> Konsultasi gratis untuk penerapan logo.</li>
                        </ul>
                        
                        <p>Paket ini cocok untuk: Startup, UMKM, perusahaan baru, rebranding, atau siapa saja yang membutuhkan logo profesional untuk membangun citra bisnis yang kuat.</p>
                    </div>
                </div>
                
                <div class="detail-tab-content" id="specifications">
                    <table class="detail-specifications">
                        <tr>
                            <td>Kategori</td>
                            <td>Desain Grafis / Logo & Branding</td>
                        </tr>
                        <tr>
                            <td>Jumlah Konsep</td>
                            <td>3 konsep desain berbeda</td>
                        </tr>
                        <tr>
                            <td>Revisi</td>
                            <td>Tanpa batas hingga puas</td>
                        </tr>
                        <tr>
                            <td>Waktu Pengerjaan</td>
                            <td>3-7 hari kerja (tergantung kompleksitas)</td>
                        </tr>
                        <tr>
                            <td>Format File</td>
                            <td>AI (Adobe Illustrator), EPS, PDF, JPG, PNG, SVG</td>
                        </tr>
                        <tr>
                            <td>Resolusi</td>
                            <td>High-resolution (300 DPI) untuk cetak & digital</td>
                        </tr>
                        <tr>
                            <td>Hak Cipta</td>
                            <td>100% milik klien setelah pembayaran lunas</td>
                        </tr>
                        <tr>
                            <td>Garansi</td>
                            <td>Garansi revisi & hak cipta</td>
                        </tr>
                        <tr>
                            <td>Dukungan Warna</td>
                            <td>Full color, CMYK untuk cetak, RGB untuk digital</td>
                        </tr>
                        <tr>
                            <td>Bonus</td>
                            <td>Panduan penggunaan logo, Mockup preview, Konsultasi branding gratis</td>
                        </tr>
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td>Transfer Bank, E-Wallet, Virtual Account</td>
                        </tr>
                        <tr>
                            <td>Metode Konsultasi</td>
                            <td>Online meeting, WhatsApp, Email</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-products">
        <div class="container">
            <div class="section-title">
                <h2>Produk Terkait</h2>
            </div>
            
            <div class="related-grid">
                <!-- Produk 1 -->
                <div class="related-card">
                    <div class="related-image">
                        <img src="https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Paket Branding Lengkap">
                    </div>
                    <div class="related-info">
                        <h3 class="related-title">Paket Branding Lengkap</h3>
                        <div class="related-price">Rp 1.299.000</div>
                        <a href="detail-produk-branding.html" class="related-btn">Lihat Detail</a>
                    </div>
                </div>
                
                <!-- Produk 2 -->
                <div class="related-card">
                    <div class="related-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Kartu Nama">
                    </div>
                    <div class="related-info">
                        <h3 class="related-title">Desain Kartu Nama Profesional</h3>
                        <div class="related-price">Rp 199.000</div>
                        <a href="detail-produk-kartunama.html" class="related-btn">Lihat Detail</a>
                    </div>
                </div>
                
                <!-- Produk 3 -->
                <div class="related-card">
                    <div class="related-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Desain Brosur">
                    </div>
                    <div class="related-info">
                        <h3 class="related-title">Desain Brosur & Flyer</h3>
                        <div class="related-price">Rp 349.000</div>
                        <a href="detail-produk-brosur.html" class="related-btn">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Product Gallery
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumbnail');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                // Hapus class active dari semua thumbnail
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                
                // Tambah class active ke thumbnail yang diklik
                thumbnail.classList.add('active');
                
                // Update gambar utama
                const newImageSrc = thumbnail.getAttribute('data-image');
                mainImage.src = newImageSrc;
                mainImage.alt = thumbnail.querySelector('img').alt;
            });
        });

        // Product Variants
        const variantOptions = document.querySelectorAll('.detail-variant-option');
        const currentPrice = document.querySelector('.detail-current-price');
        const originalPrice = document.querySelector('.detail-original-price');
        const discountPercentage = document.querySelector('.detail-discount-percentage');
        
        // Data harga untuk setiap varian
        const variantPrices = {
            basic: {
                current: 'Rp 499.000',
                original: 'Rp 624.000',
                discount: 'Hemat 20%'
            },
            professional: {
                current: 'Rp 899.000',
                original: 'Rp 1.124.000',
                discount: 'Hemat 20%'
            },
            enterprise: {
                current: 'Rp 1.499.000',
                original: 'Rp 1.874.000',
                discount: 'Hemat 20%'
            }
        };

        variantOptions.forEach(option => {
            option.addEventListener('click', () => {
                // Skip jika disabled
                if (option.classList.contains('disabled')) return;
                
                // Hapus class selected dari semua option
                variantOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Tambah class selected ke option yang diklik
                option.classList.add('selected');
                
                // Update harga berdasarkan varian
                const variant = option.getAttribute('data-variant');
                if (variantPrices[variant]) {
                    currentPrice.textContent = variantPrices[variant].current;
                    originalPrice.textContent = variantPrices[variant].original;
                    discountPercentage.textContent = variantPrices[variant].discount;
                }
            });
        });

        // Product Tabs
        const tabHeaders = document.querySelectorAll('.detail-tab-header');
        const tabContents = document.querySelectorAll('.detail-tab-content');

        tabHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const tabId = header.getAttribute('data-tab');
                
                // Hapus class active dari semua tab header
                tabHeaders.forEach(h => h.classList.remove('active'));
                
                // Tambah class active ke tab header yang diklik
                header.classList.add('active');
                
                // Sembunyikan semua tab content
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Tampilkan tab content yang sesuai
                document.getElementById(tabId).classList.add('active');
            });
        });

        // WhatsApp link dengan pesan otomatis
        const whatsappBtn = document.querySelector('.btn-whatsapp');
        const telegramBtn = document.querySelector('.btn-telegram');
        
        // Update WhatsApp link dengan varian yang dipilih
        function updateWhatsAppLink() {
            const selectedVariant = document.querySelector('.detail-variant-option.selected').getAttribute('data-variant');
            const variantNames = {
                basic: 'Paket Dasar',
                professional: 'Paket Profesional',
                enterprise: 'Paket Enterprise'
            };
            
            const message = `Halo Ravaa Creative, saya tertarik dengan ${variantNames[selectedVariant]} - Paket Desain Logo Profesional. Bisa info lebih detail?`;
            const encodedMessage = encodeURIComponent(message);
            whatsappBtn.href = `https://wa.me/6281234567890?text=${encodedMessage}`;
        }
        
        // Update link saat varian berubah
        variantOptions.forEach(option => {
            option.addEventListener('click', () => {
                if (!option.classList.contains('disabled')) {
                    updateWhatsAppLink();
                }
            });
        });
        
        // Inisialisasi link WhatsApp
        updateWhatsAppLink();
    </script>
@endsection