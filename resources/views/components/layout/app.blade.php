<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <title>Index - OnePage Bootstrap Template</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/main/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/main/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/main/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/main/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/main/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/main/app.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: OnePage
    * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
    * Updated: Jun 29 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com 
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
  </head>
  <body class="index-page">
    <x-layout.navbar :show="$isNavbarShown" />

    <main class="py-5">
      <img src="assets/main/img/hero-bg-abstract.jpg" id="background-image" alt="Background">
      <div id="content">
        {{ $slot }}
      </div>
    </main>

    <x-layout.footer />
    
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/main/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/main/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main/app.js') }}"></script>
  </body>
</html>