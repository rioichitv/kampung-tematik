<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Produk - Kampung 1000 Topeng</title>
  <link rel="stylesheet" href="{{ asset('css/csstopeng.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    .booking-modal{
      position:fixed; inset:0; display:flex; align-items:center; justify-content:center;
      z-index:3000; pointer-events:none; opacity:0; transition:opacity .2s ease;
    }
    .booking-modal.show{pointer-events:auto; opacity:1;}
    .booking-modal__overlay{
      position:absolute; inset:0; background:rgba(0,0,0,.45); opacity:0; transition:opacity .2s ease;
    }
    .booking-modal.show .booking-modal__overlay{opacity:1;}
    .booking-modal__dialog{
      position:relative; background:#fff; border-radius:14px; padding:20px 20px 16px; width:380px; max-width:90%;
      box-shadow:0 18px 40px rgba(0,0,0,.18); transform:translateY(12px); transition:transform .2s ease;
      z-index:1; font-family:"Poppins",sans-serif;
    }
    .booking-modal.show .booking-modal__dialog{transform:translateY(0);}
    .booking-modal__close{
      position:absolute; top:10px; right:10px; border:none; background:#f3f4f6; width:28px; height:28px;
      border-radius:50%; cursor:pointer; font-weight:700; color:#4b5563;
    }
    .booking-modal__icon{font-size:30px; text-align:center; margin-top:6px;}
    .booking-modal__desc{text-align:center; color:#6b7280; margin:0 0 10px;}
    .booking-modal__summary{display:grid; grid-template-columns:1.2fr 1fr; row-gap:8px; column-gap:10px; margin:10px 0;}
    .booking-modal__summary strong{color:#111827;}
    .booking-modal__summary span{color:#111827; text-align:right;}
    .booking-modal__actions{display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:8px;}
    .booking-modal__actions .primary{background:#0f2a1d; color:#fff; border:none; border-radius:8px; padding:10px; font-weight:700; cursor:pointer;}
    .booking-modal__actions .secondary{background:#e5e7eb; color:#374151; border:none; border-radius:8px; padding:10px; font-weight:700; cursor:pointer;}
    .btn-primary{
      width:100%; margin-top:12px; padding:12px 0;
      border:1px solid #1f3524; border-radius:8px;
      background:#1f3524; color:#fff; font-weight:700; font-size:13px;
      cursor:not-allowed; opacity:0.6; transition:opacity .2s ease, filter .2s ease;
    }
    .btn-primary.is-active{cursor:pointer; opacity:1;}
    .btn-primary.is-active:hover{filter:brightness(1.05);}
    .toast-warning{
      position:fixed; top:18px; left:50%; transform:translate(-50%,-8px);
      z-index:3200; background:#fff; color:#111827; border:1px solid #fca5a5;
      padding:10px 16px; border-radius:14px; box-shadow:0 10px 20px rgba(0,0,0,.12);
      opacity:0; transition:opacity .2s ease, transform .2s ease;
      font-weight:700; display:flex; align-items:center; gap:8px;
    }
    .toast-warning .icon{
      width:22px; height:22px; border-radius:50%; background:#ef4444; color:#fff;
      display:grid; place-items:center; font-weight:700; font-size:14px;
      box-shadow:0 6px 12px rgba(239,68,68,.35);
      flex-shrink:0;
    }
    .toast-warning.show{opacity:1; transform:translate(-50%,0);}
    .field-error{
      display:none;
      color:#b91c1c;
      font-size:12px;
      margin-top:4px;
    }
    .field-error.show{display:block;}
    .pay-accordion{display:grid; gap:10px;}
    .pay-accordion__item{
      width:100%; display:flex; flex-direction:column; justify-content:space-between;
      border:1px solid #d7d7d7; border-radius:12px; overflow:hidden; background:#fff;
      transition:transform .45s ease, box-shadow .45s ease;
    }
    .pay-accordion__item:hover{transform:translateY(-1px); box-shadow:0 8px 20px rgba(0,0,0,.08);}
    .pay-accordion__header{
      width:100%; border:none; background:#f1f3f5; color:#1f2d1f;
      display:flex; align-items:center; justify-content:space-between;
      padding:10px 12px; font-weight:700; cursor:pointer;
    }
    .pay-accordion__body{padding:10px 12px; display:none;}
    .pay-accordion__body{
      max-height:0; overflow:hidden; transition:max-height .5s ease, opacity .5s ease; opacity:0;
    }
    .pay-accordion__item.is-open .pay-accordion__body{display:block; max-height:1200px; opacity:1;}
    .pay-accordion__item .chevron{transition:transform .2s ease;}
    .pay-accordion__item.is-open .chevron{transform:rotate(180deg);}
    .pay-accordion__item.is-open .pay-logo-bar{display:none;}
    .pay-logo-bar{
      background:#3a3d42; padding:8px 12px; display:flex; gap:8px; flex-wrap:wrap;
      align-items:center; justify-content:flex-start; border-top:1px solid #303338;
    }
    .pay-logo-bar img{height:18px; object-fit:contain;}
    .pay-grid{
      display:grid; grid-template-columns:repeat(auto-fill, minmax(160px,1fr)); gap:10px;
    }
    .pay-option-card{
      border:1px solid #d7d7d7; border-radius:12px; padding:10px 10px 12px; background:#fff;
      color:#1f2d1f; text-align:left; cursor:pointer;
      transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease; width:100%;
    }
    .pay-option-card:hover{transform:translateY(-1px); box-shadow:0 8px 18px rgba(0,0,0,.18);}
    .pay-option-card.active{border-color:#4f6cf0; box-shadow:0 0 0 2px rgba(79,108,240,0.25);}
    .pay-card-logo{width:100%; display:flex; justify-content:flex-start; align-items:center; margin-bottom:8px;}
    .pay-card-logo img{height:36px; object-fit:contain;}
    .pay-card-price{font-weight:700; margin-bottom:4px; border-bottom:1px dashed #3b3d42; padding-bottom:6px;}
    .pay-option__meta{font-size:12px; color:#6a7a6d;}
    .qty-row{display:flex; align-items:center; gap:10px; margin-bottom:14px;}
    .qty-row label{font-weight:700; color:#1f2d1f; width:100%;}
    .qty-control{display:flex; align-items:center; gap:10px; width:100%;}
    .qty-display{
      flex:1; padding:12px; border:1px solid #d7d7d7; border-radius:8px;
      background:#f8f8f8; font-size:14px;
    }
    .qty-btn{
      width:44px; height:44px; border:none; border-radius:8px; background:#0f2a1d; color:#fff;
      font-size:18px; font-weight:700; cursor:pointer; display:grid; place-items:center;
    }
    .qty-btn:disabled{opacity:0.6; cursor:not-allowed;}
  </style>
</head>
<body class="checkout-body">
  @php
    $cartSvg = '<svg viewBox="0 0 24 24" aria-hidden="true" class="icon-cart"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2Zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2Zm-9.83-4.75 11.07-1.08c.58-.06 1.08-.5 1.18-1.08l.82-4.68c.12-.66-.4-1.26-1.08-1.26H6.21L5.89 3.5H3v1.5h1.5l1.6 8.32c-.61.36-1.02 1.02-1.02 1.78 0 1.12.9 2.02 2.02 2.02h11.98V15H7.43c-.14 0-.25-.11-.25-.25 0-.13.09-.23.21-.25Z"/></svg>';
    $productName = request('product','Topeng Raden Panji');
    $imageMap = [
      'topeng raden panji' => 'images/TopengRadenPanji.jpg',
      'topeng buto jawa' => 'images/TopengButoJawa.jpg',
      'topeng bali' => 'images/TopengBali.jpg',
      'topeng jawa' => 'images/TopengJawa.jpg',
      'topeng rumyang' => 'images/TopengRumyan.jpg',
      'topeng panji cirebon' => 'images/TopengPanjiCirebon.jpg',
      'topeng bali emas' => 'images/TopengBali.jpg',
      'topeng buto malangan' => 'images/TopengButoMalangan.jpg',
      'topeng panji semirang batik' => 'images/TopengPanjiSemirangBatik.jpg',
      'baju topeng malangan' => 'images/bajutopengmalangan.jpg',
      'topeng malangan' => 'images/topengmalangan.jpg',
      'topeng ornamen' => 'images/topengornamen.jpg',
    ];
    $productImage = $imageMap[strtolower($productName)] ?? request('image', default: 'images/topeng-galeri2.jpg');
    $productPriceRaw = (int) request('price',150000);
    $productPrice = 'Rp ' . number_format($productPriceRaw,0,',','.').',00';
    $productTotal = 'Rp ' . number_format($productPriceRaw,0,',','.');
  @endphp
  @include('kampung.partials.navbar-topeng')

  <main class="checkout-page">
    <div class="container">
      <h1 class="checkout-title">Checkout</h1>
      <form id="topengForm" method="POST" action="{{ route('kampung.topeng.checkout.store') }}">
        @csrf
        <input type="hidden" name="product_name" value="{{ $productName }}">
        <input type="hidden" name="product_price" value="{{ $productPriceRaw }}">
        <input type="hidden" name="image" value="{{ $productImage }}">
        <input type="hidden" name="quantity" id="quantityInput" value="1">

        <div class="checkout-grid">
          <section class="checkout-card">
            <h2 class="checkout-subtitle">Biodata</h2>
            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input id="nama" name="name" type="text" placeholder="Masukkan nama lengkap" required>
              <small class="field-error" id="errNama">Isi nama terlebih dahulu.</small>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" name="email" type="email" placeholder="nama@email.com" required>
              <small class="field-error" id="errEmail">Isi email terlebih dahulu.</small>
            </div>
            <div class="form-group">
              <label for="telepon">Nomor Telepon</label>
              <input id="telepon" name="phone" type="text" placeholder="Contoh: 081234567890" required>
              <small class="field-error" id="errTelepon">Isi nomor telepon terlebih dahulu.</small>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat Lengkap</label>
              <textarea id="alamat" name="address" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
            </div>

            <div class="form-group">
              <div class="qty-row">
                <label for="qtyDisplay">Jumlah</label>
              </div>
              <div class="qty-control">
                <input id="qtyDisplay" type="text" class="qty-display" value="1" readonly>
                <button type="button" class="qty-btn" id="btnMinusQty" aria-label="Kurangi">-</button>
                <button type="button" class="qty-btn" id="btnPlusQty" aria-label="Tambah">+</button>
              </div>
            </div>

            <div class="form-group">
              <label>Metode Pembayaran</label>
              @php
                use Illuminate\Support\Str;
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
              <div class="pay-accordion" id="payAccordionTopeng">
                @foreach($payCategories as $categoryName => $items)
                  @php $slug = Str::slug($categoryName, '-'); @endphp
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
              <input type="hidden" name="payment_method" id="paymentMethodTopeng" required>
              <div class="selected-method" id="selectedMethodLabel" style="margin-top:8px; color:#6b7280;">Pilih Metode</div>
              <small class="field-error" id="errPayment">Pilih metode pembayaran terlebih dahulu.</small>
            </div>

            <button type="button" class="btn-primary" id="btnSubmitTopeng">Lanjut ke Pembayaran</button>
          </section>

          <aside class="checkout-summary">
            <h2 class="checkout-subtitle">Detail Pesanan</h2>
            <div class="summary-item">
              <img src="{{ asset($productImage) }}" alt="{{ $productName }}">
              <div>
                <div class="summary-name">{{ $productName }}</div>
                <div class="summary-meta">1 x {{ $productTotal }}</div>
                <div class="summary-meta">{{ $productTotal }}</div>
              </div>
            </div>
            <div class="summary-total">
              <span>Total</span>
              <strong>{{ $productTotal }}</strong>
            </div>
          </aside>
        </div>
      </form>
    </div>
  </main>

  <div class="booking-modal" id="confirmModal" aria-hidden="true">
    <div class="booking-modal__overlay" id="modalOverlay"></div>
    <div class="booking-modal__dialog">
      <button class="booking-modal__close" type="button" aria-label="Tutup" id="modalClose">×</button>
      <div class="booking-modal__icon">⏰</div>
      <h4 style="text-align:center; margin:6px 0 4px;">Berhasil Membuat Pesanan</h4>
      <p class="booking-modal__desc">Pastikan data yang Anda masukkan valid dan sesuai.</p>
      <div class="booking-modal__summary">
        <div><strong>Layanan</strong></div><span id="modalSummaryName">-</span>
        <div><strong>Metode Pembayaran</strong></div><span id="modalSummaryMethod">-</span>
        <div><strong>Jumlah</strong></div><span id="modalSummaryQty">1x</span>
        <div><strong>Biaya Admin</strong></div><span id="modalSummaryAdmin">Rp0,00</span>
        <div><strong>Total Pembayaran</strong></div><span id="modalSummaryTotal">-</span>
      </div>
      <div class="booking-modal__actions">
        <button id="modalPay" type="button" class="primary">Bayar Sekarang!</button>
        <button type="button" class="modal-edit__close secondary" id="modalCancel">Batal Pesanan</button>
      </div>
    </div>
  </div>

  @include('kampung.partials.footer-topeng')
  <div class="booking-modal" id="confirmModal" aria-hidden="true">
    <div class="booking-modal__overlay" id="modalOverlay"></div>
    <div class="booking-modal__dialog">
      <button class="booking-modal__close" type="button" aria-label="Tutup" id="modalClose">×</button>
      <div class="booking-modal__icon">⏰</div>
      <h4>Berhasil Membuat Pesanan</h4>
      <p class="booking-modal__desc">Pastikan data yang Anda masukkan valid dan sesuai.</p>
      <div class="booking-modal__summary">
        <div><strong>Layanan</strong><span id="modalSummaryName">-</span></div>
        <div><strong>Metode Pembayaran</strong><span id="modalSummaryMethod">-</span></div>
        <div><strong>Jumlah</strong><span id="modalSummaryQty">1x</span></div>
        <div><strong>Biaya Admin</strong><span id="modalSummaryAdmin">Rp0,00</span></div>
        <div><strong>Total Pembayaran</strong><span id="modalSummaryTotal">-</span></div>
      </div>
      <div class="booking-modal__actions">
        <button id="modalPay" type="button" class="primary">Bayar Sekarang!</button>
        <button type="button" class="modal-edit__close secondary" id="modalCancel">Batal Pesanan</button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const payAccordion = document.getElementById('payAccordionTopeng');
      const paymentMethodInput = document.getElementById('paymentMethodTopeng');
      const selectedLabel = document.getElementById('selectedMethodLabel');
      const form = document.getElementById('topengForm');
      const modal = document.getElementById('confirmModal');
      const modalOverlay = document.getElementById('modalOverlay');
      const modalClose = document.getElementById('modalClose');
      const modalSummaryName = document.getElementById('modalSummaryName');
      const modalSummaryMethod = document.getElementById('modalSummaryMethod');
      const modalSummaryTotal = document.getElementById('modalSummaryTotal');
      const modalSummaryQty = document.getElementById('modalSummaryQty');
      const modalSummaryAdmin = document.getElementById('modalSummaryAdmin');
      const modalPay = document.getElementById('modalPay');
      const modalCancel = document.getElementById('modalCancel');
      const priceText = '{{ $productTotal }}';
      const priceRaw = {{ $productPriceRaw }};
      const adminFee = 500;
      const btnSubmit = document.getElementById('btnSubmitTopeng');
      const qtyDisplay = document.getElementById('qtyDisplay');
      const btnMinusQty = document.getElementById('btnMinusQty');
      const btnPlusQty = document.getElementById('btnPlusQty');
      const qtyInputHidden = document.getElementById('quantityInput');
      let quantity = 1;

      function showWarningToast(message) {
        const existing = document.querySelector('.toast-warning');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = 'toast-warning';
        toast.innerHTML = `<span class="icon">!</span><span>${message}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
          toast.classList.remove('show');
          setTimeout(() => toast.remove(), 250);
        }, 4000);
      }

      function updateButtonState() {
        const hasName = document.getElementById('nama').value.trim() !== '';
        const hasEmail = document.getElementById('email').value.trim() !== '';
        const hasPhone = document.getElementById('telepon').value.trim() !== '';
        const hasPayment = paymentMethodInput.value.trim() !== '';
        const allFilled = hasName && hasEmail && hasPhone && hasPayment;
        if (allFilled) {
          btnSubmit.classList.add('is-active');
          btnSubmit.style.cursor = 'pointer';
        } else {
          btnSubmit.classList.remove('is-active');
          btnSubmit.style.cursor = 'not-allowed';
        }
        return allFilled;
      }

      ['nama','email','telepon'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function () {
          const errEl = document.getElementById('err' + this.id.charAt(0).toUpperCase() + this.id.slice(1));
          errEl?.classList.remove('show');
          updateButtonState();
        });
      });

      // set prices on cards
      document.querySelectorAll('.pay-card-price').forEach(el => {
        el.textContent = priceText;
      });

      function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID') + ',00';
      }

      function updateQuantity(delta) {
        quantity = Math.max(1, quantity + delta);
        qtyDisplay.value = quantity;
        qtyInputHidden.value = quantity;
        const subtotal = priceRaw * quantity;
        const total = subtotal + adminFee;
        document.querySelectorAll('.pay-card-price').forEach(el => {
          el.textContent = formatRupiah(total);
        });
        const summaryMeta = document.querySelector('.summary-item .summary-meta:nth-child(2)');
        const summaryPrice = document.querySelector('.summary-item .summary-meta:nth-child(3)');
        const summaryTotal = document.querySelector('.summary-total strong');
        if (summaryMeta) summaryMeta.textContent = `${quantity} x ${formatRupiah(priceRaw)}`;
        if (summaryPrice) summaryPrice.textContent = formatRupiah(subtotal);
        if (summaryTotal) summaryTotal.textContent = formatRupiah(total);
        if (modalSummaryQty) modalSummaryQty.textContent = `${quantity}x`;
        if (modalSummaryAdmin) modalSummaryAdmin.textContent = formatRupiah(adminFee);
        if (modalSummaryTotal) modalSummaryTotal.textContent = formatRupiah(total);
      }

      btnPlusQty?.addEventListener('click', () => updateQuantity(1));
      btnMinusQty?.addEventListener('click', () => updateQuantity(-1));

      payAccordion?.querySelectorAll('.pay-option-card').forEach(function (btn) {
        btn.addEventListener('click', function () {
          payAccordion.querySelectorAll('.pay-option-card').forEach(el => el.classList.remove('active'));
          btn.classList.add('active');
          const method = btn.dataset.method || '';
          paymentMethodInput.value = method;
          if (selectedLabel) {
            selectedLabel.textContent = method || 'Pilih Metode';
            selectedLabel.style.color = method ? '#111827' : '#6b7280';
          }
          updateButtonState();
        });
      });

      payAccordion?.querySelectorAll('.pay-accordion__header').forEach(function (header) {
        header.addEventListener('click', function () {
          const item = header.closest('.pay-accordion__item');
          const isOpen = item.classList.contains('is-open');
          payAccordion.querySelectorAll('.pay-accordion__item').forEach(el => el.classList.remove('is-open'));
          if (!isOpen) {
            item.classList.add('is-open');
          }
        });
      });

      updateQuantity(0);
      updateButtonState();

      function openModal() {
        const subtotal = priceRaw * quantity;
        const total = subtotal + adminFee;
        modalSummaryName.textContent = '{{ $productName }}';
        modalSummaryMethod.textContent = paymentMethodInput.value || '-';
        if (modalSummaryQty) modalSummaryQty.textContent = `${quantity}x`;
        if (modalSummaryAdmin) modalSummaryAdmin.textContent = formatRupiah(adminFee);
        modalSummaryTotal.textContent = formatRupiah(total);
        modal.classList.add('show');
        modalOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modal.classList.remove('show');
        modalOverlay.classList.remove('show');
        document.body.style.overflow = '';
      }

      document.getElementById('btnSubmitTopeng')?.addEventListener('click', function () {
        const missing = [];
        let targetEl = null;
        const namaEl = document.getElementById('nama');
        const emailEl = document.getElementById('email');
        const telEl = document.getElementById('telepon');
        const errNama = document.getElementById('errNama');
        const errEmail = document.getElementById('errEmail');
        const errTelepon = document.getElementById('errTelepon');
        const errPayment = document.getElementById('errPayment');

        [errNama, errEmail, errTelepon, errPayment].forEach(el => el?.classList.remove('show'));

        if (!namaEl.value.trim()) { missing.push('Nama'); targetEl = targetEl || namaEl; }
        if (!emailEl.value.trim()) { missing.push('Email'); targetEl = targetEl || emailEl; }
        if (!telEl.value.trim()) { missing.push('Nomor Telepon'); targetEl = targetEl || telEl; }
        if (!paymentMethodInput.value.trim()) {
            missing.push('Metode Pembayaran');
            targetEl = targetEl || payAccordion.querySelector('.pay-option-card');
        }

        if (missing.length) {
          if (!namaEl.value.trim()) errNama?.classList.add('show');
          if (!emailEl.value.trim()) errEmail?.classList.add('show');
          if (!telEl.value.trim()) errTelepon?.classList.add('show');
          if (!paymentMethodInput.value.trim()) errPayment?.classList.add('show');

          showWarningToast(`Lengkapi: ${missing[0]}`);
          if (targetEl && typeof targetEl.scrollIntoView === 'function') {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetEl.focus?.();
          }
          return;
        }
        if (!form.reportValidity()) {
          return;
        }
        openModal();
      });

      modalClose?.addEventListener('click', closeModal);
      modalOverlay?.addEventListener('click', closeModal);
      modalCancel?.addEventListener('click', function () {
        closeModal();
      });
      modalPay?.addEventListener('click', function () {
        form.submit();
      });
    });
  </script>
</body>
</html>

<div class="booking-modal" id="confirmModal" aria-hidden="true">
  <div class="booking-modal__overlay" id="modalOverlay"></div>
  <div class="booking-modal__dialog">
    <button class="booking-modal__close" type="button" aria-label="Tutup" id="modalClose">×</button>
    <div class="booking-modal__icon">⏰</div>
    <h4>Berhasil Membuat Pesanan</h4>
    <p class="booking-modal__desc">Pastikan data yang Anda masukkan valid dan sesuai.</p>
    <div class="booking-modal__summary">
      <div><strong>Layanan</strong><span id="modalSummaryName">-</span></div>
      <div><strong>Metode Pembayaran</strong><span id="modalSummaryMethod">-</span></div>
      <div><strong>Jumlah</strong><span>1x</span></div>
      <div><strong>Biaya Admin</strong><span id="modalSummaryAdmin">Rp0,00</span></div>
      <div><strong>Total Pembayaran</strong><span id="modalSummaryTotal">-</span></div>
    </div>
    <div class="booking-modal__actions">
      <button id="modalPay" type="button" class="primary">Bayar Sekarang!</button>
      <button type="button" class="modal-edit__close secondary" id="modalCancel">Batal Pesanan</button>
    </div>
  </div>
</div>
