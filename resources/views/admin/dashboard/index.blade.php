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
    {{-- PAGE TITLE --}}
<div class="d-flex flex-column mb-8">
    <h1 class="text-dark fw-bold fs-2 mb-1">Dashboard</h1>
    <span class="text-muted fs-7">Content Management System — Ravaa Creative</span>
</div>

{{-- STAT CARDS --}}
<div class="row g-6 mb-8">

    {{-- Pages --}}
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-45px me-4">
                        <span class="symbol-label bg-light-primary">
                            <i class="bi bi-file-earmark-text fs-2 text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fw-bold fs-4">Pages</span>
                        <div class="text-muted fs-7">Total halaman</div>
                    </div>
                </div>
                <div class="fw-bold fs-2 text-dark mt-auto">12</div>
            </div>
        </div>
    </div>

    {{-- Blog --}}
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-45px me-4">
                        <span class="symbol-label bg-light-success">
                            <i class="bi bi-journal-text fs-2 text-success"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fw-bold fs-4">Blog</span>
                        <div class="text-muted fs-7">Artikel aktif</div>
                    </div>
                </div>
                <div class="fw-bold fs-2 text-dark mt-auto">34</div>
            </div>
        </div>
    </div>

    {{-- Media --}}
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-45px me-4">
                        <span class="symbol-label bg-light-warning">
                            <i class="bi bi-image fs-2 text-warning"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fw-bold fs-4">Media</span>
                        <div class="text-muted fs-7">File tersimpan</div>
                    </div>
                </div>
                <div class="fw-bold fs-2 text-dark mt-auto">128</div>
            </div>
        </div>
    </div>

    {{-- Users --}}
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-45px me-4">
                        <span class="symbol-label bg-light-danger">
                            <i class="bi bi-people fs-2 text-danger"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fw-bold fs-4">Users</span>
                        <div class="text-muted fs-7">Admin & editor</div>
                    </div>
                </div>
                <div class="fw-bold fs-2 text-dark mt-auto">5</div>
            </div>
        </div>
    </div>

</div>

{{-- MAIN CONTENT --}}
<div class="row g-6">

    {{-- RECENT CONTENT --}}
    <div class="col-xl-8">
        <div class="card card-flush h-100">
            <div class="card-header">
                <h3 class="card-title fw-bold">Konten Terbaru</h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle">
                        <thead>
                        <tr class="fw-bold text-muted fs-7">
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                        </thead>
                        <tbody class="fs-7">
                        <tr>
                            <td>Landing Page Ravaa Creative</td>
                            <td>Page</td>
                            <td><span class="badge badge-light-success">Published</span></td>
                            <td>02 Jan 2026</td>
                        </tr>
                        <tr>
                            <td>Branding Strategy 2026</td>
                            <td>Blog</td>
                            <td><span class="badge badge-light-warning">Draft</span></td>
                            <td>01 Jan 2026</td>
                        </tr>
                        <tr>
                            <td>Company Profile Update</td>
                            <td>Page</td>
                            <td><span class="badge badge-light-success">Published</span></td>
                            <td>29 Des 2025</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTION --}}
    <div class="col-xl-4">
        <div class="card card-flush h-100">
            <div class="card-header">
                <h3 class="card-title fw-bold">Quick Action</h3>
            </div>

            <div class="card-body d-grid gap-4">
                <a href="#" class="btn btn-light-primary w-100">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Halaman
                </a>
                <a href="#" class="btn btn-light-success w-100">
                    <i class="bi bi-pencil-square me-2"></i> Tulis Artikel
                </a>
                <a href="#" class="btn btn-light-warning w-100">
                    <i class="bi bi-upload me-2"></i> Upload Media
                </a>
                <a href="#" class="btn btn-light-dark w-100">
                    <i class="bi bi-gear me-2"></i> Pengaturan Website
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
