@extends('admin.layouts.app')

@section('page-title', 'Profil Saya')

@section('breadcrumb')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door"></i> Home
        </a>
    </li>
    <li class="bc-separator"><i class="bi bi-chevron-right"></i></li>
    <li>
        <span class="bc-current">Profil Saya</span>
    </li>
@endsection

@section('content')
<div class="row g-4">

    {{-- ===== AVATAR CARD ===== --}}
    <div class="col-lg-4">
        <div class="glass-card h-100">
            <div class="card-body text-center">
                <h5 class="card-title mb-4">Foto Profil</h5>

                <div class="avatar-preview-wrapper mx-auto mb-3" style="width: 140px; height: 140px;">
                    <div class="avatar-preview" id="avatarPreview"
                         style="width: 100%; height: 100%; border-radius: 50%; background-size: cover; background-position: center;
                                background-image: url('{{ $user->avatar_url }}');
                                border: 3px solid var(--glass-border);
                                box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    </div>
                </div>

                <form action="{{ route('admin.profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="avatar" id="avatarInput"
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               style="display: none;">
                        <button type="button" class="btn btn-primary btn-sm w-100" onclick="document.getElementById('avatarInput').click();">
                            <i class="bi bi-camera me-1"></i> Upload Foto
                        </button>
                    </div>
                    <p class="text-muted small mb-0">Format: JPEG, PNG, GIF, WebP. Maks. 2MB</p>
                </form>

                @if($user->avatar_media_id)
                <div class="mt-2">
                    <form action="{{ route('admin.profile.avatar.remove') }}" method="POST" onsubmit="return confirm('Hapus foto profil?')">
                        @csrf
                        <button type="submit" class="btn btn-sm text-danger" style="background: none; border: none; padding: 0; font-size: 0.8rem;">
                            <i class="bi bi-trash me-1"></i> Hapus foto
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== PROFILE FORM CARD ===== --}}
    <div class="col-lg-8">
        <div class="glass-card">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Profil</h5>

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold mb-3" style="color: var(--text-primary);">
                        <i class="bi bi-key me-1"></i> Ubah Password
                    </h6>
                    <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah password.</p>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" minlength="8">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('avatarInput')?.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('avatarPreview').style.backgroundImage = "url('" + ev.target.result + "')";
        };
        reader.readAsDataURL(this.files[0]);
        document.getElementById('avatarForm').submit();
    }
});
</script>
@endpush
