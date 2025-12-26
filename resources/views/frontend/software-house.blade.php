@extends('frontend.layouts.master')

@section('title', 'Software House')

@section('content')
        <!-- Hero Section -->
    <section class="hero-tech">
        <div class="container">
            <div class="hero-content">
                <div class="tech-badge">
                    <i class="fas fa-code"></i> Divisi Software House
                </div>
                <h1>Ravaa Creative Tech</h1>
                <p>Kami adalah divisi Software House dari Ravaa Creative yang khusus mengembangkan website, aplikasi mobile, dan solusi digital custom untuk bisnis Anda. Tim developer berpengalaman kami siap mewujudkan ide digital Anda.</p>
                
                <div class="hero-actions">
                    <a href="#pricing" class="btn">Lihat Paket Website</a>
                    <a href="#portfolio" class="btn btn-outline">Portfolio Tech</a>
                    <a href="https://wa.me/6281234567890" class="btn btn-light" target="_blank">
                        <i class="fab fa-whatsapp"></i> Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Development Kami</h2>
            </div>
            
            <p class="section-subtitle">Kami menyediakan berbagai layanan pengembangan software untuk kebutuhan digital bisnis Anda.</p>
            
            <div class="services-grid">
                <!-- Service 1 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Website Development</h3>
                    <p>Pembuatan website company profile, e-commerce, landing page, dan website custom sesuai kebutuhan bisnis Anda.</p>
                    
                    <div class="service-features">
                        <h4>Fitur termasuk:</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Website Responsive</li>
                            <li><i class="fas fa-check"></i> CMS Custom</li>
                            <li><i class="fas fa-check"></i> SEO Friendly</li>
                            <li><i class="fas fa-check"></i> Integrasi Payment</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Service 2 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile App Development</h3>
                    <p>Pengembangan aplikasi mobile iOS & Android untuk bisnis, startup, atau kebutuhan internal perusahaan.</p>
                    
                    <div class="service-features">
                        <h4>Fitur termasuk:</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Android & iOS</li>
                            <li><i class="fas fa-check"></i> Cross-Platform</li>
                            <li><i class="fas fa-check"></i> Push Notification</li>
                            <li><i class="fas fa-check"></i> API Integration</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Service 3 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>E-Commerce Solution</h3>
                    <p>Solusi toko online lengkap dengan sistem manajemen produk, order, payment gateway, dan dashboard analytics.</p>
                    
                    <div class="service-features">
                        <h4>Fitur termasuk:</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Multi-Vendor System</li>
                            <li><i class="fas fa-check"></i> Payment Gateway</li>
                            <li><i class="fas fa-check"></i> Inventory Management</li>
                            <li><i class="fas fa-check"></i> Reporting System</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Service 4 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>Custom Software</h3>
                    <p>Pengembangan software khusus untuk kebutuhan bisnis seperti CRM, ERP, sistem inventory, dan aplikasi internal.</p>
                    
                    <div class="service-features">
                        <h4>Fitur termasuk:</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Custom Requirements</li>
                            <li><i class="fas fa-check"></i> Scalable Architecture</li>
                            <li><i class="fas fa-check"></i> Database Design</li>
                            <li><i class="fas fa-check"></i> API Development</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section class="tech-stack-section">
        <div class="container">
            <div class="section-title">
                <h2>Technology Stack Kami</h2>
            </div>
            
            <p class="section-subtitle">Kami menggunakan teknologi terbaru dan terpercaya untuk pengembangan software yang berkualitas.</p>
            
            <div class="tech-grid">
                <!-- Tech 1 -->
                <div class="tech-item">
                    <i class="fab fa-html5 tech-icon html"></i>
                    <h4>HTML5</h4>
                    <p>Frontend Structure</p>
                </div>
                
                <!-- Tech 2 -->
                <div class="tech-item">
                    <i class="fab fa-css3-alt tech-icon css"></i>
                    <h4>CSS3</h4>
                    <p>Styling & Design</p>
                </div>
                
                <!-- Tech 3 -->
                <div class="tech-item">
                    <i class="fab fa-js-square tech-icon js"></i>
                    <h4>JavaScript</h4>
                    <p>Frontend Logic</p>
                </div>
                
                <!-- Tech 4 -->
                <div class="tech-item">
                    <i class="fab fa-react tech-icon react"></i>
                    <h4>React.js</h4>
                    <p>Frontend Framework</p>
                </div>
                
                <!-- Tech 5 -->
                <div class="tech-item">
                    <i class="fab fa-node-js tech-icon node"></i>
                    <h4>Node.js</h4>
                    <p>Backend Runtime</p>
                </div>
                
                <!-- Tech 6 -->
                <div class="tech-item">
                    <i class="fab fa-php tech-icon php"></i>
                    <h4>PHP</h4>
                    <p>Server Side</p>
                </div>
                
                <!-- Tech 7 -->
                <div class="tech-item">
                    <i class="fab fa-laravel tech-icon laravel"></i>
                    <h4>Laravel</h4>
                    <p>PHP Framework</p>
                </div>
                
                <!-- Tech 8 -->
                <div class="tech-item">
                    <i class="fab fa-flutter tech-icon flutter"></i>
                    <h4>Flutter</h4>
                    <p>Mobile Cross-Platform</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Process -->
    <section class="process-section">
        <div class="container">
            <div class="section-title">
                <h2>Proses Pengembangan</h2>
            </div>
            
            <p class="section-subtitle">Kami mengikuti proses pengembangan yang terstruktur untuk memastikan kualitas dan ketepatan waktu.</p>
            
            <div class="process-steps">
                <!-- Step 1 -->
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h4>Konsultasi & Analisis</h4>
                    <p>Diskusi kebutuhan, analisis requirement, dan perencanaan proyek.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h4>UI/UX Design</h4>
                    <p>Mendesain user interface dan experience yang optimal.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h4>Development</h4>
                    <p>Pengembangan kode dengan teknologi terbaru dan best practices.</p>
                </div>
                
                <!-- Step 4 -->
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h4>Testing & QA</h4>
                    <p>Pengujian menyeluruh untuk memastikan kualitas software.</p>
                </div>
                
                <!-- Step 5 -->
                <div class="process-step">
                    <div class="step-number">5</div>
                    <h4>Deployment & Support</h4>
                    <p>Peluncuran dan dukungan pasca-launch untuk maintenance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Tech -->
    <section class="portfolio-tech-section" id="portfolio">
        <div class="container">
            <div class="section-title">
                <h2>Portfolio Tech Kami</h2>
            </div>
            
            <p class="section-subtitle">Beberapa proyek website dan aplikasi yang telah kami kembangkan untuk klien.</p>
            
            <div class="portfolio-tech-grid">
                <!-- Portfolio 1 -->
                <div class="portfolio-tech-item">
                    <div class="portfolio-tech-image">
                        <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="E-commerce Website">
                        <div class="portfolio-tech-category">E-commerce</div>
                    </div>
                    <div class="portfolio-tech-info">
                        <h3>Tokopedia-like Marketplace</h3>
                        <p>Pengembangan platform marketplace dengan sistem multi-vendor, integrasi berbagai payment gateway, dan dashboard analytics lengkap.</p>
                        <div class="portfolio-tech-tags">
                            <span class="portfolio-tech-tag">Laravel</span>
                            <span class="portfolio-tech-tag">Vue.js</span>
                            <span class="portfolio-tech-tag">MySQL</span>
                        </div>
                    </div>
                </div>
                
                <!-- Portfolio 2 -->
                <div class="portfolio-tech-item">
                    <div class="portfolio-tech-image">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Mobile App">
                        <div class="portfolio-tech-category">Mobile App</div>
                    </div>
                    <div class="portfolio-tech-info">
                        <h3>Delivery Service App</h3>
                        <p>Aplikasi mobile untuk layanan delivery dengan fitur real-time tracking, in-app chat, dan sistem rating untuk driver dan customer.</p>
                        <div class="portfolio-tech-tags">
                            <span class="portfolio-tech-tag">Flutter</span>
                            <span class="portfolio-tech-tag">Firebase</span>
                            <span class="portfolio-tech-tag">Node.js</span>
                        </div>
                    </div>
                </div>
                
                <!-- Portfolio 3 -->
                <div class="portfolio-tech-item">
                    <div class="portfolio-tech-image">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="CRM System">
                        <div class="portfolio-tech-category">CRM System</div>
                    </div>
                    <div class="portfolio-tech-info">
                        <h3>Custom CRM System</h3>
                        <p>Sistem CRM khusus untuk perusahaan properti dengan modul lead management, marketing automation, dan reporting dashboard.</p>
                        <div class="portfolio-tech-tags">
                            <span class="portfolio-tech-tag">React.js</span>
                            <span class="portfolio-tech-tag">Express.js</span>
                            <span class="portfolio-tech-tag">MongoDB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section" id="pricing">
        <div class="container">
            <div class="section-title">
                <h2>Paket Website Development</h2>
            </div>
            
            <p class="section-subtitle">Pilih paket yang sesuai dengan kebutuhan bisnis Anda. Semua paket termasuk domain, hosting, dan maintenance.</p>
            
            <div class="pricing-grid">
                <!-- Paket Basic -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3 class="pricing-name">Paket Basic</h3>
                        <div class="pricing-price">Rp 3.9JT</div>
                        <div class="pricing-period">One-time payment</div>
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li><i class="fas fa-check"></i> 5 Halaman Website</li>
                            <li><i class="fas fa-check"></i> Design Responsive</li>
                            <li><i class="fas fa-check"></i> CMS Simple</li>
                            <li><i class="fas fa-check"></i> Kontak Form</li>
                            <li><i class="fas fa-times"></i> E-commerce</li>
                            <li><i class="fas fa-times"></i> Admin Panel</li>
                            <li><i class="fas fa-times"></i> Mobile App</li>
                        </ul>
                    </div>
                    <div class="pricing-cta">
                        <a href="https://wa.me/6281234567890" class="btn btn-outline" target="_blank">Pesan Sekarang</a>
                    </div>
                </div>
                
                <!-- Paket Professional -->
                <div class="pricing-card popular">
                    <div class="pricing-badge">POPULAR</div>
                    <div class="pricing-header">
                        <h3 class="pricing-name">Paket Professional</h3>
                        <div class="pricing-price">Rp 8.9JT</div>
                        <div class="pricing-period">One-time payment</div>
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li><i class="fas fa-check"></i> 10-15 Halaman Website</li>
                            <li><i class="fas fa-check"></i> Design Custom</li>
                            <li><i class="fas fa-check"></i> CMS Custom</li>
                            <li><i class="fas fa-check"></i> Admin Panel</li>
                            <li><i class="fas fa-check"></i> Basic E-commerce</li>
                            <li><i class="fas fa-check"></i> SEO Optimization</li>
                            <li><i class="fas fa-times"></i> Mobile App</li>
                        </ul>
                    </div>
                    <div class="pricing-cta">
                        <a href="https://wa.me/6281234567890" class="btn" target="_blank">Pesan Sekarang</a>
                    </div>
                </div>
                
                <!-- Paket Enterprise -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3 class="pricing-name">Paket Enterprise</h3>
                        <div class="pricing-price">Rp 19.9JT</div>
                        <div class="pricing-period">Custom Project</div>
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Unlimited Pages</li>
                            <li><i class="fas fa-check"></i> Advanced E-commerce</li>
                            <li><i class="fas fa-check"></i> Mobile App Included</li>
                            <li><i class="fas fa-check"></i> Custom Features</li>
                            <li><i class="fas fa-check"></i> API Integration</li>
                            <li><i class="fas fa-check"></i> Priority Support</li>
                            <li><i class="fas fa-check"></i> 1 Year Maintenance</li>
                        </ul>
                    </div>
                    <div class="pricing-cta">
                        <a href="https://wa.me/6281234567890" class="btn btn-outline" target="_blank">Konsultasi Proyek</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-tech-section">
        <div class="container">
            <div class="cta-content">
                <h2>Siap Transformasi Bisnis Anda ke Digital?</h2>
                <p>Konsultasikan kebutuhan website atau aplikasi Anda dengan tim developer kami. Dapatkan solusi digital yang tepat untuk pertumbuhan bisnis Anda.</p>
                
                <div class="hero-actions">
                    <a href="kontak.html" class="btn btn-light">
                        <i class="fas fa-calendar-alt"></i> Jadwalkan Meeting
                    </a>
                    <a href="https://wa.me/6281234567890" class="btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                    
                    // Tutup mobile menu jika terbuka
                    closeMobileMenu();
                }
            });
        });

        // Update WhatsApp links dengan pesan khusus software house
        const whatsappLinks = document.querySelectorAll('a[href*="wa.me"]');
        
        whatsappLinks.forEach(link => {
            if (link.classList.contains('btn-light') || link.textContent.includes('Konsultasi')) {
                const message = "Halo Ravaa Creative Tech, saya tertarik dengan layanan software house/development. Bisa info lebih detail?";
                const encodedMessage = encodeURIComponent(message);
                link.href = `https://wa.me/6281234567890?text=${encodedMessage}`;
            }
        });

        // Animasi saat scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe service cards
        document.querySelectorAll('.service-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });

        // Observe tech items
        document.querySelectorAll('.tech-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });

        // Observe portfolio items
        document.querySelectorAll('.portfolio-tech-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });

        // Observe pricing cards
        document.querySelectorAll('.pricing-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });

        // Animasi process steps
        document.querySelectorAll('.process-step').forEach((step, index) => {
            step.style.opacity = '0';
            step.style.transform = 'translateY(20px)';
            step.style.transition = `opacity 0.5s ease ${index * 0.2}s, transform 0.5s ease ${index * 0.2}s`;
            observer.observe(step);
        });

        // Counter animation untuk tech stack (jika ada counter)
        const techItems = document.querySelectorAll('.tech-item');
        techItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-5px) scale(1.05)';
            });
            
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateY(-5px)';
            });
        });
    </script>
@endsection