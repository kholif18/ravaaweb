@extends('admin.layouts.app')

@section('page-title','Login Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="glass-card" style="max-width: 420px; margin: 0 auto;">
                <div class="text-center mb-4">
                    <div style="width: 56px; height: 56px; margin: 0 auto 0.75rem;">
                        <img src="{{ asset('admin/images/logo.png') }}" alt="RavaaWeb" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <h3 style="font-weight: 700; margin: 0;">Admin Login</h3>
                    <p class="text-muted mt-1" style="font-size: 0.85rem;">Masuk ke panel admin RavaaWeb</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="fv-row">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                        </div>
                    </div>
                    <div class="fv-row mt-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    <div class="form-check mt-3 mb-4">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
