@php
    $desktopLinks = $navLinks->filter(fn($link) => in_array($link->position, ['navbar', 'both']))->values();

    // Active check: root '/' only active on exact match, others use wildcard
    function isNavLinkActive($url) {
        $slug = ltrim($url, '/');
        if ($slug === '' || $slug === '/') {
            return request()->is('/');
        }
        return request()->is($slug) || request()->is($slug . '/*');
    }
@endphp

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="navbar-logo" style="display: flex; align-items: center; gap: 8px;">
            <img src="{{ !empty($settings['site_logo']) ? $settings['site_logo'] : asset('images/logo.svg') }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" style="height: 32px; width: auto; object-fit: contain;">
            {{ $settings['site_name'] ?? 'Ravaa Creative' }}
        </a>

        <ul class="navbar-links">
            @foreach($desktopLinks as $link)
                @if($link->children->count())
                    {{-- Dropdown parent --}}
                    <li class="navbar-dropdown">
                        <a href="#" class="navbar-dropdown-toggle {{ isNavLinkActive($link->url) ? 'active' : '' }}">
                            {{ $link->label }}
                            <i class="fas fa-chevron-down navbar-dropdown-arrow"></i>
                        </a>
                        <ul class="navbar-dropdown-menu">
                            <li>
                                <a href="{{ $link->url }}" target="{{ $link->target }}">
                                    Semua {{ $link->label }}
                                </a>
                            </li>
                            <li class="navbar-dropdown-divider"></li>
                            @foreach($link->children as $child)
                                <li>
                                    <a href="{{ $child->url }}" target="{{ $child->target }}">
                                        {{ $child->label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    {{-- Single link --}}
                    <li>
                        <a href="{{ $link->url }}" target="{{ $link->target }}" class="{{ isNavLinkActive($link->url) ? 'active' : '' }}">
                            {{ $link->label }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <div style="display: flex; align-items: center; gap: 6px;">
            <a href="{{ route('search') }}" class="navbar-search-btn" aria-label="Cari">
                <i class="fas fa-search"></i>
            </a>
            <button class="navbar-toggle" id="menuToggle" aria-label="Buka menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>
