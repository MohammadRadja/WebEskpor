<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.guest.head')

<body class="index-page overflow-x-hidden d-flex flex-column min-vh-100">
    @include('layouts.guest.navbar')

    <main class="main flex-grow-1">
        @yield('content')
    </main>

    @include('layouts.guest.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    @include('layouts.guest.scripts')
    @stack('scripts')
</body>

</html>
