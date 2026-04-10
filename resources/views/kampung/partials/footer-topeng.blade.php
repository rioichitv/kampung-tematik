<footer class="footer-topeng">
  <div class="container footer-grid">
    <div class="f-left">
      @php($logoTopeng = public_path('images/logo-topeng.png'))
      @if(file_exists($logoTopeng))
        <img src="{{ asset('images/logo-topeng.png') }}" alt="Logo 1000 Topeng" class="logo-topeng">
      @else
        <div class="footer-logo-fallback">
          <img src="{{ asset('images/topeng.jpg') }}" alt="Logo 1000 Topeng" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
        </div>
      @endif
      <div>
        <h4>Kampung 1000 Topeng</h4>
        <p>Kampung 1000 Topeng yang menonjolkan seni dan budaya Topeng Malangan sebagai identitas serta daya tarik wisata edukatif dan budaya.</p>
      </div>
    </div>

    <div class="f-col">
      <h4>Menu</h4>
      <ul>
        <li><a href="{{ route('kampung.topeng') }}#sejarah">Sejarah</a></li>
        <li><a href="{{ route('kampung.topeng') }}#event">Event</a></li>
        <li><a href="{{ route('kampung.topeng') }}#galeri">Galeri</a></li>
        <li><a href="{{ route('kampung.topeng') }}#tujuan">Tujuan & Fungsi</a></li>
      </ul>
    </div>

    <div class="f-col">
      <h4>Informasi</h4>
      <ul>
        <li><a href="{{ url('/') }}">Beranda</a></li>
        <li><a href="#">Berita</a></li>
        <li><a href="#">Kontak</a></li>
        <li><a href="{{ route('kampung.topeng.produk') }}">Produk Wisata</a></li>
      </ul>
    </div>
  </div>

  <div class="container f-copy">
    &copy; 2025 Kampung Tematik Malang. Semua hak cipta dilindungi.
  </div>
</footer>
