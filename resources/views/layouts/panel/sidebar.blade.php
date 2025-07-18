<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @if (auth()->user()->role === 'kepala_kebun')
                    <a class="nav-link active" href="{{ route('kepala.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser"
                        aria-expanded="false" aria-controls="collapseUser">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Kebun Manejemen
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseUser" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('kebun.show') }}">
                                <i class="fas fa-worm me-2"></i>Lihat Kebun
                            </a>
                            <a class="nav-link" href="{{ route('bibit.show') }}">
                                <i class="fas fa-seedling me-2"></i>Pembelian Stok Bibit
                            </a>
                        </nav>
                    </div>

                    <a class="nav-link" href="{{ route('barang.show') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>Pembelian Barang Jadi
                    </a>
                    <a class="nav-link" href="{{ route('penanaman.show') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-leaf"></i></div>Penanaman
                    </a>
                    <a class="nav-link" href="{{ route('kepala.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>Laporan
                    </a>
                @elseif(auth()->user()->role === 'sales')
                    <a class="nav-link active" href="{{ route('sales.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('sales.produk') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>Kelola Produk
                    </a>
                    <a class="nav-link" href="{{ route('sales.order') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-leaf"></i></div>Kelola Orderan
                    </a>
                    <a class="nav-link" href="{{ route('sales.berita') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>Berita
                    </a>
                    <a class="nav-link" href="#">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>Laporan
                    </a>
                @endif
            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <div class="fw-bold" style="color: var(--primary-green);">
                <i class="fas fa-user-circle me-1"></i>
                {{ Auth::user()->username ?? 'Guest' }}
            </div>
        </div>
    </nav>
</div>
