@extends('admin.layouts.app')

@section('page-title', 'Kategori Layanan')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
    </li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-dark">Kategori Layanan</li>
@endsection

@section('content')
<div class="card card-flush">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="bi bi-search position-absolute ms-4 fs-4"></i>
                <input type="text" class="form-control form-control-solid w-250px ps-12" 
                       placeholder="Cari Kategori..." 
                       id="category-search" />
            </div>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
                <i class="bi bi-plus-circle me-2"></i> Tambah Kategori
            </button>
        </div>
    </div>
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_service_categories_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" id="select-all" />
                        </div>
                    </th>
                    <th class="min-w-150px">Nama Kategori</th>
                    <th class="min-w-100px">Icon</th>
                    <th class="min-w-100px">Status</th>
                    <th class="min-w-100px">Urutan</th>
                    <th class="min-w-100px">Jumlah Layanan</th>
                    <th class="text-end min-w-70px">Aksi</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @foreach($categories as $category)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input select-item" type="checkbox" value="{{ $category->id }}" />
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-3">
                                <div class="symbol-label bg-light-{{ $category->color ?? 'primary' }}">
                                    <i class="{{ $category->icon ?? 'bi bi-grid' }} fs-2 text-{{ $category->color ?? 'primary' }}"></i>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#" class="text-gray-800 text-hover-primary fw-bold" onclick="editCategory({{ $category->id }})">{{ $category->name }}</a>
                                <span class="text-muted fw-semibold fs-7">{{ Str::limit($category->description, 50) }}</span>
                            </div>
                        </div>
                    </td>
                    <td><i class="{{ $category->icon ?? 'bi bi-grid' }} fs-3"></i></td>
                    <td>
                        <div class="badge badge-light-{{ $category->is_active ? 'success' : 'danger' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </div>
                    </td>
                    <td>{{ $category->order }}</td>
                    <td>{{ $category->services_count }} Layanan</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editCategory({{ $category->id }})"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')"><i class="bi bi-trash me-2"></i> Hapus</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Menampilkan {{ $categories->count() }} kategori
            </div>
            <button type="button" class="btn btn-light-danger btn-sm" id="bulk-delete-btn" style="display: none;">
                <i class="bi bi-trash"></i> Hapus Terpilih
            </button>
        </div>
    </div>
</div>

<!-- Modal Add Category -->
<div class="modal fade" id="kt_modal_add_category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form action="{{ route('admin.service-categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Kategori Layanan</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="mb-5 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" name="name" required />
                    </div>
                    <div class="mb-5 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" name="description" rows="3"></textarea>
                    </div>
                    <div class="row g-9 mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Icon (Bootstrap Icon)</label>
                            <input type="text" class="form-control form-control-solid" name="icon" placeholder="bi bi-grid" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Warna</label>
                            <select class="form-select form-select-solid" name="color">
                                <option value="primary">Biru (Primary)</option>
                                <option value="success">Hijau (Success)</option>
                                <option value="danger">Merah (Danger)</option>
                                <option value="warning">Kuning (Warning)</option>
                                <option value="info">Cyan (Info)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-9 mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Urutan</label>
                            <input type="number" class="form-control form-control-solid" name="order" value="1" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Status</label>
                            <div class="form-check form-switch form-check-custom form-check-solid mt-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked />
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="bulk-delete-form" method="POST" action="{{ route('admin.service-categories.bulk.destroy') }}" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
    function editCategory(id) {
        // Implementasi AJAX edit jika diperlukan
        Ravaa.toast('Fitur edit sedang dikembangkan', 'info');
    }

    function deleteCategory(id, name) {
        Ravaa.confirm('Hapus Kategori?', `Kategori "${name}" akan dihapus.`)
            .then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = `/admin/service-categories/${id}`;
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
            Ravaa.confirm('Hapus Terpilih?', `Anda akan menghapus ${selectedIds.length} kategori.`)
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
