@if($categories->count() > 0)
<!--begin::Table-->
<div class="table-responsive">
<table class="table" id="kt_categories_table">
    <thead>
        <tr>
            <th style="width: 32px;">
                <div class="form-check" style="margin: 0;">
                    <input class="form-check-input" type="checkbox" id="select-all" />
                </div>
            </th>
            <th style="width: 32px;"></th>
            <th>Nama Kategori</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 60px;">Urutan</th>
            <th style="width: 120px;" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody id="sortable-categories">
        @foreach($categories as $category)
        <tr data-id="{{ $category->id }}">
            <td>
                <div class="form-check" style="margin: 0;">
                    <input class="form-check-input select-item" type="checkbox" value="{{ $category->id }}" />
                </div>
            </td>
            <td class="drag-handle" style="cursor:grab;color:var(--text-muted);user-select:none;" title="Drag untuk mengubah urutan">
                <i class="bi bi-grip-vertical" style="font-size:0.85rem;"></i>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="td-symbol d-flex align-items-center justify-content-center" 
                         style="background: rgba({{ $category->color_rgb }},0.08);">
                        <i class="{{ $category->icon }}" style="font-size: 0.95rem; color: {{ $category->color_hex }};"></i>
                    </div>
                    <div>
                        <a href="#" class="fw-semibold text-hover-primary" style="color: var(--text-primary); text-decoration: none;"
                            onclick="editCategory({{ $category->id }})" 
                            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_category">
                            {{ $category->name }}
                        </a>
                        @if($category->description)
                        <div class="text-muted" style="font-size: 0.72rem;">{{ Str::limit($category->description, 40) }}</div>
                        @endif
                    </div>
                </div>
            </td>
            <td>
                @if($category->status == 'active')
                <span class="td-badge badge badge-success" style="background: rgba(34,197,94,0.1); color: #15803d;">Aktif</span>
                @else
                <span class="td-badge badge badge-danger" style="background: rgba(239,68,68,0.1); color: #b91c1c;">Nonaktif</span>
                @endif
            </td>
            <td>
                <span class="text-muted" style="font-size: 0.75rem; font-weight: 600;">{{ $category->order }}</span>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="editCategory({{ $category->id }})"
                            title="Edit"
                            style="width: 28px; height: 28px; border-radius: 6px; background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent);">
                        <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                    </button>
                    @if($category->status == 'active')
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="updateStatus({{ $category->id }}, 'inactive', '{{ $category->name }}')"
                            title="Nonaktifkan"
                            style="width: 28px; height: 28px; border-radius: 6px; background: rgba(234,179,8,0.1); color: #a16207;">
                        <i class="bi bi-pause-circle" style="font-size: 0.75rem;"></i>
                    </button>
                    @else
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="updateStatus({{ $category->id }}, 'active', '{{ $category->name }}')"
                            title="Aktifkan"
                            style="width: 28px; height: 28px; border-radius: 6px; background: rgba(34,197,94,0.1); color: #15803d;">
                        <i class="bi bi-play-circle" style="font-size: 0.75rem;"></i>
                    </button>
                    @endif
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')"
                            title="Hapus"
                            style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); color: #ef4444;">
                        <i class="bi bi-trash" style="font-size: 0.75rem;"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<!--end::Table-->

@else
<!-- Empty State -->
<div class="text-center py-8">
    <i class="bi bi-tags" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block;"></i>
    <h4 style="color: var(--text-primary); font-weight: 600;">Tidak Ada Kategori</h4>
    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">Belum ada kategori produk. Tambahkan kategori pertama Anda.</p>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </button>
</div>
@endif

<!-- Pagination Footer -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
    <div>
        <button type="button" class="btn btn-sm btn-light-danger" id="bulk-delete-btn" style="display: none;">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
    <x-pagination :paginator="$categories" :perPage="$filters['per_page'] ?? 10" label="kategori" />
</div>
