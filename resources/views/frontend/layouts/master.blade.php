<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — {{ $settings['site_name'] ?? 'Ravaa Creative' }}</title>
    <meta name="description" content="@yield('meta_desc', $settings['meta_description'] ?? 'Solusi kreatif untuk desain, percetakan, ATK, dan software house.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
    @stack('styles')
</head>
<body>

    @if($settings['whatsapp'] ?? null)
    <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya ingin bertanya mengenai produk / layanan yang tersedia.') }}"
       class="float-wa"
       target="_blank"
       rel="noopener"
       aria-label="Hubungi via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    @endif

    @include('frontend.partials.navbar')

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-drawer" id="mobileDrawer">
        <div class="mobile-drawer-header">
            <span style="font-weight:700;font-size:1.15rem;">{{ $settings['site_name'] ?? 'Ravaa Creative' }}</span>
            <button class="mobile-drawer-close" id="mobileClose" aria-label="Tutup menu">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
        <nav>
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/product') }}" class="{{ request()->is('product*') ? 'active' : '' }}">Katalog</a>
            <a href="{{ url('/layanan') }}" class="{{ request()->is('layanan') ? 'active' : '' }}">Layanan</a>
            <a href="{{ url('/portofolio') }}" class="{{ request()->is('portofolio') ? 'active' : '' }}">Portfolio</a>
            <a href="{{ url('/software-house') }}" class="{{ request()->is('software-house') ? 'active' : '' }}">Software House</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Kontak</a>
        </nav>
        <div style="margin-top:32px;">
            @if($settings['whatsapp'] ?? null)
            <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="btn btn-whatsapp w-full" style="justify-content:center;">
                <i class="fab fa-whatsapp"></i> Hubungi Kami
            </a>
            @endif
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="{{ asset('frontend/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
