<nav class="sb-topnav navbar navbar-expand navbar-dark bg-success shadow-sm border-bottom border-light">
    <!-- Logo Kiri -->
    <a class="navbar-brand ps-3 d-flex align-items-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/log1.svg') }}" alt="AgriCulture" class="img-fluid" style="max-height: 50px;">
    </a>

    <!-- Sidebar Toggle (Mobile) -->
    <button class="btn btn-link btn-sm me-3 d-lg-none text-white" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Right -->
    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-user me-2 text-secondary"></i> Profile
                    </a>
                </li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-secondary"></i>Settings</a>
                </li>
                <hr class="dropdown-divider" />
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2 text-danger"></i>Logout
                </button>
            </form>
        </li>
    </ul>
    </li>
    </ul>
</nav>
