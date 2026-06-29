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
            <th style="width: 50px;">Aksi</th>
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
            <td class="table-actions">
                <button class="dropdown-action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Aksi">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#" 
                           onclick="editTag({{ $tag->id }})"
                           data-bs-toggle="modal" data-bs-target="#kt_modal_edit_tag">
                            <i class="bi bi-pencil"></i> <span class="dropdown-item-text">Edit</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" 
                           onclick="deleteTag({{ $tag->id }}, '{{ $tag->name }}')" 
                           style="color: var(--danger);">
                            <i class="bi bi-trash"></i> <span class="dropdown-item-text">Hapus</span>
                        </a>
                    </li>
                </ul>
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
        {{-- Bulk delete button jika diperlukan --}}
    </div>
    <x-pagination :paginator="$tags" :perPage="$filters['per_page'] ?? 10" label="tag" />
</div>
