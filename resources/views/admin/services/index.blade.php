@extends('admin.layouts.app')

@section('page-title', 'Manajemen Layanan')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-dark">Layanan</li>
@endsection

@section('content')
<div class="card card-flush">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="bi bi-search position-absolute ms-4 fs-4"></i>
                <input type="text" class="form-control form-control-solid w-250px ps-12" 
                       placeholder="Cari Layanan..." 
                       id="service-search" />
            </div>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Tambah Layanan
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_services_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" id="select-all" />
                        </div>
                    </th>
                    <th class="min-w-200px">Layanan</th>
                    <th class="min-w-150px">Kategori</th>
                    <th class="min-w-100px">Harga</th>
                    <th class="min-w-100px">Status</th>
                    <th class="min-w-100px">Urutan</th>
                    <th class="text-end min-w-70px">Aksi</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @foreach($services as $service)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input select-item" type="checkbox" value="{{ $service->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-3">
                                @if($service->image)
                                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}">
                                @else
                                    <div class="symbol-label bg-light-primary text-primary">
                                        {{ substr($service->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('admin.services.edit', $service) }}" class="text-gray-800 text-hover-primary fw-bold">{{ $service->name }}</a>
                                <span class="text-muted fw-semibold fs-7">{{ Str::limit($service->description, 50) }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-light-{{ $service->category->color ?? 'info' }}">
                            {{ $service->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td>{{ $service->formatted_price }}</td>
                    <td>
                        <div class="badge badge-light-{{ $service->is_active ? 'success' : 'danger' }}">
                            {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                        </div>
                    </td>
                    <td>{{ $service->order }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.services.edit', $service) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteService({{ $service->id }}, '{{ $service->name }}')"><i class="bi bi-trash me-2"></i> Hapus</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Menampilkan {{ $services->firstItem() }} - {{ $services->lastItem() }} dari {{ $services->total() }} layanan
            </div>
            
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-light-danger btn-sm me-5" id="bulk-delete-btn" style="display: none;">
                    <i class="bi bi-trash"></i> Hapus Terpilih
                </button>
                {{ $services->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="bulk-delete-form" method="POST" action="{{ route('admin.services.bulk.destroy') }}" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
    function deleteService(id, name) {
        Ravaa.confirm('Hapus Layanan?', `Layanan "${name}" akan dihapus.`)
            .then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = `/admin/services/${id}`;
                    form.submit();
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const selectItems = document.querySelectorAll('.select-item');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                selectItems.forEach(item => item.checked = this.checked);
                updateBulkDeleteButton();
            });
        }

        selectItems.forEach(item => {
            item.addEventListener('change', updateBulkDeleteButton);
        });

        function updateBulkDeleteButton() {
            const selectedCount = document.querySelectorAll('.select-item:checked').length;
            if (selectedCount > 0) {
                bulkDeleteBtn.style.display = 'inline-block';
                bulkDeleteBtn.innerHTML = `<i class="bi bi-trash"></i> Hapus Terpilih (${selectedCount})`;
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.select-item:checked')).map(item => item.value);
            Ravaa.confirm('Hapus Terpilih?', `Anda akan menghapus ${selectedIds.length} layanan.`)
                .then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('bulk-delete-ids').value = JSON.stringify(selectedIds);
                        document.getElementById('bulk-delete-form').submit();
                    }
                });
        });
    });
</script>
@endpush
