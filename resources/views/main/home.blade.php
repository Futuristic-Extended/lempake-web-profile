<x-layout.app>
  <section id="hero" class="section d-flex align-items-center justify-content-center container">
    <x-home.hero />
  </section>

  <section class="pb-2" id="menu">
    <div class="container">
      <div class="row gy-4 mb-5">
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu />
        </div>
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu />
        </div>
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu />
        </div>
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu />
        </div>
      </div>
    </div>
  </section>

  <section id="information">
    <div class="container">
      <x-home.information />
    </div>
  </section>

  <section id="location-and-headman">
    <div class="container">
      <div class="row" id="headman" data-aos="zoom-in">
        <div class="d-none col-lg-3 d-lg-block">
          <x-home.headman />
        </div>
        <div class="col-12 col-lg-9">
          <x-home.location />
        </div>
      </div>
    </div>
  </section>
</x-layout.app>