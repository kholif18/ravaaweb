<!-- Header -->
    <header>
        <div class="container header-container">
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-palette"></i>
                Ravaa<span>Creative</span>
            </a>
            
            <!-- Desktop Navigation -->
            <div class="desktop-nav">
                <nav>
                    <ul>
                        <li><a href="{{ url('/') }}" class="active">Home</a></li>
                        <li><a href="{{ url('/layanan') }}">Layanan</a></li>
                        <li><a href="{{ url('/product') }}">Produk</a></li>
                        <li><a href="{{ url('/portofolio') }}">Portfolio</a></li>
                        <li><a href="{{ url('/software-house') }}">Software House</a></li>
                        <li><a href="#">Form</a></li>
                        <li><a href="{{ url('/contact') }}">Kontak</a></li>
                    </ul>
                </nav>
                
                <div class="desktop-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari produk...">
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

    <!-- Mobile Navigation Menu -->
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <a href="index.html" class="logo">
                <i class="fas fa-palette"></i>
                Ravaa<span>Creative</span>
            </a>
            <button class="mobile-close-btn" id="mobileCloseBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mobile-nav-content">
            <ul class="mobile-nav-menu">
                <li><a href="{{ url('/') }}" class="active">Home</a></li>
                <li><a href="{{ url('/layanan') }}">Layanan</a></li>
                <li><a href="{{ url('/product') }}">Produk</a></li>
                <li><a href="{{ url('/portofolio') }}">Portfolio</a></li>
                <li><a href="{{ url('/software-house') }}">Software House</a></li>
                <li><a href="#">Form</a></li>
                <li><a href="{{ url('/contact') }}">Kontak</a></li>
            </ul>
        </div>
        
        <div class="mobile-actions">
            <div class="mobile-search" style="position: relative;">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari produk atau layanan...">
            </div>
            
            <div class="mobile-contact">
                <p>Butuh bantuan? Hubungi kami:</p>
                <a href="https://wa.me/6281234567890" class="btn" style="width: 100%;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>