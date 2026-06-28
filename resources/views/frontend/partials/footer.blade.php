<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3><i class="fas fa-palette"></i> Ravaa<span>Creative</span></h3>
                <p>Solusi kreatif terpadu untuk desain grafis, percetakan, ATK, dan pengembangan software. Wujudkan ide kreatif Anda bersama kami.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
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
                    <li><a href="tel:+62223456789"><i class="fas fa-phone"></i> (022) 3456-789</a></li>
                    <li><a href="mailto:info@ravaacreative.com"><i class="fas fa-envelope"></i> info@ravaacreative.com</a></li>
                    <li><i class="fas fa-location-dot"></i> Jl. Kreatif No. 123, Bandung</li>
                    <li><i class="fas fa-clock"></i> Sen-Jum 08:00-17:00</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Ravaa Creative. All rights reserved.
        </div>
    </div>
</footer>
