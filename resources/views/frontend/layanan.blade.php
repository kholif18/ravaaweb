@extends('frontend.layouts.master')

@section('title', 'Layanan')

@section('content')
    <section class="page-hero">
        <div class="container">
            <h1>Layanan Kami</h1>
            <p>Solusi lengkap untuk kebutuhan kreatif dan teknologi bisnis Anda — dari desain hingga software.</p>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="service-grid">
                @forelse($services as $service)
                    <div class="svc-card">
                        <div class="svc-card-icon">
                            <i class="{{ $service->icon }}"></i>
                        </div>
                        <h3>{{ $service->name }}</h3>
                        <p>{{ $service->description }}</p>
                        @if(!empty($service->features))
                            <ul class="svc-features">
                                @foreach($service->features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="https://wa.me/6282233377661?text=Halo%20Ravaa%20Creative%2C%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($service->name) }}..."
                           class="btn btn-whatsapp btn-sm"
                           target="_blank">
                            <i class="fab fa-whatsapp"></i> Konsultasi Sekarang
                        </a>
                    </div>
                @empty
                    <p>Belum ada layanan tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="glass-card" style="padding:48px;text-align:center;">
                <span class="section-label">Butuh Bantuan?</span>
                <h2 class="section-title" style="max-width:600px;margin:0 auto 12px;">Hubungi Tim Kami</h2>
                <p style="color:var(--text-secondary);margin:0 auto 28px;max-width:480px;">Dapatkan konsultasi gratis mengenai kebutuhan project Anda.</p>
                <a href="https://wa.me/6282233377661?text=Halo%20Ravaa%20Creative%2C%20saya%20ingin%20konsultasi"
                   class="btn btn-whatsapp btn-lg"
                   target="_blank">
                    <i class="fab fa-whatsapp"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection
