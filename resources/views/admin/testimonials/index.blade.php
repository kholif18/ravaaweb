@extends('admin.layouts.app')

@section('page-title', 'Testimonials')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Testimonials</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="bi bi-search position-absolute ms-6"></i>
                <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Testimoni" />
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_testimonial">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah Testimoni
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_testimonials">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_testimonials .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px">Nama</th>
                    <th class="min-w-125px">Jabatan/Perusahaan</th>
                    <th class="min-w-150px">Konten</th>
                    <th class="min-w-100px">Rating</th>
                    <th class="min-w-100px">Unggulan</th>
                    <th class="min-w-100px">Status</th>
                    <th class="text-end min-w-100px">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                @foreach($testimonials as $testimonial)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="{{ $testimonial->id }}" />
                        </div>
                    </td>
                    <td class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a href="#">
                                <div class="symbol-label">
                                    <img src="{{ $testimonial->avatar_url ?? asset('admin/assets/media/avatars/blank.png') }}" alt="{{ $testimonial->name }}" class="w-100" />
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $testimonial->name }}</a>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $testimonial->position ?? '-' }}</div>
                        <div class="text-muted">{{ $testimonial->company ?? '-' }}</div>
                    </td>
                    <td>
                        <span title="{{ $testimonial->content }}">{{ Str::limit($testimonial->content, 50) }}</span>
                    </td>
                    <td>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="rating-label {{ $i <= $testimonial->rating ? 'checked' : '' }}">
                                    <i class="bi bi-star-fill fs-6"></i>
                                </div>
                            @endfor
                        </div>
                    </td>
                    <td>
                        <div class="badge badge-light-{{ $testimonial->is_featured ? 'primary' : 'secondary' }} fw-bold">{{ $testimonial->is_featured ? 'Ya' : 'Tidak' }}</div>
                    </td>
                    <td>
                        <div class="badge badge-light-{{ $testimonial->is_active ? 'success' : 'danger' }} fw-bold">{{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}</div>
                    </td>
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                        <i class="bi bi-chevron-down ms-1"></i></a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_testimonial_{{ $testimonial->id }}">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST">
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
        {{ $testimonials->links() }}
    </div>
</div>
@endsection
