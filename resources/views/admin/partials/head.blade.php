<head>
    <base href="">
    <title>@yield('title', 'Admin RavaaWeb')</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#0071e3" />

    @php
        $logoMediaId = \App\Models\Setting::get('logo_media_id');
        $customLogoUrl = null;
        if ($logoMediaId) {
            $customLogoUrl = \Illuminate\Support\Facades\Cache::remember('logo_url_' . $logoMediaId, 3600, function () use ($logoMediaId) {
                return \App\Models\Media::find($logoMediaId)?->url;
            });
        }
    @endphp
    <link rel="icon" href="{{ $customLogoUrl ?? asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ $customLogoUrl ?? asset('images/logo.svg') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts: Inter (primary) + Poppins (fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    {{-- Icons: Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />

    {{-- Icons: Font Awesome 6 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />

    {{-- Page Vendor Styles --}}
    @stack('styles')

    {{-- Global Admin Styles --}}
    <link href="{{ asset('admin/css/admin.css') }}" rel="stylesheet" />
</head>
