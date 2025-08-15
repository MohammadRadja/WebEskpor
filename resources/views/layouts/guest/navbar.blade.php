<header id="header" class="header d-flex align-items-center position-relative"
    style="padding: 5px 0; background-color: #ffffff00; z-index: 999;">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="{{ route('Home') }}">
            <img src="{{ asset_or_default('assets/img/log1.svg') }}" alt="Logo" class="img-fluid">
        </a>

        <!-- NAV MENU - Desktop -->
        <nav id="navmenu" class="d-none d-lg-flex align-items-center mx-auto">
            <ul class="d-flex flex-row align-items-center gap-3 mb-0 p-0 list-unstyled">
                <li><a href="{{ route('Home') }}" class="{{ request()->routeIs('Home') ? 'text-success fw-bold' : 'text-dark' }}">Beranda</a></li>
                <li><a href="{{ route('About') }}" class="{{ request()->is('about') ? 'text-success fw-bold' : 'text-dark' }}">Tentang Kami</a></li>
                <li><a href="{{ url('/product') }}" class="{{ request()->is('service') ? 'text-success fw-bold' : 'text-dark' }}">Produk</a></li>
                <li><a href="{{ url('/blog') }}" class="{{ request()->is('blog') ? 'text-success fw-bold' : 'text-dark' }}">Berita</a></li>
                <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'text-success fw-bold' : 'text-dark' }}">Kontak</a></li>
            </ul>
        </nav>

        <!-- ICONS & PROFILE - Desktop -->
        <div class="d-none d-lg-flex align-items-center gap-3">
            @auth
                <!-- Messages -->
                <a href="{{ route('message.index') }}" class="position-relative text-dark me-3">
                    <i class="bi bi-envelope fs-5"></i>
                    @if ($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                <!-- Cart -->
                <a href="{{ url('/cart') }}" class="position-relative text-dark me-3">
                    <i class="bi bi-cart3 fs-5"></i>
                    @if ($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            @endauth

            <!-- Profile Dropdown -->
            <div class="dropdown ms-lg-2">
                <a href="#" class="text-dark" id="desktopProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="desktopProfileDropdown">
                    @auth
                        <li><a href="{{ route('profile.show') }}" class="dropdown-item"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a href="#" class="dropdown-item"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item bg-transparent border-0 text-start w-100">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                    @endguest
                </ul>
            </div>
        </div>

        <!-- MOBILE TOGGLE & ICONS -->
        <div class="d-flex align-items-center d-lg-none gap-3">
            <!-- Menu Toggle -->
            <i class="mobile-nav-toggle bi bi-list fs-3"></i>

            @auth
                <!-- Messages -->
                <a href="{{ route('message.index') }}" class="position-relative text-dark">
                    <i class="bi bi-envelope fs-4"></i>
                    @if ($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                <!-- Cart -->
                <a href="{{ url('/cart') }}" class="position-relative text-dark">
                    <i class="bi bi-cart3 fs-4"></i>
                    @if ($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="text-dark" id="mobileProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileProfileDropdown">
                        <li><a href="{{ route('profile.show') }}" class="dropdown-item"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a href="#" class="dropdown-item"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item bg-transparent border-0 text-start w-100">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-dark">
                    <i class="bi bi-person-circle fs-4"></i>
                </a>
            @endguest
        </div>
    </div>
</header>
