@extends('frontend.layouts.master')

@section('title', 'Terima Kasih')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Terima Kasih!</h1>
        <p>Pesanan {{ $typeLabel }} Anda telah berhasil dikirim.</p>
    </div>
</section>

<section class="section fade-up">
    <div class="container" style="max-width: 600px; text-align: center;">
        <div class="contact-form" style="padding: 48px 32px;">
            <div style="font-size: 4rem; margin-bottom: 16px;">✅</div>
            <h2 style="font-weight: 700; font-size: 1.5rem; margin-bottom: 12px;">
                Pesanan Berhasil Dikirim!
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 8px;">
                Nomor pesanan Anda: <strong>#{{ session('order_id', '-') }}</strong>
            </p>
            <p style="color: var(--text-secondary); margin-bottom: 24px;">
                Tim kami akan segera menghubungi Anda melalui WhatsApp untuk konfirmasi lebih lanjut.
            </p>

            @if(session('wa_url') && session('wa_url') != '#')
            <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-primary" style="justify-content:center; margin-bottom: 16px;">
                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
            </a>
            @endif

            <div style="margin-top: 24px;">
                <a href="{{ url('/') }}" class="btn btn-outline">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
