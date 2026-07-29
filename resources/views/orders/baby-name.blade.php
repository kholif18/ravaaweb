@extends('frontend.layouts.master')

@section('title', 'Form Nama Bayi')
@section('meta_desc', 'Isi form untuk data nama bayi desain banner di Ravaa Creative.')

@section('content')
<section class="page-hero" style="padding-bottom:0;">
    <div class="container">
        <h1>Nama Bayi</h1>
        <p>Isi form berikut untuk data nama bayi desain banner. Tanda * wajib diisi.</p>
    </div>
</section>

<section class="section fade-up" style="padding-top:16px;">
    <div class="container" style="max-width: 720px;">
        @if(session('success'))
            <div class="toast-success">{{ session('success') }}</div>
        @endif

        <div class="contact-form" style="padding: 32px;">
            <form id="baby-name-form" action="{{ route('order.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_type" value="baby_name">

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

                {{-- Data Bayi --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-baby"></i> Data Bayi *
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="baby_full_name">Nama Lengkap Bayi *</label>
                        <input type="text" id="baby_full_name" name="baby_full_name" value="{{ old('baby_full_name') }}" placeholder="Nama lengkap bayi" required>
                        @error('baby_full_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="baby_nickname">Nama Panggilan</label>
                        <input type="text" id="baby_nickname" name="baby_nickname" value="{{ old('baby_nickname') }}" placeholder="Nama panggilan">
                        @error('baby_nickname') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="birth_day">Hari Lahir</label>
                        <input type="text" id="birth_day" name="birth_day" value="{{ old('birth_day') }}" placeholder="Contoh: Senin Legi">
                        <small style="color:var(--text-muted);font-size:0.75rem;">Jika pakai pasaran, tulis dengan pasaran</small>
                        @error('birth_day') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir *</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                        @error('birth_date') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="birth_order">Anak ke-</label>
                        <input type="number" id="birth_order" name="birth_order" value="{{ old('birth_order') }}" placeholder="1" min="1" max="20">
                        @error('birth_order') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="weight">Berat Bayi</label>
                        <input type="text" id="weight" name="weight" value="{{ old('weight') }}" placeholder="Contoh: 3.2 kg">
                        <small style="color:var(--text-muted);font-size:0.75rem;">Tulis satuan: kg/gr</small>
                        @error('weight') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="height">Panjang Bayi</label>
                        <input type="text" id="height" name="height" value="{{ old('height') }}" placeholder="Contoh: 50 cm">
                        <small style="color:var(--text-muted);font-size:0.75rem;">Tulis satuan: cm/m</small>
                        @error('height') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="birth_time">Jam Lahir</label>
                    <input type="time" id="birth_time" name="birth_time" value="{{ old('birth_time') }}">
                    <small style="color:var(--text-muted);font-size:0.75rem;">AM: 00:01 - 12:00 | PM: 12:01 - 23:59</small>
                    @error('birth_time') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="parent_names">Nama Orang Tua Bayi *</label>
                    <input type="text" id="parent_names" name="parent_names" value="{{ old('parent_names') }}" placeholder="Contoh: Budi & Ani" required>
                    @error('parent_names') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Upload Foto --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-camera"></i> Foto Bayi <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-group">
                    <label for="file">Foto Bayi</label>
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
                    <label for="notes">Catatan untuk Desain</label>
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
