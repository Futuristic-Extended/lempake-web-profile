<x-layout.app>
  <section id="hero" class="section d-flex align-items-center justify-content-center container">
    <x-home.hero />
  </section>

  <section class="pb-2" id="menu">
    <div class="container">
      <div class="row gy-4 mb-5">
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu
            icon="bi bi-person-lines-fill"
            name="Profil"
            description="Sambutan, Sejarah, Visi dan Misi, Tugas Pokok, serta para personil Kelurahan."
            route="{{ url('/profil') }}"
          />
        </div>
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu
            icon="bi bi-newspaper"
            name="Informasi"
            description="Kontak/Telepon penting, berita, pengumuman, dan jadwal agenda seputar kelurahan Lempake."
            route="{{ url('/profil') }}"
          />
        </div>
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu
            icon="bi bi-images"
            name="Media"
            description="Koleksi foto, video, dan dokumen terkait kelurahan Lempake."
            route="{{ url('/profil') }}"
          />
        </div>
        <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
          <x-home.menu
            icon="bi bi-shop"
            name="UMKM"
            description="Usaha-usaha yang terdapat di sekitar wilayah Lempake."
            route="{{ url('/profil') }}"
          />
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