<footer class="footer-topeng">
  <div class="container footer-grid">
    <div class="f-left">
      @php($logoWarna = public_path('images/logo-warna.png'))
      @if(file_exists($logoWarna))
        <img src="{{ asset('images/logo-warna.png') }}" alt="Logo Kampung Warna-Warni" class="logo-topeng">
      @else
        <div class="footer-logo-fallback">
          <img src="{{ asset('images/warnawarni.jpg') }}" alt="Logo Kampung Warna-Warni" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
        </div>
      @endif
      <div>
        <h4>Kampung Warna-Warni Jodipan</h4>
        <p>Kampung penuh warna dan mural yang menjadi ikon wisata kreatif di Kota Malang, hasil kolaborasi warga untuk mempercantik lingkungan.</p>
      </div>
    </div>

    <div class="f-col">
      <h4>Menu</h4>
      <ul>
        <li><a href="{{ route('kampung.warna') }}#sejarah">Sejarah</a></li>
        <li><a href="{{ route('kampung.warna') }}#event">Event</a></li>
        <li><a href="{{ route('kampung.warna') }}#galeri">Galeri</a></li>
        <li><a href="{{ route('kampung.warna') }}#tujuan">Tujuan & Fungsi</a></li>
      </ul>
    </div>

    <div class="f-col">
      <h4>Informasi</h4>
      <ul>
        <li><a href="{{ url('/') }}">Beranda</a></li>
        <li><a href="#">Berita</a></li>
        <li><a href="#">Kontak</a></li>
        <li><a href="#">Produk Wisata</a></li>
      </ul>
    </div>
  </div>

  <div class="container f-copy">
    &copy; 2025 Kampung Tematik Malang. Semua hak cipta dilindungi.
  </div>
</footer>
