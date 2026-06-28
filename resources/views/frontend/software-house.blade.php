@extends('frontend.layouts.master')

@section('title', 'Software House')

@section('content')
    <section class="page-hero" style="padding-bottom:0;">
        <div class="container">
            <h1>Software House</h1>
            <p>Kami mengembangkan solusi digital custom untuk bisnis Anda — dari website hingga aplikasi mobile dan IoT.</p>
        </div>
    </section>

    <section class="section sh-section">
        <div class="container">
            <span class="section-label">LAYANAN</span>
            <h2 class="section-title">Layanan Pengembangan Software</h2>
            <p class="section-subtitle">Kami menyediakan layanan pengembangan software end-to-end yang disesuaikan dengan kebutuhan bisnis Anda.</p>

            <div class="service-grid">
                <div class="sh-card">
                    <div class="svc-card-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Aplikasi Web</h3>
                    <ul class="svc-features">
                        <li>Analisis Kebutuhan</li>
                        <li>UI/UX Design</li>
                        <li>Development</li>
                        <li>Testing</li>
                        <li>Deployment</li>
                        <li>Maintenance</li>
                    </ul>
                    <a href="https://wa.me/6282233377661?text=Halo%20saya%20tertarik%20dengan%20layanan%20Aplikasi%20Web" class="btn btn-whatsapp btn-sm">Hubungi Kami</a>
                </div>

                <div class="sh-card">
                    <div class="svc-card-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile App</h3>
                    <ul class="svc-features">
                        <li>Analisis Kebutuhan</li>
                        <li>UI/UX Design</li>
                        <li>Development</li>
                        <li>Testing</li>
                        <li>Deployment</li>
                        <li>Maintenance</li>
                    </ul>
                    <a href="https://wa.me/6282233377661?text=Halo%20saya%20tertarik%20dengan%20layanan%20Mobile%20App" class="btn btn-whatsapp btn-sm">Hubungi Kami</a>
                </div>

                <div class="sh-card">
                    <div class="svc-card-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>API &amp; Integration</h3>
                    <ul class="svc-features">
                        <li>Analisis Kebutuhan</li>
                        <li>UI/UX Design</li>
                        <li>Development</li>
                        <li>Testing</li>
                        <li>Deployment</li>
                        <li>Maintenance</li>
                    </ul>
                    <a href="https://wa.me/6282233377661?text=Halo%20saya%20tertarik%20dengan%20layanan%20API%20%26%20Integration" class="btn btn-whatsapp btn-sm">Hubungi Kami</a>
                </div>

                <div class="sh-card">
                    <div class="svc-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>IoT &amp; Embedded</h3>
                    <ul class="svc-features">
                        <li>Analisis Kebutuhan</li>
                        <li>UI/UX Design</li>
                        <li>Development</li>
                        <li>Testing</li>
                        <li>Deployment</li>
                        <li>Maintenance</li>
                    </ul>
                    <a href="https://wa.me/6282233377661?text=Halo%20saya%20tertarik%20dengan%20layanan%20IoT%20%26%20Embedded" class="btn btn-whatsapp btn-sm">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section sh-section">
        <div class="container">
            <span class="section-label">PROSES</span>
            <h2 class="section-title">Bagaimana Kami Bekerja</h2>
            <p class="section-subtitle">Langkah-langkah sistematis untuk menghadirkan solusi software terbaik bagi bisnis Anda.</p>

            <div class="grid grid-4">
                <div class="sh-card">
                    <h3>1. Konsultasi</h3>
                    <p>Diskusi kebutuhan dan tujuan bisnis Anda untuk menentukan solusi yang tepat.</p>
                </div>
                <div class="sh-card">
                    <h3>2. Desain</h3>
                    <p>Perancangan arsitektur sistem dan antarmuka pengguna yang intuitif.</p>
                </div>
                <div class="sh-card">
                    <h3>3. Development</h3>
                    <p>Proses pengembangan menggunakan teknologi terkini dengan standar kualitas tinggi.</p>
                </div>
                <div class="sh-card">
                    <h3>4. Launch</h3>
                    <p>Deployment ke production dan pendampingan hingga sistem berjalan lancar.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="text-center">
                <span class="section-label">PORTOFOLIO</span>
                <h2 class="section-title">Proyek Software Kami</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Beberapa proyek pengembangan software yang telah kami selesaikan.</p>
            </div>

            @if(isset($portfolioItems))
                @php
                    $softwareCategories = ['Web App', 'Mobile App', 'IoT & Embedded'];
                    $filteredItems = array_filter($portfolioItems, function($item) use ($softwareCategories) {
                        return in_array($item->category, $softwareCategories);
                    });
                @endphp

                @if(count($filteredItems) > 0)
                    <div class="portfolio-grid">
                        @foreach($filteredItems as $item)
                            <div class="port-card">
                                @if(!empty($item->image))
                                    <img src="{{ $item->image }}" alt="{{ $item->title }}" class="port-card-img">
                                @endif
                                <div class="port-card-body">
                                    <span class="port-card-category">{{ $item->category }}</span>
                                    <h3 class="port-card-title">{{ $item->title }}</h3>
                                    @if(!empty($item->client))
                                        <p class="port-card-client">{{ $item->client }}</p>
                                    @endif
                                    @if(!empty($item->description))
                                        <p class="port-card-desc">{{ $item->description }}</p>
                                    @endif
                                    @if(!empty($item->tech) && is_array($item->tech))
                                        <div class="port-card-tech">
                                            @foreach($item->tech as $tech)
                                                <span class="tech-tag">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Tidak ada proyek software yang tersedia saat ini.</p>
                @endif
            @else
                <p>Tidak ada proyek software yang tersedia saat ini.</p>
            @endif
        </div>
    </section>
@endsection
