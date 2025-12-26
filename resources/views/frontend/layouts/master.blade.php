<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - Ravaa Creative</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/ravaa.css') }}">
    </head>
    <body>
        @include('frontend.partials.header')

        <main>
            @yield('content')
        </main>

        @include('frontend.partials.footer')
        
        <script src="{{ asset('assets/js/ravaa.js') }}"></script>
    </body>
</html>