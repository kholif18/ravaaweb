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
                <th style="width:60px;">Gambar</th>
                <th style="min-width:160px;">Judul</th>
                <th style="min-width:120px;">Kategori</th>
                <th style="min-width:100px;">Klien</th>
                <th style="min-width:120px;">Tech Stack</th>
                <th style="width:60px;">Urutan</th>
                <th style="width:70px;">Status</th>
                <th style="width:70px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-portfolio">
            @forelse($portfolioItems as $item)
            <tr data-id="{{ $item->id }}">
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $item->id }}"></div></td>
                <td class="drag-handle" style="cursor:grab;color:var(--text-muted);user-select:none;" title="Drag untuk mengubah urutan">
                    <i class="bi bi-grip-vertical" style="font-size:0.85rem;"></i>
                </td>
                <td>
                    @if($item->image)
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:40px;height:40px;border-radius:8px;object-fit:cover;">
                    @else
                        <div style="width:40px;height:40px;border-radius:8px;background:rgba(var(--accent-rgb,79,110,247),0.1);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-image" style="color:var(--accent);font-size:0.9rem;"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <a href="#" class="fw-semibold text-hover-primary" style="color:var(--text-primary);text-decoration:none;font-size:0.82rem;" onclick="editPortfolio({{ $item->id }});return false;">
                        {{ $item->title }}
                    </a>
                    @if($item->is_featured)
                        <span class="badge" style="background:rgba(234,179,8,0.1);color:#a16207;font-size:0.65rem;margin-left:4px;">Featured</span>
                    @endif
                </td>
                <td><span class="badge" style="background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);font-size:0.7rem;">{{ $item->category }}</span></td>
                <td style="font-size:0.78rem;color:var(--text-muted);">{{ $item->client ?? '-' }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach(($item->tech ?? []) as $t)
                            <span style="font-size:0.65rem;padding:1px 5px;border-radius:3px;background:rgba(0,0,0,0.04);color:var(--text-secondary);">{{ $t }}</span>
                        @endforeach
                    </div>
                </td>
                <td style="font-size:0.78rem;">{{ $item->order }}</td>
                <td>
                    @if($item->status === 'active')
                        <span class="badge" style="background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;">Aktif</span>
                    @else
                        <span class="badge" style="background:rgba(239,68,68,0.1);color:#b91c1c;font-size:0.7rem;">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm" onclick="editPortfolio({{ $item->id }})" style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);" title="Edit">
                            <i class="bi bi-pencil-square" style="font-size:0.75rem;"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm" onclick="deletePortfolio({{ $item->id }}, '{{ addslashes($item->title) }}')" style="width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;" title="Hapus">
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
                        <span style="font-size:0.82rem;">Tidak ada portfolio ditemukan</span>
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
    <x-pagination :paginator="$portfolioItems" label="portfolio" :perPage="$perPage" />
</div>
