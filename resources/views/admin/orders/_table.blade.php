@php
    $perPage = request('per_page', 15);
@endphp

<div class="table-responsive">
    <table class="table align-middle mb-0" id="kt_order_table">
        <thead>
            <tr>
                <th style="width:32px;">
                    <div class="form-check" style="margin:0;"><input class="form-check-input" type="checkbox" id="select-all"></div>
                </th>
                <th style="min-width:120px;">Tipe</th>
                <th style="min-width:140px;">Pemesan</th>
                <th style="min-width:130px;">WhatsApp</th>
                <th style="min-width:180px;">Data</th>
                <th style="width:100px;">Status</th>
                <th style="width:130px;">Tanggal</th>
                <th style="width:100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr data-id="{{ $order->id }}">
                <td><div class="form-check" style="margin:0;"><input class="form-check-input select-item" type="checkbox" value="{{ $order->id }}"></div></td>
                <td>
                    <span class="badge" style="font-size:0.7rem;padding:4px 8px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);">
                        {{ $order->type_label }}
                    </span>
                </td>
                <td style="font-size:0.82rem;color:var(--text-primary);">{{ $order->customer_name }}</td>
                <td style="font-size:0.78rem;color:var(--text-muted);">{{ $order->whatsapp }}</td>
                <td style="font-size:0.78rem;color:var(--text-muted);max-width:200px;">
                    <div style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        @if($order->type === 'wedding')
                            {{ $order->getDataField('bride.full_name', '-') }} & {{ $order->getDataField('groom.full_name', '-') }}
                        @elseif($order->type === 'khitan')
                            {{ $order->getDataField('child_name', '-') }}
                        @elseif($order->type === 'baby_name')
                            {{ $order->getDataField('full_name', '-') }}
                        @elseif($order->type === 'birthday')
                            {{ $order->getDataField('person_name', '-') }} ({{ $order->getDataField('age', '-') }} thn)
                        @endif
                    </div>
                </td>
                <td>
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'rgba(234,179,8,0.1)', 'color' => '#a16207'],
                            'confirmed' => ['bg' => 'rgba(59,130,246,0.1)', 'color' => '#2563eb'],
                            'completed' => ['bg' => 'rgba(34,197,94,0.1)', 'color' => '#15803d'],
                            'cancelled' => ['bg' => 'rgba(239,68,68,0.1)', 'color' => '#dc2626'],
                        ];
                        $statusStyle = $statusColors[$order->status] ?? $statusColors['pending'];
                    @endphp
                    <span class="badge status-badge" style="background:{{ $statusStyle['bg'] }};color:{{ $statusStyle['color'] }};font-size:0.7rem;">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);white-space:nowrap;">
                    {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="viewOrder({{ $order->id }})"
                                title="Lihat Detail"
                                style="width:28px;height:28px;border-radius:6px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);">
                            <i class="bi bi-eye" style="font-size:0.75rem;"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm"
                                onclick="deleteOrder({{ $order->id }}, '{{ addslashes($order->customer_name) }}')"
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
                        <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:0.82rem;">Tidak ada pesanan ditemukan</span>
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
    <x-pagination :paginator="$orders" label="pesanan" :perPage="$perPage" />
</div>
