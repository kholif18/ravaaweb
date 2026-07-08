@if($tags->count() > 0)
<!--begin::Table-->
<div class="table-responsive">
<table class="table" id="kt_tags_table">
    <thead>
        <tr>
            <th style="width: 32px;">
                <div class="form-check" style="margin: 0;">
                    <input class="form-check-input" type="checkbox" id="select-all" />
                </div>
            </th>
            <th>Nama Tag</th>
            <th style="width: 140px;">Warna</th>
            <th style="width: 100px;" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tags as $tag)
        <tr>
            <td>
                <div class="form-check" style="margin: 0;">
                    <input class="form-check-input select-item" type="checkbox" value="{{ $tag->id }}" />
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="td-symbol d-flex align-items-center justify-content-center" 
                         style="background: rgba({{ $tag->color_rgb }},0.08);">
                        <i class="fas fa-tag" style="font-size: 0.85rem; color: {{ $tag->color_hex }};"></i>
                    </div>
                    <div>
                        <a href="#" class="fw-semibold text-hover-primary" 
                           style="color: var(--text-primary); text-decoration: none;"
                           onclick="editTag({{ $tag->id }})"
                           data-bs-toggle="modal" data-bs-target="#kt_modal_edit_tag">
                            {{ $tag->name }}
                        </a>
                        <div class="text-muted" style="font-size: 0.72rem;">/{{ $tag->slug }}</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="td-badge badge" 
                      style="background: rgba({{ $tag->color_rgb }},0.1); color: {{ $tag->color_hex }};">
                    {{ ucfirst($tag->color) }}
                </span>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="editTag({{ $tag->id }})"
                            title="Edit"
                            style="width: 28px; height: 28px; border-radius: 6px; background: rgba(var(--accent-rgb, 79,110,247), 0.1); color: var(--accent);">
                        <i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-sm"
                            onclick="deleteTag({{ $tag->id }}, '{{ $tag->name }}')"
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
    <h4 style="color: var(--text-primary); font-weight: 600;">Tidak Ada Tag</h4>
    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">Belum ada tag produk. Tambahkan tag pertama Anda.</p>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_tag">
        <i class="bi bi-plus-circle"></i> Tambah Tag
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
    <x-pagination :paginator="$tags" :perPage="$filters['per_page'] ?? 10" label="tag" />
</div>
