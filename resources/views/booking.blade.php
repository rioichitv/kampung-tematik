<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Kunjungan</title>
  <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SzlrxWriC3LLJ5/3nCDP9t6k4VJ6ECpQ0jO1SWNE1K+nJo3N3vrL1jH7Q+X5f5pX1zPW/M1N8P3kYxZyZG7xsg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .toast-warning{
      position:fixed; top:18px; left:50%; transform:translate(-50%,-8px);
      z-index:3200; background:#fff; color:#111827; border:1px solid #fca5a5;
      padding:10px 16px; border-radius:14px; box-shadow:0 10px 20px rgba(0,0,0,.12);
      opacity:0; transition:opacity .2s ease, transform .2s ease;
      font-weight:700; font-size:15px; white-space:nowrap;
      display:flex; align-items:center; gap:8px;
    }
    .toast-warning .icon{
      width:22px; height:22px; border-radius:50%; background:#ef4444; color:#fff;
      display:grid; place-items:center; font-weight:700; font-size:14px;
      box-shadow:0 6px 12px rgba(239,68,68,.35);
      flex-shrink:0;
    }
    .toast-warning.show{opacity:1; transform:translate(-50%,0);}
    .cta.cta-disabled{opacity:0.6; cursor:not-allowed;}
    .toast-success-booking{
      position:fixed; top:18px; left:50%; transform:translate(-50%,-8px);
      z-index:3200; background:#ffffff; color:#111827; border:1px solid #c7e7cf;
      padding:10px 16px; border-radius:14px; box-shadow:0 10px 20px rgba(0,0,0,.12);
      opacity:0; transition:opacity .2s ease, transform .2s ease;
      font-weight:700; font-size:15px; white-space:nowrap;
      display:flex; align-items:center; gap:8px;
    }
    .toast-success-booking .icon{
      width:22px; height:22px; border-radius:50%; background:#22c55e; color:#fff;
      display:grid; place-items:center; font-weight:700; font-size:14px;
      box-shadow:0 6px 12px rgba(34,197,94,.35);
      flex-shrink:0;
    }
    .toast-success-booking.show{opacity:1; transform:translate(-50%,0);}
  </style>
</head>
<body class="booking-body">
  @php use Illuminate\Support\Str; @endphp
  @include('kampung.partials.navbar-booking')

  <main class="booking-main booking-two-col">
    <div class="form-card">
      <form id="bookingForm" novalidate>
        @csrf
        <h3>Biodata</h3>
        <div class="field"><input type="text" name="name" placeholder="Nama Lengkap" required></div>
        <div class="field with-icon">
          <small class="note strong">Tanggal anda pesan otomatis terisi!</small>
          <input type="date" name="booking_date" value="{{ now()->format('Y-m-d') }}" required readonly>
          <i class="fa-regular fa-calendar"></i>
        </div>
        <div class="field with-icon">
          <small class="note strong">Tanggal kunjungan yang diinginkan.</small>
          <input type="date" name="visit_date" required>
          <i class="fa-regular fa-calendar"></i>
        </div>
        <div class="field"><input type="email" name="email" placeholder="Email" required></div>
        <div class="field"><input type="tel" name="phone" placeholder="No. HP" required></div>

        <div class="section">
          <label for="packageSelect">Pilih Kampung</label>
          <select id="packageSelect" name="package_name" required>
            <option value="">Pilih Kampung</option>
            <option value="1000 Topeng">1000 Topeng</option>
            <option value="Glintung Go-Green">Glintung Go-Green</option>
            <option value="Warna-Warni Jodipan">Warna-Warni Jodipan</option>
            <option value="Biru Arema">Biru Arema</option>
          </select>
          <small class="note">Pilih destinasi kampung yang ingin dikunjungi.</small>
        </div>

        <div class="section">
          <label>Jumlah Tiket</label>
          <div class="ticket-row">
            <input id="ticketCount" name="ticket_count" type="number" min="0" value="0" readonly>
            <div class="ticket-actions">
              <button type="button" class="btn-minus" aria-label="Kurangi tiket">-</button>
              <button type="button" class="btn-plus" aria-label="Tambah tiket">+</button>
            </div>
          </div>
          <div class="ticket-note">Harga 1 tiket: Rp 10.000</div>
        </div>

        <div class="section">
          <label>Pilih Pembayaran</label>
          @php
            $logoMap = [
              'qris' => 'qris.webp',
              'bni' => 'bni.webp',
              'bca' => 'bca.webp',
              'mandiri' => 'mandiri.webp',
              'cimb' => 'cimb.webp',
              'dana' => 'dana.webp',
              'Gopay' => 'Gopay.webp',
              'linkaja-payment' => 'linkaja-payment.webp',
              'ovo' => 'ovo.webp',
              'bsi' => 'bsi.webp',
              'permata' => 'permata.webp',
              'alfamart' => 'alfamart.webp',
            ];
            $payCategories = [
              'QRIS' => [
                ['label' => 'QRIS', 'logo' => 'qris'],
              ],
              'E-Wallet' => [
                ['label' => 'LinkAja', 'logo' => 'linkaja-payment'],
                ['label' => 'DANA', 'logo' => 'dana'],
                ['label' => 'OVO', 'logo' => 'ovo'],
                ['label' => 'Gopay', 'logo' => 'Gopay'],
              ],
              'Transfer Bank' => [
                ['label' => 'BSI Transfer', 'logo' => 'bsi'],
                ['label' => 'CIMB Niaga Transfer', 'logo' => 'cimb'],
                ['label' => 'BNI Transfer', 'logo' => 'bni'],
                ['label' => 'Mandiri Transfer', 'logo' => 'mandiri'],
                ['label' => 'Permata Transfer', 'logo' => 'permata'],
              ],
              'Virtual Account' => [
                ['label' => 'Mandiri VA', 'logo' => 'mandiri'],
                ['label' => 'Permata VA', 'logo' => 'permata'],
                ['label' => 'CIMB VA', 'logo' => 'cimb'],
                ['label' => 'BNI VA', 'logo' => 'bni'],
                ['label' => 'BSI VA', 'logo' => 'bsi'],
                ['label' => 'BCA VA', 'logo' => 'bca'],
              ],
              'Convenience Store' => [
                ['label' => 'Alfamart', 'logo' => 'alfamart'],
              ],
            ];
          @endphp
          <div class="pay-accordion" id="payAccordion">
            @foreach($payCategories as $categoryName => $items)
              @php
                $slug = Str::slug($categoryName, '-');
              @endphp
              <div class="pay-accordion__item" data-category="{{ $categoryName }}">
                <button type="button" class="pay-accordion__header">
                  <span>{{ $categoryName }}</span>
                  <span class="chevron">⌄</span>
                </button>
                @if(count($items) > 1 || ($items[0]['logo'] ?? null))
                  <div class="pay-logo-bar">
                    @foreach($items as $item)
                      @if(isset($logoMap[$item['logo']]))
                        <img src="{{ asset('images/payment/'.$logoMap[$item['logo']]) }}" alt="{{ $item['label'] }}">
                      @endif
                    @endforeach
                  </div>
                @endif
                <div class="pay-accordion__body">
                  <div class="pay-grid">
                    @foreach($items as $item)
                      <button type="button" class="pay-option-card" data-method="{{ $item['label'] }}">
                        @if(isset($logoMap[$item['logo']]))
                          <div class="pay-card-logo">
                            <img src="{{ asset('images/payment/'.$logoMap[$item['logo']]) }}" alt="{{ $item['label'] }}">
                          </div>
                        @endif
                        <div class="pay-card-price" data-price>Rp0</div>
                        <div class="pay-option__meta">Dicek Otomatis</div>
                      </button>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <input type="hidden" name="payment_method" id="paymentMethod">
        </div>

        <div class="summary">
          <div class="summary-row">
            <span>Layanan</span>
            <span id="summaryPackage" class="muted">Pilih Kampung</span>
          </div>
          <div class="summary-row">
            <span>Metode Pembayaran</span>
            <span id="summaryMethod" class="muted">Pilih Metode</span>
          </div>
          <div class="summary-row">
            <span>Jumlah Tiket</span>
            <span id="summaryCount">0x</span>
          </div>
          <div class="summary-row">
            <span>Biaya Admin</span>
            <span id="summaryAdmin">Rp0,00</span>
          </div>
          <div class="summary-row total">
            <span>Total Pembayaran</span>
            <span id="summaryTotal">Rp0,00</span>
          </div>
        </div>

        <button id="btnSubmit" class="cta" type="submit">Pesan Sekarang!</button>
      </form>
    </div>

    <aside class="booking-aside">
      <a class="help-card" href="https://api.whatsapp.com/send/?phone=6281317815664&text=Bantu%20Saya%20Bingung%20Pesan%20Tiket%20Kunjungan%20di%20Website%20Kampung%20Tematik&type=phone_number&app_absent=0" target="_blank" rel="noopener">
        <div class="help-icon" aria-hidden="true">
          <svg width="32" height="32" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.67151 19.7552C6.19123 20.657 7.34509 20.9653 8.24587 20.4446C9.14569 19.9239 9.45403 18.773 8.93431 17.8722L7.35188 15.1301C6.83216 14.2293 5.68121 13.92 4.77946 14.4397L4.55838 14.5667C3.99309 14.8935 3.70802 15.5645 3.90097 16.188C4.24422 17.2991 4.83278 18.4947 5.67151 19.7552Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.3415 19.7552C18.8217 20.657 17.6679 20.9653 16.7671 20.4446C15.8673 19.9239 15.559 18.773 16.0787 17.8722L17.6611 15.1301C18.1808 14.2293 19.3318 13.92 20.2335 14.4397L20.4546 14.5667C21.0199 14.8935 21.305 15.5645 21.112 16.188C20.7688 17.2991 20.1802 18.4947 19.3415 19.7552Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.10793 7.83938C5.62506 7.3565 5.595 6.56917 6.0643 6.07272C6.1186 6.01551 6.17387 5.9583 6.23107 5.90109C9.69555 2.43661 15.3116 2.43661 18.7761 5.90109C18.8323 5.95733 18.8866 6.01357 18.9409 6.07078C19.4112 6.5682 19.3812 7.35747 18.8973 7.84132C18.3844 8.35425 17.5612 8.3271 17.0589 7.8035C17.0288 7.77247 16.9988 7.74145 16.9678 7.71042C14.502 5.23496 10.5062 5.23496 8.0307 7.71042C8.00064 7.74048 7.97156 7.77053 7.9415 7.80156C7.4402 8.32322 6.61989 8.35134 6.10793 7.83938Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path opacity="0.4" d="M19.1426 7.48242C20.6096 9.08425 21.5007 11.2077 21.5007 13.5474C21.5007 14.3939 21.3834 15.2133 21.1584 15.987" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path opacity="0.4" d="M3.88688 16.1218C3.62605 15.3112 3.5 14.4385 3.5 13.5474C3.5 11.2077 4.39109 9.08425 5.85813 7.48242" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
        </div>
        <div>
          <div class="help-title">Butuh Bantuan?</div>
          <div class="help-text">Kamu bisa hubungi admin disini.</div>
        </div>
      </a>
    </aside>
  </main>

  @include('kampung.partials.footer-booking')

  <div class="booking-modal" id="confirmModal" aria-hidden="true">
    <div class="booking-modal__overlay"></div>
    <div class="booking-modal__dialog">
      <button class="booking-modal__close" type="button" aria-label="Tutup">×</button>
      <div class="booking-modal__icon">⏰</div>
      <h4>Berhasil Membuat Pesanan</h4>
      <p class="booking-modal__desc">Pastikan data yang Anda masukkan valid dan sesuai.</p>
      <div class="booking-modal__summary">
        <div><strong>Layanan</strong><span id="modalPackage">-</span></div>
        <div><strong>Metode Pembayaran</strong><span id="modalMethod">-</span></div>
        <div><strong>Jumlah Tiket</strong><span id="modalTickets">-</span></div>
        <div><strong>Biaya Admin</strong><span id="modalAdmin">-</span></div>
        <div><strong>Total Pembayaran</strong><span id="modalTotal">-</span></div>
      </div>
      <div class="booking-modal__actions">
        <button id="modalPay" type="button" class="primary">Bayar Sekarang!</button>
        <button type="button" class="modal-edit__close secondary">Batal Pesanan</button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ticketPrice = 10000;
      const adminFee = 500;
      let selectedMethod = '';
      let selectedPackage = '';
      let latestInvoiceUrl = null;

      const form = document.getElementById('bookingForm');
      const countInput = document.getElementById('ticketCount');
      const packageSelect = document.getElementById('packageSelect');
      const summaryPackage = document.getElementById('summaryPackage');
      const summaryMethod = document.getElementById('summaryMethod');
      const summaryCount = document.getElementById('summaryCount');
      const summaryAdmin = document.getElementById('summaryAdmin');
      const summaryTotal = document.getElementById('summaryTotal');
      const btnSubmit = document.getElementById('btnSubmit');
      const paymentMethodInput = document.getElementById('paymentMethod');
      const payAccordion = document.getElementById('payAccordion');

      const modal = document.getElementById('confirmModal');
      const modalPackage = document.getElementById('modalPackage');
      const modalMethod = document.getElementById('modalMethod');
      const modalTickets = document.getElementById('modalTickets');
      const modalAdmin = document.getElementById('modalAdmin');
      const modalTotal = document.getElementById('modalTotal');
      const modalPay = document.getElementById('modalPay');
      const nameInput = form.querySelector('input[name="name"]');
      const emailInput = form.querySelector('input[name="email"]');
      const phoneInput = form.querySelector('input[name="phone"]');
      const visitDateInput = form.querySelector('input[name="visit_date"]');
      let isSubmitting = false;
      selectedPackage = packageSelect.value.trim();

      function showBaseToast(content) {
        const existing = document.querySelector('.toast-warning');
        if (existing) {
          existing.remove();
        }
        const toast = document.createElement('div');
        toast.className = 'toast-warning';
        toast.innerHTML = `<span class="icon">!</span><span>${content}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
          toast.classList.remove('show');
          setTimeout(() => toast.remove(), 250);
        }, 5000);
      }

      function showSuccessToast(message) {
        const existing = document.querySelector('.toast-success-booking');
        if (existing) {
          existing.remove();
        }
        const toast = document.createElement('div');
        toast.className = 'toast-success-booking';
        toast.innerHTML = `<span class="icon">✓</span><span>${message}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
          toast.classList.remove('show');
          setTimeout(() => toast.remove(), 250);
        }, 5000);
      }

      function showWarningToast(label) {
        showBaseToast(`Lengkapi: ${label}`);
      }

      function formatRupiah(num) {
        return 'Rp' + num.toLocaleString('id-ID') + ',00';
      }

      function updateCardPrices(total) {
        document.querySelectorAll('.pay-card-price').forEach(el => {
          el.textContent = total ? formatRupiah(total) : '-';
        });
      }

      function updateSummary() {
        const count = parseInt(countInput.value, 10) || 0;
        const hasPackage = Boolean(selectedPackage);
        summaryCount.textContent = `${count}x`;
        const total = (count * ticketPrice) + (count > 0 ? adminFee : 0);
        summaryTotal.textContent = formatRupiah(total);
        summaryAdmin.textContent = count > 0 ? formatRupiah(adminFee) : 'Rp0,00';
        summaryPackage.textContent = hasPackage ? selectedPackage : 'Pilih Kampung';
        summaryPackage.classList.toggle('muted', !hasPackage);
        btnSubmit.disabled = false;
        updateCardPrices(total);
        updateCtaVisual();
      }

      document.querySelector('.btn-plus').addEventListener('click', function () {
        countInput.value = Math.max(0, parseInt(countInput.value, 10) + 1);
        updateSummary();
      });

      document.querySelector('.btn-minus').addEventListener('click', function () {
        countInput.value = Math.max(0, parseInt(countInput.value, 10) - 1);
        updateSummary();
      });

      [nameInput, emailInput, phoneInput, visitDateInput].forEach(input => {
        input.addEventListener('input', updateCtaVisual);
      });

      payAccordion?.querySelectorAll('.pay-option-card').forEach(function (btn) {
        btn.addEventListener('click', function () {
          payAccordion.querySelectorAll('.pay-option-card').forEach(el => el.classList.remove('active'));
          btn.classList.add('active');
          selectedMethod = btn.dataset.method || '';
          summaryMethod.textContent = selectedMethod || 'Pilih Metode';
          summaryMethod.classList.toggle('muted', !selectedMethod);
          paymentMethodInput.value = selectedMethod;
          updateSummary();
        });
      });

      payAccordion?.querySelectorAll('.pay-accordion__header').forEach(function (header) {
        header.addEventListener('click', function () {
          const item = header.closest('.pay-accordion__item');
          const isOpen = item.classList.contains('is-open');
          payAccordion.querySelectorAll('.pay-accordion__item').forEach(el => el.classList.remove('is-open'));
          if (!isOpen) {
            item.classList.add('is-open');
          } else {
            item.classList.remove('is-open');
          }
          updateCtaVisual();
        });
      });

      packageSelect.addEventListener('change', () => {
        selectedPackage = packageSelect.value.trim();
        updateSummary();
      });

      function getFirstMissing() {
        if (!nameInput.value.trim()) return { target: nameInput, label: 'Nama' };
        if (!emailInput.value.trim()) return { target: emailInput, label: 'Email' };
        if (!phoneInput.value.trim()) return { target: phoneInput, label: 'No. HP' };
        if (!visitDateInput.value) return { target: visitDateInput, label: 'Tanggal Kunjungan' };
        if (!selectedPackage) return { target: packageSelect, label: 'Layanan' };
        if (!selectedMethod) return { target: payAccordion.querySelector('.pay-accordion__header'), label: 'Metode Pembayaran' };
        const count = parseInt(countInput.value, 10) || 0;
        if (count === 0) return { target: countInput, label: 'Jumlah Tiket' };
        return null;
      }

      function updateCtaVisual() {
        btnSubmit.classList.toggle('cta-disabled', Boolean(getFirstMissing()));
      }
      function openModal(summary) {
        modalPackage.textContent = summary.package_name || '-';
        modalMethod.textContent = summary.method || '-';
        modalTickets.textContent = summary.tickets + 'x';
        modalAdmin.textContent = formatRupiah(summary.admin_fee);
        modalTotal.textContent = formatRupiah(summary.total);
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }

      modal.querySelector('.booking-modal__close').addEventListener('click', closeModal);
      modal.querySelector('.secondary').addEventListener('click', closeModal);
      modal.querySelector('.booking-modal__overlay').addEventListener('click', closeModal);

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (isSubmitting) return;
        const missing = getFirstMissing();
        if (missing) {
          showWarningToast(missing.label);
          if (missing.target && typeof missing.target.focus === 'function') {
            missing.target.focus();
          }
          if (missing.target && typeof missing.target.scrollIntoView === 'function') {
            missing.target.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
          updateCtaVisual();
          return;
        }
        const formData = new FormData(form);
        try {
          isSubmitting = true;
          btnSubmit.disabled = true;
          const res = await fetch("{{ route('booking.store') }}", {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': formData.get('_token'),
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: formData,
          });
          let json = null;
          try { json = await res.json(); } catch (_) {}
          if (!res.ok || !json || !json.success) {
            const firstError = json && json.errors ? Object.values(json.errors)[0][0] : (json && json.message ? json.message : 'Gagal membuat pesanan');
            throw new Error(firstError);
          }
          latestInvoiceUrl = json.snap_redirect_url || json.invoice_url;
          if (json.snap_redirect_url) {
            window.location.href = json.snap_redirect_url;
            return;
          }
          openModal(json.summary);
        } catch (err) {
          showWarningToast(err.message || 'Terjadi kesalahan');
        } finally {
          isSubmitting = false;
          btnSubmit.disabled = false;
        }
      });

      modalPay.addEventListener('click', () => {
        if (latestInvoiceUrl) {
          const message = 'Pembelian berhasil, silakan lakukan pembayaran.';
          showSuccessToast(message);
          localStorage.setItem('bookingSuccessToast', message);
          setTimeout(() => { window.location.href = latestInvoiceUrl; }, 300);
        }
      });

      // Buka picker saat field tanggal diklik
      document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('click', () => {
          if (typeof input.showPicker === 'function') {
            input.showPicker();
          }
        });
      });

      updateSummary();
    });
  </script>
</body>
</html>
