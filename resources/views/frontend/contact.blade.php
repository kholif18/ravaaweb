@extends('frontend.layouts.master')

@section('title', 'Kontak')
@section('meta_desc', $settings['meta_description'] ?? 'Hubungi ' . ($settings['site_name'] ?? 'Ravaa Creative') . ' untuk konsultasi desain, percetakan, ATK, dan software house.')

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
                    @if($settings['whatsapp'] ?? null)
                    <form action="https://wa.me/{{ $settings['whatsapp'] }}" method="GET" target="_blank">
                    @else
                    <form>
                    @endif
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="contoh@email.com">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subjek</label>
                            <input type="text" id="subject" name="subject" placeholder="Subjek pesan">
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>

                <div class="contact-info-card">
                    <h3 style="font-weight:600;font-size:1.3rem;margin:0 0 24px;letter-spacing:-0.02em;">Informasi Kontak</h3>

                    @if($settings['whatsapp'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>WhatsApp</h4>
                            <p><a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank">{{ $settings['whatsapp'] }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($settings['email'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Email</h4>
                            <p><a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($settings['phone'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Telepon</h4>
                            <p><a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($settings['address'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Alamat</h4>
                            <p>{{ $settings['address'] }}</p>
                        </div>
                    </div>
                    @endif

                    @if($settings['operating_hours'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Jam Operasional</h4>
                            <p>{{ $settings['operating_hours'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if(($settings['instagram'] ?? null) || ($settings['facebook'] ?? null) || ($settings['linkedin'] ?? null))
    <section class="section fade-up">
        <div class="container">
            <div class="text-center">
                <span class="section-label">Media Sosial</span>
                <h2 class="section-title">Ikuti Kami</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Dapatkan informasi terbaru seputar produk, promo, dan inspirasi.</p>
                <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                    @if($settings['instagram'] ?? null)
                    <a href="{{ $settings['instagram'] }}" class="btn btn-outline btn-lg" target="_blank" style="min-width:120px;"><i class="fab fa-instagram"></i> Instagram</a>
                    @endif
                    @if($settings['facebook'] ?? null)
                    <a href="{{ $settings['facebook'] }}" class="btn btn-outline btn-lg" target="_blank" style="min-width:120px;"><i class="fab fa-facebook-f"></i> Facebook</a>
                    @endif
                    @if($settings['linkedin'] ?? null)
                    <a href="{{ $settings['linkedin'] }}" class="btn btn-outline btn-lg" target="_blank" style="min-width:120px;"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
