<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $payment->order_id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    @php
        $paidStatuses = ['lunas', 'paid', 'settlement'];
        $processingStatuses = ['process', 'processing', 'on_process', 'onprocess'];
        $waitingStatuses = ['pending', 'unpaid', 'waiting'];
        $cancelStatuses = ['cancel', 'cancelled', 'deny', 'expire'];

        $bookingStatus = strtolower($booking->status ?? '');
        $paymentStatusValue = strtolower($payment->status ?? ($booking->payment_status ?? 'unpaid'));

        $isPaid = in_array($paymentStatusValue, $paidStatuses);
        $isProcessing = in_array($bookingStatus, $processingStatuses);
        $isWaiting = in_array($bookingStatus, $waitingStatuses) || (! $bookingStatus);
        $isCancelled = in_array($bookingStatus, $cancelStatuses) || in_array($paymentStatusValue, $cancelStatuses);
        $isFullySuccess = $bookingStatus === 'success' && $isPaid;
        $isProcessPaid = $isProcessing && $isPaid && ! $isCancelled && ! $isFullySuccess;
        $isFinal = $isFullySuccess || $isCancelled;

        // State untuk stepper
        $stepPaymentDone = $isPaid;
        $stepProcessDone = $isFullySuccess || $isProcessPaid;
        $stepProcessCurrent = $isProcessing && ! $isProcessPaid && ! $isFullySuccess && ! $isCancelled;
        $stepPaymentCurrent = ! $isPaid && ! $isCancelled;
        $stepFinishDone = $isFullySuccess;

        $doneCount = 1; // transaksi dibuat selalu done
        $doneCount += $stepPaymentDone ? 1 : 0;
        $doneCount += $stepProcessDone ? 1 : 0;
        $doneCount += $stepFinishDone ? 1 : 0;
        $isFullySuccess = $isPaid && (
            ($payment->status ?? '') === 'success'
            || ($payment->payment_status ?? '') === 'success'
            || ($booking->payment_status ?? '') === 'success'
        );

        // Tahap progress: 1 = dibuat, 2 = pembayaran, 3 = proses, 4 = selesai
        $progressStage = 2; // default menunggu pembayaran
        if ($isFullySuccess) {
            $progressStage = 4;
        } elseif ($isProcessPaid || $isProcessing) {
            $progressStage = 3;
        } elseif (! $isWaiting) {
            $progressStage = 2;
        }

        $progressWidth = max(0, min(100, (($doneCount - 1) / 3) * 100));
        $paymentLabel = $isCancelled ? 'Unpaid' : ($isPaid ? 'Paid' : 'Unpaid');
        $txnLabel = $isCancelled ? 'Batal' : ($bookingStatus === 'success' ? 'Success' : ($isProcessing ? 'Process' : 'Pending'));
        $message = $isCancelled
            ? 'Transaksi dibatalkan/expired!'
            : ($bookingStatus === 'success'
                ? 'Terima kasih telah melakukan transaksi di Kampung Tematik, ditunggu transaksi selanjutnya!'
                : ($isProcessing ? 'Pesanan anda sedang di proses harap tunggu sebentar !' : 'Pesanan anda sedang di proses!'));
        $paymentMethod = $booking->payment_method ?? ($payment->metode ?? $payment->method ?? null);
        $paymentMethodLabel = $paymentMethod ?: '-';

        $baseTime = $payment->created_at ?? now();
        $expireAt = $baseTime->copy()->addHours(3);
        $remainingSeconds = $isFinal ? 0 : max(0, $expireAt->timestamp - now()->timestamp);
        $isExpiredUnpaid = ! $isPaid && ! $isCancelled && $remainingSeconds <= 0;
        $isHideQr = $isFinal || $isProcessPaid || $isExpiredUnpaid;
        $isHideTimer = $isFinal || $isProcessPaid || $isExpiredUnpaid;
        if ($isExpiredUnpaid) {
            $message = 'Transaksi dibatalkan/expired!';
        }

        $formatSeconds = function ($seconds) {
            $seconds = max(0, (int) $seconds);
            $hrs = floor($seconds / 3600);
            $mins = floor(($seconds % 3600) / 60);
            $secs = $seconds % 60;
            return sprintf('%d Jam %02d Menit %02d Detik', $hrs, $mins, $secs);
        };

        // Ambil kode kunjungan dari booking atau payment (fallback)
        $visitCode = $booking->visit_code ?: $payment->visit_code;
        $isMultipleOf150k5 = ((int) ($payment->total_harga ?? 0)) % 150500 === 0;
        // Tampilkan jika ada kode kunjungan, kecuali total bayar kelipatan 150.500
        $showVisitCode = (bool) $visitCode && ! $isMultipleOf150k5;
        $showSuccessActions = $isPaid && $bookingStatus === 'success';
    @endphp
    
</head>
<body class="invoice-body">
    <nav class="nav-booking invoice-nav">
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

    <main class="page">
        <div class="container">
            <section class="invoice-card">
                <div class="card-head">
                    <h1>Progres Transaksi</h1>
                </div>

                <div class="progress-wrapper">
                    <div class="progress-line"><span style="width:{{ $progressWidth }}%"></span></div>
                    <div class="steps">
                        <div class="step is-done">
                            <div class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="step-title">Transaksi Dibuat</div>
                            <div>Transaksi telah berhasil dibuat</div>
                        </div>
                        <div class="step {{ $stepPaymentDone ? 'is-done' : ($stepPaymentCurrent ? 'is-current' : '') }}">
                            <div class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="step-title">Pembayaran</div>
                            <div>Silahkan melakukan pembayaran</div>
                        </div>
                        <div class="step {{ $stepProcessDone ? 'is-done' : ($stepProcessCurrent ? 'is-current' : '') }}">
                            <div class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 6V12M12 18H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="step-title">Sedang Di Proses</div>
                            <div>Pembelian sedang dalam proses</div>
                        </div>
                        <div class="step {{ $stepFinishDone ? 'is-done' : '' }}">
                            <div class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="step-title">Transaksi Selesai</div>
                            <div>Transaksi telah berhasil dilakukan</div>
                        </div>
                    </div>
                </div>

                @unless($isHideTimer)
                <div class="timer-pill" data-timer data-seconds="{{ $remainingSeconds }}">
                    {{ $formatSeconds($remainingSeconds) }}
                </div>
                @endunless

                <div class="content-grid">
                    <div class="card-block biodata-card">
                        <h3>Biodata</h3>
                        <dl class="info-list">
                            <div class="info-row">
                                <dt>Nama</dt>
                                <dd>: {{ $booking->contact_name }}</dd>
                            </div>
                            <div class="info-row">
                                <dt>Email</dt>
                                <dd>: {{ $booking->contact_email }}</dd>
                            </div>
                            <div class="info-row">
                                <dt>No. HP</dt>
                                <dd>: {{ $booking->contact_phone }}</dd>
                            </div>
                            <div class="info-row">
                                <dt>Tanggal Pemesanan</dt>
                                <dd>: {{ $booking->visit_date?->format('d/m/Y') }}</dd>
                            </div>
                            @php
                                $isTopeng = str_contains(strtolower($booking->package_name ?? ''), 'topeng');
                                $hideVisitDateTopeng = $isTopeng;
                            @endphp
                            @unless($hideVisitDateTopeng)
                            <div class="info-row">
                                <dt>Tanggal Kunjungan</dt>
                                <dd>: <strong>{{ \Illuminate\Support\Carbon::parse($booking->visit_time)->format('d/m/Y') }}</strong></dd>
                            </div>
                            @endunless
                            
                            <div class="info-row">
                                <dt>Layanan</dt>
                                <dd>: {{ $booking->package_name }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="card-block payment-card">
                        <h3>Rincian Pembayaran</h3>
                        <div class="payment-table">
                            <div class="label">Harga Tiket</div>
                            <div class="value">Rp{{ number_format($booking->price, 2, ',', '.') }}</div>

                            <div class="label">Jumlah Tiket</div>
                            <div class="value">{{ $booking->ticket_count }}x</div>

                            <div class="label">Biaya Admin</div>
                            <div class="value">Rp{{ number_format($booking->admin_fee, 2, ',', '.') }}</div>

                            <div class="label total-row">Total Pembayaran</div>
                            <div class="value total-row">Rp{{ number_format($payment->total_harga, 2, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="card-block invoice-meta">
                        @if($showVisitCode)
                        <div class="meta-grid" style="margin-bottom:10px;">
                            <div class="meta-label">Kode Kunjungan</div>
                            <div class="meta-value"><strong>{{ $visitCode }}</strong></div>
                        </div>
                        @endif
                        <div class="meta-grid">
                            <div class="meta-label">Nomor Invoice</div>
                            <div class="meta-value">
                                <span class="copy-wrap">
                                    <strong id="invoiceId">{{ $payment->order_id }}</strong>
                                    <button class="copy-btn" type="button" data-copy="#invoiceId" aria-label="Salin nomor invoice">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="9" y="9" width="11" height="11" rx="2" stroke="currentColor" stroke-width="2"/>
                                            <path d="M6 15H5C3.89543 15 3 14.1046 3 13V5C3 3.89543 3.89543 3 5 3H13C14.1046 3 15 3.89543 15 5V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                            <div class="meta-label">Status Pembayaran</div>
                            <div class="meta-value"><span class="badge {{ $isCancelled ? 'badge-cancel' : ($isPaid ? 'badge-success' : 'badge-unpaid') }}">{{ $paymentLabel }}</span></div>
                            <div class="meta-label">Status Transaksi</div>
                            <div class="meta-value"><span class="badge {{ $isCancelled ? 'badge-cancel' : ($isPaid && $bookingStatus === 'success' ? 'badge-success' : ($isProcessing ? 'badge-process' : 'badge-pending')) }}">{{ $txnLabel }}</span></div>
                            <div class="meta-label">Metode Pembayaran</div>
                            <div class="meta-value">{{ $paymentMethodLabel }}</div>
                        </div>
                        @if($isFullySuccess)
                        <div class="final-banner">
                            <div class="icon" aria-hidden="true">&#10003;</div>
                            <div><strong>Pesanan selesai &amp; pembayaran berhasil.</strong></div>
                        </div>
                        @endif
                        @if($isProcessPaid)
                        <div class="process-banner">
                            <div class="icon" aria-hidden="true">&#10003;</div>
                            <div><strong>Pesanan anda sedang dalam proses!</strong></div>
                        </div>
                        @endif
                        <p class="message" style="margin:6px 0 0;">{{ $message }}</p>

                        @if($isHideQr && $showSuccessActions)
                        <div class="success-actions">
                            <a class="primary" href="{{ url('/booking') }}">Beli Tiket Lagi!</a>
                            <a class="secondary" href="{{ url('/') }}">Beranda</a>
                        </div>
                        @elseif($isHideQr && $isExpiredUnpaid)
                        <div class="success-actions" style="margin-top:10%;">
                            <a class="primary" href="{{ url('/booking') }}">Beli Tiket Lagi!</a>
                            <a class="secondary" href="{{ url('/') }}">Beranda</a>
                        </div>
                        @elseif(! $isHideQr)
                        <div class="qr-panel">
                            <div class="qr-box">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($payment->order_id) }}" alt="Kode QR pembayaran">
                            </div>
                            <a class="btn-download" href="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ urlencode($payment->order_id) }}" download="qr-{{ $payment->order_id }}.png">
                                Unduh Kode QR
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="invoice-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h4>Kampung Tematik Malang</h4>
                    <p>Kampung Tematik Malang merupakan wadah informasi dan promosi wisata kreatif di Kota Malang yang menampilkan keindahan, inovasi, serta kearifan lokal dari berbagai kampung unggulan.</p>
                </div>
                <div>
                    <h4>Menu</h4>
                    <ul class="footer-list">
                        <li><a href="#sejarah">Sejarah</a></li>
                        <li><a href="#maps">Maps</a></li>
                        <li><a href="#visi">Visi &amp; Misi</a></li>
                        <li><a href="#tujuan">Tujuan &amp; Fungsi</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Informasi</h4>
                    <ul class="footer-list">
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
        </div>
    </footer>

    <script>
        (function(){
            const timerEl = document.querySelector('[data-timer]');
            if(!timerEl) return;
            let remaining = parseInt(timerEl.dataset.seconds || '0', 10);

            const format = (seconds) => {
                const hrs = Math.floor(seconds / 3600);
                const mins = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                return `${hrs} Jam ${mins.toString().padStart(2,'0')} Menit ${secs.toString().padStart(2,'0')} Detik`;
            };

            const tick = () => {
                timerEl.textContent = format(Math.max(0, remaining));
                if (remaining <= 0) return;
                remaining -= 1;
                setTimeout(tick, 1000);
            };
            tick();
        })();

        (function(){
            const copyBtn = document.querySelector('[data-copy]');
            if(copyBtn){
                copyBtn.addEventListener('click', async () => {
                    const target = document.querySelector(copyBtn.dataset.copy);
                    if(!target) return;
                    const text = target.textContent.trim();
                    try{
                        await navigator.clipboard.writeText(text);
                        const toast = document.createElement('div');
                        toast.className = 'copy-toast';
                        toast.innerHTML = `
                            <div class="icon">✓</div>
                            <div>Berhasil di copy ke clipboard!</div>
                        `;
                        document.body.appendChild(toast);
                        requestAnimationFrame(() => toast.classList.add('show'));
                        setTimeout(() => {
                            toast.classList.remove('show');
                            setTimeout(() => toast.remove(), 250);
                        }, 1800);
                    }catch(e){
                        alert('Gagal menyalin');
                    }
                });
            }
        })();

        (function(){
            const isFullySuccess = {{ $isFullySuccess ? 'true' : 'false' }};
            if (isFullySuccess) return;
            setInterval(() => {
                window.location.reload();
            }, 15000);
        })();

        (function(){
            const toastMessage = localStorage.getItem('bookingSuccessToast');
            if(!toastMessage) return;
            const toast = document.createElement('div');
            toast.className = 'toast-success';
            toast.innerHTML = `
                <div class="toast-icon">✓</div>
                <div class="toast-text">${toastMessage}</div>
                <div class="toast-confetti"></div>
            `;
            document.body.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('show'));
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 250);
            }, 5000);
            localStorage.removeItem('bookingSuccessToast');
        })();

        (function(){
            document.querySelectorAll('.final-banner .icon, .process-banner .icon').forEach(el => {
                el.textContent = '\u2713';
            });
        })();

        (function(){
            const nav = document.querySelector('.invoice-nav');
            if(!nav) return;
            const toggle = nav.querySelector('.nav-toggle');
            const links = nav.querySelector('.nav-links');
            if (!toggle || !links) return;

            const closeMenu = () => {
                links.classList.remove('is-open');
                toggle.classList.remove('is-open');
                toggle.setAttribute('aria-expanded','false');
                document.body.classList.remove('no-scroll');
            };

            toggle.addEventListener('click', () => {
                const isOpen = links.classList.toggle('is-open');
                toggle.classList.toggle('is-open', isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                document.body.classList.toggle('no-scroll', isOpen);
            });

            links.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
            window.addEventListener('resize', () => { if (window.innerWidth > 680) closeMenu(); });
        })();

    </script>
</body>
</html>




