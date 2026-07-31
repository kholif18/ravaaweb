<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — {{ $settings['site_name'] ?? 'Ravaa Creative' }}</title>
    <meta name="description" content="@yield('meta_desc', $settings['meta_description'] ?? 'Solusi kreatif untuk desain, percetakan, ATK, dan software house.')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $settings['site_name'] ?? 'Ravaa Creative') — {{ $settings['site_name'] ?? 'Ravaa Creative' }}">
    <meta property="og:description" content="@yield('meta_desc', $settings['meta_description'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $settings['site_name'] ?? 'Ravaa Creative' }}">
    @yield('og_image')
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $settings['site_name'] ?? 'Ravaa Creative') — {{ $settings['site_name'] ?? 'Ravaa Creative' }}">
    <meta name="twitter:description" content="@yield('meta_desc', $settings['meta_description'] ?? '')">
    @yield('twitter_image')

    {{-- Favicon --}}
    <link rel="icon" href="{{ !empty($settings['site_logo']) ? $settings['site_logo'] : asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ !empty($settings['site_logo']) ? $settings['site_logo'] : asset('images/logo.svg') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}?v={{ filemtime(public_path('frontend/css/app.css')) }}">
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
            <span style="font-weight:700;font-size:1.15rem;display:flex;align-items:center;gap:8px;">
                <img src="{{ !empty($settings['site_logo']) ? $settings['site_logo'] : asset('images/logo.svg') }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" style="height: 28px; width: auto; object-fit: contain;">
                {{ $settings['site_name'] ?? 'Ravaa Creative' }}
            </span>
            <button class="mobile-drawer-close" id="mobileClose" aria-label="Tutup menu">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
        <nav>
            @php
                $mobileLinks = $navLinks->filter(fn($link) => in_array($link->position, ['mobile', 'both']));
            @endphp

            @foreach($mobileLinks as $link)
                @if($link->children->count())
                    {{-- Collapsible parent --}}
                    <div class="mobile-nav-parent">
                        <a href="#" class="mobile-nav-toggle" onclick="event.preventDefault(); this.parentElement.classList.toggle('open');">
                            {{ $link->label }}
                            <i class="fas fa-chevron-down mobile-nav-arrow"></i>
                        </a>
                        <div class="mobile-nav-children">
                            @foreach($link->children as $child)
                                <a href="{{ $child->url }}" target="{{ $child->target }}" class="mobile-nav-child-link">
                                    {{ $child->label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $link->url }}" target="{{ $link->target }}" class="{{ (ltrim($link->url, '/') === '' || ltrim($link->url, '/') === '/') ? (request()->is('/') ? 'active' : '') : (request()->is(ltrim($link->url, '/')) || request()->is(ltrim($link->url, '/') . '/*') ? 'active' : '') }}">
                        {{ $link->label }}
                    </a>
                @endif
            @endforeach

            <a href="{{ route('search') }}" class="{{ request()->is('search') ? 'active' : '' }}" style="margin-top: 8px; border-top: 1px solid var(--glass-border); padding-top: 12px;">
                <i class="fas fa-search"></i> Cari
            </a>
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

    <button class="float-top" id="scrollTopBtn" aria-label="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    {{-- Holiday Popup --}}
    @include('frontend.partials.holiday-popup')

    {{-- Cookie Consent Banner --}}
    <div id="cookieBanner" class="cookie-banner" style="display: none;">
        <div class="cookie-banner-inner">
            <div class="cookie-banner-text">
                <i class="fas fa-cookie-bite" style="color: var(--accent); font-size: 1.1rem;"></i>
                <span>Kami menggunakan cookie untuk meningkatkan pengalaman Anda. Dengan melanjutkan, Anda menyetujui penggunaan cookie.</span>
            </div>
            <div class="cookie-banner-actions">
                <button onclick="dismissCookie()" class="btn-cookie-accept">Setuju</button>
                <button onclick="dismissCookie()" class="btn-cookie-dismiss">Tutup</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem('cookie_consent')) {
            document.getElementById('cookieBanner').style.display = 'block';
        }
    });
    function dismissCookie() {
        localStorage.setItem('cookie_consent', '1');
        var el = document.getElementById('cookieBanner');
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        setTimeout(function() { el.style.display = 'none'; }, 300);
    }
    </script>

    {{-- data-cfasync="false" mencegah Cloudflare Rocket Loader menunda eksekusi script ini --}}
    <script data-cfasync="false" src="{{ asset('frontend/js/app.js') }}?v={{ filemtime(public_path('frontend/js/app.js')) }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('scrollTopBtn');
        window.addEventListener('scroll', function() {
            btn.classList.toggle('visible', window.scrollY > 300);
        });
        btn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
    </script>
    @stack('scripts')
</body>
</html>
