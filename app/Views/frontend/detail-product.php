<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<style>
      
  .tab-pane {
    display: none;
  }
  
  .tab-pane.active {
    display: block;
  }
  
</style>

<!-- Breadcrumb -->
<section class="py-3">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fas fa-home me-1"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Produk</a></li>
        <li class="breadcrumb-item"><a href="#">Elektronik</a></li>
        <li class="breadcrumb-item active" aria-current="page">Smartphone Pro Max</li>
      </ol>
    </nav>
  </div>
</section>

<!-- Product Detail Section -->
<section class="py-4">
  <div class="container">
    <div class="row">
      <!-- Product Gallery -->
      <div class="col-lg-6 mb-4">
        <div class="product-gallery">
          <div class="main-image">
            <img id="main-product-image" src="<?= base_url('assets/img/product_1.png') ?>" alt="Smartphone Pro Max">
          </div>
          <div class="thumbnail-container">
            <div class="thumbnail active" data-image="<?= base_url('assets/img/product_1.png') ?>">
              <img src="<?= base_url('assets/img/product_1.png') ?>" alt="Thumbnail 1">
            </div>
            <div class="thumbnail" data-image="<?= base_url('assets/img/product_2.jpg') ?>">
              <img src="<?= base_url('assets/img/product_2.jpg') ?>" alt="Thumbnail 2">
            </div>
            <div class="thumbnail" data-image="<?= base_url('assets/img/product_3.jpeg') ?>">
              <img src="<?= base_url('assets/img/product_3.jpeg') ?>" alt="Thumbnail 3">
            </div>
            <div class="thumbnail" data-image="<?= base_url('assets/img/product_1.png') ?>">
              <img src="<?= base_url('assets/img/product_1.png') ?>" alt="Thumbnail 4">
            </div>
          </div>
        </div>
      </div>
      
      <!-- Product Info -->
      <div class="col-lg-6 mb-4">
        <div class="product-info">
          <h1 class="product-title">Smartphone Pro Max 512GB - Garansi Resmi</h1>
          
          <div class="product-price">
            <span class="current-price" id="product-price">Rp12.999.000</span>
            <span class="original-price">Rp14.999.000</span>
            <span class="discount-badge">13%</span>
          </div>
          
          <div class="variant-section">
            <h5 class="variant-title">Pilih Warna:</h5>
            <div class="variant-options">
              <div class="variant-option active" data-variant="hitam" data-price="12999000">Hitam</div>
              <div class="variant-option" data-variant="putih" data-price="12999000">Putih</div>
              <div class="variant-option" data-variant="emas" data-price="13499000">Emas</div>
              <div class="variant-option" data-variant="biru" data-price="13299000">Biru</div>
            </div>
          </div>
          
          <div class="variant-section">
            <h5 class="variant-title">Pilih Storage:</h5>
            <div class="variant-options">
              <div class="variant-option" data-variant="128gb" data-price="11999000">128GB</div>
              <div class="variant-option active" data-variant="256gb" data-price="12999000">256GB</div>
              <div class="variant-option" data-variant="512gb" data-price="14999000">512GB</div>
              <div class="variant-option" data-variant="1tb" data-price="16999000">1TB</div>
            </div>
          </div>
          
          <div class="action-buttons">
            <button class="btn-message">
              <i class="fab fa-whatsapp me-2"></i> Pesan Sekarang
            </button>
            <button class="btn-message-telegram">
              <i class="fab fa-telegram me-2"></i> Pesan Sekarang
            </button>
          </div>
          
          <div class="product-meta">
            <div class="meta-item">
              <span class="meta-label">Kategori:</span>
              <span class="meta-value">Elektronik > Smartphone</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Stok:</span>
              <span class="meta-value text-success">Tersedia (25)</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Pengiriman:</span>
              <span class="meta-value">Gratis ongkir ke Jakarta</span>
            </div>
            <div class="meta-item">
              <span class="meta-label">Garansi:</span>
              <span class="meta-value">Resmi 1 tahun</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Product Description & Tabs -->
    <div class="product-tabs">
        <div class="tab-nav">
            <button class="tab-link active" data-tab="description">Deskripsi Produk</button>
            <button class="tab-link" data-tab="specification">Spesifikasi</button>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane active" id="description">
            <h4>Deskripsi Smartphone Pro Max</h4>
            <p>Smartphone Pro Max adalah ponsel flagship dengan performa terbaik di kelasnya. Dilengkapi dengan prosesor terbaru, kamera canggih, dan baterai tahan lama.</p>
            
            <h5>Fitur Utama:</h5>
            <ul>
                <li>Layar Super Retina XDR 6.7 inci</li>
                <li>Chip A15 Bionic dengan Neural Engine</li>
                <li>Sistem kamera Pro 12MP dengan sensor baru</li>
                <li>Baterai tahan seharian dengan fast charging</li>
                <li>Tahan air dan debu (IP68)</li>
                <li>5G untuk download super cepat</li>
            </ul>
            
            <h5>Keunggulan Produk:</h5>
            <p>Dengan desain premium dan material berkualitas tinggi, smartphone ini memberikan pengalaman penggunaan yang luar biasa. Cocok untuk produktivitas, gaming, dan kreativitas.</p>
            </div>
            
            <div class="tab-pane" id="specification">
            <h4>Spesifikasi Teknis</h4>
            <table class="table table-bordered">
                <tr>
                <td width="30%">Layar</td>
                <td>6.7 inci, Super Retina XDR, OLED</td>
                </tr>
                <tr>
                <td>Chipset</td>
                <td>A15 Bionic Chip</td>
                </tr>
                <tr>
                <td>RAM/Storage</td>
                <td>6GB/256GB</td>
                </tr>
                <tr>
                <td>Kamera Belakang</td>
                <td>12MP Wide + 12MP Ultra Wide + 12MP Telephoto</td>
                </tr>
                <tr>
                <td>Kamera Depan</td>
                <td>12MP TrueDepth</td>
                </tr>
                <tr>
                <td>Baterai</td>
                <td>4352 mAh, Fast Charging 20W</td>
                </tr>
                <tr>
                <td>Sistem Operasi</td>
                <td>iOS 15</td>
                </tr>
            </table>
            </div>
            
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="related-products">
      <h3 class="section-title">Produk Terkait</h3>
      <div class="row">
        <div class="col-md-3 col-6 mb-4">
          <div class="related-product-card">
            <img src="<?= base_url('assets/img/product_1.png') ?>" alt="Related Product" class="related-product-img">
            <div class="related-product-info">
              <h6 class="related-product-title">Smartphone Pro 256GB</h6>
              <p class="related-product-price">Rp10.999.000</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="related-product-card">
            <img src="<?= base_url('assets/img/product_2.jpg') ?>" alt="Related Product" class="related-product-img">
            <div class="related-product-info">
              <h6 class="related-product-title">Smartphone Standard 128GB</h6>
              <p class="related-product-price">Rp7.999.000</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="related-product-card">
            <img src="<?= base_url('assets/img/product_3.jpeg') ?>" alt="Related Product" class="related-product-img">
            <div class="related-product-info">
              <h6 class="related-product-title">Wireless Charger</h6>
              <p class="related-product-price">Rp499.000</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="related-product-card">
            <img src="<?= base_url('assets/img/product_1.png') ?>" alt="Related Product" class="related-product-img">
            <div class="related-product-info">
              <h6 class="related-product-title">Case Premium</h6>
              <p class="related-product-price">Rp299.000</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Thumbnail Gallery Functionality
  document.querySelectorAll('.thumbnail').forEach(thumb => {
    thumb.addEventListener('click', function() {
      // Remove active class from all thumbnails
      document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
      
      // Add active class to clicked thumbnail
      this.classList.add('active');
      
      // Change main image
      const newImage = this.getAttribute('data-image');
      document.getElementById('main-product-image').src = newImage;
    });
  });
  
  // Variant Selection Functionality
  document.querySelectorAll('.variant-option').forEach(option => {
    option.addEventListener('click', function() {
      if (this.classList.contains('disabled')) return;
      
      // Remove active class from siblings
      const parent = this.parentElement;
      parent.querySelectorAll('.variant-option').forEach(opt => opt.classList.remove('active'));
      
      // Add active class to clicked option
      this.classList.add('active');
      
      // Update price (in a real app, this would calculate based on all selected variants)
      updateProductPrice();
    });
  });
  
  // Tab Functionality
  document.querySelectorAll('.tab-link').forEach(tab => {
    tab.addEventListener('click', function() {
      // Remove active class from all tabs
      document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
      
      // Add active class to clicked tab
      this.classList.add('active');
      
      // Show corresponding content
      const tabId = this.getAttribute('data-tab');
      document.getElementById(tabId).classList.add('active');
    });
  });
  
  // Update product price based on selected variants
  function updateProductPrice() {
    // In a real application, this would calculate based on all selected variants
    const activeOptions = document.querySelectorAll('.variant-option.active');
    let basePrice = 12999000; // Base price
    
    // Check for price modifiers from variants
    activeOptions.forEach(option => {
      const variantPrice = option.getAttribute('data-price');
      if (variantPrice) {
        basePrice = parseInt(variantPrice);
      }
    });
    
    // Format price with Indonesian Rupiah format
    const formattedPrice = 'Rp' + basePrice.toLocaleString('id-ID');
    document.getElementById('product-price').textContent = formattedPrice;
  }
</script>

<?= $this->endSection() ?>