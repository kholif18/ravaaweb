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
        <div class="category-filter">
            <h4 class="mb-3">Filter Berdasarkan Kategori</h4>
            <div class="btn-group btn-group-md" role="group" aria-label="Filter Kategori">
                <button type="button" class="btn btn-filter active" data-category="all">Semua</button>
                <button type="button" class="btn btn-filter" data-category="electronics">Elektronik</button>
                <button type="button" class="btn btn-filter" data-category="fashion">Fashion</button>
                <button type="button" class="btn btn-filter" data-category="home">Rumah</button>
                <button type="button" class="btn btn-filter" data-category="books">Buku</button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-4">
        <!-- Produk 1 -->
        <div class="col-6 col-md-3 product-item" data-category="electronics">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?smartphone" class="img-fluid product-img" alt="Smartphone">
            <div class="card-body">
                <h5 class="card-title">Smartphone X1</h5>
                <p class="card-text text-muted small">Kamera 108MP, layar 6.7"</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp3.999.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 2 -->
        <div class="col-6 col-md-3 product-item" data-category="fashion">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?tshirt" class="img-fluid product-img" alt="T-shirt">
            <div class="card-body">
                <h5 class="card-title">T-Shirt Premium</h5>
                <p class="card-text text-muted small">Bahan katun, warna hitam & biru</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp149.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 3 -->
        <div class="col-6 col-md-3 product-item" data-category="home">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?lamp" class="img-fluid product-img" alt="Lampu">
            <div class="card-body">
                <h5 class="card-title">Lampu LED Modern</h5>
                <p class="card-text text-muted small">Desain minimal, bisa diatur cahaya</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp279.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 4 -->
        <div class="col-6 col-md-3 product-item" data-category="books">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?book" class="img-fluid product-img" alt="Buku">
            <div class="card-body">
                <h5 class="card-title">Belajar Python</h5>
                <p class="card-text text-muted small">Untuk pemula, lengkap dengan latihan</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp129.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 5 -->
        <div class="col-6 col-md-3 product-item" data-category="electronics">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?headphones" class="img-fluid product-img" alt="Headphones">
            <div class="card-body">
                <h5 class="card-title">Headphone Gaming</h5>
                <p class="card-text text-muted small">Audio berkualitas tinggi, noise cancelling</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp699.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 6 -->
        <div class="col-6 col-md-3 product-item" data-category="fashion">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?shoes" class="img-fluid product-img" alt="Sepatu">
            <div class="card-body">
                <h5 class="card-title">Sepatu Sneaker</h5>
                <p class="card-text text-muted small">Nyaman, cocok untuk sehari-hari</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp499.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 7 -->
        <div class="col-6 col-md-3 product-item" data-category="home">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?table" class="img-fluid product-img" alt="Meja">
            <div class="card-body">
                <h5 class="card-title">Meja Kerja Minimalis</h5>
                <p class="card-text text-muted small">Kayu solid, antikarat</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp1.299.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Produk 8 -->
        <div class="col-6 col-md-3 product-item" data-category="books">
            <div class="card product-card h-100 shadow-sm">
            <img src="https://source.unsplash.com/random/300x300/?journal" class="img-fluid product-img" alt="Jurnal">
            <div class="card-body">
                <h5 class="card-title">Jurnal Harian</h5>
                <p class="card-text text-muted small">100 halaman, spiral binding</p>
                <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-danger">Rp89.000</span>
                <button class="btn btn-sm btn-outline-primary">Beli Sekarang</button>
                </div>
            </div>
            </div>
        </div>
        </div>

    </div>

<?= $this->endSection() ?>
