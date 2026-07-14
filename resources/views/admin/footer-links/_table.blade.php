@php
    $perPage = request('per_page', 10);
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0" id="kt_footer_links_table">
        <thead>
            <tr>
                <th style="width:32px;">
                    <div class="form-check" style="margin:0;"><input class="form-check-input" type="checkbox" id="select-all"></div>
                </th>
                <th style="width:32px;"></th>
                <th style="min-width:160px;">Label</th>
                <th style="min-width:200px;">URL</th>
                <th style="width:60px;">Urutan</th>
                <th style="width:70px;">Status</th>
                <th style="width:100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-footer-links">
            @forelse($footerLinks as $link)
            <tr data-id="{{ $link->id }}">
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $link->id }}"></div></td>
                <td class="drag-handle" style="cursor:grab;color:var(--text-muted);user-select:none;" title="Drag untuk mengubah urutan">
                    <i class="bi bi-grip-vertical" style="font-size:0.85rem;"></i>
                </td>
                <td style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">{{ $link->label }}</td>
                <td style="font-size:0.78rem;color:var(--accent);max-width:250px;word-break:break-all;">
                    <a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a>
                </td>
                <td style="font-size:0.78rem;">{{ $link->sort_order }}</td>
                <td>
                    @if($link->is_active)
                        <span class="badge" style="background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;">Aktif</span>
                    @else
                        <span class="badge" style="background:rgba(239,68,68,0.1);color:#b91c1c;font-size:0.7rem;">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="editFooterLink({{ $link->id }})"
                                title="Edit"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);">
                            <i class="bi bi-pencil-square" style="font-size:0.75rem;"></i>
                        </button>
                        @if($link->is_active)
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="updateStatus({{ $link->id }}, 0, '{{ addslashes($link->label) }}')"
                                title="Nonaktifkan"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(234,179,8,0.1);color:#a16207;">
                            <i class="bi bi-pause-circle" style="font-size:0.75rem;"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="updateStatus({{ $link->id }}, 1, '{{ addslashes($link->label) }}')"
                                title="Aktifkan"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(34,197,94,0.1);color:#15803d;">
                            <i class="bi bi-play-circle" style="font-size:0.75rem;"></i>
                        </button>
                        @endif
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="deleteFooterLink({{ $link->id }}, '{{ addslashes($link->label) }}')"
                                title="Hapus"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;">
                            <i class="bi bi-trash" style="font-size:0.75rem;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding:40px 0;">
                    <div style="color:var(--text-muted);">
                        <i class="bi bi-link-45deg" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:0.82rem;">Tidak ada link ditemukan</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
    <div>
        <button type="button" class="btn btn-sm btn-light-danger" id="bulk-delete-btn" style="display:none;">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
    <x-pagination :paginator="$footerLinks" label="link" :perPage="$perPage" />
</div>
