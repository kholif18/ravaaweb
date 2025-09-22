<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Banner -->
    <section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-4 fw-bold mb-3">Shop Our Latest Products</h1>
            <p class="lead mb-4">Temukan barang terbaik dengan diskon khusus untuk Anda.</p>
        </div>
    </div>
    </section>

    <!-- Category Filter -->
    <div class="container">
        <div class="category-filter mb-4 text-center">
            <h4 class="mb-3">Filter Berdasarkan Kategori</h4>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <button type="button" class="btn btn-outline-primary active" data-category="all">Semua</button>
                <button type="button" class="btn btn-outline-primary" data-category="electronics">Elektronik</button>
                <button type="button" class="btn btn-outline-primary" data-category="fashion">Fashion</button>
                <button type="button" class="btn btn-outline-primary" data-category="home">Rumah</button>
                <button type="button" class="btn btn-outline-primary" data-category="books">Buku</button>
            </div>
        </div>


        <!-- Product Grid -->
        <div class="row g-4">
            <!-- Produk 1 -->
            <div class="col-6 col-md-3 product-item" data-category="electronics">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_1.png" class="img-fluid product-img" alt="Smartphone">
                        <div class="card-body">
                            <h5 class="card-title">Smartphone X1</h5>
                            <p class="card-text text-muted small">Kamera 108MP, layar 6.7"</p>
                            <span class="fw-bold text-danger">Rp3.999.000</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produk 2 -->
            <div class="col-6 col-md-3 product-item" data-category="fashion">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_2.jpg" class="img-fluid product-img" alt="T-shirt">
                        <div class="card-body">
                            <h5 class="card-title">T-Shirt Premium</h5>
                            <p class="card-text text-muted small">Bahan katun, warna hitam & biru</p>
                            <span class="fw-bold text-danger">Rp149.000</span>
                        </div>  
                    </div>
                </a>
            </div>

            <!-- Produk 3 -->
            <div class="col-6 col-md-3 product-item" data-category="home">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_3.jpeg" class="img-fluid product-img" alt="Lampu">
                        <div class="card-body">
                            <h5 class="card-title">Lampu LED Modern</h5>
                            <p class="card-text text-muted small">Desain minimal, bisa diatur cahaya</p>
                            <span class="fw-bold text-danger">Rp279.000</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produk 4 -->
            <div class="col-6 col-md-3 product-item" data-category="books">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_4.jpg" class="img-fluid product-img" alt="Buku">
                        <div class="card-body">
                            <h5 class="card-title">Belajar Python</h5>
                            <p class="card-text text-muted small">Untuk pemula, lengkap dengan latihan</p>
                            <span class="fw-bold text-danger">Rp129.000</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produk 5 -->
            <div class="col-6 col-md-3 product-item" data-category="electronics">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_1.png" class="img-fluid product-img" alt="Headphones">
                        <div class="card-body">
                            <h5 class="card-title">Headphone Gaming</h5>
                            <p class="card-text text-muted small">Audio berkualitas tinggi, noise cancelling</p>
                            <span class="fw-bold text-danger">Rp699.000</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produk 6 -->
            <div class="col-6 col-md-3 product-item" data-category="fashion">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_2.jpg" class="img-fluid product-img" alt="Sepatu">
                        <div class="card-body">
                            <h5 class="card-title">Sepatu Sneaker</h5>
                            <p class="card-text text-muted small">Nyaman, cocok untuk sehari-hari</p>
                            <span class="fw-bold text-danger">Rp499.000</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produk 7 -->
            <div class="col-6 col-md-3 product-item" data-category="home">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_3.jpeg" class="img-fluid product-img" alt="Meja">
                        <div class="card-body">
                            <h5 class="card-title">Meja Kerja Minimalis</h5>
                            <p class="card-text text-muted small">Kayu solid, antikarat</p>
                            <span class="fw-bold text-danger">Rp1.299.000</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Produk 8 -->
            <div class="col-6 col-md-3 product-item" data-category="books">
                <a href="<?= site_url('/detail') ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="assets/img/product_4.jpg" class="img-fluid product-img" alt="Jurnal">
                        <div class="card-body">
                            <h5 class="card-title">Jurnal Harian</h5>
                            <p class="card-text text-muted small">100 halaman, spiral binding</p>
                            <span class="fw-bold text-danger">Rp89.000</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>

<?= $this->endSection() ?>
