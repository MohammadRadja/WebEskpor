@extends('layouts.guest.index')
@section('title', 'Kontak - PT. Rajawali Prima Andalas')
@section('content')

    {{-- Hero Section --}}
    <x-hero-section title="Contact Us" background="assets/img/page-title-bg.webp" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Contact Us']]" />

    <!-- Contact Section -->
    <section id="contact" class="contact py-5">
        <div class="container">

            <!-- Map -->
            <div class="mb-5 rounded overflow-hidden shadow-sm">
                <iframe class="w-100 border-0" height="400"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.037232410178!2d100.36196731416502!3d-0.9500474352572055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2d62c273a5c23b%3A0x6e3d66c96a99b212!2sJalan%20Ripan%203%20No.11%2C%20Padang%2C%20Sumatera%20Barat!5e0!3m2!1sid!2sid!4v1685298123456"
                    allowfullscreen loading="lazy">
                </iframe>
            </div>

            <!-- Contact Info + Form -->
            <div class="row g-5">

                <!-- Info -->
                <div class="col-lg-4">
                    <div class="p-4 rounded shadow-sm h-100">
                        <h4 class="mb-3">Contact Information</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-geo-alt me-3 fs-5 text-success"></i>
                                <div>
                                    <strong>Address:</strong>
                                    <p class="mb-0">Jl. Ripan 3 No.11, Padang, Sumatera Barat</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-envelope me-3 fs-5 text-success"></i>
                                <div>
                                    <strong>Email:</strong>
                                    <p class="mb-0">info@rajawaliprima.co.id</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-phone me-3 fs-5 text-success"></i>
                                <div>
                                    <strong>Phone:</strong>
                                    <p class="mb-0">+62 812 3456 7890</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <form action="forms/contact.php" method="post" class="php-email-form">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email"
                                        required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject"
                                        required>
                                </div>
                                <div class="col-12">
                                    <textarea name="message" rows="5" class="form-control" placeholder="Message" required></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Send Message</button>
                                </div>
                            </div>

                            <!-- Message Status -->
                            <div class="mt-3">
                                <div class="loading">Loading...</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Contact Section -->

    <!-- Newsletter Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h4>Subscribe to Our Newsletter</h4>
                    <p class="text-muted mb-0">Stay updated with the latest news and insights from PT. Rajawali Prima
                        Andalas.</p>
                </div>
                <div class="col-lg-6">
                    <form action="forms/newsletter.php" method="post" class="form-subscribe php-email-form d-flex">
                        <input type="email" name="email" class="form-control me-2" placeholder="Enter your email"
                            required>
                        <button type="submit" class="btn btn-secondary">Subscribe</button>
                    </form>
                    <div class="loading mt-2">Loading...</div>
                    <div class="error-message mt-2"></div>
                    <div class="sent-message mt-2">Subscription successful. Thank you!</div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Newsletter Section -->

@endsection
