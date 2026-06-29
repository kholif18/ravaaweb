<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin — RavaaWeb</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f0f2f5;
            background-image:
                radial-gradient(at 20% 30%, rgba(79, 110, 247, 0.06) 0px, transparent 60%),
                radial-gradient(at 80% 70%, rgba(34, 197, 94, 0.04) 0px, transparent 60%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 1rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            padding: 2.25rem 2rem 1.75rem;
            box-shadow:
                0 4px 24px rgba(0, 0, 0, 0.06),
                0 1px 2px rgba(0, 0, 0, 0.04);
            animation: fadeUp 0.5s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        .brand-icon img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .brand h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1a1d21;
            letter-spacing: -0.02em;
        }

        .brand p {
            font-size: 0.82rem;
            color: #9aa0a6;
            margin-top: 0.2rem;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: #5f6368;
            margin-bottom: 0.35rem;
            display: block;
        }

        .input-wrap { position: relative; }

        .input-wrap .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa0a6;
            pointer-events: none;
            z-index: 4;
            line-height: 0;
        }

        .input-wrap .form-control {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 0.65rem 0.85rem 0.65rem 2.6rem;
            font-size: 0.88rem;
            font-family: inherit;
            color: #1a1d21;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
            line-height: 1.5;
        }

        .input-wrap .form-control:focus {
            outline: none;
            border-color: #4f6ef7;
            box-shadow: 0 0 0 3px rgba(79, 110, 247, 0.12);
        }

        .input-wrap .form-control::placeholder {
            color: #c4c8cc;
            font-size: 0.85rem;
        }

        .input-wrap .form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
        }

        .password-toggle {
            position: absolute;
            right: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9aa0a6;
            cursor: pointer;
            padding: 0.25rem;
            line-height: 0;
            z-index: 4;
            transition: color 0.2s;
        }

        .password-toggle:hover { color: #5f6368; }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.3rem;
            margin-bottom: 1.25rem;
        }

        .form-check-input {
            width: 1rem;
            height: 1rem;
            margin: 0;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            cursor: pointer;
            accent-color: #4f6ef7;
        }

        .form-check-label {
            font-size: 0.82rem;
            color: #5f6368;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            background: #4f6ef7;
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: inherit;
            color: #ffffff;
            width: 100%;
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
            box-shadow: 0 2px 8px rgba(79, 110, 247, 0.25);
        }

        .btn-login:hover {
            background: #3b5de7;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79, 110, 247, 0.35);
        }

        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .btn-login .spinner {
            display: none;
            width: 1.1rem;
            height: 1.1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            position: absolute;
            left: 50%; top: 50%;
            margin-left: -0.55rem; margin-top: -0.55rem;
        }

        .btn-login.loading .spinner { display: block; }
        .btn-login.loading .btn-text { visibility: hidden; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .alert-compact {
            background: rgba(239, 68, 68, 0.06);
            border: 1px solid rgba(239, 68, 68, 0.12);
            border-radius: 10px;
            color: #b91c1c;
            font-size: 0.8rem;
            padding: 0.6rem 0.85rem;
            margin-bottom: 1rem;
        }

        .alert-compact ul { margin: 0; padding-left: 1.1rem; }
        .alert-compact li { margin-bottom: 0.1rem; }
        .alert-compact li:last-child { margin-bottom: 0; }

        .alert-compact-success {
            background: rgba(34, 197, 94, 0.06);
            border-color: rgba(34, 197, 94, 0.12);
            color: #15803d;
        }

        .footer-text {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.72rem;
            color: #9aa0a6;
        }

        .invalid-feedback-custom {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.25rem;
        }

        .mb-3 { margin-bottom: 1rem; }

        @media (max-width: 420px) {
            .login-card { padding: 1.5rem 1.25rem 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <div class="brand-icon">
                <img src="{{ asset('admin/images/logo.png') }}" alt="RavaaWeb">
            </div>
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
                        <i class="bi bi-envelope"></i>
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
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password" required autocomplete="current-password">
                    <button type="button" class="password-toggle" id="togglePassword" tabindex="-1" aria-label="Toggle password visibility">
                        <i class="bi bi-eye" id="eyeIcon"></i>
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

    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pw.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });

        document.getElementById('loginForm')?.addEventListener('submit', function () {
            document.getElementById('submitBtn')?.classList.add('loading');
        });
    </script>
</body>
</html>
