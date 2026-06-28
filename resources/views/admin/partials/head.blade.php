<head>
    <base href="">
    <title>@yield('title', 'Admin RavaaWeb')</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    {{-- Page Vendor --}}
    @stack('styles')

    {{-- Global Styles --}}
<link href="https://cdn.jsdelivr.net/npm/tabler@1.0.0-beta16/dist/css/tabler.min.css" rel="stylesheet">
<link href="{{ asset('frontend/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/admin-glass.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
