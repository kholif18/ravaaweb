@extends('admin.layouts.app')

@section('page-title', 'Laporan & Analytics')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="bc-current">Laporan & Analytics</span>
    </li>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <!-- ===== ROW 1: CORE STATS CARDS ===== -->
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-primary me-3">
                    <i class="bi bi-box fs-3 text-primary"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-label">Total Produk</div>
                    <div class="text-muted fs-8 mt-1">
                        <span class="text-success fw-semibold">{{ $featuredProductsCount }}</span> Unggulan (Featured)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-success me-3">
                    <i class="bi bi-folder2-open fs-3 text-success"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                    <div class="stat-label">Total Kategori</div>
                    <div class="text-muted fs-8 mt-1">
                        Menampung semua katalog
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-info me-3">
                    <i class="bi bi-briefcase fs-3 text-info"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalPortfolio }}</div>
                    <div class="stat-label">Portfolio Items</div>
                    <div class="text-muted fs-8 mt-1">
                        Karya & portofolio aktif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-warning me-3">
                    <i class="bi bi-headset fs-3 text-warning"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalServices }}</div>
                    <div class="stat-label">Total Layanan</div>
                    <div class="text-muted fs-8 mt-1">
                        Layanan kreatif ditawarkan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- ===== ROW 2: DETAILED INSIGHTS ===== -->
    <!-- Column 1: Pricing & Inventory Stats -->
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h5 class="fw-bold mb-4" style="color: var(--text-primary);">Analisa & Statistik Harga</h5>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fs-7 text-muted">Rata-rata Harga Produk</span>
                    <span class="fw-bold text-primary fs-6">Rp {{ number_format($avgPrice, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fs-7 text-muted">Harga Tertinggi</span>
                    <span class="fw-bold text-success fs-6">Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fs-7 text-muted">Harga Terendah</span>
                    <span class="fw-bold text-info fs-6">Rp {{ number_format($minPrice, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fs-7 text-muted">Produk Dengan Diskon</span>
                    <span class="badge badge-light-danger fs-7" style="background: rgba(239,68,68,0.1); color: #b91c1c;">
                        {{ $discountedCount }} Produk Aktif Diskon
                    </span>
                </div>
            </div>

            <hr style="border-color: rgba(0,0,0,0.08); margin: 24px 0;">

            <h6 class="fw-semibold mb-3">Ringkasan Sistem Lainnya</h6>
            <div class="row g-2">
                <div class="col-6">
                    <div class="p-3 rounded text-center" style="background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04);">
                        <div class="fs-4 fw-bold text-primary">{{ $totalTestimonials }}</div>
                        <div class="fs-8 text-muted">Total Testimoni</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded text-center" style="background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04);">
                        <div class="fs-4 fw-bold text-success">{{ $totalMedia }}</div>
                        <div class="fs-8 text-muted">File Media Library</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded text-center" style="background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04);">
                        <div class="fs-4 fw-bold text-info">{{ $totalBanners }}</div>
                        <div class="fs-8 text-muted">Banners / Hero</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded text-center" style="background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04);">
                        <div class="fs-4 fw-bold text-warning">{{ $totalUsers }}</div>
                        <div class="fs-8 text-muted">Admin & Editor</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Column 2: Status Breakdown Segmentations -->
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h5 class="fw-bold mb-4" style="color: var(--text-primary);">Status Data & Publikasi</h5>
            
            <!-- Products Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-box me-1"></i> Produk</span>
                    <span class="fs-8 text-muted">
                        Aktif: {{ $productStatus['active'] ?? 0 }} | Draft: {{ $productStatus['draft'] ?? 0 }}
                    </span>
                </div>
                @php
                    $prodTotal = array_sum($productStatus) ?: 1;
                    $prodActivePct = (($productStatus['active'] ?? 0) / $prodTotal) * 100;
                @endphp
                <div class="progress" style="height: 8px; border-radius: var(--radius-full);">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $prodActivePct }}%;" aria-valuenow="{{ $prodActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ 100 - $prodActivePct }}%;" aria-valuenow="{{ 100 - $prodActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <!-- Services Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-headset me-1"></i> Layanan</span>
                    <span class="fs-8 text-muted">
                        Aktif: {{ $serviceStatus['active'] ?? 0 }} | Inaktif: {{ $serviceStatus['inactive'] ?? 0 }}
                    </span>
                </div>
                @php
                    $svcTotal = array_sum($serviceStatus) ?: 1;
                    $svcActivePct = (($serviceStatus['active'] ?? 0) / $svcTotal) * 100;
                @endphp
                <div class="progress" style="height: 8px; border-radius: var(--radius-full);">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $svcActivePct }}%;" aria-valuenow="{{ $svcActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ 100 - $svcActivePct }}%;" aria-valuenow="{{ 100 - $svcActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <!-- Portfolio Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-briefcase me-1"></i> Portfolio</span>
                    <span class="fs-8 text-muted">
                        Aktif: {{ $portfolioStatus['active'] ?? 0 }} | Draft: {{ $portfolioStatus['draft'] ?? 0 }}
                    </span>
                </div>
                @php
                    $portTotal = array_sum($portfolioStatus) ?: 1;
                    $portActivePct = (($portfolioStatus['active'] ?? 0) / $portTotal) * 100;
                @endphp
                <div class="progress" style="height: 8px; border-radius: var(--radius-full);">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $portActivePct }}%;" aria-valuenow="{{ $portActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ 100 - $portActivePct }}%;" aria-valuenow="{{ 100 - $portActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <!-- Testimonial Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-chat-quote me-1"></i> Testimoni</span>
                    <span class="fs-8 text-muted">
                        Aktif: {{ $testimonialStatus['active'] ?? 0 }} | Draft: {{ $testimonialStatus['draft'] ?? 0 }}
                    </span>
                </div>
                @php
                    $testTotal = array_sum($testimonialStatus) ?: 1;
                    $testActivePct = (($testimonialStatus['active'] ?? 0) / $testTotal) * 100;
                @endphp
                <div class="progress" style="height: 8px; border-radius: var(--radius-full);">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $testActivePct }}%;" aria-valuenow="{{ $testActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ 100 - $testActivePct }}%;" aria-valuenow="{{ 100 - $testActivePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-4 pt-2">
                <span class="d-flex align-items-center fs-8 text-muted"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span> Terpublikasi / Aktif</span>
                <span class="d-flex align-items-center fs-8 text-muted"><span class="d-inline-block rounded-circle bg-secondary me-1" style="width: 8px; height: 8px;"></span> Draft / Inaktif</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 3: DETAILED TABLES (DISTRIBUTIONS) ===== -->
<div class="row">
    <div class="col-12">
        <div class="glass-card">
            <h5 class="fw-bold mb-4" style="color: var(--text-primary);">Distribusi Produk per Kategori</h5>
            <div class="table-responsive">
                <table class="table table-row-dashed align-middle mb-0">
                    <thead class="fs-7 text-muted">
                        <tr>
                            <th>Kategori</th>
                            <th>Slug Kategori</th>
                            <th class="text-center" style="width: 15%;">Jumlah Produk</th>
                            <th>Persentase Kepadatan</th>
                        </tr>
                    </thead>
                    <tbody class="fs-7">
                        @foreach($productsPerCategory as $cat)
                            @php
                                $density = $totalProducts > 0 ? ($cat->products_count / $totalProducts) * 100 : 0;
                            @endphp
                            <tr>
                                <td class="fw-semibold text-primary">
                                    {{ $cat->name }}
                                </td>
                                <td class="text-muted">
                                    {{ $cat->slug }}
                                </td>
                                <td class="text-center fw-bold">
                                    {{ $cat->products_count }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="progress flex-grow-1" style="height: 6px; border-radius: var(--radius-full);">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $density }}%;" aria-valuenow="{{ $density }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-muted" style="min-width: 45px; text-align: right;">{{ number_format($density, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
