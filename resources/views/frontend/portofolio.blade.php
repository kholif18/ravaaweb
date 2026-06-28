@extends('frontend.layouts.master')

@section('title', 'Portfolio')

@section('content')
    <section class="page-hero">
        <div class="container">
            <h1>Portfolio Kami</h1>
            <p>Kumpulan proyek kreatif dan teknologi yang telah kami kerjakan.</p>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="portfolio-grid">
                @forelse($portfolioItems as $item)
                    <div class="port-card">
                        <img class="port-card-img" src="{{ $item->image }}" alt="{{ $item->title }}">
                        <div class="port-card-body">
                            <div class="port-card-category">{{ $item->category }}</div>
                            <h3 class="port-card-title">{{ $item->title }}</h3>
                            <div class="port-card-client">{{ $item->client }}</div>
                            <p class="port-card-desc">{{ Str::limit($item->description, 120) }}</p>
                            <div class="port-card-tech">
                                @foreach($item->tech as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                            <a href="https://wa.me/6282233377661?text={{ urlencode('Halo Ravaa Creative, saya tertarik dengan proyek ' . $item->title . '. Mohon info lebih lanjut.') }}"
                               class="btn btn-whatsapp"
                               target="_blank"
                               rel="noopener">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                @empty
                    <p>Tidak ada portfolio tersedia saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
