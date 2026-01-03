<head>
    <base href="">
    <title>@yield('title', 'Admin RavaaWeb')</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{ asset('admin/assets/media/logos/favicon.ico') }}" />

    {{-- Fonts --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    {{-- Page Vendor --}}
    @stack('styles')

    {{-- Global Styles --}}
    <link href="{{ asset('admin/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/style.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/ravaa.css') }}" rel="stylesheet">
</head>
