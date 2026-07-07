<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3><i class="fas fa-palette"></i> {{ $settings['site_name'] ?? 'Ravaa Creative' }}</h3>
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
                    <li><a href="{{ url('/product?category=Desain+Grafis') }}">Desain Grafis</a></li>
                    <li><a href="{{ url('/product?category=Percetakan') }}">Percetakan</a></li>
                    <li><a href="{{ url('/product?category=Custom+Invitations') }}">Custom Invitations</a></li>
                    <li><a href="{{ url('/product?category=ATK') }}">ATK &amp; Stationery</a></li>
                    <li><a href="{{ url('/product?category=Software+House') }}">Software House</a></li>
                </ul>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="{{ url('/portofolio') }}">Portfolio</a></li>
                    <li><a href="{{ url('/software-house') }}">Software House</a></li>
                    <li><a href="{{ url('/contact') }}">Kontak</a></li>
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
                    <li><i class="fas fa-location-dot"></i> {{ $settings['address'] }}</li>
                    @endif
                    @if($settings['operating_hours'] ?? null)
                    <li><i class="fas fa-clock"></i> {{ $settings['operating_hours'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            {{ $settings['footer_text'] ?? '© ' . date('Y') . ' ' . ($settings['site_name'] ?? 'Ravaa Creative') . '. All rights reserved.' }}
        </div>
    </div>
</footer>
