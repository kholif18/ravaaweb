@extends('frontend.layouts.master')

@section('title', 'Layanan Kami')

@section('content')
    
    <!-- Hero Section -->
    <section class="hero-services">
        <div class="container">
            <h1>Layanan Profesional Kami</h1>
            <p>Ravaa Creative menyediakan berbagai solusi kreatif untuk kebutuhan desain, percetakan, dan alat tulis kantor Anda. Tim profesional kami siap membantu mewujudkan ide-ide kreatif menjadi hasil yang memukau.</p>
        </div>
    </section>

    <!-- Service Categories -->
    <section class="service-categories">
        <div class="container">
            <div class="section-title">
                <h2>Kategori Layanan</h2>
            </div>
            
            <p class="section-subtitle">Kami menawarkan berbagai layanan profesional yang disesuaikan dengan kebutuhan bisnis Anda. Pilih kategori layanan untuk melihat detailnya.</p>
            
            <div class="category-tabs">
                <div class="category-tab active" data-service="design">
                    <i class="fas fa-paint-brush"></i>
                    Desain Grafis
                </div>
                <div class="category-tab" data-service="printing">
                    <i class="fas fa-print"></i>
                    Percetakan
                </div>
                <div class="category-tab" data-service="atk">
                    <i class="fas fa-pen-fancy"></i>
                    ATK & Perlengkapan
                </div>
                <div class="category-tab" data-service="merchandise">
                    <i class="fas fa-tshirt"></i>
                    Sablon & Merchandise
                </div>
                <div class="category-tab" data-service="digital">
                    <i class="fas fa-laptop-code"></i>
                    Digital Printing
                </div>
            </div>
        </div>
    </section>

    <!-- Service Detail: Desain Grafis -->
    <section class="service-detail">
        <div class="container">
            <div class="service-content active" id="design-content">
                <div class="service-header">
                    <div class="service-title">
                        <div class="service-icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <div>
                            <h2>Desain Grafis Profesional</h2>
                            <p>Mewujudkan ide kreatif Anda menjadi desain visual yang menarik</p>
                        </div>
                    </div>
                    <div class="service-cta">
                        <a href="#" class="btn">Konsultasi Gratis</a>
                        <a href="portfolio.html" class="btn btn-outline">Lihat Portfolio</a>
                    </div>
                </div>
                
                <p class="service-description">
                    Layanan desain grafis profesional kami mencakup pembuatan logo, branding, brosur, banner, dan materi promosi lainnya. Tim desainer berpengalaman kami siap membantu mengkomunikasikan pesan bisnis Anda melalui desain visual yang menarik dan efektif.
                </p>
                
                <div class="service-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4>Desain Logo & Branding</h4>
                        <p>Pembuatan logo, identitas visual, dan panduan branding untuk membangun citra perusahaan yang kuat dan konsisten.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h4>Materi Promosi</h4>
                        <p>Desain brosur, flyer, banner, katalog, dan materi promosi cetak maupun digital lainnya untuk kampanye pemasaran.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h4>Digital & UI/UX Design</h4>
                        <p>Desain website, aplikasi mobile, user interface, dan pengalaman pengguna untuk platform digital.</p>
                    </div>
                </div>
                
                <div class="service-packages">
                    <h3 style="margin-bottom: 30px;">Paket Layanan Desain</h3>
                    
                    <div class="package-grid">
                        <div class="package-card">
                            <div class="package-header">
                                <h4 class="package-name">Paket Dasar</h4>
                                <div class="package-price">Rp 499K</div>
                                <div class="package-period">Proyek sederhana</div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> 1 konsep desain</li>
                                    <li><i class="fas fa-check"></i> 3 revisi minor</li>
                                    <li><i class="fas fa-check"></i> File final (JPG, PNG)</li>
                                    <li><i class="fas fa-times"></i> File sumber (AI/PSD)</li>
                                    <li><i class="fas fa-times"></i> Panduan branding</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#" class="btn btn-outline">Pilih Paket</a>
                            </div>
                        </div>
                        
                        <div class="package-card popular">
                            <div class="package-badge">POPULAR</div>
                            <div class="package-header">
                                <h4 class="package-name">Paket Profesional</h4>
                                <div class="package-price">Rp 1.299K</div>
                                <div class="package-period">Proyek komprehensif</div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> 3 konsep desain</li>
                                    <li><i class="fas fa-check"></i> Revisi tanpa batas</li>
                                    <li><i class="fas fa-check"></i> File final semua format</li>
                                    <li><i class="fas fa-check"></i> File sumber (AI/PSD)</li>
                                    <li><i class="fas fa-check"></i> Panduan branding lengkap</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#" class="btn">Pilih Paket</a>
                            </div>
                        </div>
                        
                        <div class="package-card">
                            <div class="package-header">
                                <h4 class="package-name">Paket Perusahaan</h4>
                                <div class="package-price">Rp 3.999K</div>
                                <div class="package-period">Paket bulanan</div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Unlimited desain proyek</li>
                                    <li><i class="fas fa-check"></i> Prioritas pengerjaan</li>
                                    <li><i class="fas fa-check"></i> Konsultasi branding</li>
                                    <li><i class="fas fa-check"></i> Support 24/7</li>
                                    <li><i class="fas fa-check"></i> Revisi tanpa batas</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#" class="btn btn-outline">Pilih Paket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service Detail: Percetakan -->
            <div class="service-content" id="printing-content">
                <div class="service-header">
                    <div class="service-title">
                        <div class="service-icon">
                            <i class="fas fa-print"></i>
                        </div>
                        <div>
                            <h2>Layanan Percetakan</h2>
                            <p>Cetak berkualitas tinggi untuk segala kebutuhan bisnis Anda</p>
                        </div>
                    </div>
                    <div class="service-cta">
                        <a href="#" class="btn">Request Quotation</a>
                        <a href="#" class="btn btn-outline">Lihat Katalog</a>
                    </div>
                </div>
                
                <p class="service-description">
                    Layanan percetakan kami mencakup cetak offset dan digital untuk berbagai media dan ukuran. Dengan peralatan modern dan tenaga ahli, kami menjamin hasil cetak yang tajam, warna akurat, dan ketahanan yang optimal untuk semua produk cetakan Anda.
                </p>
                
                <div class="service-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-scroll"></i>
                        </div>
                        <h4>Cetak Offset</h4>
                        <p>Cetak berkualitas tinggi untuk kebutuhan dalam jumlah besar seperti brosur, buku, katalog, dan kemasan produk.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-print"></i>
                        </div>
                        <h4>Digital Printing</h4>
                        <p>Cetak cepat dengan kualitas tinggi untuk kebutuhan dalam jumlah kecil hingga menengah dengan fleksibilitas waktu.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cut"></i>
                        </div>
                        <h4>Finishing & Packaging</h4>
                        <p>Layanan finishing seperti laminating, spot UV, emboss, dan packaging yang memperindah hasil cetakan.</p>
                    </div>
                </div>
                
                <div class="service-packages">
                    <h3 style="margin-bottom: 30px;">Paket Layanan Percetakan</h3>
                    
                    <div class="package-grid">
                        <div class="package-card">
                            <div class="package-header">
                                <h4 class="package-name">Cetak Digital</h4>
                                <div class="package-price">Mulai Rp 5K</div>
                                <div class="package-period">per lembar</div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Cetak full color A4/A3</li>
                                    <li><i class="fas fa-check"></i> Minimal order 10 lembar</li>
                                    <li><i class="fas fa-check"></i> Pilihan kertas: HVS, Art paper</li>
                                    <li><i class="fas fa-check"></i> Waktu pengerjaan 1-2 hari</li>
                                    <li><i class="fas fa-times"></i> Finishing khusus</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#" class="btn btn-outline">Pilih Paket</a>
                            </div>
                        </div>
                        
                        <div class="package-card popular">
                            <div class="package-badge">POPULAR</div>
                            <div class="package-header">
                                <h4 class="package-name">Cetak Offset</h4>
                                <div class="package-price">Mulai Rp 2K</div>
                                <div class="package-period">per lembar</div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Cetak full color berbagai ukuran</li>
                                    <li><i class="fas fa-check"></i> Minimal order 500 lembar</li>
                                    <li><i class="fas fa-check"></i> Pilihan kertas premium</li>
                                    <li><i class="fas fa-check"></i> Waktu pengerjaan 3-5 hari</li>
                                    <li><i class="fas fa-check"></i> Konsultasi gratis</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#" class="btn">Pilih Paket</a>
                            </div>
                        </div>
                        
                        <div class="package-card">
                            <div class="package-header">
                                <h4 class="package-name">Paket Lengkap</h4>
                                <div class="package-price">Rp 2.5K</div>
                                <div class="package-period">per lembar</div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Desain + cetak + finishing</li>
                                    <li><i class="fas fa-check"></i> Pilihan finishing premium</li>
                                    <li><i class="fas fa-check"></i> Garansi kualitas cetak</li>
                                    <li><i class="fas fa-check"></i> Gratis pengiriman area tertentu</li>
                                    <li><i class="fas fa-check"></i> Prioritas pengerjaan</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#" class="btn btn-outline">Pilih Paket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service Detail: ATK -->
            <div class="service-content" id="atk-content">
                <div class="service-header">
                    <div class="service-title">
                        <div class="service-icon">
                            <i class="fas fa-pen-fancy"></i>
                        </div>
                        <div>
                            <h2>ATK & Perlengkapan Kantor</h2>
                            <p>Kebutuhan alat tulis kantor lengkap dengan harga kompetitif</p>
                        </div>
                    </div>
                    <div class="service-cta">
                        <a href="#" class="btn">Lihat Katalog ATK</a>
                        <a href="#" class="btn btn-outline">Request Quotation</a>
                    </div>
                </div>
                
                <p class="service-description">
                    Menyediakan berbagai kebutuhan alat tulis kantor (ATK) dan perlengkapan kantor lainnya dengan kualitas terjamin. Kami juga menerima pesanan custom dengan logo perusahaan untuk kebutuhan branding internal dan eksternal.
                </p>
                
                <div class="service-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-pen"></i>
                        </div>
                        <h4>Alat Tulis Standar</h4>
                        <p>Berbagai alat tulis kantor seperti pulpen, pensil, penggaris, penghapus, dan perlengkapan menulis lainnya.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-print"></i>
                        </div>
                        <h4>Perlengkapan Cetak</h4>
                        <p>Kertas, tinta printer, toner, dan consumables lainnya untuk mendukung operasional kantor.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <h4>ATK Custom</h4>
                        <p>Pembuatan alat tulis kantor custom dengan logo perusahaan untuk kebutuhan branding dan promosi.</p>
                    </div>
                </div>
            </div>
            
            <!-- Service Detail: Merchandise -->
            <div class="service-content" id="merchandise-content">
                <div class="service-header">
                    <div class="service-title">
                        <div class="service-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div>
                            <h2>Sablon & Merchandise</h2>
                            <p>Produk merchandise custom untuk branding dan promosi perusahaan</p>
                        </div>
                    </div>
                    <div class="service-cta">
                        <a href="#" class="btn">Konsultasi Merchandise</a>
                        <a href="#" class="btn btn-outline">Lihat Produk</a>
                    </div>
                </div>
                
                <p class="service-description">
                    Layanan pembuatan merchandise custom seperti kaos, topi, mug, tumbler, tas, dan berbagai produk promosi lainnya dengan desain sesuai kebutuhan branding perusahaan Anda. Kami menggunakan teknik sablon dan printing terbaik untuk hasil yang tahan lama dan menarik.
                </p>
                
                <div class="service-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <h4>Sablon Kaos & Pakaian</h4>
                        <p>Sablon kaos, kemeja, jaket, dan pakaian lainnya dengan berbagai teknik untuk hasil terbaik.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mug-hot"></i>
                        </div>
                        <h4>Merchandise Promosi</h4>
                        <p>Pembuatan mug, tumbler, gantungan kunci, tas, dan merchandise promosi lainnya.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <h4>Corporate Gift</h4>
                        <p>Paket corporate gift custom untuk klien, karyawan, atau acara perusahaan dengan packaging eksklusif.</p>
                    </div>
                </div>
            </div>
            
            <!-- Service Detail: Digital Printing -->
            <div class="service-content" id="digital-content">
                <div class="service-header">
                    <div class="service-title">
                        <div class="service-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div>
                            <h2>Digital Printing Khusus</h2>
                            <p>Solusi printing digital untuk kebutuhan khusus dan material unik</p>
                        </div>
                    </div>
                    <div class="service-cta">
                        <a href="#" class="btn">Konsultasi Proyek</a>
                        <a href="#" class="btn btn-outline">Lihat Contoh</a>
                    </div>
                </div>
                
                <p class="service-description">
                    Layanan digital printing khusus untuk media dan material unik seperti stiker vinyl, banner flexi, spanduk, backdrop, sticker cutting, dan printing pada berbagai media non-kertas. Cocok untuk kebutuhan indoor dan outdoor dengan ketahanan yang disesuaikan.
                </p>
                
                <div class="service-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-sticky-note"></i>
                        </div>
                        <h4>Sticker & Label</h4>
                        <p>Cetak stiker vinyl, hologram, label produk, dan sticker cutting untuk berbagai kebutuhan.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-flag"></i>
                        </div>
                        <h4>Banner & Spanduk</h4>
                        <p>Cetak banner flexi, spanduk, backdrop, dan media promosi outdoor dengan kualitas tahan cuaca.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h4>Printing Khusus</h4>
                        <p>Printing pada akrilik, kayu, kain, logam, dan media unik lainnya untuk kebutuhan khusus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section">
        <div class="container">
            <div class="section-title">
                <h2>Proses Pengerjaan</h2>
            </div>
            
            <p class="section-subtitle">Kami memiliki proses pengerjaan yang terstruktur untuk memastikan hasil terbaik dan kepuasan pelanggan.</p>
            
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h4>Konsultasi</h4>
                    <p>Diskusikan kebutuhan dan konsep proyek Anda dengan tim kami untuk menentukan solusi terbaik.</p>
                </div>
                
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h4>Penawaran & Kontrak</h4>
                    <p>Kami akan memberikan penawaran harga yang transparan dan perjanjian kerja yang jelas.</p>
                </div>
                
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h4>Pengerjaan</h4>
                    <p>Tim ahli kami akan mengerjakan proyek dengan standar kualitas tertinggi sesuai timeline.</p>
                </div>
                
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h4>Pengiriman</h4>
                    <p>Hasil akhir dikirimkan sesuai kesepakatan dengan jaminan kualitas dan ketepatan waktu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container">
        <div class="cta-section">
            <h2>Siap Mewujudkan Ide Kreatif Anda?</h2>
            <p>Konsultasikan kebutuhan desain, printing, atau ATK Anda dengan tim profesional kami. Dapatkan solusi terbaik dengan harga kompetitif.</p>
            <a href="kontak.html" class="btn btn-light">Hubungi Kami Sekarang</a>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-title">
                <h2>Pertanyaan Umum</h2>
            </div>
            
            <p class="section-subtitle">Berikut adalah beberapa pertanyaan yang sering diajukan tentang layanan kami.</p>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        Berapa lama waktu pengerjaan untuk desain logo?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Waktu pengerjaan desain logo biasanya membutuhkan 3-7 hari kerja, tergantung kompleksitas dan jumlah revisi yang dibutuhkan. Untuk paket prioritas, waktu pengerjaan bisa dipercepat menjadi 1-3 hari kerja.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Apa perbedaan cetak offset dan digital printing?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Cetak offset cocok untuk jumlah besar (minimal 500 lembar) dengan biaya per unit lebih murah dan kualitas warna yang konsisten. Digital printing cocok untuk jumlah kecil (10-500 lembar) dengan biaya setup lebih murah dan waktu pengerjaan lebih cepat.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah bisa membuat ATK dengan logo perusahaan custom?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, kami menyediakan layanan pembuatan ATK custom dengan logo perusahaan. Minimal order bervariasi tergantung jenis produk, mulai dari 50 pcs untuk pulpen custom hingga 100 pcs untuk notebook custom.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah menyediakan layanan pengiriman?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, kami menyediakan layanan pengiriman ke seluruh Indonesia. Untuk area tertentu dalam kota, kami memberikan gratis ongkos kirim dengan minimal order tertentu. Biaya pengiriman luar kota disesuaikan dengan kurir yang dipilih.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana cara melakukan pembayaran?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Kami menerima pembayaran melalui transfer bank, virtual account, e-wallet, dan tunai di tempat. Untuk proyek bernilai tinggi, biasanya kami menerapkan pembayaran bertahap: 50% di awal dan 50% sebelum pengiriman.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Tab layanan
        const categoryTabs = document.querySelectorAll('.category-tab');
        const serviceContents = document.querySelectorAll('.service-content');
        
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Hapus class active dari semua tab
                categoryTabs.forEach(t => t.classList.remove('active'));
                // Tambah class active ke tab yang diklik
                tab.classList.add('active');
                
                // Sembunyikan semua konten layanan
                serviceContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Tampilkan konten sesuai tab
                const serviceId = tab.getAttribute('data-service');
                const targetContent = document.getElementById(`${serviceId}-content`);
                if(targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
        
        // FAQ accordion
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                // Tutup semua FAQ lainnya
                faqItems.forEach(otherItem => {
                    if(otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Buka/tutup FAQ yang diklik
                item.classList.toggle('active');
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
    </script>
@endsection