@php
    $perPage = request('per_page', 10);
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0" id="kt_testimonials_table">
        <thead>
            <tr>
                <th style="width:32px;">
                    <div class="form-check" style="margin:0;"><input class="form-check-input" type="checkbox" id="select-all"></div>
                </th>
                <th style="width:32px;"></th>
                <th style="min-width:160px;">Klien</th>
                <th style="min-width:200px;">Testimoni</th>
                <th style="width:80px;">Rating</th>
                <th style="width:60px;">Urutan</th>
                <th style="width:70px;">Status</th>
                <th style="width:100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-testimonials">
            @forelse($testimonials as $testimonial)
            <tr data-id="{{ $testimonial->id }}">
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $testimonial->id }}"></div></td>
                <td class="drag-handle" style="cursor:grab;color:var(--text-muted);user-select:none;" title="Drag untuk mengubah urutan">
                    <i class="bi bi-grip-vertical" style="font-size:0.85rem;"></i>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        @if($testimonial->imageMedia)
                            <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->client_name }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(0,0,0,0.04);">
                        @else
                            <div style="width:36px;height:36px;border-radius:50%;background:rgba(var(--accent-rgb,79,110,247),0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-person" style="color:var(--accent);font-size:0.85rem;"></i>
                            </div>
                        @endif
                        <div>
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">{{ $testimonial->client_name }}</div>
                            @if($testimonial->position || $testimonial->company)
                            <div style="font-size:0.7rem;color:var(--text-muted);">
                                {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ' · ' : '' }}{{ $testimonial->company }}
                            </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);max-width:250px;">
                    <div style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <i class="bi bi-quote" style="color:var(--accent);opacity:0.4;margin-right:2px;"></i>
                        {{ $testimonial->content }}
                    </div>
                </td>
                <td>
                    <div style="white-space:nowrap;font-size:0.75rem;color:#f59e0b;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star" style="color:var(--text-muted);opacity:0.3;"></i>
                            @endif
                        @endfor
                    </div>
                </td>
                <td style="font-size:0.78rem;">{{ $testimonial->order }}</td>
                <td>
                    @if($testimonial->status == 'active')
                        <span class="badge" style="background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;">Aktif</span>
                    @else
                        <span class="badge" style="background:rgba(239,68,68,0.1);color:#b91c1c;font-size:0.7rem;">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="editTestimonial({{ $testimonial->id }})"
                                title="Edit"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);">
                            <i class="bi bi-pencil-square" style="font-size:0.75rem;"></i>
                        </button>
                        @if($testimonial->status == 'active')
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="updateStatus({{ $testimonial->id }}, 'inactive', '{{ addslashes($testimonial->client_name) }}')"
                                title="Nonaktifkan"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(234,179,8,0.1);color:#a16207;">
                            <i class="bi bi-pause-circle" style="font-size:0.75rem;"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="updateStatus({{ $testimonial->id }}, 'active', '{{ addslashes($testimonial->client_name) }}')"
                                title="Aktifkan"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(34,197,94,0.1);color:#15803d;">
                            <i class="bi bi-play-circle" style="font-size:0.75rem;"></i>
                        </button>
                        @endif
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="deleteTestimonial({{ $testimonial->id }}, '{{ addslashes($testimonial->client_name) }}')"
                                title="Hapus"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;">
                            <i class="bi bi-trash" style="font-size:0.75rem;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding:40px 0;">
                    <div style="color:var(--text-muted);">
                        <i class="bi bi-chat-quote" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:0.82rem;">Tidak ada testimoni ditemukan</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination & Bulk Delete -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
    <div>
        <button type="button" class="btn btn-sm btn-light-danger" id="bulk-delete-btn" style="display:none;">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
    <x-pagination :paginator="$testimonials" label="testimoni" :perPage="$perPage" />
</div>
