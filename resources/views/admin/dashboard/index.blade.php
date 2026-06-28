@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}"
           class="text-muted text-hover-primary">
            Home
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        Dashboard
    </li>
@endsection

@section('content')
    {{-- QUICK STATS --}}
    <div class="row g-6 mb-8">

        @php
            $stats = [
                ['Produk', 42, 'box', 'primary'],
                ['Kategori', 4, 'tags', 'success'],
                ['Testimoni', 15, 'star', 'warning'],
                ['Portfolio', 8, 'images', 'info'],
            ];
        @endphp

        @foreach($stats as [$label, $value, $icon, $color])
            <div class="col-xl-3 col-md-6">
                <div class="card card-flush h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="symbol symbol-45px me-5">
                            <span class="symbol-label bg-light-{{ $color }}">
                                <i class="bi bi-{{ $icon }} fs-2 text-{{ $color }}"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-bold fs-4">{{ $value }}</div>
                            <div class="text-muted fs-7">{{ $label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- ACTION CARDS --}}
    <div class="row g-6 mb-8">

        <div class="col-xl-3 col-md-6">
            <a href="#" class="card card-flush h-100 hover-elevate-up">
                <div class="card-body">
                    <i class="bi bi-box fs-2 text-primary mb-3"></i>
                    <div class="fw-bold fs-5">Kelola Produk</div>
                    <div class="text-muted fs-7">
                        Tambah, edit, atau hapus produk
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="#" class="card card-flush h-100 hover-elevate-up">
                <div class="card-body">
                    <i class="bi bi-tags fs-2 text-success mb-3"></i>
                    <div class="fw-bold fs-5">Kelola Kategori</div>
                    <div class="text-muted fs-7">
                        Atur kategori produk & portfolio
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="#" class="card card-flush h-100 hover-elevate-up">
                <div class="card-body">
                    <i class="bi bi-star fs-2 text-warning mb-3"></i>
                    <div class="fw-bold fs-5">Kelola Testimoni</div>
                    <div class="text-muted fs-7">
                        Review & publikasi testimoni
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="#" class="card card-flush h-100 hover-elevate-up">
                <div class="card-body">
                    <i class="bi bi-images fs-2 text-info mb-3"></i>
                    <div class="fw-bold fs-5">Kelola Portfolio</div>
                    <div class="text-muted fs-7">
                        Manajemen proyek & galeri
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- VISITOR ANALYTICS --}}
    <div class="row g-6 mb-8">

        {{-- AREA CHART: KUNJUNGAN HARIAN --}}
        <div class="col-xl-6">
            <div class="card card-flush h-100">
                <div class="card-header">
                    <h3 class="card-title fw-bold">
                        Kunjungan Situs
                    </h3>

                    <div class="card-toolbar">
                        <select class="form-select form-select-sm w-125px">
                            <option>7 Hari</option>
                            <option>30 Hari</option>
                            <option>3 Bulan</option>
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <div id="visitor_area_chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        {{-- BAR CHART: KUNJUNGAN PER HALAMAN --}}
        <div class="col-xl-6">
            <div class="card card-flush h-100">
                <div class="card-header">
                    <h3 class="card-title fw-bold">
                        Halaman Paling Banyak Dikunjungi
                    </h3>
                </div>

                <div class="card-body">
                    <div id="visitor_page_chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE + ACTIVITY --}}
    <div class="row g-6">

        {{-- TABLE --}}
        <div class="col-xl-8">
            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Produk Terbaru</h3>
                </div>
                <div class="card-body">
                    <table class="table table-row-dashed align-middle">
                        <thead class="fs-7 text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fs-7">
                            <tr>
                                <td>#RC-DES-015</td>
                                <td>UI/UX Mobile App</td>
                                <td>Design</td>
                                <td><span class="badge badge-light-success">Aktif</span></td>
                                <td>20 Nov 2023</td>
                                <td>
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
                                <td>
                                    <a href="#" class="btn btn-sm btn-light-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-light-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ACTIVITY --}}
        <div class="col-xl-4">
            <div class="card card-flush h-100">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Aktivitas Terbaru</h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <span class="symbol-label bg-light-primary">
                                    <i class="bi bi-plus"></i>
                                </span>
                            </div>
                            <div class="timeline-content ps-3">
                                <div class="fw-bold">Produk Baru Ditambahkan</div>
                                <div class="text-muted fs-7">2 jam yang lalu</div>
                            </div>
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

            if (typeof ApexCharts === 'undefined') {
                console.warn('ApexCharts not loaded');
                return;
            }

            /* ===============================
            AREA CHART - KUNJUNGAN HARIAN
            ================================*/
            const areaEl = document.getElementById("visitor_area_chart");
            if (areaEl) {
                new ApexCharts(areaEl, {
                    series: [{
                        name: 'Pengunjung',
                        data: [120, 180, 160, 210, 260, 240, 300]
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: { show: false },
                        fontFamily: 'inherit'
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.45,
                            opacityTo: 0.1
                        }
                    },
                    colors: ['#009EF7'],
                    xaxis: {
                        categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        labels: {
                            style: { colors: '#A1A5B7', fontSize: '12px' }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: { colors: '#A1A5B7', fontSize: '12px' }
                        }
                    },
                    grid: {
                        borderColor: '#EFF2F5',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: {
                            formatter: val => val + ' pengunjung'
                        }
                    }
                }).render();
            }

            /* =====================================
            BAR CHART - KUNJUNGAN PER HALAMAN
            ======================================*/
            const barEl = document.getElementById("visitor_page_chart");
            if (barEl) {
                new ApexCharts(barEl, {
                    series: [{
                        name: 'Kunjungan',
                        data: [520, 430, 380, 310, 260]
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: { show: false },
                        fontFamily: 'inherit'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            barHeight: '60%'
                        }
                    },
                    colors: ['#50CD89'],
                    xaxis: {
                        categories: [
                            'Beranda',
                            'Produk',
                            'Portfolio',
                            'Tentang Kami',
                            'Kontak'
                        ],
                        labels: {
                            style: { colors: '#A1A5B7', fontSize: '12px' }
                        }
                    },
                    grid: {
                        borderColor: '#EFF2F5',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        x: { show: true },
                        y: {
                            formatter: val => val + ' kunjungan'
                        }
                    }
                }).render();
            }

        });
    </script>
@endpush

