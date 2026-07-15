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

{{-- ======================================================================== --}}
{{-- BAGIAN 1: ANALYTICS KUNJUNGAN                                                         --}}
{{-- ======================================================================== --}}

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="glass-card">
            <h5 class="fw-bold mb-0" style="color: var(--text-primary);">
                <i class="bi bi-graph-up me-2"></i>Analytics Kunjungan
            </h5>
        </div>
    </div>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="glass-card h-100 text-center py-3">
            <div class="stat-value fs-3">{{ $totalVisits }}</div>
            <div class="stat-label fs-8">Total Kunjungan</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="glass-card h-100 text-center py-3">
            <div class="stat-value fs-3 text-primary">{{ $todayVisits }}</div>
            <div class="stat-label fs-8">Hari Ini</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="glass-card h-100 text-center py-3">
            <div class="stat-value fs-3 text-success">{{ $thisWeekVisits }}</div>
            <div class="stat-label fs-8">Minggu Ini</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="glass-card h-100 text-center py-3">
            <div class="stat-value fs-3 text-warning">{{ $thisMonthVisits }}</div>
            <div class="stat-label fs-8">Bulan Ini</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="glass-card h-100 text-center py-3">
            <div class="stat-value fs-3 text-info">{{ $uniqueVisitors }}</div>
            <div class="stat-label fs-8">Unik (30 hr)</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="glass-card h-100 text-center py-3">
            <div class="stat-value fs-3 text-secondary">{{ $totalProducts }}</div>
            <div class="stat-label fs-8">Total Produk</div>
        </div>
    </div>
</div>

{{-- Charts row --}}
<div class="row g-3 mb-4">

    {{-- Area chart: 14 hari --}}
    <div class="col-xl-8">
        <div class="glass-card">
            <h6 class="fw-semibold mb-3">Kunjungan 14 Hari Terakhir</h6>
            <div id="chart_14days" style="height: 260px;"></div>
        </div>
    </div>

    {{-- Hourly distribution --}}
    <div class="col-xl-4">
        <div class="glass-card">
            <h6 class="fw-semibold mb-3">Distribusi Jam (Hari Ini)</h6>
            <div id="chart_hourly" style="height: 260px;"></div>
        </div>
    </div>

</div>

{{-- Popular pages + visits by type --}}
<div class="row g-3 mb-4">

    {{-- Most visited pages --}}
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h6 class="fw-semibold mb-3">Halaman Terpopuler (Bulan Ini)</h6>
            <div class="table-responsive">
                <table class="table table-row-dashed align-middle mb-0">
                    <thead class="fs-7 text-muted">
                        <tr>
                            <th>#</th>
                            <th>Halaman</th>
                            <th>Tipe</th>
                            <th class="text-end">Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody class="fs-7">
                        @forelse($popularPages as $i => $page)
                        <tr>
                            <td class="fw-bold" style="width: 32px; color: var(--text-muted);">{{ $i + 1 }}</td>
                            <td>
                                <span class="fw-semibold">{{ $page['title'] ?? $page['page_type'] }}</span>
                                <div class="text-muted fs-8 text-truncate" style="max-width: 280px;">{{ $page['url'] }}</div>
                            </td>
                            <td><span class="badge badge-light-primary">{{ $page['page_type'] }}</span></td>
                            <td class="text-end fw-bold">{{ $page['count'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data kunjungan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Visits by type + top products --}}
    <div class="col-xl-6">
        <div class="row g-3">

            <div class="col-12">
                <div class="glass-card">
                    <h6 class="fw-semibold mb-3">Kunjungan per Halaman</h6>
                    <div id="chart_by_type" style="height: 200px;"></div>
                </div>
            </div>

            <div class="col-12">
                <div class="glass-card">
                    <h6 class="fw-semibold mb-3">Produk Terpopuler</h6>
                    @forelse($topProducts as $i => $p)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fw-bold text-muted" style="width: 20px; font-size: 0.75rem;">{{ $i + 1 }}</span>
                        <div class="flex-grow-1">
                            <div class="fw-semibold fs-7">{{ $p->name }}</div>
                        </div>
                        <span class="badge badge-light-primary" style="flex-shrink: 0;">{{ $p->views_count }} dilihat</span>
                    </div>
                    @empty
                    <div class="text-muted fs-7 text-center py-3">Belum ada data.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>

{{-- ======================================================================== --}}
{{-- BAGIAN 2: KONTEN STATISTICS (existing)                                --}}
{{-- ======================================================================== --}}

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="glass-card">
            <h5 class="fw-bold mb-0" style="color: var(--text-primary);">
                <i class="bi bi-bar-chart me-2"></i>Statistik Konten
            </h5>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
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
                    <div class="text-muted fs-8 mt-1">Menampung semua katalog</div>
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
                    <div class="text-muted fs-8 mt-1">Karya & portofolio aktif</div>
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
                    <div class="text-muted fs-8 mt-1">Layanan kreatif ditawarkan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
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
                <div class="d-flex justify-content-between align-items-center">
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
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h5 class="fw-bold mb-4" style="color: var(--text-primary);">Status Data & Publikasi</h5>
            <!-- Products Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-box me-1"></i> Produk</span>
                    <span class="fs-8 text-muted">Aktif: {{ $productStatus['active'] ?? 0 }} | Draft: {{ $productStatus['draft'] ?? 0 }}</span>
                </div>
                @php $prodTotal = array_sum($productStatus) ?: 1; $prodActivePct = (($productStatus['active'] ?? 0) / $prodTotal) * 100; @endphp
                <div class="progress" style="height: 8px; border-radius: var(--radius-full);">
                    <div class="progress-bar bg-success" style="width: {{ $prodActivePct }}%;"></div>
                    <div class="progress-bar bg-secondary" style="width: {{ 100 - $prodActivePct }}%;"></div>
                </div>
            </div>
            <!-- Services Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-headset me-1"></i> Layanan</span>
                    <span class="fs-8 text-muted">Aktif: {{ $serviceStatus['active'] ?? 0 }} | Inaktif: {{ $serviceStatus['inactive'] ?? 0 }}</span>
                </div>
                @php $svcTotal = array_sum($serviceStatus) ?: 1; $svcActivePct = (($serviceStatus['active'] ?? 0) / $svcTotal) * 100; @endphp
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: {{ $svcActivePct }}%;"></div>
                    <div class="progress-bar bg-secondary" style="width: {{ 100 - $svcActivePct }}%;"></div>
                </div>
            </div>
            <!-- Portfolio Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-briefcase me-1"></i> Portfolio</span>
                    <span class="fs-8 text-muted">Aktif: {{ $portfolioStatus['active'] ?? 0 }} | Draft: {{ $portfolioStatus['draft'] ?? 0 }}</span>
                </div>
                @php $portTotal = array_sum($portfolioStatus) ?: 1; $portActivePct = (($portfolioStatus['active'] ?? 0) / $portTotal) * 100; @endphp
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: {{ $portActivePct }}%;"></div>
                    <div class="progress-bar bg-secondary" style="width: {{ 100 - $portActivePct }}%;"></div>
                </div>
            </div>
            <!-- Testimonial Status -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold fs-7"><i class="bi bi-chat-quote me-1"></i> Testimoni</span>
                    <span class="fs-8 text-muted">Aktif: {{ $testimonialStatus['active'] ?? 0 }} | Draft: {{ $testimonialStatus['draft'] ?? 0 }}</span>
                </div>
                @php $testTotal = array_sum($testimonialStatus) ?: 1; $testActivePct = (($testimonialStatus['active'] ?? 0) / $testTotal) * 100; @endphp
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: {{ $testActivePct }}%;"></div>
                    <div class="progress-bar bg-secondary" style="width: {{ 100 - $testActivePct }}%;"></div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 mt-4 pt-2">
                <span class="d-flex align-items-center fs-8 text-muted"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span> Terpublikasi / Aktif</span>
                <span class="d-flex align-items-center fs-8 text-muted"><span class="d-inline-block rounded-circle bg-secondary me-1" style="width: 8px; height: 8px;"></span> Draft / Inaktif</span>
            </div>
        </div>
    </div>
</div>

<!-- Distribusi Produk per Kategori -->
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
                            @php $density = $totalProducts > 0 ? ($cat->products_count / $totalProducts) * 100 : 0; @endphp
                            <tr>
                                <td class="fw-semibold text-primary">{{ $cat->name }}</td>
                                <td class="text-muted">{{ $cat->slug }}</td>
                                <td class="text-center fw-bold">{{ $cat->products_count }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: {{ $density }}%;"></div>
                                        </div>
                                        <span class="text-muted" style="min-width: 45px;">{{ number_format($density, 1) }}%</span>
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

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof ApexCharts === 'undefined') return;

    // ── 14-Day Area Chart ──
    var el14 = document.getElementById("chart_14days");
    if (el14) {
        new ApexCharts(el14, {
            series: [{ name: 'Kunjungan', data: @json($chartValues14) }],
            chart: { type: 'area', height: 260, toolbar: { show: false }, fontFamily: 'inherit', background: 'transparent' },
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.08 } },
            colors: ['#4f6ef7'],
            xaxis: {
                categories: @json($chartLabels14),
                labels: { style: { colors: '#9aa0a6', fontSize: '11px' }, formatter: function(v) { return v ? v.substring(5) : ''; } }
            },
            yaxis: { labels: { style: { colors: '#9aa0a6', fontSize: '12px' } }, min: 0 },
            grid: { borderColor: 'rgba(0,0,0,0.04)', strokeDashArray: 4 },
            tooltip: { y: { formatter: function(v) { return v + ' kunjungan'; } } }
        }).render();
    }

    // ── Hourly Bar Chart ──
    var elHourly = document.getElementById("chart_hourly");
    if (elHourly) {
        var hours = [];
        for (var h = 0; h < 24; h++) { hours.push(('0' + h).slice(-2) + ':00'); }
        new ApexCharts(elHourly, {
            series: [{ name: 'Kunjungan', data: @json($hourlyData) }],
            chart: { type: 'bar', height: 260, toolbar: { show: false }, fontFamily: 'inherit', background: 'transparent' },
            plotOptions: { bar: { borderRadius: 3, columnWidth: '70%' } },
            colors: ['#22c55e'],
            xaxis: { categories: hours, labels: { style: { colors: '#9aa0a6', fontSize: '10px' }, rotate: -45 } },
            yaxis: { labels: { style: { colors: '#9aa0a6', fontSize: '11px' } }, min: 0 },
            grid: { borderColor: 'rgba(0,0,0,0.04)', strokeDashArray: 4 },
            tooltip: { y: { formatter: function(v) { return v + ' kunjungan'; } } }
        }).render();
    }

    // ── Visits by Type Pie ──
    var elByType = document.getElementById("chart_by_type");
    if (elByType) {
        var byType = @json($visitsByType);
        var labels = Object.keys(byType);
        var values = Object.values(byType);
        if (!labels.length) { labels = ['Belum ada data']; values = [1]; }
        new ApexCharts(elByType, {
            series: values,
            chart: { type: 'donut', height: 200, fontFamily: 'inherit', background: 'transparent' },
            labels: labels,
            colors: ['#4f6ef7', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#f97316'],
            legend: { position: 'right', fontSize: '11px', labels: { colors: '#5f6368' } },
            dataLabels: { enabled: false },
            plotOptions: { pie: { donut: { size: '55%' } } },
            tooltip: { y: { formatter: function(v) { return v + ' kunjungan'; } } }
        }).render();
    }
});
</script>
@endpush
