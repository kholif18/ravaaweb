@extends('frontend.layouts.master')

@section('title', 'Kontak')

@section('meta_desc', 'Hubungi Ravaa Creative untuk konsultasi desain, percetakan, ATK, dan software house.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Ada pertanyaan atau ingin konsultasi? Tim kami siap membantu Anda.</p>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form">
                    <h3 style="font-weight:600;font-size:1.3rem;margin:0 0 24px;letter-spacing:-0.02em;">Kirim Pesan</h3>
                    <form>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" placeholder="Masukkan nama Anda">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" placeholder="contoh@email.com">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subjek</label>
                            <input type="text" id="subject" placeholder="Subjek pesan">
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea id="message" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>

                <div class="contact-info-card">
                    <h3 style="font-weight:600;font-size:1.3rem;margin:0 0 24px;letter-spacing:-0.02em;">Informasi Kontak</h3>

                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>WhatsApp</h4>
                            <p><a href="https://wa.me/6282233377661" target="_blank">+62 822-3337-7661</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Email</h4>
                            <p><a href="mailto:info@ravaacreative.com">info@ravaacreative.com</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Telepon</h4>
                            <p><a href="tel:+62223456789">(022) 3456-789</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Alamat</h4>
                            <p>Jl. Kreatif No. 123, Bandung</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Jam Operasional</h4>
                            <p>Senin – Jumat: 08:00 – 17:00<br>Sabtu: 08:00 – 14:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="text-center">
                <span class="section-label">Media Sosial</span>
                <h2 class="section-title">Ikuti Kami</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Dapatkan informasi terbaru seputar produk, promo, dan inspirasi.</p>
                <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                    <a href="#" class="btn btn-outline btn-lg" style="min-width:120px;"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#" class="btn btn-outline btn-lg" style="min-width:120px;"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="btn btn-outline btn-lg" style="min-width:120px;"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                </div>
            </div>
        </div>
    </section>
@endsection
