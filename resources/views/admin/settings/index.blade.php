@extends('admin.layouts.app')

@section('page-title', 'Pengaturan Umum')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="text-muted">Pengaturan Umum</span>
    </li>
@endsection

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    @if ($errors->any())
    <div class="col-12 mb-3">
        <div class="alert alert-danger mb-0">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="row g-4">
        <!-- Kiri: Form Utama -->
        <div class="col-lg-8">

            <!-- Info Bisnis -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-building me-1"></i> Info Bisnis</div>
                </div>
                <div class="card-body">
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Nama Bisnis / Brand</label>
                        <input type="text" class="form-control form-control-sm" name="site_name"
                               value="{{ $settings['site_name'] ?? '' }}" placeholder="Ravaa Creative">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Tagline</label>
                        <input type="text" class="form-control form-control-sm" name="site_tagline"
                               value="{{ $settings['site_tagline'] ?? '' }}" placeholder="Solusi Kreatif untuk Bisnis Anda">
                    </div>
                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-2">Deskripsi Singkat</label>
                        <textarea class="form-control form-control-sm" rows="2" name="site_description"
                                  placeholder="Deskripsi singkat tentang bisnis Anda">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Kontak -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-telephone me-1"></i> Kontak</div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">No. WhatsApp</label>
                            <input type="text" class="form-control form-control-sm" name="whatsapp"
                                   value="{{ $settings['whatsapp'] ?? '' }}" placeholder="6282233377661">
                            <div class="form-text fs-8">Format: kode negara + nomor (tanpa +)</div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Pesan WhatsApp Default</label>
                            <input type="text" class="form-control form-control-sm" name="whatsapp_message"
                                   value="{{ $settings['whatsapp_message'] ?? '' }}" placeholder="Halo, saya tertarik dengan...">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email"
                                   value="{{ $settings['email'] ?? '' }}" placeholder="info@ravaacreative.com">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Telepon</label>
                            <input type="text" class="form-control form-control-sm" name="phone"
                                   value="{{ $settings['phone'] ?? '' }}" placeholder="(022) 3456-789">
                        </div>
                        <div class="col-12 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Alamat</label>
                            <textarea class="form-control form-control-sm" rows="2" name="address"
                                      placeholder="Jl. Kreatif No. 123, Bandung">{{ $settings['address'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6 fv-row mb-0">
                            <label class="fs-7 fw-semibold mb-2">Jam Operasional</label>
                            <input type="text" class="form-control form-control-sm" name="operating_hours"
                                   value="{{ $settings['operating_hours'] ?? '' }}" placeholder="Senin-Jumat 08:00-17:00">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-share me-1"></i> Social Media</div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-instagram me-1"></i> Instagram</label>
                            <input type="url" class="form-control form-control-sm" name="instagram"
                                   value="{{ $settings['instagram'] ?? '' }}" placeholder="https://instagram.com/username">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-facebook me-1"></i> Facebook</label>
                            <input type="url" class="form-control form-control-sm" name="facebook"
                                   value="{{ $settings['facebook'] ?? '' }}" placeholder="https://facebook.com/page">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-linkedin me-1"></i> LinkedIn</label>
                            <input type="url" class="form-control form-control-sm" name="linkedin"
                                   value="{{ $settings['linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/name">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-tiktok me-1"></i> TikTok</label>
                            <input type="url" class="form-control form-control-sm" name="tiktok"
                                   value="{{ $settings['tiktok'] ?? '' }}" placeholder="https://tiktok.com/@username">
                        </div>
                        <div class="col-md-6 fv-row mb-0">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-youtube me-1"></i> YouTube</label>
                            <input type="url" class="form-control form-control-sm" name="youtube"
                                   value="{{ $settings['youtube'] ?? '' }}" placeholder="https://youtube.com/@channel">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-layout-sidebar me-1"></i> Footer</div>
                </div>
                <div class="card-body">
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Footer Text</label>
                        <textarea class="form-control form-control-sm" rows="2" name="footer_text"
                                  placeholder="© 2026 Ravaa Creative. All rights reserved.">{{ $settings['footer_text'] ?? '' }}</textarea>
                    </div>
                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-2">Copyright</label>
                        <input type="text" class="form-control form-control-sm" name="copyright"
                               value="{{ $settings['copyright'] ?? '' }}" placeholder="© 2026 Ravaa Creative">
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-search me-1"></i> SEO Default</div>
                </div>
                <div class="card-body">
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Meta Title</label>
                        <input type="text" class="form-control form-control-sm" name="meta_title"
                               value="{{ $settings['meta_title'] ?? '' }}" placeholder="Judul default untuk SEO">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Meta Description</label>
                        <textarea class="form-control form-control-sm" rows="2" name="meta_description"
                                  placeholder="Deskripsi default untuk SEO">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-2">Meta Keywords</label>
                        <input type="text" class="form-control form-control-sm" name="meta_keywords"
                               value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="keyword1, keyword2, keyword3">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Hero Section + Preview -->
        <div class="col-lg-4">

            <!-- Hero / Banner -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-image me-1"></i> Hero / Banner</div>
                </div>
                <div class="card-body">
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Judul Hero</label>
                        <input type="text" class="form-control form-control-sm" name="hero_title"
                               value="{{ $settings['hero_title'] ?? '' }}" placeholder="Solusi Kreatif untuk Bisnis & Kebutuhan Anda">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Subtitle Hero</label>
                        <textarea class="form-control form-control-sm" rows="2" name="hero_subtitle"
                                  placeholder="Deskripsi singkat hero section">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">Badge / Promo Text</label>
                        <input type="text" class="form-control form-control-sm" name="hero_badge"
                               value="{{ $settings['hero_badge'] ?? '' }}" placeholder="Paket Desain Logo mulai Rp399k">
                    </div>
                    <div class="fv-row mb-3">
                        <label class="fs-7 fw-semibold mb-2">URL Gambar Hero</label>
                        <input type="url" class="form-control form-control-sm" name="hero_image"
                               value="{{ $settings['hero_image'] ?? '' }}" placeholder="https://...">
                    </div>
                    <div class="row g-2">
                        <div class="col-8 fv-row">
                            <label class="fs-7 fw-semibold mb-2">CTA Text</label>
                            <input type="text" class="form-control form-control-sm" name="hero_cta_text"
                                   value="{{ $settings['hero_cta_text'] ?? '' }}" placeholder="Lihat Produk">
                        </div>
                        <div class="col-4 fv-row mb-0">
                            <label class="fs-7 fw-semibold mb-2">CTA URL</label>
                            <input type="text" class="form-control form-control-sm" name="hero_cta_url"
                                   value="{{ $settings['hero_cta_url'] ?? '' }}" placeholder="/product">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="glass-card mb-4">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-1"></i> Simpan Pengaturan
                    </button>
                    <div class="form-text fs-8 text-center mt-2">Perubahan akan langsung terlihat di website</div>
                </div>
            </div>
        </div>
    </div>
</form>
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
