@extends('frontend.layouts.master')

@section('title', 'Hubungi Kami')

@section('content')
    <!-- Hero Section -->
    <section class="hero-contact">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda dengan segala kebutuhan desain, percetakan, dan ATK. Jangan ragu untuk menghubungi kami untuk konsultasi gratis atau informasi lebih lanjut.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="section-title">
                <h2>Get in Touch</h2>
            </div>
            
            <p class="section-subtitle">Hubungi kami melalui berbagai cara yang tersedia. Tim customer service kami siap membantu Anda dari Senin hingga Jumat, pukul 08.00 - 17.00 WIB.</p>
            
            <div class="contact-container">
                <!-- Contact Info -->
                <div class="contact-info">
                    <h3>Informasi Kontak</h3>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Alamat Kantor</h4>
                            <p>Jl. Kreatif No. 123, Kel. Design, Kec. Printing</p>
                            <p>Jakarta Selatan, 12345</p>
                            <p>Indonesia</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Telepon & WhatsApp</h4>
                            <p><a href="tel:+622112345678" class="contact-link">(021) 1234-5678</a></p>
                            <p><a href="https://wa.me/6281234567890" class="contact-link">+62 812-3456-7890</a></p>
                            <p>Senin - Jumat: 08.00 - 17.00 WIB</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p><a href="mailto:info@ravaacreative.com" class="contact-link">info@ravaacreative.com</a></p>
                            <p><a href="mailto:order@ravaacreative.com" class="contact-link">order@ravaacreative.com</a></p>
                            <p>Response time: 1-2 jam kerja</p>
                        </div>
                    </div>
                    
                    <div class="social-contact">
                        <h4>Ikuti Kami di Media Sosial</h4>
                        <div class="social-icons">
                            <a href="https://wa.me/6281234567890" class="whatsapp" target="_blank" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://instagram.com/ravaacreative" class="instagram" target="_blank" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://facebook.com/ravaacreative" class="facebook" target="_blank" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/ravaacreative" class="twitter" target="_blank" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://t.me/ravaacreative" class="telegram" target="_blank" title="Telegram">
                                <i class="fab fa-telegram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h3>Kirim Pesan</h3>
                    <form id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <input type="text" id="name" class="form-control" placeholder="Masukkan nama Anda" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" id="email" class="form-control" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor Telepon/WhatsApp</label>
                            <input type="tel" id="phone" class="form-control" placeholder="0812-3456-7890">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">Subjek *</label>
                            <select id="subject" class="form-control" required>
                                <option value="" disabled selected>Pilih subjek pesan</option>
                                <option value="konsultasi">Konsultasi Desain</option>
                                <option value="pemesanan">Pemesanan Produk</option>
                                <option value="quotation">Request Quotation</option>
                                <option value="kerjasama">Peluang Kerjasama</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Pesan *</label>
                            <textarea id="message" class="form-control" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="section-title">
                <h2>Lokasi Kami</h2>
            </div>
            
            <div class="map-container">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Ravaa Creative Studio</h3>
                    <p>Jl. Kreatif No. 123, Jakarta Selatan, Indonesia</p>
                    <p style="margin-top: 10px; font-size: 0.9rem;">
                        <i class="fas fa-clock"></i> Buka Senin - Jumat: 08.00 - 17.00 WIB
                    </p>
                    <a href="https://maps.google.com/?q=Jl.+Kreatif+No.+123,+Jakarta+Selatan" class="btn" style="margin-top: 20px; background-color: white; color: #667eea;" target="_blank">
                        <i class="fas fa-directions"></i> Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-title">
                <h2>Pertanyaan Umum</h2>
            </div>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        Berapa lama waktu respon untuk pesan yang dikirim via formulir kontak?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Kami akan membalas pesan Anda dalam 1-2 jam kerja pada hari dan jam operasional (Senin-Jumat, 08.00-17.00 WIB). Untuk pesan di luar jam operasional, kami akan membalas pada hari kerja berikutnya.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah menyediakan layanan konsultasi gratis?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, kami menyediakan konsultasi gratis selama 30 menit untuk membahas kebutuhan desain atau percetakan Anda. Anda dapat menghubungi via WhatsApp untuk mengatur jadwal konsultasi.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah bisa datang langsung ke studio/showroom?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, Anda bisa datang langsung ke studio kami di Jl. Kreatif No. 123, Jakarta Selatan. Namun, kami menyarankan untuk membuat janji terlebih dahulu via telepon atau WhatsApp agar tim kami siap melayani Anda dengan maksimal.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana cara mendapatkan quotation untuk proyek desain atau percetakan?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Anda dapat mengirimkan detail proyek melalui formulir kontak dengan memilih subjek "Request Quotation" atau langsung menghubungi kami via WhatsApp/Telegram. Kami akan mengirimkan quotation dalam 24 jam kerja.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah melayani pemesanan dari luar kota?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ya, kami melayani pemesanan dari seluruh Indonesia. Untuk layanan desain, semua proses dapat dilakukan online. Untuk produk fisik (percetakan, ATK, merchandise), kami akan mengirimkan ke alamat Anda dengan biaya pengiriman yang disesuaikan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container">
        <div class="cta-section">
            <h2>Siap Bekerja Sama dengan Kami?</h2>
            <p>Konsultasikan kebutuhan desain, printing, atau ATK Anda dengan tim profesional kami. Dapatkan solusi terbaik dengan harga kompetitif.</p>
            <a href="https://wa.me/6281234567890" class="btn btn-light" target="_blank">
                <i class="fab fa-whatsapp"></i> Chat via WhatsApp Sekarang
            </a>
        </div>
    </section>

    <script>
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

        // Contact Form Submission
        const contactForm = document.getElementById('contactForm');
        
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Ambil nilai dari form
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            
            // Validasi sederhana
            if (!name || !email || !subject || !message) {
                alert('Harap lengkapi semua field yang wajib diisi.');
                return;
            }
            
            // Simulasi pengiriman form
            alert('Terima kasih, ' + name + '! Pesan Anda telah berhasil dikirim. Kami akan menghubungi Anda dalam 1-2 jam kerja.');
            
            // Reset form
            contactForm.reset();
            
            // Reset select ke default
            document.getElementById('subject').selectedIndex = 0;
        });

        // Format nomor telepon saat input
        const phoneInput = document.getElementById('phone');
        
        phoneInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.substring(0, 3) + '-' + value.substring(3);
                } else if (value.length <= 10) {
                    value = value.substring(0, 3) + '-' + value.substring(3, 6) + '-' + value.substring(6);
                } else {
                    value = value.substring(0, 3) + '-' + value.substring(3, 7) + '-' + value.substring(7, 11);
                }
            }
            
            e.target.value = value;
        });

        // WhatsApp button dengan pesan otomatis
        const whatsappBtn = document.querySelector('.btn-light');
        const contactWhatsappBtn = document.querySelector('.contact-details a[href*="wa.me"]');
        
        // Update WhatsApp link dengan pesan default
        function updateWhatsAppLink(button, message) {
            const encodedMessage = encodeURIComponent(message);
            button.href = `https://wa.me/6281234567890?text=${encodedMessage}`;
        }
        
        // Set pesan untuk tombol CTA
        updateWhatsAppLink(whatsappBtn, "Halo Ravaa Creative, saya ingin konsultasi tentang layanan desain/percetakan. Bisa info lebih detail?");
        
        // Set pesan untuk tombol di contact info
        if (contactWhatsappBtn) {
            updateWhatsAppLink(contactWhatsappBtn, "Halo Ravaa Creative, saya ingin bertanya tentang...");
        }

        // Tambah event listener untuk form submission dengan validasi lebih lengkap
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = 'red';
                alert('Format email tidak valid. Contoh: nama@email.com');
            } else {
                this.style.borderColor = '';
            }
        });

        // Smooth scroll untuk anchor links di halaman yang sama
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
                }
            });
        });
    </script>
@endsection