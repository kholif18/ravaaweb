@extends('frontend.layouts.master')

@section('title', 'Form Undangan Khitan')
@section('meta_desc', 'Isi form untuk pemesanan undangan khitan di Ravaa Creative.')

@section('content')
<section class="page-hero" style="padding-bottom:0;">
    <div class="container">
        <h1>Undangan Khitan</h1>
        <p>Isi form berikut untuk pemesanan undangan khitan. Tanda * wajib diisi.</p>
    </div>
</section>

<section class="section fade-up" style="padding-top:16px;">
    <div class="container" style="max-width: 720px;">
        @if(session('success'))
            <div class="toast-success">{{ session('success') }}</div>
        @endif

        <div class="contact-form" style="padding: 32px;">
            <form id="khitan-form" action="{{ route('order.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_type" value="khitan">

                {{-- Data Pemesan --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:0 0 16px;color:var(--accent);">
                    <i class="fas fa-user"></i> Data Pemesan
                </h3>

                <div class="form-group">
                    <label for="customer_name">Nama Lengkap Pemesan *</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="Nama lengkap Anda" required>
                    @error('customer_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="whatsapp">No. WhatsApp *</label>
                        <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxx" required>
                        @error('whatsapp') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email (Opsional)</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com">
                        @error('email') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Data Anak --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-child"></i> Data Anak *
                </h3>

                <div class="form-group">
                    <label for="child_name">Nama Anak yang Di Khitan *</label>
                    <input type="text" id="child_name" name="child_name" value="{{ old('child_name') }}" placeholder="Nama lengkap anak" required>
                    @error('child_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="father_name">Nama Bapak *</label>
                        <input type="text" id="father_name" name="father_name" value="{{ old('father_name') }}" placeholder="Nama bapak" required>
                        @error('father_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="mother_name">Nama Ibu *</label>
                        <input type="text" id="mother_name" name="mother_name" value="{{ old('mother_name') }}" placeholder="Nama ibu" required>
                        @error('mother_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Alamat *</label>
                    <textarea id="address" name="address" placeholder="Alamat lengkap" rows="2" required>{{ old('address') }}</textarea>
                    @error('address') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Resepsi --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-glass-cheers"></i> Resepsi *
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="resepsi_day">Hari *</label>
                        <select id="resepsi_day" name="resepsi_day" required>
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                                <option value="{{ $day }}" {{ old('resepsi_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('resepsi_day') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="resepsi_date">Tanggal *</label>
                        <input type="date" id="resepsi_date" name="resepsi_date" value="{{ old('resepsi_date') }}" required>
                        @error('resepsi_date') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="resepsi_venue">Tempat Resepsi *</label>
                    <input type="text" id="resepsi_venue" name="resepsi_venue" value="{{ old('resepsi_venue') }}" placeholder="Tempat resepsi" required>
                    @error('resepsi_venue') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Hiburan --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-music"></i> Hiburan <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-group">
                    <label for="entertainment">Hiburan</label>
                    <input type="text" id="entertainment" name="entertainment" value="{{ old('entertainment') }}" placeholder="Contoh: Organ Tunggal, Dangdut, DJ, dll">
                    @error('entertainment') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Upload File --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-cloud-upload-alt"></i> Foto <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-group">
                    <label for="file">Foto / Denah</label>
                    <input type="file" id="file" name="file[]" accept="image/*" multiple style="padding:8px;">
                    <small style="color:var(--text-muted);font-size:0.78rem;">Bisa pilih beberapa file sekaligus. Format: JPG, PNG (Maks. 5MB per file)</small>
                    @error('file') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    @error('file.*') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Catatan --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-sticky-note"></i> Catatan <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-group">
                    <label for="notes">Catatan untuk Undangan</label>
                    <textarea id="notes" name="notes" placeholder="Tambahkan catatan jika perlu..." rows="3">{{ old('notes') }}</textarea>
                    @error('notes') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full" style="justify-content:center;margin-top:16px;">
                    <i class="fas fa-paper-plane"></i> Kirim Pesanan
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
