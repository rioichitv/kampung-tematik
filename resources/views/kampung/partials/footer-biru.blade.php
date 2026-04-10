<footer class="footer-topeng">
  <div class="container footer-grid">
    <div class="f-left">
      @php($logoBiru = public_path('images/logo-biru.png'))
      @if(file_exists($logoBiru))
        <img src="{{ asset('images/logo-biru.png') }}" alt="Logo Kampung Biru" class="logo-topeng">
      @else
        <div class="footer-logo-fallback">
          <img src="{{ asset('images/biru-arema.jpg') }}" alt="Logo Kampung Biru" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
        </div>
      @endif
      <div>
        <h4>Kampung Biru Arema</h4>
        <p>Kampung bertema biru Arema yang menjadi destinasi wisata foto dan kebanggaan suporter Malang, dikelola gotong royong warga.</p>
      </div>
    </div>

    <div class="f-col">
      <h4>Menu</h4>
      <ul>
        <li><a href="{{ route('kampung.biru') }}#sejarah">Sejarah</a></li>
        <li><a href="{{ route('kampung.biru') }}#event">Event</a></li>
        <li><a href="{{ route('kampung.biru') }}#galeri">Galeri</a></li>
        <li><a href="{{ route('kampung.biru') }}#tujuan">Tujuan & Fungsi</a></li>
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
