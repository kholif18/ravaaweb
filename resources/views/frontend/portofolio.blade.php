@extends('frontend.layouts.master')

@section('title', 'Portfolio')

@section('content')
    <!-- Hero Section -->
    <section class="hero-portfolio">
        <div class="container">
            <h1>Portofolio Karya Kami</h1>
            <p>Lihat berbagai karya desain, percetakan, dan proyek kreatif yang telah kami selesaikan untuk klien-klien kami. Setiap karya mencerminkan kualitas dan kreativitas Ravaa Creative.</p>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section class="portfolio-section">
        <div class="container">
            <div class="section-title">
                <h2>Karya Terbaik Kami</h2>
            </div>
            
            <p class="section-subtitle">Jelajahi berbagai proyek yang telah kami kerjakan, mulai dari desain logo, branding, hingga percetakan dan merchandise.</p>
            
            <!-- Portfolio Filter -->
            <div class="portfolio-filter">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-th-large"></i> Semua Karya
                </button>
                <button class="filter-btn" data-filter="logo">
                    <i class="fas fa-paint-brush"></i> Desain Logo
                </button>
                <button class="filter-btn" data-filter="branding">
                    <i class="fas fa-palette"></i> Branding
                </button>
                <button class="filter-btn" data-filter="printing">
                    <i class="fas fa-print"></i> Percetakan
                </button>
                <button class="filter-btn" data-filter="merchandise">
                    <i class="fas fa-tshirt"></i> Merchandise
                </button>
                <button class="filter-btn" data-filter="packaging">
                    <i class="fas fa-box"></i> Packaging
                </button>
            </div>
            
            <!-- Portfolio Grid -->
            <div class="portfolio-grid" id="portfolioGrid">
                <!-- Portfolio Item 1 -->
                <div class="portfolio-item" data-category="logo">
                    <div class="portfolio-image">
                        <img src="https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Logo Design for Cafe">
                        <div class="portfolio-overlay">
                            <button class="btn btn-light" data-portfolio="1">Lihat Detail</button>
                        </div>
                        <div class="portfolio-category">Logo Design</div>
                    </div>
                    <div class="portfolio-info">
                        <h3>Logo & Branding untuk Kafe "Brew & Co"</h3>
                        <p>Desain logo modern dan elegan untuk kafe specialty coffee di Jakarta. Logo mencerminkan kehangatan dan kualitas kopi premium.</p>
                        <div class="portfolio-client">
                            <i class="fas fa-user-tie"></i>
                            <span>Klien: Brew & Co Coffee</span>
                        </div>
                        <div class="portfolio-tags">
                            <span class="portfolio-tag">Logo Design</span>
                            <span class="portfolio-tag">Coffee Shop</span>
                            <span class="portfolio-tag">Modern</span>
                        </div>
                        <a href="#" class="portfolio-link" data-portfolio="1">Lihat detail proyek →</a>
                    </div>
                </div>
                
                <!-- Portfolio Item 2 -->
                <div class="portfolio-item" data-category="branding">
                    <div class="portfolio-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Corporate Branding">
                        <div class="portfolio-overlay">
                            <button class="btn btn-light" data-portfolio="2">Lihat Detail</button>
                        </div>
                        <div class="portfolio-category">Corporate Branding</div>
                    </div>
                    <div class="portfolio-info">
                        <h3>Corporate Branding untuk Startup Tech</h3>
                        <p>Paket branding lengkap termasuk logo, kartu nama, kop surat, dan panduan visual untuk perusahaan teknologi yang sedang berkembang.</p>
                        <div class="portfolio-client">
                            <i class="fas fa-user-tie"></i>
                            <span>Klien: TechSolutions Inc.</span>
                        </div>
                        <div class="portfolio-tags">
                            <span class="portfolio-tag">Branding</span>
                            <span class="portfolio-tag">Corporate</span>
                            <span class="portfolio-tag">Tech</span>
                        </div>
                        <a href="#" class="portfolio-link" data-portfolio="2">Lihat detail proyek →</a>
                    </div>
                </div>
                
                <!-- Portfolio Item 3 -->
                <div class="portfolio-item" data-category="printing">
                    <div class="portfolio-image">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Printing Catalog">
                        <div class="portfolio-overlay">
                            <button class="btn btn-light" data-portfolio="3">Lihat Detail</button>
                        </div>
                        <div class="portfolio-category">Percetakan</div>
                    </div>
                    <div class="portfolio-info">
                        <h3>Cetak Katalog Produk Fashion</h3>
                        <p>Desain dan percetakan katalog produk fashion dengan kualitas premium, menggunakan teknik cetak offset dan finishing khusus.</p>
                        <div class="portfolio-client">
                            <i class="fas fa-user-tie"></i>
                            <span>Klien: FashionHouse ID</span>
                        </div>
                        <div class="portfolio-tags">
                            <span class="portfolio-tag">Printing</span>
                            <span class="portfolio-tag">Catalog</span>
                            <span class="portfolio-tag">Fashion</span>
                        </div>
                        <a href="#" class="portfolio-link" data-portfolio="3">Lihat detail proyek →</a>
                    </div>
                </div>
                
                <!-- Portfolio Item 4 -->
                <div class="portfolio-item" data-category="merchandise">
                    <div class="portfolio-image">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Company Merchandise">
                        <div class="portfolio-overlay">
                            <button class="btn btn-light" data-portfolio="4">Lihat Detail</button>
                        </div>
                        <div class="portfolio-category">Merchandise</div>
                    </div>
                    <div class="portfolio-info">
                        <h3>Merchandise untuk Event Perusahaan</h3>
                        <p>Produksi merchandise berupa kaos, topi, dan tumbler untuk acara tahunan perusahaan dengan desain custom yang menarik.</p>
                        <div class="portfolio-client">
                            <i class="fas fa-user-tie"></i>
                            <span>Klien: GlobalCorp Ltd.</span>
                        </div>
                        <div class="portfolio-tags">
                            <span class="portfolio-tag">Merchandise</span>
                            <span class="portfolio-tag">Event</span>
                            <span class="portfolio-tag">Corporate</span>
                        </div>
                        <a href="#" class="portfolio-link" data-portfolio="4">Lihat detail proyek →</a>
                    </div>
                </div>
                
                <!-- Portfolio Item 5 -->
                <div class="portfolio-item" data-category="packaging">
                    <div class="portfolio-image">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Product Packaging">
                        <div class="portfolio-overlay">
                            <button class="btn btn-light" data-portfolio="5">Lihat Detail</button>
                        </div>
                        <div class="portfolio-category">Packaging</div>
                    </div>
                    <div class="portfolio-info">
                        <h3>Desain Kemasan Produk Makanan</h3>
                        <p>Desain kemasan yang eye-catching untuk produk makanan lokal, dengan fokus pada daya tarik visual dan informasi produk yang jelas.</p>
                        <div class="portfolio-client">
                            <i class="fas fa-user-tie"></i>
                            <span>Klien: LocalFood Brand</span>
                        </div>
                        <div class="portfolio-tags">
                            <span class="portfolio-tag">Packaging</span>
                            <span class="portfolio-tag">Food</span>
                            <span class="portfolio-tag">Design</span>
                        </div>
                        <a href="#" class="portfolio-link" data-portfolio="5">Lihat detail proyek →</a>
                    </div>
                </div>
                
                <!-- Portfolio Item 6 -->
                <div class="portfolio-item" data-category="logo">
                    <div class="portfolio-image">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Logo for Fitness Studio">
                        <div class="portfolio-overlay">
                            <button class="btn btn-light" data-portfolio="6">Lihat Detail</button>
                        </div>
                        <div class="portfolio-category">Logo Design</div>
                    </div>
                    <div class="portfolio-info">
                        <h3>Logo untuk Studio Fitness & Wellness</h3>
                        <p>Desain logo yang energik dan modern untuk studio fitness, menggambarkan gerakan dan kesehatan secara visual.</p>
                        <div class="portfolio-client">
                            <i class="fas fa-user-tie"></i>
                            <span>Klien: FitLife Studio</span>
                        </div>
                        <div class="portfolio-tags">
                            <span class="portfolio-tag">Logo Design</span>
                            <span class="portfolio-tag">Fitness</span>
                            <span class="portfolio-tag">Modern</span>
                        </div>
                        <a href="#" class="portfolio-link" data-portfolio="6">Lihat detail proyek →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Stats -->
    <section class="portfolio-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="stat-number">250+</div>
                    <div class="stat-title">Proyek Selesai</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">150+</div>
                    <div class="stat-title">Klien Puas</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="stat-number">98%</div>
                    <div class="stat-title">Tingkat Kepuasan</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">5 Tahun</div>
                    <div class="stat-title">Pengalaman</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>Apa Kata Klien Kami</h2>
            </div>
            
            <div class="testimonials-slider">
                <!-- Testimonial 1 -->
                <div class="testimonial-item active" data-testimonial="1">
                    <div class="testimonial-quote">"</div>
                    <p class="testimonial-text">"Ravaa Creative sangat profesional dalam mengerjakan logo untuk bisnis saya. Mereka memahami kebutuhan dengan baik dan memberikan hasil yang melebihi ekspektasi. Proses revisi juga sangat fleksibel dan responsif."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Budi Santoso">
                        </div>
                        <div class="author-info">
                            <h4>Budi Santoso</h4>
                            <p>Owner, Brew & Co Coffee</p>
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-item" data-testimonial="2">
                    <div class="testimonial-quote">"</div>
                    <p class="testimonial-text">"Kerjasama dengan Ravaa Creative untuk proyek branding perusahaan kami sangat memuaskan. Tim mereka kreatif, detail-oriented, dan selalu tepat waktu. Hasil akhirnya sangat profesional dan sesuai dengan identitas perusahaan kami."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sari Dewi">
                        </div>
                        <div class="author-info">
                            <h4>Sari Dewi</h4>
                            <p>Marketing Director, TechSolutions Inc.</p>
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-item" data-testimonial="3">
                    <div class="testimonial-quote">"</div>
                    <p class="testimonial-text">"Kualitas percetakan dari Ravaa Creative sangat bagus. Mereka membantu kami dari desain hingga produksi katalog produk. Hasil cetakan tajam, warna akurat, dan finishing-nya rapi. Highly recommended!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Ahmad Rizki">
                        </div>
                        <div class="author-info">
                            <h4>Ahmad Rizki</h4>
                            <p>CEO, FashionHouse ID</p>
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slider Controls -->
                <div class="slider-controls">
                    <button class="slider-btn" id="prevTestimonial">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-btn" id="nextTestimonial">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div class="slider-dots">
                    <div class="slider-dot active" data-testimonial="1"></div>
                    <div class="slider-dot" data-testimonial="2"></div>
                    <div class="slider-dot" data-testimonial="3"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container">
        <div class="cta-section">
            <h2>Siap Bekerja Sama dengan Kami?</h2>
            <p>Jadikan ide kreatif Anda menjadi kenyataan dengan tim profesional Ravaa Creative. Konsultasikan proyek Anda sekarang.</p>
            <a href="kontak.html" class="btn btn-light">
                <i class="fas fa-envelope"></i> Konsultasi Proyek
            </a>
        </div>
    </section>

    <!-- Portfolio Modal -->
    <div class="portfolio-modal-overlay" id="portfolioModal">
        <div class="portfolio-modal">
            <button class="modal-close" id="modalClose">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-content" id="modalContent">
                <!-- Konten modal akan dimuat di sini oleh JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Portfolio Filter
        const filterButtons = document.querySelectorAll('.filter-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Hapus active class dari semua filter button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Tambah active class ke button yang diklik
                button.classList.add('active');
                
                // Ambil filter value
                const filterValue = button.getAttribute('data-filter');
                
                // Filter portfolio items
                portfolioItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Portfolio Modal Data
        const portfolioData = {
            1: {
                title: "Logo & Branding untuk Kafe 'Brew & Co'",
                category: "Logo Design",
                client: "Brew & Co Coffee",
                timeline: "2 minggu",
                year: "2023",
                description: "Proyek desain logo dan identitas visual untuk kafe specialty coffee baru di Jakarta. Logo dirancang untuk mencerminkan kehangatan, kualitas, dan pengalaman kopi premium. Warna coklat dan emas dipilih untuk menciptakan kesan premium dan hangat.",
                challenge: "Menciptakan logo yang bisa menarik perhatian generasi muda pecinta kopi sekaligus terlihat profesional untuk bisnis.",
                solution: "Desain logo minimalis dengan elemen biji kopi yang disederhanakan, menggunakan warna earth tone yang hangat dan tipografi modern yang mudah dibaca.",
                image: "https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80",
                gallery: [
                    "https://images.unsplash.com/photo-1634942537034-2531766767d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                ]
            },
            2: {
                title: "Corporate Branding untuk Startup Tech",
                category: "Corporate Branding",
                client: "TechSolutions Inc.",
                timeline: "4 minggu",
                year: "2023",
                description: "Paket branding komprehensif untuk startup teknologi yang bergerak di bidang solusi software. Proyek mencakup desain logo, kartu nama, kop surat, amplop, presentasi template, dan panduan visual brand.",
                challenge: "Menciptakan identitas brand yang terlihat inovatif dan teknologi namun tetap dapat dipercaya untuk klien korporat.",
                solution: "Menggunakan warna biru sebagai warna utama untuk menciptakan kesan profesional dan teknologi, dengan aksen hijau untuk kesan inovasi. Desain minimalis dengan tipografi sans-serif yang modern.",
                image: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80",
                gallery: [
                    "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                ]
            },
            3: {
                title: "Cetak Katalog Produk Fashion",
                category: "Percetakan",
                client: "FashionHouse ID",
                timeline: "3 minggu",
                year: "2023",
                description: "Proyek desain dan percetakan katalog produk fashion musiman. Katalog 48 halaman dengan foto produk high-quality, deskripsi produk, dan informasi harga.",
                challenge: "Mencetak katalog dengan warna yang akurat dan konsisten untuk merepresentasikan produk fashion dengan tepat.",
                solution: "Menggunakan teknik cetak offset dengan 4 warna proses dan finishing laminating doff untuk kesan premium. Proofing warna dilakukan secara ketat sebelum produksi massal.",
                image: "https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80",
                gallery: [
                    "https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                ]
            }
        };

        // Portfolio Modal
        const portfolioModal = document.getElementById('portfolioModal');
        const modalCloseBtn = document.getElementById('modalClose');
        const modalContent = document.getElementById('modalContent');
        const portfolioLinks = document.querySelectorAll('.portfolio-link, .portfolio-overlay .btn');

        // Buka modal portfolio
        portfolioLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const portfolioId = link.getAttribute('data-portfolio');
                const portfolio = portfolioData[portfolioId];
                
                if (portfolio) {
                    modalContent.innerHTML = `
                        <div class="modal-image">
                            <img src="${portfolio.image}" alt="${portfolio.title}">
                        </div>
                        
                        <div class="modal-info">
                            <h2>${portfolio.title}</h2>
                            <div class="modal-category">${portfolio.category}</div>
                            <p class="modal-description">${portfolio.description}</p>
                            
                            <div class="modal-details">
                                <div class="detail-item">
                                    <h4>Klien</h4>
                                    <p>${portfolio.client}</p>
                                </div>
                                <div class="detail-item">
                                    <h4>Timeline</h4>
                                    <p>${portfolio.timeline}</p>
                                </div>
                                <div class="detail-item">
                                    <h4>Tahun</h4>
                                    <p>${portfolio.year}</p>
                                </div>
                                <div class="detail-item">
                                    <h4>Kategori</h4>
                                    <p>${portfolio.category}</p>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <h4>Tantangan</h4>
                                <p>${portfolio.challenge}</p>
                            </div>
                            
                            <div class="detail-item">
                                <h4>Solusi</h4>
                                <p>${portfolio.solution}</p>
                            </div>
                            
                            ${portfolio.gallery ? `
                            <div class="modal-gallery">
                                <h3>Galeri Proyek</h3>
                                <div class="gallery-grid">
                                    ${portfolio.gallery.map(img => `
                                        <div class="gallery-item">
                                            <img src="${img}" alt="${portfolio.title}">
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    
                    // Buka modal
                    portfolioModal.classList.add('active');
                    body.style.overflow = 'hidden';
                }
            });
        });

        // Tutup modal portfolio
        modalCloseBtn.addEventListener('click', () => {
            portfolioModal.classList.remove('active');
            body.style.overflow = '';
        });

        // Tutup modal dengan klik di luar konten
        portfolioModal.addEventListener('click', (e) => {
            if (e.target === portfolioModal) {
                portfolioModal.classList.remove('active');
                body.style.overflow = '';
            }
        });

        // Testimonials Slider
        const testimonialItems = document.querySelectorAll('.testimonial-item');
        const testimonialDots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.getElementById('prevTestimonial');
        const nextBtn = document.getElementById('nextTestimonial');
        let currentTestimonial = 1;
        let autoSlideInterval;

        // Fungsi untuk menampilkan testimonial tertentu
        function showTestimonial(testimonialNumber) {
            // Sembunyikan semua testimonial
            testimonialItems.forEach(item => {
                item.classList.remove('active');
            });
            
            // Hapus active dari semua dots
            testimonialDots.forEach(dot => {
                dot.classList.remove('active');
            });
            
            // Tampilkan testimonial yang dipilih
            const selectedTestimonial = document.querySelector(`[data-testimonial="${testimonialNumber}"]`);
            if (selectedTestimonial) {
                selectedTestimonial.classList.add('active');
            }
            
            // Active dot yang sesuai
            const selectedDot = document.querySelector(`.slider-dot[data-testimonial="${testimonialNumber}"]`);
            if (selectedDot) {
                selectedDot.classList.add('active');
            }
            
            currentTestimonial = testimonialNumber;
        }

        // Event listener untuk tombol prev
        prevBtn.addEventListener('click', () => {
            let newTestimonial = currentTestimonial - 1;
            if (newTestimonial < 1) newTestimonial = testimonialItems.length;
            showTestimonial(newTestimonial);
            resetAutoSlide();
        });

        // Event listener untuk tombol next
        nextBtn.addEventListener('click', () => {
            let newTestimonial = currentTestimonial + 1;
            if (newTestimonial > testimonialItems.length) newTestimonial = 1;
            showTestimonial(newTestimonial);
            resetAutoSlide();
        });

        // Event listener untuk dots
        testimonialDots.forEach(dot => {
            dot.addEventListener('click', () => {
                const testimonialNumber = parseInt(dot.getAttribute('data-testimonial'));
                showTestimonial(testimonialNumber);
                resetAutoSlide();
            });
        });

        // Fungsi untuk auto slide
        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                let newTestimonial = currentTestimonial + 1;
                if (newTestimonial > testimonialItems.length) newTestimonial = 1;
                showTestimonial(newTestimonial);
            }, 5000); // Ganti slide setiap 5 detik
        }

        // Fungsi untuk reset auto slide
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Mulai auto slide
        startAutoSlide();

        // Hentikan auto slide saat hover di testimonial
        const testimonialSlider = document.querySelector('.testimonials-slider');
        testimonialSlider.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });

        testimonialSlider.addEventListener('mouseleave', () => {
            startAutoSlide();
        });

        // Inisialisasi testimonial pertama
        showTestimonial(1);
    </script>
@endsection