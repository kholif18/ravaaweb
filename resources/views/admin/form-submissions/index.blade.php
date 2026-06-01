@extends('admin.layouts.app')

@section('page-title', 'Form Submissions')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Form Submissions</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="bi bi-search position-absolute ms-6"></i>
                <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Pesan" />
            </div>
        </div>
    </div>
    
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_submissions">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_submissions .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-150px">Pengirim</th>
                    <th class="min-w-150px">Subjek</th>
                    <th class="min-w-200px">Pesan</th>
                    <th class="min-w-100px">Status</th>
                    <th class="min-w-125px">Tanggal</th>
                    <th class="text-end min-w-100px">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                @foreach($submissions as $submission)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="{{ $submission->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $submission->name }}</a>
                            <span>{{ $submission->email }}</span>
                            <span class="text-muted fs-7">{{ $submission->phone }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="text-gray-800">{{ $submission->subject }}</span>
                    </td>
                    <td>
                        <span title="{{ $submission->message }}">{{ Str::limit($submission->message, 50) }}</span>
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'unread' => 'danger',
                                'read' => 'info',
                                'replied' => 'success'
                            ][$submission->status] ?? 'secondary';
                            
                            $statusLabel = [
                                'unread' => 'Belum Dibaca',
                                'read' => 'Dibaca',
                                'replied' => 'Dibalas'
                            ][$submission->status] ?? $submission->status;
                        @endphp
                        <div class="badge badge-light-{{ $statusClass }} fw-bold">{{ $statusLabel }}</div>
                    </td>
                    <td>
                        <span class="fw-bold">{{ $submission->created_at->format('d M Y') }}</span>
                        <div class="text-muted fs-7">{{ $submission->created_at->format('H:i') }}</div>
                    </td>
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                        <i class="bi bi-chevron-down ms-1"></i></a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_view_submission_{{ $submission->id }}">Lihat</a>
                            </div>
                            <div class="menu-item px-3">
                                <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="menu-link px-3 btn btn-link text-danger w-100 text-start" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $submissions->links() }}
    </div>
</div>
@endsection
