<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'PT. Rajawali Prima Andalas')</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    <!-- Favicon -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="logo-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Marcellus&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <style>
        body.auth-layout {
            background-color: #f8f9fa;
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body_class', 'index-page')">

    {{-- HEADER --}}
    @hasSection('auth')
    @else
        @include('components.navbar')
    @endif

    {{-- MAIN CONTENT --}}
    <main class="main">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @hasSection('auth')
    @else
        @include('components.footer')
    @endif

    {{-- Scroll Top & Preloader --}}
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Tidio Live Chat -->
    <script src="//code.tidio.co/0pr9g5tuwokaqzb52hjeaujqhmjegvb3.js" async></script>

    @stack('scripts')
</body>

</html>
