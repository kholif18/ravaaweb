@extends('frontend.layouts.master')

@section('title', $content['hero']['title'] ?? 'Software House')

@section('content')
    <section class="page-hero" style="padding-bottom:0;">
        <div class="container">
            <h1>{{ $content['hero']['title'] ?? 'Software House' }}</h1>
            <p>{{ $content['hero']['description'] ?? 'Kami mengembangkan solusi digital custom untuk bisnis Anda — dari website hingga aplikasi mobile dan IoT.' }}</p>
        </div>
    </section>

    <section class="section sh-section">
        <div class="container">
            <span class="section-label">LAYANAN</span>
            <h2 class="section-title">{{ $content['layanan']['title'] ?? 'Layanan Pengembangan Software' }}</h2>
            <p class="section-subtitle">{{ $content['layanan']['subtitle'] ?? 'Kami menyediakan layanan pengembangan software end-to-end yang disesuaikan dengan kebutuhan bisnis Anda.' }}</p>

            <div class="service-grid">
                @foreach($service->features ?? [] as $feature)
                @php
                    $featTitle = is_array($feature) ? ($feature['title'] ?? '') : $feature;
                    $featIcon = is_array($feature) ? ($feature['icon'] ?? ($service->icon ?? 'fas fa-code')) : ($service->icon ?? 'fas fa-code');
                    $featSteps = is_array($feature) ? ($feature['steps'] ?? []) : [];
                @endphp
                <div class="sh-card">
                    <div class="svc-card-icon">
                        <i class="{{ $featIcon }}"></i>
                    </div>
                    <h3>{{ $featTitle }}</h3>
                    <ul class="svc-features">
                        @forelse($featSteps as $step)
                            <li>{{ $step }}</li>
                        @empty
                            <li>Analisis Kebutuhan</li>
                            <li>UI/UX Design</li>
                            <li>Development</li>
                            <li>Testing</li>
                            <li>Deployment</li>
                            <li>Maintenance</li>
                        @endforelse
                    </ul>
                    <a href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}?text={{ urlencode('Halo, saya tertarik dengan layanan ' . $featTitle) }}" class="btn btn-whatsapp btn-sm">Hubungi Kami</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section sh-section">
        <div class="container">
            <span class="section-label">PROSES</span>
            <h2 class="section-title">{{ $content['proses']['title'] ?? 'Bagaimana Kami Bekerja' }}</h2>
            <p class="section-subtitle">{{ $content['proses']['subtitle'] ?? 'Langkah-langkah sistematis untuk menghadirkan solusi software terbaik bagi bisnis Anda.' }}</p>

            <div class="grid grid-4">
                @foreach($content['proses']['steps'] ?? [] as $index => $step)
                <div class="sh-card">
                    <h3>{{ $index + 1 }}. {{ $step['title'] ?? '' }}</h3>
                    <p>{{ $step['description'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="text-center">
                <span class="section-label">PORTOFOLIO</span>
                <h2 class="section-title">{{ $content['portfolio']['title'] ?? 'Proyek Software Kami' }}</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">{{ $content['portfolio']['subtitle'] ?? 'Beberapa proyek pengembangan software yang telah kami selesaikan.' }}</p>
            </div>

            @if(isset($portfolioItems))
                @php
                    $softwareCategories = $content['portfolio']['categories'] ?? ['Web App', 'Mobile App', 'IoT & Embedded'];
                    $filteredItems = $portfolioItems->filter(function($item) use ($softwareCategories) {
                        return in_array($item->category, $softwareCategories);
                    });
                @endphp

                @if($filteredItems->count() > 0)
                    <div class="portfolio-grid">
                        @foreach($filteredItems as $item)
                            <div class="port-card">
                                @if(!empty($item->image_url))
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="port-card-img">
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
                    <p class="text-center text-muted py-4">Tidak ada proyek software yang tersedia saat ini.</p>
                @endif
            @else
                <p class="text-center text-muted py-4">Tidak ada proyek software yang tersedia saat ini.</p>
            @endif
        </div>
    </section>
@endsection
