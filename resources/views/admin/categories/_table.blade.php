@if($categories->count() > 0)
<!--begin::Table-->
<div class="table-responsive">
<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_categories_table" style="min-width: 900px;">
    <thead>
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th class="w-10px pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input" type="checkbox" id="select-all" />
                </div>
            </th>
            <th class="min-w-150px">Nama Kategori</th>
            <th class="min-w-150px">Slug</th>
            <th class="min-w-100px">Icon</th>
            <th class="min-w-100px">Status</th>
            <th class="min-w-100px">Urutan</th>
            <th class="min-w-100px">Parent</th>
            <th class="min-w-100px text-end">Aksi</th>
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
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <div class="symbol-label">
                            <i class="{{ $category->icon }} fs-2 text-{{ $category->color ?? 'primary' }}"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="#" class="text-gray-800 text-hover-primary fw-bold" 
                            onclick="editCategory({{ $category->id }})" 
                            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category">
                            {{ $category->name }}
                        </a>
                        @if($category->description)
                        <span class="text-muted fw-semibold fs-7">{{ Str::limit($category->description, 50) }}</span>
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <span class="badge badge-light">{{ $category->slug }}</span>
            </td>
            <td>
                <i class="{{ $category->icon }} fs-3 text-{{ $category->color ?? 'primary' }}"></i>
            </td>
            <td>
                @if($category->status == 'active')
                <span class="badge badge-light-success">Aktif</span>
                @else
                <span class="badge badge-light-danger">Tidak Aktif</span>
                @endif
            </td>
            <td>
                <span class="badge badge-circle badge-light">{{ $category->order }}</span>
            </td>
            <td>
                @if($category->parent)
                    <span class="badge badge-light-info">{{ $category->parent->name }}</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td class="text-end">
                <div class="dropdown">
                    <button class="btn-action-dropdown" 
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#" 
                                onclick="editCategory({{ $category->id }})" 
                                data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" 
                                onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            @if($category->status == 'active')
                            <a class="dropdown-item text-danger" href="#" 
                                onclick="updateStatus({{ $category->id }}, 'inactive', '{{ $category->name }}')">
                                <i class="bi bi-x-circle"></i> Nonaktifkan
                            </a>
                            @else
                            <a class="dropdown-item text-success" href="#" 
                                onclick="updateStatus({{ $category->id }}, 'active', '{{ $category->name }}')">
                                <i class="bi bi-check-circle"></i> Aktifkan
                            </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<!--end::Table-->

@else
<!--begin::Empty State-->
<div class="text-center py-10">
    <i class="bi bi-tags fs-4hx text-gray-400 mb-5"></i>
    <h3 class="text-gray-600">Tidak Ada Kategori</h3>
    <p class="text-muted">Belum ada kategori produk. Tambahkan kategori pertama Anda.</p>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
        <i class="bi bi-plus-circle"></i> Tambah Kategori Pertama
    </button>
</div>
<!--end::Empty State-->
@endif

<!-- Pagination Footer -->
<x-pagination :paginator="$categories" :perPage="$filters['per_page'] ?? 10" label="kategori">
    <div class="me-5">
        <button type="button" class="btn btn-light-danger btn-sm" id="bulk-delete-btn" style="display: none;">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
</x-pagination>
