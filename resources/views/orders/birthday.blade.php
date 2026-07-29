@extends('frontend.layouts.master')

@section('title', 'Form Ulang Tahun')
@section('meta_desc', 'Isi form untuk pemesanan undangan ulang tahun di Ravaa Creative.')

@section('content')
<section class="page-hero" style="padding-bottom:0;">
    <div class="container">
        <h1>Undangan Ulang Tahun</h1>
        <p>Isi form berikut untuk pemesanan undangan ulang tahun. Tanda * wajib diisi.</p>
    </div>
</section>

<section class="section fade-up" style="padding-top:16px;">
    <div class="container" style="max-width: 720px;">
        @if(session('success'))
            <div class="toast-success">{{ session('success') }}</div>
        @endif

        <div class="contact-form" style="padding: 32px;">
            <form id="birthday-form" action="{{ route('order.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_type" value="birthday">

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

                {{-- Data Ulang Tahun --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-birthday-cake"></i> Data Ulang Tahun *
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="person_name">Nama yang Ulang Tahun *</label>
                        <input type="text" id="person_name" name="person_name" value="{{ old('person_name') }}" placeholder="Nama lengkap" required>
                        @error('person_name') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="age">Umur ke-</label>
                        <input type="number" id="age" name="age" value="{{ old('age') }}" placeholder="1" min="1" max="150" required>
                        @error('age') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="event_day">Hari *</label>
                        <select id="event_day" name="event_day" required>
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                                <option value="{{ $day }}" {{ old('event_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('event_day') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="event_date">Tanggal Acara *</label>
                        <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                        @error('event_date') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="theme">Tema / Warna</label>
                    <input type="text" id="theme" name="theme" value="{{ old('theme') }}" placeholder="Contoh: Superhero, Pink, Dinosaur, dll">
                    @error('theme') <small style="color:#ef4444;">{{ $message }}</small> @enderror
                </div>

                {{-- Upload Foto --}}
                <h3 style="font-weight:600;font-size:1.1rem;margin:32px 0 16px;color:var(--accent);padding-top:24px;border-top:1px solid rgba(0,0,0,0.06);">
                    <i class="fas fa-camera"></i> Foto <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">(Opsional)</span>
                </h3>

                <div class="form-group">
                    <label for="file">Foto</label>
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
