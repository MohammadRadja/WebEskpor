<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 glow-effect" href="index.html">
            <i class="fas fa-leaf me-2"></i>
            Green Admin
        </a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw" style="color: var(--primary-green);"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><a class="dropdown-item" href="#!"><i class="fas fa-list me-2"></i>Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <a class="dropdown-item" href="#!"><i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </a>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @if(auth()->user()->role === 'kepala_kebun')
                        <a class="nav-link active" href="{{route('kepala.dashboard')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- User Menu -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Kebun Manejemen
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUser" aria-labelledby="headingUser" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('kebun.show') }}">
                                    <i class="fas fa-worm me-2"></i>
                                    Lihat Kebun
                                </a>
                                <a class="nav-link" href="{{route('bibit.show')}}">
                                    <i class="fas fa-seedling me-2"></i>
                                    Pembelian Stok Bibit
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link" href="{{route('barang.show')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                            Pembelian Barang Jadi
                        </a>
                        <a class="nav-link" href="{{route('penanaman.show')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-leaf"></i></div>
                            Penanaman
                        </a>
                        <a class="nav-link" href="{{route('kepala.dashboard')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>
                            Laporan
                        </a>
                        @elseif(auth()->user()->role === 'sales')
                        <!-- Sales Menu -->
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                            Kelola Produk
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-leaf"></i></div>
                            Kelola Orderan
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>
                            Berita
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>
                            Laporan
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

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            <i class="fas fa-copyright me-1"></i>
                            Copyright &copy; Green Admin Panel 2024
                        </div>
                        <div>
                            <a href="#"><i class="fas fa-shield-alt me-1"></i>Privacy Policy</a>
                            &middot;
                            <a href="#"><i class="fas fa-file-contract me-1"></i>Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>

    <script>
        // Enhanced sidebar interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effects to nav links
            const navLinks = document.querySelectorAll('.sb-sidenav .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                });
            });

            // Add hover effects to dropdown items
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
</body>

</html>