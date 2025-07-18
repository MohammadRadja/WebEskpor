<!DOCTYPE html>
<html lang="en">

@include('layouts.panel.head')

<body class="sb-nav-fixed">
    @include('layouts.panel.navbar')

    <div id="layoutSidenav">
        @include('layouts.panel.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            @include('layouts.panel.footer')
        </div>
    </div>

    @include('layouts.panel.scripts')
    @stack('scripts')
</body>

</html>
