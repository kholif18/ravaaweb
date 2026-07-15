@php
    $settings = \App\Models\Setting::allAsArray();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Pemeliharaan — {{ $settings['site_name'] ?? 'Ravaa Creative' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #1a1040 30%, #1e1b4b 60%, #0f172a 100%);
            color: #fff;
            padding: 24px;
        }

        .maintenance-card {
            max-width: 520px;
            width: 100%;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 20px;
            padding: 48px 36px;
            animation: fadeUp 0.6s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-wrap {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #818cf8;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #a5b4fc, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        p {
            font-size: 0.95rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 32px;
        }

        .logo {
            margin-bottom: 8px;
        }
        .logo img {
            height: 36px;
            width: auto;
            object-fit: contain;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
        }
        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 1.1rem;
        }
        .social-links a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateY(-2px);
        }

        .contact-info {
            margin-top: 20px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
        }
        .contact-info a {
            color: #818cf8;
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }

        .gear {
            display: inline-block;
            animation: spin 4s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        @php
            $logoMediaId = $settings['logo_media_id'] ?? null;
            $logoUrl = $logoMediaId ? (\App\Models\Media::find($logoMediaId)?->url ?? asset('images/logo.svg')) : asset('images/logo.svg');
        @endphp
        @if(!empty($settings['site_name']) || $logoMediaId)
        <div class="logo">
            <img src="{{ $logoUrl }}" alt="{{ $settings['site_name'] ?? '' }}">
        </div>
        @endif

        <div class="icon-wrap">
            <i class="fas fa-cog gear"></i>
        </div>

        <h1>Sedang Pemeliharaan</h1>
        <p>
            Kami sedang melakukan perbaikan dan peningkatan sistem.<br>
            Website akan segera kembali. Terima kasih atas kesabaran Anda.
        </p>

        @if(!empty($settings['whatsapp']) || !empty($settings['email']))
        <div class="contact-info">
            @if(!empty($settings['whatsapp']))
            <div>WhatsApp: <a href="https://wa.me/{{ $settings['whatsapp'] }}">{{ $settings['whatsapp'] }}</a></div>
            @endif
            @if(!empty($settings['email']))
            <div>Email: <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a></div>
            @endif
        </div>
        @endif

        @php
            $socials = ['instagram', 'facebook', 'linkedin', 'tiktok', 'youtube'];
            $socialIcons = [
                'instagram' => 'fab fa-instagram',
                'facebook' => 'fab fa-facebook-f',
                'linkedin' => 'fab fa-linkedin-in',
                'tiktok' => 'fab fa-tiktok',
                'youtube' => 'fab fa-youtube',
            ];
        @endphp
        @if(array_filter(array_intersect_key($settings, array_flip($socials))))
        <div class="social-links">
            @foreach($socials as $s)
                @if(!empty($settings[$s]))
                <a href="{{ $settings[$s] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($s) }}">
                    <i class="{{ $socialIcons[$s] }}"></i>
                </a>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</body>
</html>
