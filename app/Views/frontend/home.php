<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section with Animated Gradient -->
<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <h1 class="display-4 fw-bold mb-3">Selamat Datang di Ravaa Creative</h1>
      <p class="lead mb-4">Temukan berbagai produk berkualitas dengan harga terbaik</p>
      <a href="#products" class="btn btn-light btn-lg px-4 py-2 rounded-pill">Jelajahi Sekarang</a>
    </div>
  </div>
</section>

<!-- Banner Section -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <!-- Banner 1 -->
      <div class="col-md-4">
        <div class="banner floating" style="background-image: url('<?= base_url('assets/img/product_1.png') ?>')">
          <div class="banner-content">
            <h2 class="banner-title">Promo Bulan Ini</h2>
            <p class="banner-subtitle">Diskon hingga 50% untuk produk terlaris!</p>
            <a href="<?= base_url('/shop') ?>" class="btn btn-banner">Belanja Sekarang</a>
          </div>
        </div>
      </div>

      <!-- Banner 2 -->
      <div class="col-md-4">
        <div class="banner floating" style="background-image: url('<?= base_url('assets/img/product_2.jpg') ?>')">
          <div class="banner-content">
            <h2 class="banner-title">Produk Baru</h2>
            <p class="banner-subtitle">Diluncurkan dengan fitur terbaik!</p>
            <a href="<?= base_url('/shop') ?>" class="btn btn-banner">Cek Sekarang</a>
          </div>
        </div>
      </div>

      <!-- Banner 3 -->
      <div class="col-md-4">
        <div class="banner floating" style="background-image: url('<?= base_url('assets/img/product_3.jpeg') ?>')">
          <div class="banner-content">
            <h2 class="banner-title">Gratis Ongkir</h2>
            <p class="banner-subtitle">Untuk pembelian di atas Rp200.000!</p>
            <a href="<?= base_url('/shop') ?>" class="btn btn-banner">Beli Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Kategori Produk -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5">Kategori Produk</h2>
    <div class="row g-4">
      <!-- Kategori 1 -->
      <div class="col-md-3">
        <div class="category-card text-center p-4 shadow-sm rounded-3 glass-card">
          <i class="fas fa-print fa-3x text-danger mb-3"></i>
          <h5>Print</h5>
        </div>
      </div>

      <!-- Kategori 2 -->
      <div class="col-md-3">
        <div class="category-card text-center p-4 shadow-sm rounded-3 glass-card">
          <i class="fas fa-paint-brush fa-3x text-info mb-3"></i>
          <h5>Design</h5>
        </div>
      </div>

      <!-- Kategori 3 -->
      <div class="col-md-3">
        <div class="category-card text-center p-4 shadow-sm rounded-3 glass-card">
          <i class="fas fa-pen fa-3x text-primary mb-3"></i>
          <h5>ATK</h5>
        </div>
      </div>

      <!-- Kategori 4 -->
      <div class="col-md-3">
        <div class="category-card text-center p-4 shadow-sm rounded-3 glass-card">
          <i class="fas fa-tshirt fa-3x text-warning mb-3"></i>
          <h5>Sablon</h5>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Produk Terbaru -->
<section class="py-5" id="products">
  <div class="container">
    <h2 class="text-center mb-5">Produk Terbaru</h2>
    <div class="row g-4">
      <!-- Produk 1 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Smartphone" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Smartphone Pro Max</h6>
              <p class="product-price">Rp12.999.000</p>
            </div>
          </div>
        </a>
      </div>
      <!-- Produk 2 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Laptop" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Laptop Gaming X1</h6>
              <p class="product-price">Rp25.500.000</p>
            </div>
          </div>
        </a>
      </div>
      <!-- Produk 3 -->
      <div class="col-6 col-md-3">
        <div class="product-card">
          <img src="assets/img/product_1.png" alt="Smartwatch" class="img-fluid product-img">
          <div class="p-3">
            <h6 class="product-title">Smartwatch Fit</h6>
            <p class="product-price">Rp2.199.000</p>
          </div>
        </div>
      </div>
      <!-- Produk 4 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Speaker" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Speaker Bluetooth</h6>
              <p class="product-price">Rp899.000</p>
            </div>
          </div>
        </a>
      </div>
      <!-- Produk 5 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Smartphone" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Smartphone Pro Max</h6>
              <p class="product-price">Rp12.999.000</p>
            </div>
          </div>
        </a>
      </div>
      <!-- Produk 6 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Laptop" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Laptop Gaming X1</h6>
              <p class="product-price">Rp25.500.000</p>
            </div>
          </div>
        </a>
      </div>
      <!-- Produk 7 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Smartwatch" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Smartwatch Fit</h6>
              <p class="product-price">Rp2.199.000</p>
            </div>
          </div>
        </a>
      </div>
      <!-- Produk 8 -->
      <div class="col-6 col-md-3">
        <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
          <div class="product-card">
            <img src="assets/img/product_1.png" alt="Speaker" class="img-fluid product-img">
            <div class="p-3">
              <h6 class="product-title">Speaker Bluetooth</h6>
              <p class="product-price">Rp899.000</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center">
        <div class="p-4 rounded-3 glass-card">
          <h3>Hubungi Kami Langsung</h3>
          <p class="mb-4">Butuh bantuan atau ingin pesan produk? Chat kami via WhatsApp!</p>
          <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success rounded-pill px-4">
            <i class="fab fa-whatsapp"></i> Chat via WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
