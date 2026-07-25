@extends('frontend.layouts.master')

@section('title', 'Katalog')

@section('content')
<section class="section catalog-section">
    <div class="container">
        <form class="catalog-header" method="GET" action="{{ url()->current() }}" id="catalogForm">
            <input type="hidden" name="category" id="inputCategory" value="{{ request('category') }}">
            <input type="hidden" name="type" id="inputType" value="{{ request('type', 'all') }}">

            <div class="catalog-toolbar">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                </div>
                <div class="type-pills">
                    <button type="button" class="filter-pill {{ request('type', 'all') == 'all' ? 'active' : '' }}" data-type="all">Semua</button>
                    <button type="button" class="filter-pill {{ request('type') == 'product' ? 'active' : '' }}" data-type="product">Produk</button>
                    <button type="button" class="filter-pill {{ request('type') == 'service' ? 'active' : '' }}" data-type="service">Layanan</button>
                </div>
            </div>

            <div class="filter-pills-wrap">
                <button type="button" class="scroll-btn scroll-left d-none" id="scrollLeftBtn" aria-label="Scroll Left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="filter-pills" id="categoryPills">
                    <button type="button" class="filter-pill {{ !request('category') ? 'active' : '' }}" data-category="">Semua</button>
                    @foreach($categories as $category)
                        <button type="button" class="filter-pill {{ request('category') == $category->slug ? 'active' : '' }}" data-category="{{ $category->slug }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                <button type="button" class="scroll-btn scroll-right d-none" id="scrollRightBtn" aria-label="Scroll Right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </form>

        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="prod-card" onclick="if(!event.target.closest('.prod-card-actions')){ window.location='{{ url('/product/' . $product->slug) }}' }" style="cursor:pointer;">
                        <div class="prod-card-img" style="position:relative;">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="prod-card-img" loading="lazy">
                            @if(!empty($product->badge))
                                <div class="prod-card-badge badge-{{ strtolower(explode(' ', $product->badge)[0]) }}">{{ $product->badge }}</div>
                            @endif
                        </div>

                        <div class="prod-card-body">
                            <div class="prod-card-category">{{ $product->category }}</div>
                            <h3 class="prod-card-title">{{ $product->name }}</h3>
                            <div class="prod-card-price">
                                {{ $product->effective_price }}
                                @if($product->original_price)
                                    <span class="original">{{ $product->original_price }}</span>
                                @endif
                            </div>
                            <p class="prod-card-desc">{{ Str::limit($product->description, 100) }}</p>
                            <div class="prod-card-actions">
                                <a href="/product/{{ $product->slug }}" class="btn btn-primary btn-sm">Detail</a>
                                @if($settings['whatsapp'] ?? null)
                                <a href="https://wa.me/{{ $settings['whatsapp'] }}?text={{ urlencode($settings['whatsapp_message'] ?? 'Halo, saya tertarik dengan ' . $product->name) }}" class="btn btn-whatsapp btn-sm" target="_blank">WhatsApp</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('frontend.partials.pagination') }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                    <path d="M8 11h6"/>
                </svg>
                <h3>Produk Tidak Ditemukan</h3>
                <p>Coba ubah filter atau kata kunci pencarian.</p>
                <a href="/product" class="btn btn-primary">Reset Filter</a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category pill click
    document.querySelectorAll('#categoryPills .filter-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.getElementById('inputCategory').value = this.dataset.category;
            document.getElementById('catalogForm').submit();
        });
    });

    // Type pill click
    document.querySelectorAll('.type-pills .filter-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.getElementById('inputType').value = this.dataset.type;
            document.getElementById('catalogForm').submit();
        });
    });

    // Category pills horizontal scroll buttons
    const pills = document.getElementById('categoryPills');
    const btnLeft = document.getElementById('scrollLeftBtn');
    const btnRight = document.getElementById('scrollRightBtn');

    if (pills && btnLeft && btnRight) {
        const updateScrollButtons = () => {
            const scrollLeft = pills.scrollLeft;
            const maxScroll = pills.scrollWidth - pills.clientWidth;
            
            if (scrollLeft <= 2) {
                btnLeft.classList.add('d-none');
            } else {
                btnLeft.classList.remove('d-none');
            }
            
            if (scrollLeft >= maxScroll - 2) {
                btnRight.classList.add('d-none');
            } else {
                btnRight.classList.remove('d-none');
            }
        };

        const scrollAmount = 200;
        btnLeft.addEventListener('click', function() {
            pills.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        btnRight.addEventListener('click', function() {
            pills.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        pills.addEventListener('scroll', updateScrollButtons);
        window.addEventListener('resize', updateScrollButtons);
        
        // Scroll active pill into view on load
        const activePill = pills.querySelector('.filter-pill.active');
        if (activePill) {
            activePill.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'center' });
        }
        
        // Initial button visibility check
        setTimeout(updateScrollButtons, 100);
    }
});
</script>
@endpush
