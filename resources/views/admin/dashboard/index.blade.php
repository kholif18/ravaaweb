@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="bc-current">Dashboard</span>
    </li>
@endsection

@section('content')

    {{-- ===== ROW 1: QUICK STATS (4 columns) ===== --}}
    <div class="row g-3 mb-4">

        @foreach($stats as [$label, $value, $icon, $color])
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="glass-card h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-light-{{ $color }} me-3">
                            <i class="bi bi-{{ $icon }} fs-3 text-{{ $color }}"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $value }}</div>
                            <div class="stat-label">{{ $label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- ===== ROW 2: VISITOR STATS (4 mini cards) ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-light-primary">
                        <i class="bi bi-eye fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $todayVisits }}</div>
                        <div class="stat-label">Kunjungan Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-light-success">
                        <i class="bi bi-calendar-week fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $thisWeekVisits }}</div>
                        <div class="stat-label">Minggu Ini</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-light-warning">
                        <i class="bi bi-calendar-month fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $thisMonthVisits }}</div>
                        <div class="stat-label">Bulan Ini</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-light-info">
                        <i class="bi bi-people fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $uniqueVisitors }}</div>
                        <div class="stat-label">Pengunjung Unik (30 hr)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== ROW 3: CHARTS (2 columns) ===== --}}
    <div class="row mb-4">

        {{-- AREA CHART: KUNJUNGAN 7 HARI --}}
        <div class="col-xl-6 col-lg-6 mb-4 mb-xl-0">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-semibold mb-0">Kunjungan 7 Hari Terakhir</h6>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-light-primary">Lihat Laporan</a>
                </div>
                <div id="visitor_area_chart" style="height: 260px;"></div>
            </div>
        </div>

        {{-- BAR CHART: HALAMAN TERPOPULER --}}
        <div class="col-xl-6 col-lg-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-semibold mb-0">Halaman Terpopuler</h6>
                </div>
                <div id="visitor_page_chart" style="height: 260px;"></div>
            </div>
        </div>

    </div>

    {{-- ===== ROW 4: TABLE + TOP PRODUK + AKTIVITAS (3 columns) ===== --}}
    <div class="row g-3">

        {{-- PRODUK TERBARU --}}
        <div class="col-xl-5">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0">Produk Terbaru</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-light-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-row-dashed align-middle mb-0">
                        <thead class="fs-7 text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fs-7">
                            @forelse($recentProducts as $product)
                            <tr>
                                <td>#{{ $product->sku ?? str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $product->status === 'active' ? 'badge-light-success' : 'badge-light-danger' }}">
                                        {{ $product->status === 'active' ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="btn btn-icon btn-sm"
                                           title="Edit"
                                           style="width: 28px; height: 28px; border-radius: 6px; background: rgba(79,110,247,0.1); color: #4f6ef7;">
                                            <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                                        </a>
                                        <button type="button" class="btn btn-icon btn-sm"
                                                onclick="window.Ravaa.deleteItem('{{ route('admin.products.destroy', $product->id) }}', 'Hapus Produk', 'Produk &quot;{{ $product->name }}&quot; akan dihapus permanen.')"
                                                title="Hapus"
                                                style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                                            <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada produk terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PRODUK TERPOPULER --}}
        <div class="col-xl-4">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0">Produk Terpopuler</h5>
                </div>
                @forelse($topProducts as $i => $product)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                         style="width: 32px; height: 32px; background: rgba(79,110,247,0.1); color: #4f6ef7; font-size: 0.8rem; flex-shrink: 0;">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <div class="fw-semibold fs-7 text-truncate">{{ $product->name }}</div>
                        <div class="text-muted fs-8">{{ $product->views_count }} dilihat</div>
                    </div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-light-primary" style="flex-shrink: 0;">
                        <i class="bi bi-box-arrow-up-right" style="font-size: 0.7rem;"></i>
                    </a>
                </div>
                @empty
                <div class="text-center py-4 text-muted">Belum ada data kunjungan.</div>
                @endforelse
            </div>
        </div>

        {{-- AKTIVITAS TERBARU --}}
        <div class="col-xl-3">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0">Kunjungan Terakhir</h5>
                </div>
                <div class="timeline">
                    @forelse(\App\Models\PageVisit::latest('visited_at')->limit(5)->get() as $visit)
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <span class="symbol-label" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: rgba(79,110,247,0.1);">
                                <i class="bi bi-eye fs-7 text-primary"></i>
                            </span>
                        </div>
                        <div class="timeline-content">
                            <div class="fw-semibold fs-7 text-truncate">{{ $visit->title ?? $visit->page_type }}</div>
                            <div class="text-muted fs-8">{{ $visit->visited_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">Belum ada kunjungan.</div>
                    @endforelse
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-light-primary w-100">
                        <i class="bi bi-graph-up me-1"></i> Laporan Lengkap
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            if (typeof ApexCharts === 'undefined') return;

            // ── Area Chart: Kunjungan 7 Hari ──
            const areaEl = document.getElementById("visitor_area_chart");
            if (areaEl) {
                new ApexCharts(areaEl, {
                    series: [{
                        name: 'Kunjungan',
                        data: @json($chartValues)
                    }],
                    chart: {
                        type: 'area',
                        height: 280,
                        toolbar: { show: false },
                        fontFamily: 'inherit',
                        background: 'transparent'
                    },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: {
                        type: 'gradient',
                        gradient: { opacityFrom: 0.45, opacityTo: 0.1 }
                    },
                    colors: ['#4f6ef7'],
                    xaxis: {
                        categories: @json($chartLabels),
                        labels: {
                            style: { colors: '#9aa0a6', fontSize: '11px' },
                            formatter: function(val) { return val ? val.substring(5) : ''; }
                        }
                    },
                    yaxis: {
                        labels: { style: { colors: '#9aa0a6', fontSize: '12px' } },
                        min: 0
                    },
                    grid: {
                        borderColor: 'rgba(0,0,0,0.04)',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: { formatter: val => val + ' kunjungan' }
                    }
                }).render();
            }

            // ── Bar Chart: Halaman Terpopuler ──
            const barEl = document.getElementById("visitor_page_chart");
            if (barEl) {
                var popularPages = @json($popularPages);
                var pageLabels = popularPages.map(function(p) {
                    return p.title || p.page_type.replace('_', ' ') || p.url;
                });
                var pageValues = popularPages.map(function(p) { return p.count; });

                new ApexCharts(barEl, {
                    series: [{
                        name: 'Kunjungan',
                        data: pageValues.length ? pageValues : [0]
                    }],
                    chart: {
                        type: 'bar',
                        height: 280,
                        toolbar: { show: false },
                        fontFamily: 'inherit',
                        background: 'transparent'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            barHeight: '50%'
                        }
                    },
                    colors: ['#22c55e'],
                    xaxis: {
                        categories: pageLabels.length ? pageLabels : ['Belum ada data'],
                        labels: { style: { colors: '#9aa0a6', fontSize: '11px' } }
                    },
                    grid: {
                        borderColor: 'rgba(0,0,0,0.04)',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: { formatter: val => val + ' kunjungan' }
                    }
                }).render();
            }

        });
    </script>
@endpush
