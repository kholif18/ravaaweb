<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3>
                    <img src="{{ !empty($settings['site_logo']) ? $settings['site_logo'] : asset('images/logo.svg') }}" alt="{{ $settings['site_name'] ?? 'Ravaa Creative' }}" style="height: 28px; width: auto; object-fit: contain; vertical-align: middle; margin-right: 6px;">
                    {{ $settings['site_name'] ?? 'Ravaa Creative' }}
                </h3>
                <p>{{ $settings['site_description'] ?? 'Solusi kreatif terpadu untuk desain grafis, percetakan, ATK, dan pengembangan software.' }}</p>
                <div class="footer-social">
                    @if($settings['instagram'] ?? null)
                    <a href="{{ $settings['instagram'] }}" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($settings['facebook'] ?? null)
                    <a href="{{ $settings['facebook'] }}" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if($settings['whatsapp'] ?? null)
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    @endif
                    @if($settings['linkedin'] ?? null)
                    <a href="{{ $settings['linkedin'] }}" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
            </div>
            <div>
                <h4>Layanan</h4>
                <ul>
                    @php
                        $footerCategories = \App\Models\Category::where('status', 'active')->orderBy('order')->limit(6)->get();
                    @endphp
                    @forelse($footerCategories as $cat)
                    <li><a href="{{ url('/product?category=' . urlencode($cat->name)) }}">{{ $cat->name }}</a></li>
                    @empty
                    <li><a href="{{ url('/product') }}">Katalog Produk</a></li>
                    @endforelse
                </ul>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <ul>
                    @php
                        $footerLinks = \App\Models\FooterLink::active()->ordered()->get();
                    @endphp
                    @forelse($footerLinks as $link)
                    <li><a href="{{ url($link->url) }}">{{ $link->label }}</a></li>
                    @empty
                    <li><a href="{{ url('/portofolio') }}">Portfolio</a></li>
                    <li><a href="{{ url('/software-house') }}">Software House</a></li>
                    <li><a href="{{ url('/layanan') }}">Layanan</a></li>
                    <li><a href="{{ url('/contact') }}">Kontak</a></li>
                    @endforelse
                </ul>
            </div>
            <div>
                <h4>Kontak</h4>
                <ul>
                    @if($settings['phone'] ?? null)
                    <li><a href="tel:{{ $settings['phone'] }}"><i class="fas fa-phone"></i> {{ $settings['phone'] }}</a></li>
                    @endif
                    @if($settings['email'] ?? null)
                    <li><a href="mailto:{{ $settings['email'] }}"><i class="fas fa-envelope"></i> {{ $settings['email'] }}</a></li>
                    @endif
                    @if($settings['address'] ?? null)
                    <li><a href="https://maps.google.com/?q={{ urlencode($settings['address']) }}" target="_blank" rel="noopener"><i class="fas fa-location-dot"></i> {{ $settings['address'] }}</a></li>
                    @endif
                    @if($settings['operating_hours'] ?? null)
                    <li><a href="javascript:void(0)" style="cursor: default;"><i class="fas fa-clock"></i> {{ $settings['operating_hours'] }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            {{ $settings['footer_text'] ?? '© ' . date('Y') . ' ' . ($settings['site_name'] ?? 'Ravaa Creative') . '. All rights reserved.' }}
        </div>
    </div>
</footer>
