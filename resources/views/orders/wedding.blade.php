@extends('frontend.layouts.master')

@section('title', 'Form Undangan Pernikahan')
@section('meta_desc', 'Isi form untuk pemesanan undangan pernikahan di Ravaa Creative.')

@section('content')
<section class="page-hero" style="padding-bottom:0;">
    <div class="container">
        <h1>Undangan Pernikahan</h1>
        <p>Isi form berikut untuk pemesanan undangan pernikahan. Data mempelai dan resepsi wajib diisi.</p>
    </div>
</section>

<section class="section fade-up" style="padding-top:16px;">
    <div class="container" style="max-width: 720px;">
        @if(session('success'))
            <div class="toast-success">{{ session('success') }}</div>
        @endif

        <div class="contact-form" style="padding: 32px;">
            <form id="wedding-form" action="{{ route('order.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_type" value="wedding">

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

                {{-- Data Mempelai Wanita --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-venus"></i> Data Mempelai Wanita *
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="bride_full_name">Nama Lengkap *</label>
                        <input type="text" id="bride_full_name" name="bride_full_name" value="{{ old('bride_full_name') }}" placeholder="Nama lengkap mempelai wanita" required>
                        @error('bride_full_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="bride_nickname">Nama Panggilan *</label>
                        <input type="text" id="bride_nickname" name="bride_nickname" value="{{ old('bride_nickname') }}" placeholder="Nama panggilan" required>
                        @error('bride_nickname') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="bride_father">Nama Bapak *</label>
                        <input type="text" id="bride_father" name="bride_father" value="{{ old('bride_father') }}" placeholder="Nama bapak mempelai" required>
                        @error('bride_father') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="bride_mother">Nama Ibu *</label>
                        <input type="text" id="bride_mother" name="bride_mother" value="{{ old('bride_mother') }}" placeholder="Nama ibu mempelai" required>
                        @error('bride_mother') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="bride_address">Alamat *</label>
                    <textarea id="bride_address" name="bride_address" placeholder="Alamat mempelai wanita" rows="2" required>{{ old('bride_address') }}</textarea>
                    @error('bride_address') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Data Mempelai Pria --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-mars"></i> Data Mempelai Pria *
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="groom_full_name">Nama Lengkap *</label>
                        <input type="text" id="groom_full_name" name="groom_full_name" value="{{ old('groom_full_name') }}" placeholder="Nama lengkap mempelai pria" required>
                        @error('groom_full_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="groom_nickname">Nama Panggilan *</label>
                        <input type="text" id="groom_nickname" name="groom_nickname" value="{{ old('groom_nickname') }}" placeholder="Nama panggilan" required>
                        @error('groom_nickname') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="groom_father">Nama Bapak *</label>
                        <input type="text" id="groom_father" name="groom_father" value="{{ old('groom_father') }}" placeholder="Nama bapak mempelai" required>
                        @error('groom_father') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="groom_mother">Nama Ibu *</label>
                        <input type="text" id="groom_mother" name="groom_mother" value="{{ old('groom_mother') }}" placeholder="Nama ibu mempelai" required>
                        @error('groom_mother') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="groom_address">Alamat *</label>
                    <textarea id="groom_address" name="groom_address" placeholder="Alamat mempelai pria" rows="2" required>{{ old('groom_address') }}</textarea>
                    @error('groom_address') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Akad Nikah --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-ring"></i> Akad Nikah <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="akad_day">Hari</label>
                        <select id="akad_day" name="akad_day">
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                                <option value="{{ $day }}" {{ old('akad_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('akad_day') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="akad_date">Tanggal</label>
                        <input type="date" id="akad_date" name="akad_date" value="{{ old('akad_date') }}">
                        @error('akad_date') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="akad_time">Pukul</label>
                        <input type="time" id="akad_time" name="akad_time" value="{{ old('akad_time') }}">
                        @error('akad_time') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="akad_venue">Tempat Akad</label>
                        <input type="text" id="akad_venue" name="akad_venue" value="{{ old('akad_venue') }}" placeholder="Tempat akad nikah">
                        @error('akad_venue') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
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

                <div class="form-grid">
                    <div class="form-group">
                        <label for="resepsi_time">Pukul</label>
                        <input type="time" id="resepsi_time" name="resepsi_time" value="{{ old('resepsi_time') }}">
                        @error('resepsi_time') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="resepsi_venue">Tempat Resepsi *</label>
                        <input type="text" id="resepsi_venue" name="resepsi_venue" value="{{ old('resepsi_venue') }}" placeholder="Tempat resepsi" required>
                        @error('resepsi_venue') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
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
                    <i class="fas fa-cloud-upload-alt"></i> Lampiran <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-group">
                    <label for="file">File Gambar / Denah</label>
                    <input type="file" id="file" name="file[]" accept="image/*,.pdf" multiple style="padding:8px;">
                    <small style="color:var(--text-muted);font-size:0.78rem;">Bisa pilih beberapa file sekaligus. Format: JPG, PNG, PDF (Maks. 5MB per file)</small>
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
