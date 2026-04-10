<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk Wisata - Kampung 1000 Topeng</title>
  <link rel="stylesheet" href="{{ asset('css/csstopeng.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&display=swap" rel="stylesheet">
</head>
<body class="produk-body">
  @php
    $cartSvg = '<svg viewBox="0 0 24 24" aria-hidden="true" class="icon-cart"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2Zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2Zm-9.83-4.75 11.07-1.08c.58-.06 1.08-.5 1.18-1.08l.82-4.68c.12-.66-.4-1.26-1.08-1.26H6.21L5.89 3.5H3v1.5h1.5l1.6 8.32c-.61.36-1.02 1.02-1.02 1.78 0 1.12.9 2.02 2.02 2.02h11.98V15H7.43c-.14 0-.25-.11-.25-.25 0-.13.09-.23.21-.25Z"/></svg>';
    $cartSvgWhite = '<svg viewBox="0 0 24 24" aria-hidden="true" class="icon-cart icon-cart--inverse"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2Zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2Zm-9.83-4.75 11.07-1.08c.58-.06 1.08-.5 1.18-1.08l.82-4.68c.12-.66-.4-1.26-1.08-1.26H6.21L5.89 3.5H3v1.5h1.5l1.6 8.32c-.61.36-1.02 1.02-1.02 1.78 0 1.12.9 2.02 2.02 2.02h11.98V15H7.43c-.14 0-.25-.11-.25-.25 0-.13.09-.23.21-.25Z"/></svg>';
    $bagSvgWhite = '<svg viewBox="0 0 24 24" aria-hidden="true" class="icon-bag icon-bag--inverse"><path d="M16 7.5V6a4 4 0 0 0-8 0v1.5H4.75A1.75 1.75 0 0 0 3 9.25v10A1.75 1.75 0 0 0 4.75 21h14.5A1.75 1.75 0 0 0 21 19.25v-10A1.75 1.75 0 0 0 19.25 7.5H16Zm-6.5-1.5a2.5 2.5 0 0 1 5 0v1.5h-5V6Zm-2.5 4a.75.75 0 0 1 1.5 0v1.25a.75.75 0 0 1-1.5 0V10Zm9.5 0a.75.75 0 0 1 1.5 0v1.25a.75.75 0 0 1-1.5 0V10Z"/></svg>';
  @endphp
  @include('kampung.partials.navbar-topeng')

  <main id="produk" class="produk-page">
    <div class="container">
      <h1 class="produk-title">Produk Wisata</h1>

      <div class="produk-search">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        <input type="text" aria-label="Cari produk" placeholder="Cari">
        <button type="button" aria-label="Hapus pencarian">
          <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
        </button>
      </div>

      <div class="produk-grid">
        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengRadenPanji.jpg') }}" alt="Topeng Raden Panji">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Raden Panji</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Raden Panji ke keranjang"
            data-product="Topeng Raden Panji"
            data-image="images/TopengRadenPanji.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengButoJawa.jpg') }}" alt="Topeng Buto Jawa">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Buto Jawa</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Buto Jawa ke keranjang"
            data-product="Topeng Buto Jawa"
            data-image="images/TopengButoJawa.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengBali.jpg') }}" alt="Topeng Bali">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Bali</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Bali ke keranjang"
            data-product="Topeng Bali"
            data-image="images/TopengBali.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengJawa.jpg') }}" alt="Topeng Jawa">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Jawa</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Jawa ke keranjang"
            data-product="Topeng Jawa"
            data-image="images/TopengJawa.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengRumyan.jpg') }}" alt="Topeng Rumyang">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Rumyang</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Rumyang ke keranjang"
            data-product="Topeng Rumyang"
            data-image="images/TopengRumyan.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengPanjiCirebon.jpg') }}" alt="Topeng Panji Cirebon">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Panji Cirebon</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Panji Cirebon ke keranjang"
            data-product="Topeng Panji Cirebon"
            data-image="images/TopengPanjiCirebon.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengBali.jpg') }}" alt="Topeng Bali Emas">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Bali</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Bali ke keranjang"
            data-product="Topeng Bali"
            data-image="images/TopengBali.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengButoMalangan.jpg') }}" alt="Topeng Buto Malangan">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Buto Malangan</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Buto Malangan ke keranjang"
            data-product="Topeng Buto Malangan"
            data-image="images/TopengButoMalangan.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/TopengPanjiSemirangBatik.jpg') }}" alt="Topeng Panji Semirang Batik">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Panji Semirang Batik</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Panji Semirang Batik ke keranjang"
            data-product="Topeng Panji Semirang Batik"
            data-image="images/TopengPanjiSemirangBatik.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/bajutopengmalangan.jpg') }}" alt="Baju Topeng Malangan">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Baju Topeng Malangan</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Baju Topeng Malangan ke keranjang"
            data-product="Baju Topeng Malangan"
            data-image="images/bajutopengmalangan.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/topengmalangan.jpg') }}" alt="Topeng Topeng Malangan">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Malangan</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Malangan ke keranjang"
            data-product="Topeng Malangan"
            data-image="images/topengmalangan.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>

        <div class="produk-card">
          <div class="produk-img">
            <img src="{{ asset('images/topengornamen.jpg') }}" alt="Topeng Ornamen">
          </div>
          <div class="produk-name">{!! $cartSvg !!}Topeng Ornamen</div>
          <div class="produk-price">Rp150.000,00</div>
          <button type="button" class="produk-btn"
            aria-label="Tambah Topeng Ornamen ke keranjang"
            data-product="Topeng Ornamen"
            data-image="images/topengornamen.jpg"
            data-price="150000">
            {!! $bagSvgWhite !!}
          </button>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const checkoutBase = "{{ route('kampung.topeng.checkout') }}";
      document.querySelectorAll('.produk-btn[data-product]').forEach(function (btn) {
        btn.addEventListener('click', function () {
          const name = btn.dataset.product || '';
          const image = btn.dataset.image || '';
          const price = btn.dataset.price || '';
          const url = new URL(checkoutBase, window.location.origin);
          url.searchParams.set('product', name);
          url.searchParams.set('image', image);
          if (price) url.searchParams.set('price', price);
          window.location.href = url.toString();
        });
      });
    });
  </script>

  @include('kampung.partials.footer-topeng')
</body>
</html>
