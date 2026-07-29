@extends('admin.layouts.app')

@section('page-title', 'Detail Pesanan #' . $order->id)

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="{{ route('admin.orders.index') }}">Kelola Pesanan</a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <a href="#">Detail Pesanan</a>
    </li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card">
            <div class="card-header">
                <div class="card-title">
                    <span style="font-size:0.85rem;color:var(--text-muted);">Pesanan #{{ $order->id }}</span>
                    <span class="badge" style="font-size:0.7rem;padding:4px 8px;background:rgba(var(--accent-rgb,79,110,247),0.1);color:var(--accent);margin-left:8px;">
                        {{ $order->type_label }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                {{-- Data Pemesan --}}
                <div class="detail-section">
                    <h4><i class="bi bi-person"></i> Data Pemesan</h4>
                    <div class="detail-row"><span class="label">Nama</span><span class="value">{{ $order->customer_name }}</span></div>
                    <div class="detail-row"><span class="label">WhatsApp</span><span class="value">{{ $order->whatsapp }}</span></div>
                    <div class="detail-row"><span class="label">Email</span><span class="value">{{ $order->email ?? '-' }}</span></div>
                    <div class="detail-row"><span class="label">Tanggal Pesan</span><span class="value">{{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}</span></div>
                </div>

                {{-- Data Spesifik --}}
                <div class="detail-section">
                    <h4><i class="bi bi-file-text"></i> Data {{ $order->type_label }}</h4>

                    @if($order->type === 'wedding')
                        @php $data = $order->data; @endphp

                        @if(isset($data['bride']))
                        <div style="margin-bottom:12px;">
                            <strong style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:8px;">Mempelai Wanita</strong>
                            <div class="detail-row"><span class="label">Nama Lengkap</span><span class="value">{{ $data['bride']['full_name'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Nama Panggilan</span><span class="value">{{ $data['bride']['nickname'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Bapak</span><span class="value">{{ $data['bride']['father'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Ibu</span><span class="value">{{ $data['bride']['mother'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Alamat</span><span class="value">{{ $data['bride']['address'] ?? '-' }}</span></div>
                        </div>
                        @endif

                        @if(isset($data['groom']))
                        <div style="margin-bottom:12px;">
                            <strong style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:8px;">Mempelai Pria</strong>
                            <div class="detail-row"><span class="label">Nama Lengkap</span><span class="value">{{ $data['groom']['full_name'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Nama Panggilan</span><span class="value">{{ $data['groom']['nickname'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Bapak</span><span class="value">{{ $data['groom']['father'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Ibu</span><span class="value">{{ $data['groom']['mother'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Alamat</span><span class="value">{{ $data['groom']['address'] ?? '-' }}</span></div>
                        </div>
                        @endif

                        @if(isset($data['akad']) && !empty($data['akad']['venue']))
                        <div style="margin-bottom:12px;">
                            <strong style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:8px;">Akad Nikah</strong>
                            <div class="detail-row"><span class="label">Hari/Tanggal</span><span class="value">{{ $data['akad']['day'] ?? '-' }}, {{ $data['akad']['date'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Pukul</span><span class="value">{{ $data['akad']['time'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Tempat</span><span class="value">{{ $data['akad']['venue'] ?? '-' }}</span></div>
                        </div>
                        @endif

                        @if(isset($data['resepsi']))
                        <div style="margin-bottom:12px;">
                            <strong style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:8px;">Resepsi</strong>
                            <div class="detail-row"><span class="label">Hari/Tanggal</span><span class="value">{{ $data['resepsi']['day'] ?? '-' }}, {{ $data['resepsi']['date'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Pukul</span><span class="value">{{ $data['resepsi']['time'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Tempat</span><span class="value">{{ $data['resepsi']['venue'] ?? '-' }}</span></div>
                        </div>
                        @endif

                        @if(!empty($data['entertainment']))
                        <div class="detail-row"><span class="label">Hiburan</span><span class="value">{{ $data['entertainment'] }}</span></div>
                        @endif

                    @elseif($order->type === 'khitan')
                        @php $data = $order->data; @endphp
                        <div class="detail-row"><span class="label">Nama Anak</span><span class="value">{{ $data['child_name'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Bapak</span><span class="value">{{ $data['father_name'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Ibu</span><span class="value">{{ $data['mother_name'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Alamat</span><span class="value">{{ $data['address'] ?? '-' }}</span></div>

                        @if(isset($data['resepsi']))
                        <div style="margin-top:12px;">
                            <strong style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:8px;">Resepsi</strong>
                            <div class="detail-row"><span class="label">Hari/Tanggal</span><span class="value">{{ $data['resepsi']['day'] ?? '-' }}, {{ $data['resepsi']['date'] ?? '-' }}</span></div>
                            <div class="detail-row"><span class="label">Tempat</span><span class="value">{{ $data['resepsi']['venue'] ?? '-' }}</span></div>
                        </div>
                        @endif

                        @if(!empty($data['entertainment']))
                        <div class="detail-row" style="margin-top:12px;"><span class="label">Hiburan</span><span class="value">{{ $data['entertainment'] }}</span></div>
                        @endif

                    @elseif($order->type === 'baby_name')
                        @php $data = $order->data; @endphp
                        <div class="detail-row"><span class="label">Nama Lengkap</span><span class="value">{{ $data['full_name'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Nama Panggilan</span><span class="value">{{ $data['nickname'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Hari Lahir</span><span class="value">{{ $data['birth_day'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Tanggal Lahir</span><span class="value">{{ $data['birth_date'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Anak ke-</span><span class="value">{{ $data['birth_order'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Jenis Kelamin</span><span class="value">{{ $data['gender'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Berat</span><span class="value">{{ $data['weight'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Panjang</span><span class="value">{{ $data['height'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Jam Lahir</span><span class="value">{{ $data['birth_time'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Orang Tua</span><span class="value">{{ $data['parent_names'] ?? '-' }}</span></div>

                    @elseif($order->type === 'birthday')
                        @php $data = $order->data; @endphp
                        <div class="detail-row"><span class="label">Nama</span><span class="value">{{ $data['person_name'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Umur ke-</span><span class="value">{{ $data['age'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Hari</span><span class="value">{{ $data['event_day'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Tanggal Acara</span><span class="value">{{ $data['event_date'] ?? '-' }}</span></div>
                        <div class="detail-row"><span class="label">Tema</span><span class="value">{{ $data['theme'] ?? '-' }}</span></div>
                    @endif

                    @if(!empty($order->data['notes']))
                    <div style="margin-top:12px;">
                        <strong style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:4px;">Catatan</strong>
                        <div style="font-size:0.82rem;color:var(--text-primary);white-space:pre-wrap;background:rgba(0,0,0,0.02);padding:8px 12px;border-radius:6px;">{{ $order->data['notes'] }}</div>
                    </div>
                    @endif
                </div>

                {{-- Files --}}
                @if($order->file_path && is_array($order->file_path) && count($order->file_path) > 0)
                <div class="detail-section">
                    <h4><i class="bi bi-paperclip"></i> Lampiran ({{ count($order->file_path) }} file)</h4>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @foreach($order->file_path as $filePath)
                        <a href="{{ Storage::disk('public')->url($filePath) }}" target="_blank" class="btn btn-sm btn-outline" style="font-size:0.78rem;">
                            <i class="bi bi-eye"></i> File {{ $loop->iteration }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Status & Actions --}}
        <div class="glass-card" style="margin-bottom:16px;">
            <div class="card-header">
                <div class="card-title">Status & Aksi</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status.update', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label for="status">Status Pesanan</label>
                        <select id="status" name="status" class="form-select">
                            @foreach($statusLabels as $key => $label)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="justify-content:center;">
                        <i class="bi bi-check-lg"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Admin Notes --}}
        <div class="glass-card" style="margin-bottom:16px;">
            <div class="card-header">
                <div class="card-title">Catatan Admin</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.notes.update', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="Tambahkan catatan internal...">{{ $order->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-outline w-100" style="justify-content:center;">
                        <i class="bi bi-save"></i> Simpan Catatan
                    </button>
                </form>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="glass-card">
            <div class="card-header">
                <div class="card-title">Aksi Cepat</div>
            </div>
            <div class="card-body">
                @if($order->whatsapp)
                <a href="https://wa.me/{{ $order->whatsapp }}" target="_blank" class="btn btn-whatsapp w-100 mb-2" style="justify-content:center;">
                    <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                </a>
                @endif
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline w-100" style="justify-content:center;">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif
});
</script>
@endpush
