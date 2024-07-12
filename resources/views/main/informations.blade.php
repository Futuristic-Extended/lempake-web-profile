<x-layout.app>
  <section class="mb-4">
    <div class="container">
      <ul class="list-group list-group-horizontal">
        <li class="list-group-item">
          <x-informations.menu icon="bi bi-newspaper" name="Berita" :route="route('under-construction')" />
        </li>
        <li class="list-group-item">
          <x-informations.menu icon="bi bi-megaphone" name="Pengumuman" :route="route('under-construction')" />
        </li>
        <li class="list-group-item">
          <x-informations.menu icon="bi bi-calendar" name="Agenda" :route="route('under-construction')" />
        </li>
        <li class="list-group-item">
          <x-informations.menu icon="bi bi-telephone" name="Telepon Penting" :route="route('under-construction')" />
        </li>
      </ul>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row gy-4">
        <div class="col-sm-6 col-lg-4">
          <x-informations.news />
        </div>
        <div class="col-sm-6 col-lg-4">
          <x-informations.news />
        </div>
        <div class="col-sm-6 col-lg-4">
          <x-informations.news />
        </div>
      </div>
    </div>
  </section>
</x-layout.app>