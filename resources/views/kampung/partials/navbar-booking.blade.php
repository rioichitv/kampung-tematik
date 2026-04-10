<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SzlrxWriC3LLJ5/3nCDP9t6k4VJ6ECpQ0jO1SWNE1K+nJo3N3vrL1jH7Q+X5f5pX1zPW/M1N8P3kYxZyZG7xsg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<nav class="nav-booking">
  <div class="container nav-inner">
    <div class="brand">KAMPUNG TEMATIK MALANG</div>
    <button class="nav-toggle" type="button" aria-label="Toggle menu" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <ul class="nav-links">
      <li><a href="{{ route('booking.history') }}">Riwayat Pesanan</a></li>
      <li><a href="{{ url('/') }}">Kembali Ke Awal</a></li>
    </ul>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navbars = document.querySelectorAll('.nav-booking');

    navbars.forEach(function (nav) {
      const toggle = nav.querySelector('.nav-toggle');
      const links = nav.querySelector('.nav-links');
      if (!toggle || !links) return;

      const closeMenu = function () {
        links.classList.remove('is-open');
        toggle.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('no-scroll');
      };

      toggle.addEventListener('click', function () {
        const isOpen = links.classList.toggle('is-open');
        toggle.classList.toggle('is-open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        document.body.classList.toggle('no-scroll', isOpen);
      });

      links.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
      });

      window.addEventListener('resize', function () {
        if (window.innerWidth > 680) {
          closeMenu();
        }
      });
    });
  });
</script>
