<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kampung Tematik Malang</title>

    {{-- CSS utama --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    

    {{-- Jika halaman punya tambahan CSS --}}
    @stack('styles')
</head>
<body>

    {{-- ===== Navbar Dinamis ===== --}}
    @if (Request::is('/'))
        {{-- Navbar khusus halaman beranda --}}
        <nav class="transparent-nav">
            <div class="logo-center">KAMPUNG TEMATIK MALANG</div>
        </nav>
    @else
        {{-- Navbar untuk halaman lain --}}
        <nav>
            <div class="logo">KAMPUNG TEMATIK MALANG</div>
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="#event">Event</a></li>
                <li><a href="#galeri">Galeri</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </nav>
    @endif

    {{-- ===== Konten Utama ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== Footer ===== --}}
    <footer>
        <div class="footer-inner">
            <div class="footer-column footer-about">
                <h3>Kampung Tematik Malang</h3>
                <p class="footer-desc">Kampung Tematik Malang merupakan wadah informasi dan promosi wisata kreatif di Kota Malang yang menampilkan keindahan, inovasi, serta kearifan lokal dari berbagai kampung unggulan.</p>
            </div>

            <div class="footer-column">
                <h3>Menu</h3>
                <ul>
                    <li><a href="#sejarah">Sejarah</a></li>
                    <li><a href="#maps">Maps</a></li>
                    <li><a href="#visi">Visi &amp; Misi</a></li>
                    <li><a href="#tujuan">Tujuan &amp; Fungsi</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Informasi</h3>
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="#berita">Berita</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                    <li><a href="#produk">Produk Wisata</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            &copy; 2025 Kampung Tematik Malang. Semua hak cipta dilindungi.
        </div>
    </footer>

    {{-- Script tambahan (jika diperlukan) --}}
    @stack('scripts')

</body>
</html>
