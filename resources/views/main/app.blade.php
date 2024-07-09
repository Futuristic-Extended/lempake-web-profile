@extends('main.layouts.app')

@yield('use-navbar', false)

@section('content')
<section id="hero" class="hero section">
  <img src="assets/main/img/hero-bg-abstract.jpg" alt="" data-aos="fade-in" class="">

  <div class="container">
    <div class="row justify-content-center pb-5" data-aos="zoom-out">
      <div class="col-xl-7 col-lg-9 text-center">
        <h1>Kelurahan Lempake</h1>
        <h2>Kota Samarinda, Kalimantan Timur</h2>
      </div>
    </div>

    <div class="row gy-4 mt-5">
      <div class="col-12 col-lg-6" data-aos="zoom-out" data-aos-delay="100">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-person-lines-fill"></i></div>
            <h4 class="title">Profil</h4>
            <p class="description">Sambutan, Sejarah, Visi dan Misi, Tugas Pokok, serta para personil Kelurahan.</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-lg-6" data-aos="zoom-out" data-aos-delay="200">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-info-circle-fill"></i></div>
            <h4 class="title">Informasi</h4>
            <p class="description">Kontak/Telepon penting, berita, pengumuman, dan agenda seputar kelurahan Lempake.</p>
          </div>
        </a>
      </div>

      <div class="col-12" data-aos="zoom-out" data-aos-delay="300">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-images"></i></div>
            <h4 class="title">Media</h4>
            <p class="description">Koleksi foto, video, dan dokumen terkait kelurahan Lempake.</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>
@endsection