@extends('main.layouts.app')

@section('content')
<section id="hero" class="hero section">
  <img src="assets/main/img/hero-bg-abstract.jpg" id="background-image" alt="Background" data-aos="fade-in" class="">

  <div class="container">
    <div class="d-flex align-items-center justify-content-center" style="height: 70vh;">
      <div class="text-center" data-aos="zoom-in">
        <h1>Kelurahan Lempake</h1>
        <h2>Pemerintah kota Samarinda, Kalimantan Timur</h2>
      </div>
    </div>

    <div class="row gy-4 mb-5">
      <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-person-lines-fill"></i></div>
            <h4 class="title">Profil</h4>
            <p class="description">Sambutan, Sejarah, Visi dan Misi, Tugas Pokok, serta para personil Kelurahan.</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-newspaper"></i></div>
            <h4 class="title">Informasi</h4>
            <p class="description">Kontak/Telepon penting, berita, pengumuman, dan jadwal agenda seputar kelurahan Lempake.</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-images"></i></div>
            <h4 class="title">Media</h4>
            <p class="description">Koleksi foto, video, dan dokumen terkait kelurahan Lempake.</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-lg-6" data-aos="zoom-in" data-aos-delay="50">
        <a href="#">
          <div class="icon-box py-5">
            <div class="icon"><i class="bi bi-shop"></i></div>
            <h4 class="title">UMKM</h4>
            <p class="description">Usaha-usaha yang terdapat di sekitar wilayah Lempake.</p>
          </div>
        </a>
      </div>
    </div>

    <div class="row" id="headman" data-aos="zoom-in">
      <div class="d-none col-lg-3 d-lg-block">
        <div class="card">
          <img src="{{ url('assets/main/img/lempake-headman-photo.jpeg') }}" class="rounded-top" alt="Lurah Lempake">
          <div class="card-body text-center py-2">
            <p class="title mb-1">MUSLIADI, S.SOS</p>
            <p class="description mb-2">Lurah Lempake</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-9">
        <div class="card">
          <div class="card-body">
            <iframe style="border:0; width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3989.7001609455933!2d117.19195617447825!3d-0.44095703528540797!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sJL.%20Poros%20Kebon%20Agung%20No.98%20Kel.%20Lempake%20Kec.%20Samarinda%20Utara.!5e0!3m2!1sid!2sid!4v1720510262012!5m2!1sid!2sid" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection