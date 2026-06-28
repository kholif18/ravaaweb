@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item text-gray-400">
        <a href="{{ route('admin.dashboard') }}"
           class="text-gray-400 text-hover-primary">
            Home
        </a>
    </li>
    <li class="breadcrumb-item text-gray-400">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">
        Dashboard
    </li>
@endsection

@section('content')

    {{-- ===== ROW 1: QUICK STATS (4 columns) ===== --}}
    <div class="row mb-4">

        @php
            $stats = [
                ['Produk', 42, 'box', 'primary'],
                ['Kategori', 4, 'tags', 'success'],
                ['Testimoni', 15, 'star', 'warning'],
                ['Portfolio', 8, 'images', 'info'],
            ];
        @endphp

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

    {{-- ===== ROW 2: STATISTICS / CHARTS (2 columns) ===== --}}
    <div class="row mb-4">

        {{-- AREA CHART: KUNJUNGAN HARIAN --}}
        <div class="col-xl-6 col-lg-6 mb-4 mb-xl-0">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-semibold mb-0">Kunjungan Situs</h6>
                    <select class="form-select form-select-sm w-auto">
                        <option>7 Hari</option>
                        <option>30 Hari</option>
                        <option>3 Bulan</option>
                    </select>
                </div>
                <div id="visitor_area_chart" style="height: 260px;"></div>
            </div>
        </div>

        {{-- BAR CHART: KUNJUNGAN PER HALAMAN --}}
        <div class="col-xl-6 col-lg-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-semibold mb-0">Halaman Terpopuler</h6>
                </div>
                <div id="visitor_page_chart" style="height: 260px;"></div>
            </div>
        </div>

    </div>

    {{-- ===== ROW 3: TABLE + ACTIVITY (2 columns) ===== --}}
    <div class="row">

        {{-- PRODUK TERBARU --}}
        <div class="col-xl-8">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0">Produk Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-light-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-row-dashed align-middle mb-0">
                        <thead class="fs-7 text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fs-7">
                            <tr>
                                <td>#RC-DES-015</td>
                                <td>UI/UX Mobile App</td>
                                <td>Design</td>
                                <td><span class="badge badge-light-success">Aktif</span></td>
                                <td>20 Nov 2023</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-light-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>#RC-WEB-010</td>
                                <td>WordPress E-commerce</td>
                                <td>Web Development</td>
                                <td><span class="badge badge-light-success">Aktif</span></td>
                                <td>18 Nov 2023</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-light-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- AKTIVITAS TERBARU --}}
        <div class="col-xl-4">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon symbol symbol-circle symbol-40px">
                            <span class="symbol-label bg-light-success">
                                <i class="bi bi-plus fs-6 text-success"></i>
                            </span>
                        </div>
                        <div class="timeline-content">
                            <div class="fw-semibold">Produk Baru Ditambahkan</div>
                            <div class="text-muted fs-7">2 jam yang lalu</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon symbol symbol-circle symbol-40px">
                            <span class="symbol-label bg-light-warning">
                                <i class="bi bi-pencil fs-6 text-warning"></i>
                            </span>
                        </div>
                        <div class="timeline-content">
                            <div class="fw-semibold">Kategori Diperbarui</div>
                            <div class="text-muted fs-7">5 jam yang lalu</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon symbol symbol-circle symbol-40px">
                            <span class="symbol-label bg-light-danger">
                                <i class="bi bi-trash fs-6 text-danger"></i>
                            </span>
                        </div>
                        <div class="timeline-content">
                            <div class="fw-semibold">Testimoni Dihapus</div>
                            <div class="text-muted fs-7">1 hari yang lalu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            if (typeof ApexCharts === 'undefined') return;

            // Area Chart - Kunjungan Harian
            const areaEl = document.getElementById("visitor_area_chart");
            if (areaEl) {
                new ApexCharts(areaEl, {
                    series: [{
                        name: 'Pengunjung',
                        data: [120, 180, 160, 210, 260, 240, 300]
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
                    colors: ['#38bdf8'],
                    xaxis: {
                        categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
                    },
                    yaxis: {
                        labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
                    },
                    grid: {
                        borderColor: 'rgba(255,255,255,0.06)',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: { formatter: val => val + ' pengunjung' }
                    }
                }).render();
            }

            // Bar Chart - Kunjungan per Halaman
            const barEl = document.getElementById("visitor_page_chart");
            if (barEl) {
                new ApexCharts(barEl, {
                    series: [{
                        name: 'Kunjungan',
                        data: [520, 430, 380, 310, 260]
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
                            barHeight: '60%'
                        }
                    },
                    colors: ['#22c55e'],
                    xaxis: {
                        categories: ['Beranda', 'Produk', 'Portfolio', 'Tentang Kami', 'Kontak'],
                        labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
                    },
                    grid: {
                        borderColor: 'rgba(255,255,255,0.06)',
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
