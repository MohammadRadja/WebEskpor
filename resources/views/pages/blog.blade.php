@extends('user.index')
@section('title', 'Blog - PT.RAJAWALI PRIMA ANDALAS')
@section('content')
    {{-- Hero Section --}}
    <x-hero-section title="Blog" background="assets/img/page-title-bg.webp" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Blog']]" />

    <!-- Blog Section -->
    <div class="container mt-5">
        <div class="row g-4">
            <!-- Blog Post 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'><rect fill='%23228B22' width='400' height='200'/><text x='200' y='100' text-anchor='middle' fill='white' font-size='20'>Perkebunan Sawit</text></svg>"
                        class="card-img-top" alt="Perkebunan Kelapa Sawit">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Inovasi Terbaru dalam Budidaya Kelapa Sawit</h5>
                        <p class="blog-meta mb-3">
                            <i class="bi bi-calendar"></i> 15 Juli 2025 •
                            <i class="bi bi-person"></i> By Admin
                        </p>
                        <p class="card-text flex-grow-1">Teknologi terbaru dalam budidaya kelapa sawit yang ramah lingkungan
                            dan meningkatkan produktivitas. Pelajari metode-metode modern yang telah diterapkan di
                            perkebunan kami.</p>
                        <a href="#" class="btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'><rect fill='%23FF8C00' width='400' height='200'/><text x='200' y='100' text-anchor='middle' fill='white' font-size='20'>Industri Kelapa Sawit</text></svg>"
                        class="card-img-top" alt="Industri Kelapa Sawit">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Perkembangan Industri Kelapa Sawit di Indonesia</h5>
                        <p class="blog-meta mb-3">
                            <i class="bi bi-calendar"></i> 12 Juli 2025 •
                            <i class="bi bi-person"></i> By Admin
                        </p>
                        <p class="card-text flex-grow-1">Analisis mendalam tentang tren industri kelapa sawit Indonesia dan
                            peluang ekspor yang semakin terbuka. Bagaimana PT Rajawali Prima Andalas mengambil peran dalam
                            pertumbuhan ini.</p>
                        <a href="#" class="btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'><rect fill='%2332CD32' width='400' height='200'/><text x='200' y='100' text-anchor='middle' fill='white' font-size='20'>Keberlanjutan</text></svg>"
                        class="card-img-top" alt="Keberlanjutan">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Komitmen terhadap Praktik Pertanian Berkelanjutan</h5>
                        <p class="blog-meta mb-3">
                            <i class="bi bi-calendar"></i> 10 Juli 2025 •
                            <i class="bi bi-person"></i> By Admin
                        </p>
                        <p class="card-text flex-grow-1">Upaya nyata kami dalam menerapkan praktik pertanian berkelanjutan
                            yang menjaga keseimbangan ekosistem dan memberikan manfaat jangka panjang bagi masyarakat
                            sekitar.</p>
                        <a href="#" class="btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'><rect fill='%234169E1' width='400' height='200'/><text x='200' y='100' text-anchor='middle' fill='white' font-size='20'>Teknologi</text></svg>"
                        class="card-img-top" alt="Teknologi">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Teknologi Digital dalam Manajemen Perkebunan</h5>
                        <p class="blog-meta mb-3">
                            <i class="bi bi-calendar"></i> 8 Juli 2025 •
                            <i class="bi bi-person"></i> By Admin
                        </p>
                        <p class="card-text flex-grow-1">Implementasi teknologi Internet of Things (IoT) dan artificial
                            intelligence dalam monitoring dan pengelolaan perkebunan modern untuk efisiensi maksimal.</p>
                        <a href="#" class="btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'><rect fill='%23DC143C' width='400' height='200'/><text x='200' y='100' text-anchor='middle' fill='white' font-size='20'>Ekspor</text></svg>"
                        class="card-img-top" alt="Ekspor">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Strategi Ekspor Minyak Kelapa Sawit ke Pasar Global</h5>
                        <p class="blog-meta mb-3">
                            <i class="bi bi-calendar"></i> 5 Juli 2025 •
                            <i class="bi bi-person"></i> By Admin
                        </p>
                        <p class="card-text flex-grow-1">Bagaimana kami membangun jaringan distribusi internasional dan
                            mempertahankan kualitas produk untuk memenuhi standar pasar global yang semakin ketat.</p>
                        <a href="#" class="btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Blog Post 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card h-100">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'><rect fill='%23800080' width='400' height='200'/><text x='200' y='100' text-anchor='middle' fill='white' font-size='20'>Komunitas</text></svg>"
                        class="card-img-top" alt="Komunitas">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Pemberdayaan Masyarakat Sekitar Perkebunan</h5>
                        <p class="blog-meta mb-3">
                            <i class="bi bi-calendar"></i> 3 Juli 2025 •
                            <i class="bi bi-person"></i> By Admin
                        </p>
                        <p class="card-text flex-grow-1">Program-program CSR yang telah kami jalankan untuk meningkatkan
                            kesejahteraan masyarakat di sekitar area perkebunan, termasuk program pendidikan dan kesehatan.
                        </p>
                        <a href="#" class="btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Blog pagination" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>

@endsection
