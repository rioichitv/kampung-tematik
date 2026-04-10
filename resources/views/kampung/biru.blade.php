<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kampung Biru Arema</title>

  <link rel="stylesheet" href="{{ asset('css/cssbiru.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
  {{-- ================= NAVBAR KHUSUS ================= --}}
  @include('kampung.partials.navbar-biru')

  {{-- ================= HERO SECTION ================= --}}
  <header class="hero-kampung">
    <img src="{{ asset('images/biruarema.jpg') }}" alt="Kampung Biru Arema">
    <div class="hero-text">
      <h1>Kampung Biru Arema</h1>
      <p>Malang, Jawa Timur</p>
      <a href="{{ route('booking') }}" class="btn-rencana">Rencanakan Kunjungan</a>
    </div>
  </header>

  <section id="info" class="info-section">
  <div class="container">
    <h2>Informasi Kunjungan</h2>

    <div class="info-grid">
      {{-- Kolom kiri: box info --}}
      <div class="info-left">
        <div class="info-box">
          <h3>Lokasi</h3>
          <p>Wisata Kampung Biru Arema, Blimbing, Malang City, East Java</p>
        </div>
        <div class="info-box">
          <h3>Jam Buka</h3>
          <p>Setiap Hari<br>07.00 - 22.00 WIB</p>
        </div>
        <div class="info-box">
          <h3>Tiket</h3>
          <p>Rp 10.000,00 / Orang<br>Terjangkau Untuk Semua Kalangan</p>
        </div>
      </div>

      {{-- Kolom kanan: map --}}
      <div class="info-right">
        <div class="info-map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.300476944743!2d112.633502!3d-7.966394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78828b1bcd6c57%3A0x3af076de61e0ad31!2sKampung%20Biru%20Arema!5e0!3m2!1sid!2sid!4v1700000000001!5m2!1sid!2sid"
            allowfullscreen loading="lazy"></iframe>
        </div>
        <button class="gmaps-btn"
          onclick="window.open('https://goo.gl/maps/VwQoqUnRUBwsAcqo8','_blank')">
          Buka Google Maps
        </button>
      </div>
    </div>
  </div>
</section>



  {{-- ================= EVENT ================= --}}
  <section id="event" class="event-section">
    <div class="container">
      <h2>event</h2>
      <div class="event-list">
        <div class="event-card">
          <img src="{{ asset('images/event-parade.jpg') }}" alt="Arak-arakan">
          <div class="content">
            <h4>Arak-arakan / Parade Budaya</h4>
            <p>Rangkaian festival budaya yang melibatkan warga dan pelaku seni setempat.</p>
          </div>
        </div>
        <div class="event-card">
          <img src="{{ asset('images/event-workshop.jpg') }}" alt="Workshop Kriya">
          <div class="content">
            <h4>Workshop Kriya</h4>
            <p>Menampilkan atraksi kesenian tradisional dan pelatihan kriya kreatif.</p>
          </div>
        </div>
        <div class="event-card">
          <img src="{{ asset('images/event-wahana.jpg') }}" alt="Wahana Baru">
          <div class="content">
            <h4>Peresmian & Pengadaan Wahana Baru</h4>
            <p>Peresmian wahana baru sebagai bagian dari pengembangan fasilitas wisata.</p>
          </div>
        </div>
      </div>
      <a href="{{ route('kampung.biru.event') }}" class="btn-more">Lihat Selengkapnya</a>
    </div>
  </section>

  {{-- ================= SEJARAH ================= --}}
  <section id="sejarah" class="sejarah">
    <div class="container sejarah-center">
      <h2>Sejarah</h2>
      <p>
        🌱 <strong>Asal-usul &amp; transformasi</strong><br>
        Dahulu, Kampung Biru Arema dikenal sebagai kawasan permukiman kumuh di bantaran Sungai Brantas dengan hunian dan sanitasi yang kurang layak. Kawasan ini kemudian direvitalisasi: seluruh bangunan dan lingkungan dicat ulang melalui kolaborasi pemerintah setempat dan PT Indana Paint (CSR), mencakup ±500 rumah di RW 4 dan RW 5 Kelurahan Kidul Dalem, menggunakan sekitar 15 ton cat biru.
      </p>
      <p>
        📅 <strong>Peresmian &amp; Tujuan</strong><br>
        Diresmikan 6 Februari 2018 sebagai kampung tematik. Tujuan utama: memperbaiki kualitas lingkungan kumuh menjadi layak dan menarik; membentuk identitas visual “bhumi” Arema FC dengan warna biru khas klub; serta mendorong pariwisata kota untuk manfaat ekonomi-sosial warga.
      </p>
      <p>
        🎨 <strong>Identitas &amp; Visual — Biru &amp; “Arema”</strong><br>
        Biru mendominasi dinding, atap, pagar, pintu, hingga jalan dan tangga—warna identitas Arema FC. Mural, grafiti, dan gambar bertema Arema (logo, maskot singa, pemain, elemen kebanggaan suporter) menghiasi kampung, menjadikannya kanvas fanatisme Aremania sekaligus simbol identitas kolektif warga Malang.
      </p>
    </div>
  </section>

  {{-- ================= GALERI ================= --}}
  <section id="galeri" class="galeri">
    <div class="container">
      <h2>Galeri</h2>
      <div class="galeri-grid">
        <img src="{{ asset('images/topeng-galeri1.jpg') }}" alt="Galeri 1">
        <img src="{{ asset('images/topeng-galeri2.jpg') }}" alt="Galeri 2">
        <img src="{{ asset('images/topeng-galeri3.jpg') }}" alt="Galeri 3">
      </div>
      <a href="{{ route('kampung.biru.galeri') }}" class="btn-more">Lihat Selengkapnya</a>
    </div>
  </section>

  {{-- ================= VISI & MISI ================= --}}
  <section class="visi-misi">
    <div class="container">
      <h2>Visi & Misi</h2>
      <div class="visi-misi-grid">
        <div class="visi">
          <h3>Visi</h3>
          <p>
            Menjadikan Kampung Biru Arema sebagai kampung wisata tematik yang memberdayakan masyarakat,
            melestarikan identitas Arema, serta meningkatkan kesejahteraan warga dan citra Kota Malang.
          </p>
        </div>
        <div class="misi">
          <h3>Misi</h3>
          <ul>
            <li>Memberdayakan masyarakat melalui pelatihan dan kegiatan produktif.</li>
            <li>Mengembangkan seni mural bertema Arema sebagai ikon kampung.</li>
            <li>Menata ruang publik yang estetis, hijau, dan edukatif.</li>
            <li>Menumbuhkan pariwisata berbasis komunitas dan kebersamaan.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- ================= TUJUAN & FUNGSI ================= --}}
  <section id="tujuan" class="tujuan">
    <div class="container">
      <h2>Tujuan</h2>
      <p>
        Kampung ini bertujuan untuk memberdayakan masyarakat dan memperkenalkan kreativitas warga sebagai identitas khas Malang yang bernilai budaya tinggi.
      </p>
    </div>
  </section>

  <section class="fungsi">
    <div class="container">
      <h2>Fungsi</h2>
      <div class="fungsi-boxes">
        <div class="fungsi-box">
          <ul>
            <li>Pemberdayaan sosial: menyediakan pelatihan keterampilan dan usaha bersama.</li>
            <li>Fungsi budaya: menjadi ruang edukasi, pertunjukan seni, dan ikon kreatif Malang.</li>
          </ul>
        </div>
        <div class="fungsi-box">
          <ul>
            <li>Fungsi ekonomi: membuka lapangan kerja baru bagi warga.</li>
            <li>Fungsi estetika & lingkungan: mempercantik kampung, menghijaukan area, dan menarik wisatawan.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- ================= FOOTER KHUSUS ================= --}}
  @include('kampung.partials.footer-biru')
</body>
</html>
