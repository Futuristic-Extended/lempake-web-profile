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
        <div class="icon-box py-5">
          <div class="icon"><i class="bi bi-person-lines-fill"></i></div>
          <h4 class="title"><a href="">Profil</a></h4>
          <p class="description">Sambutan, Sejarah, Visi dan Misi, Tugas Pokok, serta para personil Kelurahan.</p>
        </div>
      </div>

      <div class="col-12 col-lg-6" data-aos="zoom-out" data-aos-delay="200">
        <div class="icon-box py-5">
          <div class="icon"><i class="bi bi-info-circle-fill"></i></div>
          <h4 class="title"><a href="">Informasi</a></h4>
          <p class="description">Kontak/Telepon penting, berita, pengumuman, dan agenda seputar kelurahan Lempake.</p>
        </div>
      </div>

      <div class="col-12" data-aos="zoom-out" data-aos-delay="300">
        <div class="icon-box py-5">
          <div class="icon"><i class="bi bi-images"></i></div>
          <h4 class="title"><a href="">Media</a></h4>
          <p class="description">Koleksi foto, video, dan dokumen terkait kelurahan Lempake.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection