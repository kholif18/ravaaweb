@extends('admin.layouts.app')

@section('page-title', 'Statistik Traffic')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Statistik Traffic</li>
@endsection

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-md-12">
        <div class="card card-flush h-md-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Traffic Website</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Statistik kunjungan 30 hari terakhir</span>
                </h3>
            </div>
            <div class="card-body pt-6">
                <div class="alert alert-warning">
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-warning">Data Belum Tersedia</h4>
                        <span>Modul statistik traffic sedang dalam pengembangan. Integrasikan dengan Google Analytics atau pelacakan internal untuk melihat data.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
