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
                <th style="width:50px;">Icon</th>
                <th style="min-width:180px;">Nama Layanan</th>
                <th style="min-width:200px;">Deskripsi</th>
                <th style="width:60px;">Fitur</th>
                <th style="width:60px;">Urutan</th>
                <th style="width:70px;">Status</th>
                <th style="width:70px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $service->id }}"></div></td>
                <td>
                    <div style="width:36px;height:36px;border-radius:8px;background:rgba(var(--accent-rgb,79,110,247),0.1);display:flex;align-items:center;justify-content:center;">
                        <i class="{{ $service->icon ?? 'bi bi-gear' }}" style="color:var(--accent);font-size:0.9rem;"></i>
                    </div>
                </td>
                <td>
                    <a href="#" class="fw-semibold text-hover-primary" style="color:var(--text-primary);text-decoration:none;font-size:0.82rem;" onclick="editService({{ $service->id }});return false;">
                        {{ $service->name }}
                    </a>
                    @if($service->is_featured)
                        <span class="badge" style="background:rgba(234,179,8,0.1);color:#a16207;font-size:0.65rem;margin-left:4px;">Featured</span>
                    @endif
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);">{{ Str::limit($service->description, 60) }}</td>
                <td><span class="badge" style="background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);font-size:0.7rem;">{{ count($service->features ?? []) }}</span></td>
                <td style="font-size:0.78rem;">{{ $service->order }}</td>
                <td>
                    @if($service->status === 'active')
                        <span class="badge" style="background:rgba(34,197,94,0.1);color:#15803d;font-size:0.7rem;">Aktif</span>
                    @else
                        <span class="badge" style="background:rgba(239,68,68,0.1);color:#b91c1c;font-size:0.7rem;">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm" onclick="editService({{ $service->id }})" style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);" title="Edit">
                            <i class="bi bi-pencil-square" style="font-size:0.75rem;"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm" onclick="deleteService({{ $service->id }}, '{{ addslashes($service->name) }}')" style="width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;" title="Hapus">
                            <i class="bi bi-trash" style="font-size:0.75rem;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding:40px 0;">
                    <div style="color:var(--text-muted);">
                        <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:0.82rem;">Tidak ada layanan ditemukan</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-toolbar">
    <x-pagination :paginator="$services" label="layanan" :perPage="$perPage" />
</div>
