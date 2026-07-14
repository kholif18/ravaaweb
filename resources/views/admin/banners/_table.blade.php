@php
    $perPage = request('per_page', 15);
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th style="width:32px;">
                    <div class="form-check" style="margin:0;"><input class="form-check-input" type="checkbox" id="select-all"></div>
                </th>
                <th style="width:32px;"></th>
                <th style="width:80px;" class="text-center">Gambar</th>
                <th style="min-width:160px;">Judul</th>
                <th style="min-width:140px;">Subtitle</th>
                <th style="min-width:80px;">CTA</th>
                <th style="width:60px;">Urutan</th>
                <th style="width:70px;">Status</th>
                <th style="width:70px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-banners">
            @forelse($banners as $banner)
            <tr data-id="{{ $banner->id }}">
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $banner->id }}"></div></td>
                <td class="drag-handle" style="cursor:grab;color:var(--text-muted);user-select:none;" title="Drag untuk mengubah urutan">
                    <i class="bi bi-grip-vertical" style="font-size:0.85rem;"></i>
                </td>
                <td class="text-center">
                    @if($banner->image_url)
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="mx-auto" style="width:60px;height:35px;border-radius:6px;object-fit:cover;">
                    @else
                        <div class="mx-auto" style="width:60px;height:35px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-image" style="color:var(--accent);font-size:0.8rem;"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <a href="#" class="fw-semibold text-hover-primary" style="color:var(--text-primary);text-decoration:none;font-size:0.82rem;" onclick="editBanner({{ $banner->id }});return false;">
                        {{ $banner->title }}
                    </a>
                    @if($banner->badge)
                        <span class="badge" style="background:rgba(234,179,8,0.1);color:#a16207;font-size:0.65rem;margin-left:4px;">{{ $banner->badge }}</span>
                    @endif
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);">{{ Str::limit($banner->subtitle, 40) ?? '-' }}</td>
                <td style="font-size:0.78rem;">{{ $banner->cta_text ?? '-' }}</td>
                <td style="font-size:0.78rem;">{{ $banner->order }}</td>
                <td>
                    @if($banner->is_active)
                        <span class="badge" style="background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;">Aktif</span>
                    @else
                        <span class="badge" style="background:rgba(239,68,68,0.1);color:#b91c1c;font-size:0.7rem;">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm" onclick="editBanner({{ $banner->id }})" style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);" title="Edit">
                            <i class="bi bi-pencil-square" style="font-size:0.75rem;"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm" onclick="deleteBanner({{ $banner->id }}, '{{ addslashes($banner->title) }}')" style="width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;" title="Hapus">
                            <i class="bi bi-trash" style="font-size:0.75rem;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding:40px 0;">
                    <div style="color:var(--text-muted);">
                        <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:0.82rem;">Tidak ada banner ditemukan</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
    <div>
        <button type="button" class="btn btn-sm btn-light-danger" id="bulk-delete-btn" style="display: none;">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
    <x-pagination :paginator="$banners" label="banner" :perPage="$perPage" />
</div>
