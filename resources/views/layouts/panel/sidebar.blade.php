<style>
    .sb-sidenav {
        min-height: 100vh !important;
        overflow-y: auto;
    }
</style>
<div id="layoutSidenav_nav" class="position-fixed">
    <nav class="sb-sidenav border-end border-light d-flex flex-column mt-5" id="sidenavAccordion">
        {{-- Bagian Konten Utama Menu --}}
        <div class="sb-sidenav-menu px-3 py-4 flex-grow-1 position-fixed">
            <div class="nav flex-column">
                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}"
                    class="nav-link d-flex align-items-center text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>

                {{-- ADMINISTRATOR --}}
                @if (auth()->user()->role === 'administrator')
                    {{-- Manajemen Kebun --}}
                    @include('components.sidebar.collapse', [
                        'id' => 'collapseKebun',
                        'title' => 'Manajemen Kebun',
                        'icon' => 'fa-seedling',
                        'items' => [
                            ['route' => 'tanaman.index', 'icon' => 'fa-leaf', 'label' => 'Tanaman'],
                            ['route' => 'bibit.index', 'icon' => 'fa-seedling', 'label' => 'Bibit'],
                            ['route' => 'kebun.index', 'icon' => 'fa-tree', 'label' => 'Kebun'],
                            ['route' => 'petak.kebun', 'icon' => 'fa-th', 'label' => 'Petak Kebun'],
                        ],
                    ])

                    {{-- Manajemen Produk --}}
                    @include('components.sidebar.collapse', [
                        'id' => 'collapseProduk',
                        'title' => 'Manajemen Produk',
                        'icon' => 'fa-box-open',
                        'items' => [
                            ['route' => 'produk.index', 'icon' => 'fa-box', 'label' => 'Produk'],
                            [
                                'route' => 'produk-eksternal.index',
                                'icon' => 'fa-boxes',
                                'label' => 'Produk Eksternal',
                            ],
                        ],
                    ])

                    <a href="{{ route('transaksi.index') }}"
                        class="nav-link d-flex align-items-center text-white {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt me-2"></i> Manajemen Transaksi
                    </a>

                    <a href="{{ route('user.index') }}"
                        class="nav-link d-flex align-items-center text-white {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog me-2"></i> Manajemen User
                    </a>

                    <a href="{{ route('konten.index') }}"
                        class="nav-link d-flex align-items-center text-white {{ request()->routeIs('konten.*') ? 'active' : '' }}">
                        <i class="fas fa-edit me-2"></i> Manajemen Konten
                    </a>
                    <a href="{{ route('laporan.index') }}"
                        class="nav-link d-flex align-items-center text-white {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i> Laporan
                    </a>
                @elseif(auth()->user()->role === 'manajer_kebun')
                    {{-- Manajer Kebun --}}
                    @include('components.sidebar.collapse', [
                        'id' => 'collapseKebunMgr',
                        'title' => 'Manajemen Kebun',
                        'icon' => 'fa-seedling',
                        'items' => [
                            ['route' => 'bibit.index', 'icon' => 'fa-seedling', 'label' => 'Bibit'],
                            ['route' => 'tanaman.index', 'icon' => 'fa-leaf', 'label' => 'Tanaman'],
                            ['route' => 'kebun.index', 'icon' => 'fa-tree', 'label' => 'Kebun'],
                            ['route' => 'petak.kebun', 'icon' => 'fa-th-large', 'label' => 'Petak Kebun'],
                        ],
                    ])

                    @include('components.sidebar.collapse', [
                        'id' => 'collapseProdukMgr',
                        'title' => 'Manajemen Produk',
                        'icon' => 'fa-box-open',
                        'items' => [
                            ['route' => 'produk.index', 'icon' => 'fa-box', 'label' => 'Produk'],
                            [
                                'route' => 'produk-eksternal.index',
                                'icon' => 'fa-boxes',
                                'label' => 'Produk Eksternal',
                            ],
                        ],
                    ])
                @elseif(auth()->user()->role === 'penjual')
                    {{-- Penjual --}}
                    @include('components.sidebar.collapse', [
                        'id' => 'collapseProdukPenjual',
                        'title' => 'Manajemen Produk',
                        'icon' => 'fa-box-open',
                        'items' => [['route' => 'produk.index', 'icon' => 'fa-box', 'label' => 'Produk']],
                    ])

                    <a href="{{ route('konten.index') }}"
                        class="nav-link d-flex align-items-center text-white {{ request()->routeIs('konten.*') ? 'active' : '' }}">
                        <i class="fas fa-edit me-2"></i> Manajemen Konten
                    </a>

                    <a href="{{ route('transaksi.index') }}"
                        class="nav-link d-flex align-items-center text-white {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt me-2"></i> Manajemen Transaksi
                    </a>
                @endif
            </div>
        </div>
    </nav>
</div>
