@extends('admin.layouts.app')

@section('page-title', 'FAQ')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">FAQ</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="bi bi-search position-absolute ms-6"></i>
                <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari FAQ" />
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_faq">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah FAQ
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_faqs">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_faqs .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-150px">Pertanyaan</th>
                    <th class="min-w-200px">Jawaban</th>
                    <th class="min-w-100px">Kategori</th>
                    <th class="min-w-80px">Urutan</th>
                    <th class="min-w-100px">Status</th>
                    <th class="text-end min-w-100px">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                @foreach($faqs as $faq)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="{{ $faq->id }}" />
                        </div>
                    </td>
                    <td>
                        <span class="text-gray-800 fw-bold">{{ $faq->question }}</span>
                    </td>
                    <td>
                        <span title="{{ $faq->answer }}">{{ Str::limit($faq->answer, 100) }}</span>
                    </td>
                    <td>
                        <div class="badge badge-light-info fw-bold">{{ $faq->category ?? 'Umum' }}</div>
                    </td>
                    <td>{{ $faq->order }}</td>
                    <td>
                        <div class="badge badge-light-{{ $faq->is_active ? 'success' : 'danger' }} fw-bold">{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</div>
                    </td>
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                        <i class="bi bi-chevron-down ms-1"></i></a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_faq_{{ $faq->id }}">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST">
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
        {{ $faqs->links() }}
    </div>
</div>
@endsection
