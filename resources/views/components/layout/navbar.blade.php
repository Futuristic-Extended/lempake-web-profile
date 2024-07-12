<header id="header" class="header d-flex align-items-center sticky-top">
	<div class="container-fluid container-xl position-relative d-flex align-items-center">
		<a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto select-none">
			<img src="{{ asset('assets/main/img/logo-pemkot.png') }}" alt="Pemerintah kota Samarinda">
			<div>
				<p class="sitename mb-1 fs-6 fw-light">Pemerintah kota Samarinda</p>
				<h1 class="fs-6 mb-0 fw-bold">Kelurahan Lempake</h1>
			</div>
		</a>

		<nav id="navmenu" class="navmenu">
			<ul>
				<li><a href="{{ route('profile') }}" class="active">Profil<br></a></li>
				<li><a href="{{ route('informations') }}">Informasi</a></li>
				<li><a href="{{ route('under-construction') }}">Media</a></li>
				<li><a href="{{ route('under-construction') }}">UMKM</a></li>
			</ul>
			<i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
		</nav>
	</div>
</header>