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
<form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST">
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
                        <label class="fs-7 fw-semibold mb-2">Logo Bisnis</label>
                        @php
                            $logoMediaId = $settings['logo_media_id'] ?? null;
                            $logoMedia = $logoMediaId ? \App\Models\Media::find($logoMediaId) : null;
                        @endphp
                        <x-media-picker name="logo_media_id" type="image" label="Pilih Logo" :value="$logoMediaId" :media="$logoMedia ? [$logoMedia] : null" />
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
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">instagram.com/</span>
                                <input type="text" class="form-control form-control-sm" name="instagram"
                                       value="{{ $settings['instagram'] ?? '' }}" placeholder="ravaacreative">
                            </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-facebook me-1"></i> Facebook</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">facebook.com/</span>
                                <input type="text" class="form-control form-control-sm" name="facebook"
                                       value="{{ $settings['facebook'] ?? '' }}" placeholder="ravaacreative">
                            </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-linkedin me-1"></i> LinkedIn</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">linkedin.com/</span>
                                <input type="text" class="form-control form-control-sm" name="linkedin"
                                       value="{{ $settings['linkedin'] ?? '' }}" placeholder="in/ravaacreative atau company/ravaacreative">
                            </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-tiktok me-1"></i> TikTok</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">tiktok.com/@</span>
                                <input type="text" class="form-control form-control-sm" name="tiktok"
                                       value="{{ $settings['tiktok'] ?? '' }}" placeholder="ravaacreative">
                            </div>
                        </div>
                        <div class="col-md-6 fv-row mb-0">
                            <label class="fs-7 fw-semibold mb-2"><i class="bi bi-youtube me-1"></i> YouTube</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">youtube.com/@</span>
                                <input type="text" class="form-control form-control-sm" name="youtube"
                                       value="{{ $settings['youtube'] ?? '' }}" placeholder="ravaacreative">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-geo-alt me-1"></i> Peta Lokasi</div>
                </div>
                <div class="card-body">
                    <div class="fv-row mb-2">
                        <label class="fs-7 fw-semibold mb-2">Google Maps Embed</label>
                        <textarea class="form-control form-control-sm" rows="3" name="map_embed"
                                  placeholder="&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; width=&quot;100%&quot; height=&quot;400&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot;&gt;&lt;/iframe&gt;">{{ $settings['map_embed'] ?? '' }}</textarea>
                        <div class="form-text fs-8">
                            Cara dapatkan: Buka <a href="https://maps.google.com" target="_blank">Google Maps</a> → cari lokasi → klik Bagikan → pilih "Sematkan peta" → salin kode iframe-nya.
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

            <!-- Maintenance Mode -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-shield-exclamation me-1"></i> Maintenance Mode</div>
                </div>
                <div class="card-body">
                    <div class="fv-row">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fs-7 fw-semibold mb-1">Aktifkan Maintenance Mode</div>
                                <div class="form-text fs-8 mb-0" style="margin-top:0;">
                                    Jika diaktifkan, pengunjung akan melihat halaman pemeliharaan. Admin tetap bisa mengakses panel.
                                </div>
                            </div>
                            <div class="form-check form-switch" style="padding-left: 3.5em;">
                                <input class="form-check-input" type="checkbox" role="switch" id="maintenanceMode"
                                       name="maintenance_mode" value="1"
                                       {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }}
                                       style="width: 3em; height: 1.5em; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Holiday Popup -->
            <div class="glass-card mb-4">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-calendar-event me-1"></i> Popup Hari Libur</div>
                </div>
                <div class="card-body">
                    <div class="fv-row mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fs-7 fw-semibold mb-1">Aktifkan Popup Libur</div>
                                <div class="form-text fs-8 mb-0" style="margin-top:0;">
                                    Menampilkan pemberitahuan libur di halaman depan website.
                                </div>
                            </div>
                            <div class="form-check form-switch" style="padding-left: 3.5em;">
                                <input class="form-check-input" type="checkbox" role="switch" id="holidayPopupEnabled"
                                       name="holiday_popup_enabled" value="1"
                                       {{ ($settings['holiday_popup_enabled'] ?? '0') === '1' ? 'checked' : '' }}
                                       style="width: 3em; height: 1.5em; cursor: pointer;">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Tanggal Mulai Libur</label>
                            <input type="date" class="form-control form-control-sm" name="holiday_start_date"
                                   value="{{ $settings['holiday_start_date'] ?? '' }}">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-7 fw-semibold mb-2">Tanggal Akhir Libur</label>
                            <input type="date" class="form-control form-control-sm" name="holiday_end_date"
                                   value="{{ $settings['holiday_end_date'] ?? '' }}">
                        </div>
                    </div>

                    <div class="fv-row mb-3 mt-3">
                        <label class="fs-7 fw-semibold mb-2">Judul Popup</label>
                        <input type="text" class="form-control form-control-sm" name="holiday_title"
                               value="{{ $settings['holiday_title'] ?? '' }}" placeholder="Contoh: Libur Hari Raya Idul Fitri">
                    </div>

                    <div class="fv-row mb-0">
                        <label class="fs-7 fw-semibold mb-2">Konten Popup</label>
                        <div id="holiday-content-editor" style="min-height: 180px;">{!! $settings['holiday_content'] ?? '' !!}</div>
                        <input type="hidden" name="holiday_content" id="holiday-content-input">
                        <div class="form-text fs-8 mt-1">Teks pemberitahuan libur. Bisa diformat dengan bold, warna, dll.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Sticky Sidebar -->
        <div class="col-lg-4">
            <div style="position: sticky; top: 24px;">

                <!-- Tombol Simpan -->
                <div class="glass-card mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i> Simpan Pengaturan
                        </button>
                        <div class="form-text fs-8 text-center mt-2">Perubahan akan langsung terlihat di website</div>
                    </div>
                </div>

                <!-- Info Status -->
                <div class="glass-card mb-4">
                    <div class="card-header">
                        <div class="card-title"><i class="bi bi-info-circle me-1"></i> Status</div>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 0.82rem; color: var(--text-muted);">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="bi bi-building me-1"></i> Nama Bisnis</span>
                                <span style="color: var(--text-primary); font-weight: 500;">{{ $settings['site_name'] ?? '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="bi bi-whatsapp me-1"></i> WhatsApp</span>
                                <span style="color: var(--text-primary); font-weight: 500;">{{ $settings['whatsapp'] ?? '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="bi bi-envelope me-1"></i> Email</span>
                                <span style="color: var(--text-primary); font-weight: 500; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $settings['email'] ?? '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-instagram me-1"></i> Instagram</span>
                                <span style="color: var(--text-primary); font-weight: 500;">{{ $settings['instagram'] ? '@' . $settings['instagram'] : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shortcut -->
                <div class="glass-card mb-4">
                    <div class="card-header">
                        <div class="card-title"><i class="bi bi-link-45deg me-1"></i> Kelola Lainnya</div>
                    </div>
                    <div class="card-body" style="padding: 0.75rem 1rem;">
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ route('admin.footer-links.index') }}" class="btn btn-light btn-sm w-100 text-start" style="justify-content: flex-start;">
                                <i class="bi bi-link-45deg me-1"></i> Footer Links
                            </a>
                            <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-light btn-sm w-100 text-start" style="justify-content: flex-start;">
                                <i class="bi bi-envelope me-1"></i> Pesan Masuk
                            </a>
                            <a href="{{ route('admin.media.index') }}" class="btn btn-light btn-sm w-100 text-start" style="justify-content: flex-start;">
                                <i class="bi bi-folder me-1"></i> Media Library
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<style>
/* Holiday popup editor — smaller to match settings size */
#holiday-content-editor .ql-editor { min-height: 160px; }
#holiday-content-editor { border-radius: 8px; overflow: hidden; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Ravaa.toast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Ravaa.toast('{{ session('error') }}', 'error');
    @endif

    // Quill editor for Holiday Popup content
    var holidayToolbar = [
        [{ 'header': [2, 3, 4, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['link', 'clean']
    ];
    var holidayEditor = new Quill('#holiday-content-editor', {
        theme: 'snow',
        modules: { toolbar: holidayToolbar },
        placeholder: 'Tulis informasi libur di sini...'
    });

    // Sync Quill content to hidden input on every change (realtime)
    holidayEditor.on('text-change', function() {
        document.getElementById('holiday-content-input').value = holidayEditor.root.innerHTML;
    });

    // Also sync on form submit as fallback
    var form = document.getElementById('settingsForm');
    form.addEventListener('submit', function() {
        document.getElementById('holiday-content-input').value = holidayEditor.root.innerHTML;
    });
});
</script>
@endpush
