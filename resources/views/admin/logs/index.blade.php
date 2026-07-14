@extends('admin.layouts.app')

@section('page-title', 'System Logs')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="bc-current">System Logs</span>
    </li>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="glass-card">
    <div class="card-header">
        <div class="card-title">System Logs</div>
        <div class="card-header-btns d-flex align-items-center gap-3">
            <span class="badge" style="background: rgba(0,113,227,0.1); color: #0071e3; font-size: 0.8rem; padding: 6px 12px;">
                Ukuran File: {{ number_format($fileSize / 1024 / 1024, 2) }} MB
            </span>
            @if($fileSize > 0)
                <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh isi file log?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-light-danger btn-sm">
                        <i class="bi bi-trash"></i> Kosongkan Log
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="card-body">
        <!-- Filters -->
        <form method="GET" action="{{ route('admin.logs.index') }}" class="table-toolbar">
            <div class="toolbar-group w-100">
                <div class="row g-2 w-100">
                    <div class="col-md-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" name="search" placeholder="Cari isi pesan log..." value="{{ $search }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="level" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Level Log</option>
                            @foreach($levels as $lvl)
                                <option value="{{ $lvl }}" {{ $selectedLevel === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2 justify-content-md-end">
                        <button type="submit" class="btn btn-primary btn-sm px-4">Filter</button>
                        <a href="{{ route('admin.logs.index') }}" class="btn btn-light-secondary btn-sm px-3">Reset</a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Log List -->
        @if(count($logs) > 0)
            <div class="table-responsive">
                <table class="table align-middle" style="font-size: 0.85rem;">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Waktu</th>
                            <th style="width: 10%;">Env</th>
                            <th style="width: 12%;">Level</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $index => $log)
                            @php
                                $badgeClass = 'bg-secondary';
                                if (in_array($log['level'], ['ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'])) {
                                    $badgeClass = 'bg-danger';
                                    $badgeStyle = 'background: rgba(239,68,68,0.1) !important; color: #b91c1c !important;';
                                } elseif ($log['level'] === 'WARNING') {
                                    $badgeClass = 'bg-warning text-dark';
                                    $badgeStyle = 'background: rgba(245,158,11,0.1) !important; color: #b45309 !important;';
                                } elseif (in_array($log['level'], ['INFO', 'NOTICE'])) {
                                    $badgeClass = 'bg-info text-dark';
                                    $badgeStyle = 'background: rgba(59,130,246,0.1) !important; color: #1d4ed8 !important;';
                                } else {
                                    $badgeStyle = 'background: rgba(107,114,128,0.1) !important; color: #4b5563 !important;';
                                }
                            @endphp
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <td class="text-nowrap" style="color: var(--text-muted); font-size: 0.8rem;">
                                    {{ $log['date'] }}
                                </td>
                                <td>
                                    <span class="badge" style="background: rgba(0,0,0,0.05); color: var(--text-secondary); font-size: 0.75rem;">
                                        {{ $log['env'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="{{ $badgeStyle }} font-size: 0.75rem; font-weight: 600;">
                                        {{ $log['level'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-wrap" style="color: var(--text-primary); word-break: break-all;">
                                        {{ $log['message'] }}
                                    </div>
                                    
                                    @if(!empty($log['stack_trace']))
                                        <div class="mt-2">
                                            <button class="btn btn-xs btn-link p-0 text-decoration-none fw-medium fs-8" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#stack-{{ $index }}" 
                                                    aria-expanded="false" 
                                                    aria-controls="stack-{{ $index }}">
                                                <i class="bi bi-chevron-down me-1"></i> Lihat Stack Trace
                                            </button>
                                            <div class="collapse mt-2" id="stack-{{ $index }}">
                                                <pre class="p-3 rounded bg-light text-dark fs-8 text-wrap overflow-auto" 
                                                     style="max-height: 350px; font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; border: 1px solid rgba(0,0,0,0.08); line-height: 1.4;">{{ $log['stack_trace'] }}</pre>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if($totalPages > 1)
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination pagination-sm justify-content-center gap-1">
                        <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                            <a class="page-link rounded" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" title="Pertama">
                                <i class="bi bi-chevron-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                            <a class="page-link rounded" href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" title="Sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        @php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                        @endphp

                        @for($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $page == $i ? 'active' : '' }}">
                                <a class="page-link rounded" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $page == $totalPages ? 'disabled' : '' }}">
                            <a class="page-link rounded" href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" title="Berikutnya">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="page-item {{ $page == $totalPages ? 'disabled' : '' }}">
                            <a class="page-link rounded" href="{{ request()->fullUrlWithQuery(['page' => $totalPages]) }}" title="Terakhir">
                                <i class="bi bi-chevron-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        @else
            <div class="empty-state py-5 text-center">
                <i class="bi bi-journal-text text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">Tidak Ada Log Ditemukan</h5>
                <p class="text-muted fs-7">Sistem belum mencatat log apa pun atau filter Anda tidak menghasilkan data.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle chevron icons when collapsing stack trace
        const collapses = document.querySelectorAll('.collapse');
        collapses.forEach(el => {
            el.addEventListener('show.bs.collapse', function() {
                const btn = document.querySelector(`[data-bs-target="#${this.id}"]`);
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-chevron-up me-1"></i> Sembunyikan Stack Trace';
                }
            });
            el.addEventListener('hide.bs.collapse', function() {
                const btn = document.querySelector(`[data-bs-target="#${this.id}"]`);
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-chevron-down me-1"></i> Lihat Stack Trace';
                }
            });
        });
    });
</script>
@endpush
