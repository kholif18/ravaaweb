@php
    $perPage = request('per_page', 10);
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0" id="kt_contact_table">
        <thead>
            <tr>
                <th style="width:32px;">
                    <div class="form-check" style="margin:0;"><input class="form-check-input" type="checkbox" id="select-all"></div>
                </th>
                <th style="min-width:140px;">Nama</th>
                <th style="min-width:180px;">Email</th>
                <th style="min-width:150px;">Subjek</th>
                <th style="min-width:200px;">Pesan</th>
                <th style="width:100px;">Status</th>
                <th style="width:140px;">Tanggal</th>
                <th style="width:100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
            <tr data-id="{{ $submission->id }}" class="{{ $submission->status === 'unread' ? 'fw-bold' : '' }}">
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $submission->id }}"></div></td>
                <td style="font-size:0.82rem;color:var(--text-primary);">{{ $submission->name }}</td>
                <td style="font-size:0.78rem;color:var(--text-muted);">{{ $submission->email }}</td>
                <td style="font-size:0.82rem;color:var(--text-primary);">
                    <div style="display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $submission->subject }}
                    </div>
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);max-width:200px;">
                    <div style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $submission->message }}
                    </div>
                </td>
                <td>
                    @if($submission->status == 'unread')
                        <span class="badge status-badge" style="background:rgba(234,179,8,0.1);color:#a16207;font-size:0.7rem;">Belum Dibaca</span>
                    @else
                        <span class="badge status-badge" style="background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;">Sudah Dibaca</span>
                    @endif
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);white-space:nowrap;">
                    {{ \Carbon\Carbon::parse($submission->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="viewContact({{ $submission->id }})"
                                title="Lihat Detail"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);">
                            <i class="bi bi-eye" style="font-size:0.75rem;"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="deleteContact({{ $submission->id }}, '{{ addslashes($submission->name) }}')"
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
                        <i class="bi bi-envelope-open" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:0.82rem;">Tidak ada pesan ditemukan</span>
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
    <x-pagination :paginator="$submissions" label="pesan" :perPage="$perPage" />
</div>
