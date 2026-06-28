<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin — RavaaWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            background: linear-gradient(145deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 1rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            width: 100%;
            max-width: 400px;
            padding: 2rem 1.75rem 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            animation: fadeUp 0.5s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .brand svg {
            width: 40px;
            height: 40px;
            margin-bottom: 0.5rem;
        }

        .brand h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .brand p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin: 0.2rem 0 0;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.35rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            pointer-events: none;
            z-index: 4;
            line-height: 0;
        }

        .input-wrap .form-control {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.65rem;
            padding: 0.6rem 0.85rem 0.6rem 2.4rem;
            font-size: 0.88rem;
            color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            height: auto;
        }

        .input-wrap .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.06);
            color: #fff;
        }

        .input-wrap .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
            font-size: 0.82rem;
        }

        .input-wrap .form-control.is-invalid {
            border-color: #f87171;
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.12);
        }

        .input-wrap .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15);
        }

        .password-toggle {
            position: absolute;
            right: 0.6rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            padding: 0.25rem;
            line-height: 0;
            z-index: 4;
            transition: color 0.2s;
        }

        .password-toggle:hover { color: rgba(255, 255, 255, 0.6); }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.25rem;
            margin-bottom: 1.25rem;
        }

        .form-check-input {
            width: 1rem;
            height: 1rem;
            margin: 0;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 0.3rem;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.55);
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 0.65rem;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            cursor: pointer;
            position: relative;
        }

        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .spinner {
            display: none;
            width: 1.1rem;
            height: 1.1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -0.55rem;
            margin-top: -0.55rem;
        }

        .btn-login.loading .spinner { display: block; }
        .btn-login.loading .btn-text { visibility: hidden; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .alert-compact {
            background: rgba(248, 113, 113, 0.12);
            border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: 0.6rem;
            color: #fca5a5;
            font-size: 0.78rem;
            padding: 0.55rem 0.8rem;
            margin-bottom: 1rem;
        }

        .alert-compact ul {
            margin: 0;
            padding-left: 1.1rem;
        }

        .alert-compact li {
            margin-bottom: 0.1rem;
        }

        .alert-compact li:last-child {
            margin-bottom: 0;
        }

        .alert-compact-success {
            background: rgba(52, 211, 153, 0.12);
            border-color: rgba(52, 211, 153, 0.2);
            color: #6ee7b7;
        }

        .footer-text {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.25);
        }

        .invalid-feedback-custom {
            font-size: 0.75rem;
            color: #f87171;
            margin-top: 0.25rem;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        @media (max-width: 420px) {
            .login-card {
                padding: 1.5rem 1.25rem 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="10" fill="url(#g)"/>
                <path d="M12 20a8 8 0 0116 0v2h-3v-2a5 5 0 00-10 0v2h-3v-2z" fill="#fff" opacity="0.9"/>
                <path d="M11 22h18v7a1 1 0 01-1 1H12a1 1 0 01-1-1v-7z" fill="#fff" opacity="0.4"/>
                <defs><linearGradient id="g" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse"><stop stop-color="#667eea"/><stop offset="1" stop-color="#764ba2"/></linearGradient></defs>
            </svg>
            <h1>RavaaWeb</h1>
            <p>Panel Admin — CMS Katalog Produk</p>
        </div>

        @if ($errors->any())
            <div class="alert-compact" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert-compact alert-compact-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" id="loginForm">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 4L12 13 2 4"/></svg>
                    </span>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="admin@example.com"
                           required autofocus autocomplete="email">
                </div>
                @error('email')
                    <div class="invalid-feedback-custom">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="password-toggle" id="togglePassword" tabindex="-1" aria-label="Toggle password visibility">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback-custom">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <span class="btn-text">Masuk</span>
                <span class="spinner"></span>
            </button>
        </form>

        <div class="footer-text">&copy; {{ date('Y') }} Ravaa Creative. All rights reserved.</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                pw.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        });

        document.getElementById('loginForm')?.addEventListener('submit', function () {
            document.getElementById('submitBtn')?.classList.add('loading');
        });
    </script>
</body>
</html>
