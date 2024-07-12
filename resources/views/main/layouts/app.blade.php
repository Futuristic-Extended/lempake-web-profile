<!DOCTYPE html>
<html lang="en">
  <head>
    @include('main.layouts.metas')

    <title>Index - OnePage Bootstrap Template</title>

    @include('main.layouts.styles')

    <!-- =======================================================
    * Template Name: OnePage
    * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
    * Updated: Jun 29 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
  </head>
  <body class="index-page">
    @includeWhen(isset($useNavbar) && $useNavbar, 'main.layouts.navbar')

    <main class="py-5">
      <img src="assets/main/img/hero-bg-abstract.jpg" id="background-image" alt="Background">
      <div id="content">
        @yield('content')
      </div>
    </main>

    @include('main.layouts.footer')

    @include('main.layouts.scripts')
  </body>
</html>