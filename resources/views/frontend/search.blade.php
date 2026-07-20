@extends('frontend.layouts.master', ['title' => 'Pencarian: ' . request('q')])

@section('title', 'Pencarian - ' . request('q'))

@section('meta_desc', 'Hasil pencarian untuk "' . e(request('q')) . '"')

@section('content')

<section class="section" style="padding-top: 60px; padding-bottom: 80px;">
    <div class="container" style="max-width: 800px;">

        {{-- Header --}}
        <div class="text-center mb-5">
            <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem;">
                <i class="fas fa-search" style="color: var(--accent);"></i> Pencarian
            </h1>
            <p class="text-muted" style="font-size: 0.95rem;">
                @if($query)
                    Menampilkan hasil untuk "<strong>{{ e($query) }}</strong>"
                @else
                    Masukkan kata kunci untuk mencari produk, layanan, atau portfolio.
                @endif
            </p>
        </div>

        {{-- Search Form --}}
        <form action="{{ route('search') }}" method="GET" class="mb-5" style="max-width: 500px; margin: 0 auto;">
            <div class="input-group" style="display: flex; gap: 0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                <input type="text" name="q" value="{{ e($query) }}" placeholder="Cari produk, layanan..." autocomplete="off"
                       style="flex: 1; padding: 12px 18px; border: 1px solid var(--glass-border); border-right: none; border-radius: 12px 0 0 12px; font-size: 0.9rem; outline: none; background: var(--glass-bg);">
                <button type="submit"
                        style="padding: 12px 24px; background: var(--accent); color: #fff; border: none; border-radius: 0 12px 12px 0; font-size: 0.9rem; cursor: pointer;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Results --}}
        @if($query)

            @if($products->isEmpty() && $services->isEmpty() && $portfolios->isEmpty() && (!isset($softwareServices) || $softwareServices->isEmpty()))
                <div class="text-center py-5">
                    <i class="fas fa-search-minus" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 1rem; display: block;"></i>
                    <h4 style="font-weight: 600; color: var(--text-primary);">Tidak Ditemukan</h4>
                    <p class="text-muted" style="font-size: 0.9rem;">Tidak ada hasil untuk "<strong>{{ e($query) }}</strong>". Coba kata kunci lain.</p>
                </div>
            @else
                {{-- Total count --}}
                <p class="text-muted mb-4" style="font-size: 0.85rem;">
                    {{ $products->total() + $services->count() + ($softwareServices->count() ?? 0) + $portfolios->count() }} hasil ditemukan
                </p>

                {{-- Products --}}
                @if($products->isNotEmpty())
                <div class="mb-5">
                    <h5 style="font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-box" style="color: var(--accent); font-size: 0.9rem;"></i> Produk
                        <span class="badge" style="background: var(--accent); color: #fff; font-size: 0.7rem; padding: 2px 10px; border-radius: 20px;">{{ $products->total() }}</span>
                    </h5>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($products as $p)
                        <a href="{{ route('detail-product', $p->slug) }}" class="search-result-item">
                            <div class="search-result-icon" style="background: rgba(79,110,247,0.1); color: #4f6ef7;">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div class="search-result-content">
                                <div class="search-result-title">{{ $p->name }}</div>
                                <div class="search-result-desc">{{ $p->category?->name ?? '' }}</div>
                            </div>
                            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 0.7rem;"></i>
                        </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $products->withQueryString()->links('frontend.partials.pagination') }}
                    </div>
                </div>
                @endif

                {{-- Services --}}
                @if($services->isNotEmpty())
                <div class="mb-5">
                    <h5 style="font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-headset" style="color: var(--accent); font-size: 0.9rem;"></i> Layanan
                        <span class="badge" style="background: var(--accent); color: #fff; font-size: 0.7rem; padding: 2px 10px; border-radius: 20px;">{{ $services->count() }}</span>
                    </h5>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($services as $s)
                        <a href="{{ url('/layanan#' . $s->slug) }}" class="search-result-item">
                            <div class="search-result-icon" style="background: rgba(34,197,94,0.1); color: #22c55e;">
                                <i class="fas {{ $s->icon ?? 'fa-headset' }}"></i>
                            </div>
                            <div class="search-result-content">
                                <div class="search-result-title">{{ $s->name }}</div>
                                <div class="search-result-desc">{{ Str::limit(strip_tags($s->description ?? ''), 80) }}</div>
                            </div>
                            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 0.7rem;"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Software House Services --}}
                @if(isset($softwareServices) && $softwareServices->isNotEmpty())
                <div class="mb-5">
                    <h5 style="font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-laptop-code" style="color: var(--accent); font-size: 0.9rem;"></i> Software House
                        <span class="badge" style="background: var(--accent); color: #fff; font-size: 0.7rem; padding: 2px 10px; border-radius: 20px;">{{ $softwareServices->count() }}</span>
                    </h5>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($softwareServices as $shs)
                        <a href="{{ url('/software-house') }}" class="search-result-item">
                            <div class="search-result-icon" style="background: rgba(79,110,247,0.1); color: #4f6ef7;">
                                <i class="fas {{ $shs->icon ?? 'fa-laptop-code' }}"></i>
                            </div>
                            <div class="search-result-content">
                                <div class="search-result-title">{{ $shs->title }}</div>
                                <div class="search-result-desc">Layanan Software House</div>
                            </div>
                            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 0.7rem;"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Portfolio --}}
                @if($portfolios->isNotEmpty())
                <div>
                    <h5 style="font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-briefcase" style="color: var(--accent); font-size: 0.9rem;"></i> Portfolio
                        <span class="badge" style="background: var(--accent); color: #fff; font-size: 0.7rem; padding: 2px 10px; border-radius: 20px;">{{ $portfolios->count() }}</span>
                    </h5>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($portfolios as $pf)
                        <a href="{{ url('/portofolio#' . $pf->slug) }}" class="search-result-item">
                            <div class="search-result-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="search-result-content">
                                <div class="search-result-title">{{ $pf->title }}</div>
                                <div class="search-result-desc">{{ $pf->category ?? '' }}</div>
                            </div>
                            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 0.7rem;"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            @endif

        @endif

    </div>
</section>

<style>
.search-result-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 12px 16px;
    border-radius: 12px;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
}
.search-result-item:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}
.search-result-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 0.85rem;
}
.search-result-content {
    flex: 1; min-width: 0;
}
.search-result-title {
    font-weight: 600; font-size: 0.88rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.search-result-desc {
    font-size: 0.78rem; color: var(--text-muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
</style>

@endsection
