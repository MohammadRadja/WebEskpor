<header id="header" class="header d-flex align-items-center position-relative"
    style="padding: 5px 0; background-color: #ffffff00; z-index: 999;">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <img src="assets/img/log1.svg" alt="AgriCulture" style="width: 200px; height: auto;">

        <!-- Navigation -->
        <nav id="navmenu" class="navmenu d-flex align-items-center">
            <ul class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-3 mb-0 p-0">

                <!-- Menu Links -->
                <li>
                    <a href="{{ route('Home') }}"
                        class="{{ request()->routeIs('Home') ? 'text-success fw-bold' : 'text-dark' }}">Home</a>
                </li>
                <li>
                    <a href="{{ url('/tentang') }}"
                        class="{{ request()->is('tentang') ? 'text-success fw-bold' : 'text-dark' }}">About Us</a>
                </li>
                <li>
                    <a href="{{ url('/service') }}"
                        class="{{ request()->is('service') ? 'text-success fw-bold' : 'text-dark' }}">Product</a>
                </li>
                <li>
                    <a href="{{ url('/blog') }}"
                        class="{{ request()->is('blog') ? 'text-success fw-bold' : 'text-dark' }}">Blog</a>
                </li>
                <li>
                    <a href="{{ url('/contact') }}"
                        class="{{ request()->is('contact') ? 'text-success fw-bold' : 'text-dark' }}">Contact</a>
                </li>

                <!-- ICONS - Mobile Only -->
                <li class="d-lg-none w-100">
                    <div class="d-flex justify-content-start gap-3 ps-1 pt-2 border-top mt-2 pt-3">
                        <a href="{{ url('/messages') }}" class="text-dark position-relative">
                            <i class="bi bi-envelope fs-5"></i>
                        </a>

                        <a href="{{ url('/cart') }}" class="text-dark position-relative">
                            <i class="bi bi-cart3 fs-5"></i>
                        </a>

                        <div class="dropdown">
                            <a href="#" class="text-dark" id="mobileProfileDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="mobileProfileDropdown">
                                <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item bg-transparent border-0 text-start w-100">
                                            Logout
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- ICONS - Desktop Only -->
            <div class="d-none d-lg-flex align-items-center gap-3 ms-3">
                <a href="{{ url('/messages') }}" class="position-relative text-dark">
                    <i class="bi bi-envelope fs-5"></i>
                </a>
                <a href="{{ url('/cart') }}" class="position-relative text-dark">
                    <i class="bi bi-cart3 fs-5"></i>
                </a>
                <div class="dropdown">
                    <a href="#" class="text-dark" id="desktopProfileDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person-circle fs-5"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="desktopProfileDropdown">
                        <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item bg-transparent border-0 text-start w-100">
                                Logout
                            </button>
                        </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Toggle Icon -->
            <i class="mobile-nav-toggle d-lg-none bi bi-list fs-3 ms-3"></i>
        </nav>
    </div>
</header>
