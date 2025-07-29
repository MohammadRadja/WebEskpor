<!DOCTYPE html>
<html lang="en">
@include('layouts.panel.head')

<body class="sb-nav-fixed">
    @include('layouts.panel.navbar')

    <div id="layoutSidenav" class="d-flex">
        {{-- Sidebar --}}
        <div id="layoutSidenav_nav mt-5">
            @include('layouts.panel.sidebar')
        </div>

        {{-- Konten Utama --}}
        <div id="layoutSidenav_content">
            <main class="mt-5 w-100">
                @yield('content')
            </main>

            @include('layouts.panel.footer')
        </div>
    </div>

    @include('layouts.panel.scripts')
    @stack('scripts')

    {{-- Modal Form --}}
    <x-modal-form />
</body>
</html>
