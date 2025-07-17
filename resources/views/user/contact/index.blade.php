@extends('user.index')
@section('title', 'CONTACT-PT.RAJAWALI PRIMA ANDALAS')
@section('content')
<div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
  <div class="container position-relative">
    <h1>Contact</h1>
    <p>
      Home
      /
      Contact
    </p>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.html">Home</a></li>
        <li class="current">Contact</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->

<!-- Contact Section -->
<section id="contact" class="contact section">

  <div class="mb-5">
    <iframe
      style="width: 100%; height: 400px;"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.037232410178!2d100.36196731416502!3d-0.9500474352572055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2d62c273a5c23b%3A0x6e3d66c96a99b212!2sJalan%20Ripan%203%20No.11%2C%20Padang%2C%20Sumatera%20Barat!5e0!3m2!1sid!2sid!4v1685298123456"
      frameborder="0"
      allowfullscreen=""
      loading="lazy"></iframe>
  </div>


  <div class="container" data-aos="fade">

    <div class="row gy-5 gx-lg-5">

      <div class="col-lg-4">

        <div class="info">
          <h3>Get in touch</h3>
          <p>Et id eius voluptates atque nihil voluptatem enim in tempore minima sit ad mollitia commodi minus.</p>

          <div class="info-item d-flex">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h4>Location:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h4>Email:</h4>
              <p>info@example.com</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex">
            <i class="bi bi-phone flex-shrink-0"></i>
            <div>
              <h4>Call:</h4>
              <p>+1 5589 55488 55</p>
            </div>
          </div><!-- End Info Item -->

        </div>

      </div>

      <div class="col-lg-8">
        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="">
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" placeholder="Message" required=""></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center"><button type="submit">Send Message</button></div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>

</section><!-- /Contact Section -->

<!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section light-background">

  <div class="content">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h3>Subscribe To Our Newsletter</h3>
          <p class="opacity-50">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Nesciunt, reprehenderit!
          </p>
        </div>
        <div class="col-lg-6">
          <form action="forms/newsletter.php" class="form-subscribe php-email-form">
            <div class="form-group d-flex align-items-stretch">
              <input type="email" name="email" class="form-control h-100" placeholder="Enter your e-mail">
              <input type="submit" class="btn btn-secondary px-4" value="Subcribe">
            </div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">
              Your subscription request has been sent. Thank you!
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Call To Action Section -->
@endsection