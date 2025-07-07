<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>pt</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center position-relative" style="padding: 5px 0; background-color: #ffffff00; z-index: 999;">
 <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
  <!-- Logo -->
  <img src="assets/img/log1.svg" alt="AgriCulture" style="width: 200px; height: auto;">

  <!-- Navigation -->
  <nav id="navmenu" class="navmenu d-flex align-items-center">
    <ul class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-3 mb-0 p-0">

      <!-- Menu Links -->
      <li>
        <a href="{{ route('Home') }}" class="{{ request()->routeIs('Home') ? 'text-success fw-bold' : 'text-dark' }}">Home</a>
      </li>
      <li>
        <a href="{{ url('/tentang') }}" class="{{ request()->is('tentang') ? 'text-success fw-bold' : 'text-dark' }}">About Us</a>
      </li>
      <li>
        <a href="{{ url('/service') }}" class="{{ request()->is('service') ? 'text-success fw-bold' : 'text-dark' }}">Product</a>
      </li>
      <li>
        <a href="{{ url('/blog') }}" class="{{ request()->is('blog') ? 'text-success fw-bold' : 'text-dark' }}">Blog</a>
      </li>
      <li>
        <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'text-success fw-bold' : 'text-dark' }}">Contact</a>
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
            <a href="#" class="text-dark" id="mobileProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-5"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="mobileProfileDropdown">
              <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
             <li>
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
        <a href="#" class="text-dark" id="desktopProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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




<main class="main">
  @yield('content')
</main>

<footer id="footer" class="footer dark-background">
  <div class="copyright text-center">
    <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">



      <div class="d-flex flex-column align-items-center align-items-lg-start">
        <div>
          © 2025 <strong><span>PT RAJAWALI PRIMA ANDALAS</span></strong>.INDONESIA
        </div>
        <div class="credits">
          Seluruh hak cipta dilindungi.
        </div>
      </div>

      <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>

    </div>
  </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

<!-- Tidio Live Chat Script -->
<script src="//code.tidio.co/0pr9g5tuwokaqzb52hjeaujqhmjegvb3.js" async></script>

</body>
</html>
