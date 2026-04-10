<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeri Kampung Warna-Warni Jodipan</title>

  <link rel="stylesheet" href="{{ asset('css/csswarna.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="galeri-body">
  @include('kampung.partials.navbar-warna')

  @php($galleries = $galleries ?? collect())
  <main class="galeri-page">
    <div class="container">
      <h2>Galeri Kampung Warna-Warni Jodipan</h2>
      @if($galleries->isEmpty())
        <div style="padding:20px; text-align:center; color:#6b7280;">Coming soon.</div>
      @else
      <div class="galeri-grid galeri-page-grid">
        @foreach($galleries as $galeri)
          @if($galeri->jenis === 'foto' && $galeri->media_path)
            <img class="galeri-thumb" src="{{ asset($galeri->media_path) }}" alt="{{ $galeri->judul ?? 'Galeri' }}">
          @elseif($galeri->media_path)
            <video class="galeri-video" controls>
              <source src="{{ asset($galeri->media_path) }}" type="video/{{ pathinfo($galeri->media_path, PATHINFO_EXTENSION) }}">
              Browser tidak mendukung video.
            </video>
          @endif
        @endforeach
      </div>
      @endif
      @if($galleries instanceof \Illuminate\Pagination\AbstractPaginator)
      <div style="margin-top:14px; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
        <span style="color:#4b5563; font-size:14px;">
          Showing {{ $galleries->firstItem() ?? 0 }} to {{ $galleries->lastItem() ?? $galleries->count() }} of {{ $galleries->total() }} entries
        </span>
        <div style="margin-left:auto;">
          {{ $galleries->links('pagination::bootstrap-4') }}
        </div>
      </div>
      @endif
    </div>
  </main>

  <div class="galeri-modal" id="galeriModalWarna" aria-hidden="true">
    <div class="galeri-modal__inner">
      <button class="galeri-modal__close" aria-label="Tutup">×</button>
      <img class="galeri-modal__img" src="" alt="">
    </div>
  </div>

  <script>
    (function() {
      const modal = document.getElementById('galeriModalWarna');
      const modalImg = modal.querySelector('.galeri-modal__img');
      const closeBtn = modal.querySelector('.galeri-modal__close');
      const thumbs = document.querySelectorAll('.galeri-thumb');

      thumbs.forEach(img => {
        img.addEventListener('click', () => {
          modalImg.src = img.src;
          modalImg.alt = img.alt;
          modal.classList.add('show');
          document.body.classList.add('no-scroll');
        });
      });

      function hide() {
        modal.classList.remove('show');
        modalImg.src = '';
        document.body.classList.remove('no-scroll');
      }

      closeBtn.addEventListener('click', hide);
      modal.addEventListener('click', (e) => {
        if (e.target === modal) hide();
      });
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('show')) hide();
      });
    })();
  </script>

  @include('kampung.partials.footer-warna')
</body>
</html>
