<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="navbar-logo" style="display: flex; align-items: center; gap: 8px;">
            <img src="{{ !empty($settings['site_logo']) ? $settings['site_logo'] : asset('images/logo.svg') }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" style="height: 32px; width: auto; object-fit: contain;">
            {{ $settings['site_name'] ?? 'Ravaa Creative' }}
        </a>

        <ul class="navbar-links">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/product') }}" class="{{ request()->is('product*') ? 'active' : '' }}">Katalog</a></li>
            <li><a href="{{ url('/layanan') }}" class="{{ request()->is('layanan') ? 'active' : '' }}">Layanan</a></li>
            <li><a href="{{ url('/portofolio') }}" class="{{ request()->is('portofolio') ? 'active' : '' }}">Portfolio</a></li>
            <li><a href="{{ url('/software-house') }}" class="{{ request()->is('software-house') ? 'active' : '' }}">Software House</a></li>
            <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Kontak</a></li>
        </ul>

        <button class="navbar-toggle" id="menuToggle" aria-label="Buka menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>
