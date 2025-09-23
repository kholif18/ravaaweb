<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="about-hero">
  <div class="container">
    <div class="about-hero-content">
      <h1>Tentang Toko Kami</h1>
      <p>Sejak 2010, kami berkomitmen memberikan produk berkualitas dengan pelayanan terbaik untuk kebutuhan Anda</p>
    </div>
  </div>
</section>

<!-- Values Section -->
<section class="about-section bg-light">
  <div class="container">
    <h2 class="section-title">Nilai Kami</h2>
    <div class="values-grid">
      <!-- Value 1 -->
      <div class="value-card">
        <div class="value-icon">
          <i class="fas fa-award"></i>
        </div>
        <h4>Kualitas Terbaik</h4>
        <p>Kami hanya menyediakan produk dengan kualitas terjamin dan bergaransi resmi.</p>
      </div>
      
      <!-- Value 2 -->
      <div class="value-card">
        <div class="value-icon">
          <i class="fas fa-hand-holding-heart"></i>
        </div>
        <h4>Pelayanan Ramah</h4>
        <p>Tim customer service kami siap membantu dengan senyuman dan solusi terbaik.</p>
      </div>
      
      <!-- Value 3 -->
      <div class="value-card">
        <div class="value-icon">
          <i class="fas fa-shipping-fast"></i>
        </div>
        <h4>Pengiriman Cepat</h4>
        <p>Pesanan diproses maksimal 2 jam dan dikirim dengan partner terpercaya.</p>
      </div>
      
      <!-- Value 4 -->
      <div class="value-card">
        <div class="value-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <h4>Terpercaya</h4>
        <p>Sudah melayani ribuan pelanggan dengan rating 4.9/5 dari 2000+ ulasan.</p>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
  <div class="container">
    <h2 class="section-title" style="color: white;">Pencapaian Kami</h2>
    <div class="stats-grid">
      <!-- Stat 1 -->
      <div class="stat-item">
        <div class="stat-number" data-count="10000">0</div>
        <div class="stat-label">Pelanggan Setia</div>
      </div>
      
      <!-- Stat 2 -->
      <div class="stat-item">
        <div class="stat-number" data-count="50000">0</div>
        <div class="stat-label">Produk Terjual</div>
      </div>
      
      <!-- Stat 3 -->
      <div class="stat-item">
        <div class="stat-number" data-count="12">0</div>
        <div class="stat-label">Tahun Pengalaman</div>
      </div>
      
      <!-- Stat 4 -->
      <div class="stat-item">
        <div class="stat-number" data-count="50">0</div>
        <div class="stat-label">Mitra Kerja</div>
      </div>
    </div>
  </div>
</section>

<!-- Team Section -->
<section class="about-section">
  <div class="container">
    <h2 class="section-title">Tim Kami</h2>
    <div class="team-grid">
      <!-- Team 1 -->
      <div class="team-card">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Team Member" class="team-img">
        <div class="team-info">
          <h4>Budi Santoso</h4>
          <p>Founder & CEO</p>
          <div class="team-social">
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Team 2 -->
      <div class="team-card">
        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Team Member" class="team-img">
        <div class="team-info">
          <h4>Sari Indah</h4>
          <p>Head of Marketing</p>
          <div class="team-social">
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Team 3 -->
      <div class="team-card">
        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Team Member" class="team-img">
        <div class="team-info">
          <h4>Andi Wijaya</h4>
          <p>Operations Manager</p>
          <div class="team-social">
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Team 4 -->
      <div class="team-card">
        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Team Member" class="team-img">
        <div class="team-info">
          <h4>Maya Sari</h4>
          <p>Customer Service Lead</p>
          <div class="team-social">
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact & Map Section -->
<section class="contact-map-section">
  <div class="container">
    <h2 class="section-title">Kunjungi Toko Kami</h2>
    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="contact-info">
          <h3 class="mb-4">Informasi Kontak</h3>
          
          <div class="contact-item">
            <div class="contact-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="contact-details">
              <h5>Alamat</h5>
              <p>Gedong, Ds. Ngluyu, Kec. Ngluyu<br>Kabupaten Nganjuk (64452)</p>
            </div>
          </div>
          
          <div class="contact-item">
            <div class="contact-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="contact-details">
              <h5>Telepon</h5>
              <p>0822-3337-7661</p>
            </div>
          </div>
          
          <div class="contact-item">
            <div class="contact-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="contact-details">
              <h5>Email</h5>
              <p>ravaacreative@gmail.com</p>
            </div>
          </div>
          
          <div class="contact-item">
            <div class="contact-icon">
              <i class="fas fa-clock"></i>
            </div>
            <div class="contact-details">
              <h5>Jam Operasional</h5>
              <p>Senin - Jumat: <br> <strong>14.00 - 20.30 WIB</strong><br>Sabtu - Minggu: <br><strong> 09.00 - 20.00 WIB</strong></p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-8">
        <div class="map-container">
          <!-- Google Maps Placeholder -->
          <!-- <div class="map-placeholder">
            <div class="text-center">
              <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
              <p>Google Maps Integration<br><small>Jl. Merdeka No. 123, Jakarta Pusat</small></p>
            </div>
          </div> -->
          
          <!-- Actual Google Maps Embed Code (Uncomment and replace with your actual embed code) -->
          
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.25972554651173!2d111.95915741726891!3d-7.4480304330623195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78314e57a1625b%3A0xc3489dfdef9e5eee!2sRavaa%20Creative!5e0!3m2!1sen!2sid!4v1758549933036!5m2!1sen!2sid" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Counter Animation
  function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200; // The lower the slower
    
    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-count');
        const count = +counter.innerText.replace(/[^0-9]/g, '');
        
        const inc = target / speed;
        
        if (count < target) {
          counter.innerText = Math.ceil(count + inc).toLocaleString('id-ID');
          setTimeout(updateCount, 1);
        } else {
          counter.innerText = target.toLocaleString('id-ID');
        }
      };
      
      updateCount();
    });
  }
  
  // Intersection Observer for counter animation
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounters();
        observer.unobserve(entry.target);
      }
    });
  });
  
  observer.observe(document.querySelector('.stats-section'));
  
  // Add fade-in animation to elements on scroll
  const fadeElements = document.querySelectorAll('.timeline-content, .value-card, .team-card');
  
  const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
        fadeObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  
  fadeElements.forEach(el => {
    el.style.opacity = '0';
    fadeObserver.observe(el);
  });
</script>

<?= $this->endSection() ?>