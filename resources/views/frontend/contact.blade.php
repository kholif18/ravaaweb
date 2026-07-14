@extends('frontend.layouts.master')

@section('title', 'Kontak')
@section('meta_desc', $settings['meta_description'] ?? 'Hubungi ' . ($settings['site_name'] ?? 'Ravaa Creative') . ' untuk konsultasi desain, percetakan, ATK, dan software house.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Ada pertanyaan atau ingin konsultasi? Tim kami siap membantu Anda.</p>
        </div>
    </section>

    <section class="section fade-up">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form">
                    <h3 style="font-weight:600;font-size:1.3rem;margin:0 0 24px;letter-spacing:-0.02em;">Kirim Pesan</h3>
                    @if($settings['whatsapp'] ?? null)
                    <form id="contact-form" action="https://wa.me/{{ $settings['whatsapp'] }}" method="GET" target="_blank">
                    @else
                    <form id="contact-form">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subjek</label>
                            <input type="text" id="subject" name="subject" placeholder="Subjek pesan" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>

                <div class="contact-info-card">
                    <h3 style="font-weight:600;font-size:1.3rem;margin:0 0 24px;letter-spacing:-0.02em;">Informasi Kontak</h3>

                    @if($settings['whatsapp'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>WhatsApp</h4>
                            <p><a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank">{{ $settings['whatsapp'] }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($settings['email'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Email</h4>
                            <p><a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($settings['phone'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Telepon</h4>
                            <p><a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($settings['address'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Alamat</h4>
                            <p>{{ $settings['address'] }}</p>
                        </div>
                    </div>
                    @endif

                    @if($settings['operating_hours'] ?? null)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-item-text">
                            <h4>Jam Operasional</h4>
                            <p>{{ $settings['operating_hours'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if($settings['map_embed'] ?? null)
    <section class="section fade-up" style="padding-bottom: 0;">
        <div class="container">
            <div class="text-center">
                <span class="section-label">Lokasi</span>
                <h2 class="section-title">Temukan Kami</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Kunjungi langsung kantor atau workshop kami.</p>
            </div>
            <div class="map-container" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); margin-top: 24px; width: 100%; min-height: 400px;">
                {!! preg_replace('/width="[^"]+"/', 'width="100%"', preg_replace('/height="[^"]+"/', 'height="400"', $settings['map_embed'])) !!}
                <style>
                    .map-container iframe { display: block; width: 100% !important; height: 400px !important; border: 0; }
                </style>
            </div>
        </div>
    </section>
    @endif

    @if(($settings['instagram'] ?? null) || ($settings['facebook'] ?? null) || ($settings['linkedin'] ?? null))
    <section class="section fade-up">
        <div class="container">
            <div class="text-center">
                <span class="section-label">Media Sosial</span>
                <h2 class="section-title">Ikuti Kami</h2>
                <p class="section-subtitle" style="margin-left:auto;margin-right:auto;">Dapatkan informasi terbaru seputar produk, promo, dan inspirasi.</p>
                <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                    @if($settings['instagram'] ?? null)
                    <a href="{{ $settings['instagram'] }}" class="btn btn-outline btn-lg" target="_blank" style="min-width:120px;"><i class="fab fa-instagram"></i> Instagram</a>
                    @endif
                    @if($settings['facebook'] ?? null)
                    <a href="{{ $settings['facebook'] }}" class="btn btn-outline btn-lg" target="_blank" style="min-width:120px;"><i class="fab fa-facebook-f"></i> Facebook</a>
                    @endif
                    @if($settings['linkedin'] ?? null)
                    <a href="{{ $settings['linkedin'] }}" class="btn btn-outline btn-lg" target="_blank" style="min-width:120px;"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
<style>
.toast-success {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #15803d;
    background: rgba(34,197,94,0.12);
    border: 1px solid rgba(34,197,94,0.2);
    margin-top: 16px;
    text-align: center;
    animation: toastIn 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes toastIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('subject', document.getElementById('subject').value);
        formData.append('message', document.getElementById('message').value);

        fetch('{{ route("contact.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                var waUrl = form.action;
                if (waUrl && waUrl !== '#') {
                    var text = encodeURIComponent(
                        'Halo, saya ' + document.getElementById('name').value +
                        '. (' + document.getElementById('subject').value + ')\n\n' +
                        document.getElementById('message').value
                    );
                    var separator = waUrl.includes('?') ? '&' : '?';
                    window.open(waUrl + separator + 'text=' + text, '_blank');
                }
                form.reset();
                var toast = document.createElement('div');
                toast.className = 'toast-success';
                toast.textContent = 'Pesan berhasil dikirim!';
                form.parentNode.insertBefore(toast, form.nextSibling);
                setTimeout(function() { toast.remove(); }, 4000);
            } else {
                alert(data.message || 'Gagal mengirim pesan. Silakan coba lagi.');
            }
        })
        .catch(function() {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Pesan';
        });
    });
});
</script>
@endpush
