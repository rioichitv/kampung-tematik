<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pesanan</title>
  <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer-simple.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="history-body">
  <main class="history-main">
    <header class="history-header">
      <div class="history-header__brand">KAMPUNG TEMATIK MALANG</div>
      <div class="history-header__links">
        <a href="{{ route('booking.history') }}">Riwayat Pesanan</a>
        <a href="{{ url('/') }}">Kembali ke Awal</a>
        <a class="home-btn" href="{{ url('/') }}" aria-label="Beranda">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 10.5L12 3.5L20 10.5V20H14V14H10V20H4V10.5Z" stroke="#0f2a1d" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    </header>

    <section class="hero">
      <div class="hero-aurora" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
      </div>
      <div class="hero-inner">
        <div class="hero-head">
          <h1>Cek Invoice Kamu dengan Mudah dan Cepat</h1>
          <p>Lihat detail pembelian kamu menggunakan nomor Invoice.</p>
        </div>
        <div class="search-shell">
          <h3>Cari detail pembelian kamu disini</h3>
          <form action="{{ route('booking.history.search') }}" method="POST" class="search-form">
            @csrf
            <div class="input-wrap">
              <input type="text" name="invoice_code" value="{{ old('invoice_code') }}" placeholder="Masukkan nomor Invoice Kamu (Contoh: DSXXXXXXXXXXXXXX)" required>
              <button type="submit" class="btn-icon" aria-label="Cari">
                <svg width="20" height="20" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.4" d="M11.1384 21L8.96382 20.1117C8.49095 19.919 7.95874 19.9346 7.49852 20.1545L6.72695 20.5232C5.91647 20.9115 4.97852 20.3199 4.97949 19.4209L4.98922 6.98335C4.98922 4.52368 6.35722 3 8.81203 3H16.2202C18.6819 3 20.0197 4.52368 20.0197 6.98335V11.2742" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M19.0011 19.4999L20.3931 20.8899M16.8328 14.9844C18.3195 14.9844 19.5241 16.1899 19.5241 17.6766C19.5241 19.1623 18.3195 20.3678 16.8328 20.3678C15.3461 20.3678 14.1406 19.1623 14.1406 17.6766C14.1406 16.1899 15.3461 14.9844 16.8328 14.9844Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M14.6057 9.00781H9.63672M12.1226 12.8679H9.63862" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </button>
            </div>
            <button type="submit" class="btn-search">
              <svg width="20" height="20" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4" d="M11.1384 21L8.96382 20.1117C8.49095 19.919 7.95874 19.9346 7.49852 20.1545L6.72695 20.5232C5.91647 20.9115 4.97852 20.3199 4.97949 19.4209L4.98922 6.98335C4.98922 4.52368 6.35722 3 8.81203 3H16.2202C18.6819 3 20.0197 4.52368 20.0197 6.98335V11.2742" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M19.0011 19.4999L20.3931 20.8899M16.8328 14.9844C18.3195 14.9844 19.5241 16.1899 19.5241 17.6766C19.5241 19.1623 18.3195 20.3678 16.8328 20.3678C15.3461 20.3678 14.1406 19.1623 14.1406 17.6766C14.1406 16.1899 15.3461 14.9844 16.8328 14.9844Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M14.6057 9.00781H9.63672M12.1226 12.8679H9.63862" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <span>Cari Invoice</span>
            </button>
          </form>
        </div>
      </div>
    </section>

    <section class="table-section">
      <div class="table-head">
        <div class="title">Transaksi Terakhir</div>
        <p>Berikut ini Terakhir data pesanan masuk terbaru.</p>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nomor Invoice</th>
              <th>No. Handphone</th>
              <th>Harga</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @php
              use Illuminate\Support\Str;
              use Illuminate\Support\Carbon;
            @endphp
            @forelse($recentBookings as $booking)
              @php
                $payment = $booking->payments->first();
                $orderId = $payment->order_id ?? $booking->order_id;
                $price = $booking->total_amount ?? $payment->total_harga ?? 0;
                $status = strtoupper($booking->status ?? $payment->status ?? 'PENDING');
                $statusClass = $status === 'SUCCESS' ? 'badge-success' : ($status === 'PENDING' ? 'badge-pending' : ($status === 'CANCEL' ? 'badge-cancel' : 'badge-default'));
                $phone = $booking->contact_phone;
                $maskedPhone = $phone ? Str::mask($phone, '*', 0, max(0, strlen($phone) - 4)) : '-';
              @endphp
              <tr>
                <td>{{ $booking->created_at?->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>
                <td>{{ $orderId }}</td>
                <td>{{ $maskedPhone }}</td>
                <td>Rp{{ number_format($price, 0, ',', '.') }}</td>
                <td><span class="badge {{ $statusClass }}">{{ $status }}</span></td>
              </tr>
            @empty
              <tr><td colspan="5" class="empty">Belum ada pesanan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>
  </main>

  @if(session('invoice_not_found'))
    <div class="toast toast-error" id="toastNotFound">
      <span class="icon">✖</span>
      <span>Kode Invoice Tidak Ditemukan!</span>
    </div>
    <script>
      setTimeout(() => {
        const toast = document.getElementById('toastNotFound');
        if (toast) toast.remove();
      }, 3500);
    </script>
  @endif
  
  @include('partials.footer-simple')
</body>
</html>
