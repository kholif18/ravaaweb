@extends('admin.layouts.app')

@section('page-title', 'Software House Dashboard')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="text-muted">Software House Hub</span>
    </li>
@endsection

@section('content')
<div class="col-12 mb-4">
    <div class="glass-card p-4">
        <h4 class="fw-bold mb-2">Pusat Pengelolaan Halaman Software House</h4>
        <p class="text-muted mb-0 fs-7">Kelola konten halaman, fitur-fitur layanan, serta daftar portofolio proyek perangkat lunak Anda dalam satu halaman terpadu.</p>
    </div>
</div>

@if ($errors->any())
<div class="col-12 mb-3">
    <div class="alert alert-danger mb-0">
        <div class="fw-bold mb-1">Terjadi kesalahan validasi:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Navigasi Tab -->
<ul class="nav nav-tabs nav-line-tabs mb-4" id="softwareHouseTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-pane" type="button" role="tab" aria-controls="settings-pane" aria-selected="true">
            <i class="bi bi-layout-three-columns me-1"></i> 1. Pengaturan Halaman (CMS)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="layanan-tab" data-bs-toggle="tab" data-bs-target="#layanan-pane" type="button" role="tab" aria-controls="layanan-pane" aria-selected="false">
            <i class="bi bi-gear-wide-connected me-1"></i> 2. Layanan & Sub-Fitur ({{ $softwareServices->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="portfolio-tab" data-bs-toggle="tab" data-bs-target="#portfolio-pane" type="button" role="tab" aria-controls="portfolio-pane" aria-selected="false">
            <i class="bi bi-briefcase me-1"></i> 3. Portofolio Proyek ({{ $portfolioItems->count() }})
        </button>
    </li>
</ul>

<div class="tab-content" id="softwareHouseTabsContent">
    
    <!-- TAB 1: PENGATURAN HALAMAN (CMS) -->
    <div class="tab-pane fade show active" id="settings-pane" role="tabpanel" aria-labelledby="settings-tab">
        <form action="{{ route('admin.software-house.store') }}" method="POST" id="software-house-builder-form">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Section 1: Hero Header -->
                    <div class="glass-card mb-4">
                        <div class="card-header">
                            <div class="card-title"><i class="bi bi-window me-1"></i> Section Hero (Header Atas)</div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Judul Hero (Title)</label>
                                    <input type="text" class="form-control form-control-sm" name="hero[title]"
                                           value="{{ $content['hero']['title'] ?? 'Software House' }}" required>
                                </div>
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Deskripsi Hero</label>
                                    <textarea class="form-control form-control-sm" name="hero[description]" rows="3" required>{{ $content['hero']['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Layanan Header (Pengantar) -->
                    <div class="glass-card mb-4">
                        <div class="card-header">
                            <div class="card-title"><i class="bi bi-headset me-1"></i> Section Layanan (Pengantar)</div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Judul Section Layanan</label>
                                    <input type="text" class="form-control form-control-sm" name="layanan[title]"
                                           value="{{ $content['layanan']['title'] ?? 'Layanan Pengembangan Software' }}" required>
                                </div>
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Penjelasan Section Layanan</label>
                                    <textarea class="form-control form-control-sm" name="layanan[subtitle]" rows="3" required>{{ $content['layanan']['subtitle'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Info Database -->
                    <div class="glass-card mb-4">
                        <div class="card-header">
                            <div class="card-title"><i class="bi bi-database me-1"></i> Database Layanan Software</div>
                        </div>
                        <div class="card-body">
                            <p class="fs-8 text-muted mb-0">
                                Data layanan & sub-fitur Software House kini dikelola secara mandiri di tabel <strong>software_house_services</strong>, 
                                terpisah dari layanan umum. Kelola daftar layanan software di tab <strong>"2. Layanan & Sub-Fitur"</strong>.
                            </p>
                        </div>
                    </div>

                    <!-- Section 3: Proses (Bagaimana Kami Bekerja) -->
                    <div class="glass-card mb-4">
                        <div class="card-header">
                            <div class="card-title"><i class="bi bi-arrow-repeat-all me-1"></i> Section Proses (Bagaimana Kami Bekerja)</div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Judul Section Proses</label>
                                    <input type="text" class="form-control form-control-sm" name="proses[title]"
                                           value="{{ $content['proses']['title'] ?? 'Bagaimana Kami Bekerja' }}" required>
                                </div>
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Penjelasan Section Proses</label>
                                    <textarea class="form-control form-control-sm" name="proses[subtitle]" rows="2" required>{{ $content['proses']['subtitle'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4" style="border-color: rgba(0,0,0,0.08);">
                            <h6 class="fw-bold mb-3"><i class="bi bi-list-ol me-1"></i> Langkah-Langkah Proses (Steps)</h6>

                            <div class="row g-3">
                                @for($i = 0; $i < 4; $i++)
                                    @php
                                        $stepTitleDefault = ['Konsultasi', 'Desain', 'Development', 'Launch'][$i];
                                        $stepDescDefault = [
                                            'Diskusi kebutuhan dan tujuan bisnis Anda untuk menentukan solusi yang tepat.',
                                            'Perancangan arsitektur sistem dan antarmuka pengguna yang intuitif.',
                                            'Proses pengembangan menggunakan teknologi terkini dengan standar kualitas tinggi.',
                                            'Deployment ke production dan pendampingan hingga sistem berjalan lancar.'
                                        ][$i];
                                        $stepData = $content['proses']['steps'][$i] ?? [];
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="p-3 rounded border bg-glass-element h-100">
                                            <div class="fw-bold text-primary mb-2">Langkah {{ $i + 1 }}</div>
                                            <div class="mb-2">
                                                <label class="fs-8 fw-semibold mb-1">Judul Langkah</label>
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="proses[steps][{{ $i }}][title]"
                                                       value="{{ $stepData['title'] ?? $stepTitleDefault }}" required>
                                            </div>
                                            <div>
                                                <label class="fs-8 fw-semibold mb-1">Deskripsi Langkah</label>
                                                <textarea class="form-control form-control-sm" 
                                                          name="proses[steps][{{ $i }}][description]" 
                                                          rows="3" required>{{ $stepData['description'] ?? $stepDescDefault }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Portofolio Proyek Software -->
                    <div class="glass-card mb-4">
                        <div class="card-header">
                            <div class="card-title"><i class="bi bi-briefcase me-1"></i> Section Portofolio Proyek (CMS)</div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Judul Section Portofolio</label>
                                    <input type="text" class="form-control form-control-sm" name="portfolio[title]"
                                           value="{{ $content['portfolio']['title'] ?? 'Proyek Software Kami' }}" required>
                                </div>
                                <div class="col-12 fv-row">
                                    <label class="fs-7 fw-semibold mb-2">Penjelasan Section Portofolio</label>
                                    <textarea class="form-control form-control-sm" name="portfolio[subtitle]" rows="2" required>{{ $content['portfolio']['subtitle'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4" style="border-color: rgba(0,0,0,0.08);">
                            <h6 class="fw-bold mb-2"><i class="bi bi-filter me-1"></i> Filter Kategori Portofolio</h6>
                            <p class="fs-8 text-muted mb-3">Pilih kategori portofolio yang dianggap sebagai "Software". Portofolio dengan kategori yang dicentang di bawah ini otomatis dikelompokkan dan ditampilkan di halaman Software House.</p>

                            <div class="row g-2">
                                @foreach($availableCategories as $cat)
                                    <div class="col-md-4">
                                        <div class="form-check p-2 rounded border bg-glass-element d-flex align-items-center gap-2">
                                            <input class="form-check-input ms-1" type="checkbox" name="portfolio[categories][]" 
                                                   value="{{ $cat }}" id="cat-{{ Str::slug($cat) }}"
                                                   {{ in_array($cat, $content['portfolio']['categories'] ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label fs-7 fw-semibold ms-1" for="cat-{{ Str::slug($cat) }}">
                                                {{ $cat }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="glass-card sticky-lg-top" style="top: 100px; z-index: 100;">
                        <div class="card-header">
                            <div class="card-title">Aksi CMS</div>
                        </div>
                        <div class="card-body">
                            <p class="fs-8 text-muted mb-4">Simpan seluruh konfigurasi layout, teks halaman, dan detail utama layanan Software House.</p>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-circle me-1"></i> Simpan Konfigurasi Halaman
                            </button>
                            <a href="{{ url('/software-house') }}" target="_blank" class="btn btn-outline-secondary w-100 mt-2 btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Depan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 2: DETAIL LAYANAN & SUB-FITUR (REFAC TO TABLE & MODALS) -->
    <div class="tab-pane fade" id="layanan-pane" role="tabpanel" aria-labelledby="layanan-tab">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Card 2: Software House Services Table -->
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-title">Daftar Layanan Software</div>
                        <div class="card-header-btns">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_service_feature">
                                <i class="bi bi-plus-circle"></i> Tambah Layanan
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="fs-8 text-muted mb-3">Menampilkan layanan/keahlian software house. Setiap item dapat memiliki ikon sendiri serta daftar tahapan detail khusus yang tampil di dalam box halaman depan.</p>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-row-dashed fs-7 gy-3">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-8 text-uppercase gs-0">
                                        <th style="width: 40px;"></th>
                                        <th style="width: 60px;">Icon</th>
                                        <th>Nama Layanan</th>
                                        <th>Fitur Detil (Satu per baris)</th>
                                        <th style="width: 100px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-features">
                                    @forelse($softwareServices as $shService)
                                    <tr data-id="{{ $shService->id }}">
                                        <td>
                                            <span class="drag-handle cursor-move text-muted"><i class="bi bi-grip-vertical fs-5"></i></span>
                                        </td>
                                        <td data-label="Icon">
                                            <div class="rounded border bg-light d-flex align-items-center justify-content-center text-primary" style="height: 36px; width: 36px;">
                                                <i class="{{ $shService->icon ?: 'fas fa-code' }} fs-6"></i>
                                            </div>
                                        </td>
                                        <td data-label="Nama Layanan">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded border bg-light d-flex align-items-center justify-content-center text-primary flex-shrink-0" style="height: 28px; width: 28px;">
                                                    <i class="{{ $shService->icon ?: 'fas fa-code' }}" style="font-size: 0.7rem;"></i>
                                                </div>
                                                <div class="fw-bold">{{ $shService->title }}</div>
                                            </div>
                                        </td>
                                        <td data-label="Fitur Detil">
                                            @if(!empty($shService->steps) && is_array($shService->steps))
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($shService->steps as $step)
                                                        <span class="badge bg-light text-dark fs-9">{{ $step }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted fs-8">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Aksi" class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button type="button" class="btn btn-icon btn-sm" 
                                                        data-sh-service="{{ json_encode($shService->toArray()) }}"
                                                        onclick="editSHService({{ $shService->id }}, this)" title="Edit"
                                                        style="width: 28px; height: 28px; border-radius: 6px; background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent);">
                                                    <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-sm" onclick="deleteSHService({{ $shService->id }}, '{{ addslashes($shService->title) }}')" title="Hapus"
                                                        style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                                                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-gear-wide fs-1 d-block mb-2"></i>
                                            Belum ada layanan software terdaftar. Klik <strong>Tambah Layanan</strong> untuk menambahkan.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="glass-card sticky-lg-top" style="top: 100px; z-index: 100;">
                    <div class="card-header">
                        <div class="card-title">Panduan Pengaturan</div>
                    </div>
                    <div class="card-body fs-8 text-muted">
                        <p class="mb-3">Kombinasi data di Tab ini dan Tab 1 dirancang untuk mempermudah operasional:</p>
                        <ul class="ps-3 mb-0">
                            <li class="mb-2"><strong>Daftar Layanan:</strong> Muncul sebagai judul-judul box keahlian di halaman depan.</li>
                            <li class="mb-2"><strong>Fitur Detil (Steps):</strong> Memungkinkan setiap keahlian mempunyai tahapan pengerjaan tersendiri (misal: "Desain UI/UX" beda tahapannya dengan "API Integration").</li>
                            <li><strong>Drag-and-Drop:</strong> Geser baris di tabel untuk merubah urutan tampil di frontend secara instant.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: PORTFOLIO PROYEK -->
    <div class="tab-pane fade" id="portfolio-pane" role="tabpanel" aria-labelledby="portfolio-tab">
        <div class="glass-card">
            <div class="card-header">
                <div class="card-title">Daftar Portofolio Proyek Software</div>
                <div class="card-header-btns">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_portfolio">
                        <i class="bi bi-plus-circle"></i> Tambah Proyek Software
                    </button>
                </div>
            </div>

            <div class="card-body">
                <p class="fs-8 text-muted mb-4">Menampilkan portofolio yang memiliki kategori sesuai filter aktif (Saat ini: <strong>{{ implode(', ', $content['portfolio']['categories'] ?? ['Web App', 'Mobile App', 'IoT & Embedded']) }}</strong>). Anda dapat menyeret (drag-and-drop) baris tabel untuk merubah urutan.</p>

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-row-dashed fs-7 gy-3">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-8 text-uppercase gs-0">
                                <th style="width: 40px;"></th>
                                <th style="width: 80px;" class="text-center">Gambar</th>
                                <th>Judul Proyek</th>
                                <th>Kategori</th>
                                <th>Klien</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 100px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-portfolio">
                            @forelse($portfolioItems as $item)
                            <tr data-id="{{ $item->id }}">
                                <td>
                                    <span class="drag-handle cursor-move text-muted"><i class="bi bi-grip-vertical fs-5"></i></span>
                                </td>
                                <td data-label="Judul Proyek">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->image_url)
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="rounded flex-shrink-0" style="height: 32px; width: 44px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $item->title }}</div>
                                            @if($item->project_url)
                                                <a href="{{ $item->project_url }}" target="_blank" class="fs-8 text-primary"><i class="bi bi-link-45deg"></i> Link</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Kategori">
                                    <span class="badge bg-light text-dark">{{ $item->category }}</span>
                                </td>
                                <td data-label="Klien">
                                    <span class="text-muted">{{ $item->client ?? '-' }}</span>
                                </td>
                                <td data-label="Status">
                                    <span class="badge {{ $item->status == 'active' ? 'bg-success' : 'bg-secondary' }} fs-9">
                                        {{ $item->status == 'active' ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                <td data-label="Aksi" class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-icon btn-sm" 
                                                data-edit-url="{{ route('admin.portfolio.edit', $item->id) }}"
                                                onclick="editPortfolio(this)" title="Edit"
                                                style="width: 28px; height: 28px; border-radius: 6px; background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent);">
                                            <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-sm" onclick="deletePortfolio({{ $item->id }}, '{{ addslashes($item->title) }}')" title="Hapus"
                                                style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                                            <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-briefcase fs-1 d-block mb-2"></i>
                                    Belum ada proyek software yang terdaftar untuk kategori di atas. Klik <strong>Tambah Proyek Software</strong> untuk menambahkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- HIDDEN DELETE FORM FOR PORTFOLIO -->
<form id="delete-form" method="POST" data-delete-url="{{ route('admin.portfolio.destroy', ':id') }}" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="redirect_to" value="{{ route('admin.software-house.index', ['tab' => 'portfolio']) }}">
</form>

<!-- HIDDEN DELETE FORM FOR SOFTWARE HOUSE SERVICES -->
<form id="delete-sh-service-form" method="POST" data-delete-url="{{ route('admin.software-house.services.destroy', ':id') }}" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<!-- MODAL ADD SERVICE FEATURE (TAB 2) -->
<div class="modal fade" id="kt_modal_add_service_feature" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title fw-bold">Tambah Layanan Software Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kt_modal_add_service_feature_form" action="{{ route('admin.software-house.services.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Nama Layanan</label>
                            <input type="text" class="form-control form-control-sm" name="title" placeholder="Website Company Profile" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Icon FontAwesome</label>
                            <input type="text" class="form-control form-control-sm" name="icon" value="fa-solid fa-code" placeholder="fa-solid fa-code" required>
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Fitur Detil / Tahapan Kerja (Satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="6" name="steps_text" placeholder="Analisis Kebutuhan&#10;UI/UX Design&#10;Development&#10;Testing&#10;Deployment&#10;Maintenance"></textarea>
                        <div class="form-text fs-9">Tuliskan tahapan-tahapan pengerjaan layanan ini secara detail (satu per baris).</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT SERVICE FEATURE (TAB 2) -->
<div class="modal fade" id="kt_modal_edit_service_feature" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title fw-bold">Edit Layanan Software</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kt_modal_edit_service_feature_form" method="POST" data-update-url="{{ route('admin.software-house.services.update', ':id') }}">
                @csrf
                @method('PUT')
                <div class="modal-body py-3 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Nama Layanan</label>
                            <input type="text" class="form-control form-control-sm" name="title" id="edit_feature_title" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Icon FontAwesome</label>
                            <input type="text" class="form-control form-control-sm" name="icon" id="edit_feature_icon" required>
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Fitur Detil / Tahapan Kerja (Satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="6" name="steps_text" id="edit_feature_steps_text"></textarea>
                        <div class="form-text fs-9">Tuliskan tahapan-tahapan pengerjaan layanan ini secara detail (satu per baris).</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL ADD PORTFOLIO (TAB 3) -->
<div class="modal fade" id="kt_modal_add_portfolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title fw-bold">Tambah Proyek Software Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kt_modal_add_portfolio_form" action="{{ route('admin.portfolio.store') }}" method="POST">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ route('admin.software-house.index', ['tab' => 'portfolio']) }}">
                <div class="modal-body py-3 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Judul Proyek</label>
                            <input type="text" class="form-control form-control-sm" name="title" placeholder="Aplikasi HRD Mobile Ravaa" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Kategori</label>
                            <select class="form-select form-select-sm" name="category" required>
                                @foreach($content['portfolio']['categories'] ?? ['Web App', 'Mobile App', 'IoT & Embedded'] as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Klien</label>
                            <input type="text" class="form-control form-control-sm" name="client" placeholder="PT Ravaa Digital Solusi">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">URL Proyek</label>
                            <input type="url" class="form-control form-control-sm" name="project_url" placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Deskripsi Proyek</label>
                        <textarea class="form-control form-control-sm" rows="3" name="description" placeholder="Ceritakan singkat mengenai proyek ini..."></textarea>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Gambar Proyek</label>
                        <x-media-picker name="image_media_id" type="image" label="Pilih Gambar" />
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Tech Stack (satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="3" name="tech_text" placeholder="Laravel&#10;Vue.js&#10;MySQL&#10;Flutter"></textarea>
                        <div class="form-text fs-9">Setiap baris akan otomatis diubah menjadi tag teknologi</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status Tampil</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="active">Aktif (Tampilkan)</option>
                                <option value="inactive">Nonaktif (Sembunyikan)</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1">
                                <label class="form-check-label fs-8">Tampilkan di Beranda Utama</label>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-8 mb-2"><i class="bi bi-search me-1"></i> Optimasi SEO (Opsional)</div>
                        <div class="row g-2">
                            <div class="col-12 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" name="meta_title" placeholder="Meta title">
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-8 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" rows="2" name="meta_description" placeholder="Meta description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Proyek</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT PORTFOLIO (TAB 3) -->
<div class="modal fade" id="kt_modal_edit_portfolio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title fw-bold">Edit Proyek Software</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kt_modal_edit_portfolio_form" method="POST" data-update-url="{{ route('admin.portfolio.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_portfolio_id">
                <input type="hidden" name="redirect_to" value="{{ route('admin.software-house.index', ['tab' => 'portfolio']) }}">
                <div class="modal-body py-3 px-4">
                    <div class="row mb-3">
                        <div class="col-md-8 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Judul Proyek</label>
                            <input type="text" class="form-control form-control-sm" name="title" id="edit_portfolio_title" required>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-7 fw-semibold mb-1">Kategori</label>
                            <select class="form-select form-select-sm" name="category" id="edit_portfolio_category" required>
                                @foreach($content['portfolio']['categories'] ?? ['Web App', 'Mobile App', 'IoT & Embedded'] as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Klien</label>
                            <input type="text" class="form-control form-control-sm" name="client" id="edit_portfolio_client">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">URL Proyek</label>
                            <input type="url" class="form-control form-control-sm" name="project_url" id="edit_portfolio_project_url">
                        </div>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Deskripsi Proyek</label>
                        <textarea class="form-control form-control-sm" rows="3" name="description" id="edit_portfolio_description"></textarea>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Gambar Proyek</label>
                        <x-media-picker name="edit_image_media_id" type="image" label="Pilih Gambar" />
                        <input type="hidden" name="image_media_id" id="edit_image_media_id_value">
                        <input type="hidden" name="image" id="edit_portfolio_image">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-1">Tech Stack (satu per baris)</label>
                        <textarea class="form-control form-control-sm" rows="3" name="tech_text" id="edit_portfolio_tech"></textarea>
                        <div class="form-text fs-9">Setiap baris akan otomatis diubah menjadi tag teknologi</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Status Tampil</label>
                            <select class="form-select form-select-sm" name="status" id="edit_portfolio_status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-1">Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="edit_portfolio_featured">
                                <label class="form-check-label fs-8">Tampilkan di Beranda Utama</label>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-0" style="background: rgba(0,0,0,0.01);">
                        <div class="fw-semibold fs-8 mb-2"><i class="bi bi-search me-1"></i> Optimasi SEO (Opsional)</div>
                        <div class="row g-2">
                            <div class="col-12 fv-row">
                                <label class="fs-8 fw-semibold mb-1">Meta Title</label>
                                <input type="text" class="form-control form-control-sm" name="meta_title" id="edit_portfolio_meta_title">
                            </div>
                            <div class="col-12 fv-row mb-0">
                                <label class="fs-8 fw-semibold mb-1">Meta Description</label>
                                <textarea class="form-control form-control-sm" rows="2" name="meta_description" id="edit_portfolio_meta_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== PERSISTENT TABS ON RELOAD =====
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    if (activeTab) {
        const tabEl = document.querySelector(`#softwareHouseTabs button[data-bs-target="#${activeTab}-pane"]`);
        if (tabEl) {
            bootstrap.Tab.getInstance(tabEl)?.show() || new bootstrap.Tab(tabEl).show();
        }
    }

    // Update URL query string when switching tabs manually
    const tabButtons = document.querySelectorAll('#softwareHouseTabs button');
    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function(e) {
            const paneId = e.target.getAttribute('data-bs-target').replace('-pane', '').replace('#', '');
            const newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + paneId;
            window.history.pushState({path: newurl}, '', newurl);
        });
    });

    // ===== SORTABLE DRAG-AND-DROP FOR SOFTWARE HOUSE SERVICES (TAB 2) =====
    function initSortableFeatures() {
        var featTbody = document.getElementById('sortable-features');
        if (!featTbody || featTbody.children.length === 0) return;
        if (featTbody._sortable) featTbody._sortable.destroy();
        featTbody._sortable = Sortable.create(featTbody, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                var ids = Array.from(featTbody.querySelectorAll('tr[data-id]'))
                    .map(function(tr) { return parseInt(tr.dataset.id); });
                fetch('{{ route("admin.software-house.services.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) Ravaa.toast(data.message || 'Urutan layanan berhasil diperbarui', 'success');
                })
                .catch(function() { Ravaa.toast('Gagal memperbarui urutan', 'error'); });
            }
        });
    }
    initSortableFeatures();

    // ===== SORTABLE DRAG-AND-DROP FOR PORTFOLIO (TAB 3) =====
    function initSortablePortfolio() {
        var tbody = document.getElementById('sortable-portfolio');
        if (!tbody || tbody.children.length === 0) return;
        if (tbody._sortable) tbody._sortable.destroy();
        tbody._sortable = Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                var ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                    .map(function(tr) { return parseInt(tr.dataset.id); });
                fetch('{{ route("admin.portfolio.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) Ravaa.toast(data.message || 'Urutan portfolio berhasil diperbarui', 'success');
                })
                .catch(function() { Ravaa.toast('Gagal memperbarui urutan', 'error'); });
            }
        });
    }
    initSortablePortfolio();

    // Helper functions for Tech / Steps conversion
    function listToText(arr) {
        if (!arr) return '';
        if (typeof arr === 'string') {
            try {
                arr = JSON.parse(arr);
            } catch (e) {
                return arr.split(',').map(s => s.trim()).join('\n');
            }
        }
        if (!Array.isArray(arr)) return '';
        return arr.join('\n');
    }

    function textToList(text) {
        if (!text) return [];
        return text.split('\n').map(s => s.trim()).filter(Boolean);
    }

    // ===== SOFTWARE HOUSE SERVICE CRUD HANDLERS (TAB 2) =====
    window.editSHService = function(id, btnElement) {
        let rawData = btnElement.dataset.shService;
        let svc;
        try {
            svc = JSON.parse(rawData);
        } catch (e) {
            return;
        }

        document.getElementById('edit_feature_title').value = svc.title || '';
        document.getElementById('edit_feature_icon').value = svc.icon || 'fa-solid fa-code';
        document.getElementById('edit_feature_steps_text').value = listToText(svc.steps);

        const form = document.getElementById('kt_modal_edit_service_feature_form');
        form.action = form.dataset.updateUrl.replace(':id', id);

        const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_service_feature'));
        modal.show();
    };

    window.deleteSHService = function(id, title) {
        Ravaa.confirm('Hapus Layanan?', `Layanan "${title}" akan dihapus permanen!`).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-sh-service-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

    // Add portfolio submit handler (Tab 3)
    const addForm = document.getElementById('kt_modal_add_portfolio_form');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const techTextArea = this.querySelector('textarea[name="tech_text"]');
            const techText = techTextArea ? techTextArea.value : '';
            const tech = textToList(techText);
            this.querySelectorAll('input[name="tech[]"]').forEach(el => el.remove());
            tech.forEach(t => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'tech[]';
                input.value = t;
                this.appendChild(input);
            });
            if (techTextArea) techTextArea.remove();
            this.submit();
        });
    }

    // Edit portfolio submit handler (Tab 3)
    const editForm = document.getElementById('kt_modal_edit_portfolio_form');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const techTextArea = this.querySelector('textarea[name="tech_text"]');
            const techText = techTextArea ? techTextArea.value : '';
            const tech = textToList(techText);
            this.querySelectorAll('input[name="tech[]"]').forEach(el => el.remove());
            tech.forEach(t => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'tech[]';
                input.value = t;
                this.appendChild(input);
            });
            if (techTextArea) techTextArea.remove();
            
            // Sync media picker value
            const src = document.getElementById('edit_image_media_id-input');
            const dst = document.getElementById('edit_image_media_id_value');
            const imgCol = document.getElementById('edit_portfolio_image');
            if (src && dst) {
                dst.value = src.value;
                if (src.value && imgCol) {
                    imgCol.value = ''; // If new media is selected, clear raw image path
                }
            }
            
            // Set update URL
            const editId = document.getElementById('edit_portfolio_id').value;
            this.action = this.dataset.updateUrl.replace(':id', editId);
            this.submit();
        });
    }

    // Edit Portfolio Modal Populate
    window.editPortfolio = async function(btnElement) {
        const url = btnElement.dataset.editUrl;
        const response = await fetch(url, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        if (data.success) {
            const p = data.portfolioItem;
            document.getElementById('edit_portfolio_id').value = p.id;
            document.getElementById('edit_portfolio_title').value = p.title;
            document.getElementById('edit_portfolio_category').value = p.category || '';
            document.getElementById('edit_portfolio_client').value = p.client || '';
            document.getElementById('edit_portfolio_project_url').value = p.project_url || '';
            document.getElementById('edit_portfolio_description').value = p.description || '';
            document.getElementById('edit_portfolio_tech').value = listToText(p.tech);
            document.getElementById('edit_portfolio_status').value = p.status;
            document.getElementById('edit_portfolio_featured').checked = p.is_featured;
            document.getElementById('edit_portfolio_meta_title').value = p.meta_title || '';
            document.getElementById('edit_portfolio_meta_description').value = p.meta_description || '';
            
            // Sync Media picker
            const editPicInput = document.getElementById('edit_image_media_id-input');
            if (editPicInput) editPicInput.value = p.image_media_id || '';
            const imgCol = document.getElementById('edit_portfolio_image');
            if (imgCol) imgCol.value = p.image || '';
            
            const previewContainer = document.getElementById('edit_image_media_id-selected');
            if (previewContainer) {
                if (p.image_media_id && p.media_url) {
                    previewContainer.innerHTML = `
                        <div class="media-picker-thumb">
                            <img src="${p.media_url}" alt="${p.media_name || ''}">
                            <button type="button" class="remove-media" onclick="removePickerItem('edit_image_media_id', '${p.image_media_id}'); document.getElementById('edit_portfolio_image').value='';"><i class="bi bi-x"></i></button>
                        </div>
                    `;
                } else if (p.image) {
                    const imgUrl = p.image.startsWith('http') ? p.image : '/storage/' + p.image;
                    previewContainer.innerHTML = `
                        <div class="media-picker-thumb">
                            <img src="${imgUrl}" alt="Preview">
                            <button type="button" class="remove-media" onclick="removePickerItem('edit_image_media_id', ''); document.getElementById('edit_portfolio_image').value='';"><i class="bi bi-x"></i></button>
                        </div>
                    `;
                } else {
                    previewContainer.innerHTML = `
                        <div class="media-picker-empty">
                            <i class="bi bi-image"></i>
                            <span>Belum ada media dipilih</span>
                        </div>
                    `;
                }
            }
            if (!window.mediaPickerState) window.mediaPickerState = {};
            window.mediaPickerState['edit_image_media_id'] = {
                multiple: false,
                type: 'image',
                selected: (p.image_media_id ? [String(p.image_media_id)] : []),
                selectedItems: {},
                currentSearch: '',
            };
            if (p.image_media_id && p.media_url) {
                window.mediaPickerState['edit_image_media_id'].selectedItems[p.image_media_id] = `<img src="${p.media_url}" alt="${p.media_name || ''}">`;
            }

            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_portfolio'));
            modal.show();
        }
    };

    // Delete Portfolio
    window.deletePortfolio = function(id, title) {
        Ravaa.confirm('Hapus Proyek Software?', `Proyek "${title}" akan dihapus permanen!`).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = form.dataset.deleteUrl.replace(':id', id);
                form.submit();
            }
        });
    };

});
</script>
@endpush
