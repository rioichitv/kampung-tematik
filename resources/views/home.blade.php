@extends('layout')

@section('title', 'Beranda')

@push('styles')
<style>
    .rekomendasi-slider {
        position: relative;
        max-width: 1150px;
        margin: 0 auto;
        padding: 0 56px;
    }
    .rekomendasi-viewport {
        overflow: hidden;
        width: 100%;
        max-width: 1024px;
        margin: 0 auto;
        cursor: grab;
    }
    .rekomendasi-viewport:active{cursor:grabbing;}
    .rekomendasi-track {
        display: flex;
        gap: 16px;
        transition: transform .6s ease;
    }
    .rekomendasi-card {
        background: #fff;
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        overflow: hidden;
        text-align: left;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        width: 320px;
        max-width: none;
        flex-shrink: 0;
    }
    .rekomendasi-card img {
        width: 100%;
        height: 190px;
        object-fit: cover;
    }
    .rekomendasi-card .content {
        padding: 12px 14px;
    }
    .rekomendasi-card h3 {
        font-size: 18px;
        margin-bottom: 9px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .rekomendasi-card h3::before { content:""; }
    .rekomendasi-card p { color:#555; font-size:15px; line-height:1.7; }
    @media (max-width: 768px) {
        .rekomendasi-slider { padding: 0 36px; }
        .rekomendasi-track { gap: 12px; }
        .rekomendasi-card { width: 260px; }
    }
</style>
@endpush

@section('content')
<!-- ===== HERO SECTION (Video 360° + Tombol Matikan Suara) ===== -->
<header class="hero">
    <div class="video-wrapper">
        <video autoplay muted loop playsinline id="heroVideo">
            <source src="{{ asset('videos/kampung-360.mp4') }}" type="video/mp4">
            Browser kamu tidak mendukung video HTML5.
        </video>

        <!-- Tombol toggle suara -->
        <button class="mute-btn" id="muteBtn">?? Nyalakan Suara</button>
    </div>
</header>

<!-- ===== PILIH KAMPUNG ===== -->
<section class="pilih-kampung">
    <h2>Pilih Kampung</h2>
    <p>Belasan kampung wisata yang memiliki ciri khas budaya-nya masing-masing</p>

    <select onchange="location = this.value;">
        <option value="#">Pilih Kampung</option>
        <option value="{{ url('/kampung/1000-topeng') }}">1000 Topeng</option>
        <option value="{{ route('kampung.glintung') }}">Glintung Go-Green</option>
        <option value="{{ url('/kampung/warna-warni') }}">Warna-Warni Jodipan</option>
        <option value="{{ url('/kampung/biru-arema') }}">Biru Arema</option>
    </select>
</section>

<!-- ===== REKOMENDASI DESA WISATA ===== -->
<section class="rekomendasi">
    <h2>Rekomendasi Desa Wisata</h2>
    <p>Temukan desa wisata menarik lainnya dengan keunikan budaya, kreativitas warga, dan pesona lokal yang layak dikunjungi.</p>

    <div class="rekomendasi-slider">
        <div class="rekomendasi-viewport">
            <div class="rekomendasi-track">
                @forelse($rekomendasi as $item)
                    @php
                        $img = $item->gambar ? asset($item->gambar) : asset('images/coming-soon.webp');
                    @endphp
                    <div class="rekomendasi-card" data-img="{{ $img }}" data-title="{{ $item->judul }}" data-desc="{{ strip_tags($item->deskripsi) }}">
                        <img src="{{ $img }}" alt="{{ $item->judul }}">
                        <div class="content">
                            <h3>{{ $item->judul }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 150) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rekomendasi-card">
                        <img src="{{ asset('images/coming-soon.webp') }}" alt="Rekomendasi Desa Wisata">
                        <div class="content">
                            <h3>Belum ada rekomendasi</h3>
                            <p>Tambahkan konten bertipe "Rekomendasi Desa Wisata" melalui halaman admin.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- ===== BERITA DAN INFORMASI ===== -->
<section class="berita">
    <h2>Berita</h2>
    <p>Menyajikan informasi dan kabar seputar kegiatan, inovasi, dan perkembangan kampung tematik di berbagai daerah.</p>

    @php $jumlahBerita = $berita->count(); @endphp
    @php
        $formatDate = fn($d) => $d ? $d->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') : '';
    @endphp

    <div class="berita-slider">
        <div class="berita-viewport">
            <div class="berita-track">
                @forelse($berita as $item)
                    @php
                        $tgl = $formatDate($item->created_at);
                        $img = $item->gambar ? asset($item->gambar) : asset('images/coming-soon.webp');
                    @endphp
                    <div class="berita-card" data-img="{{ $img }}" data-date="{{ $tgl }}" data-title="{{ $item->judul }}" data-desc="{{ strip_tags($item->deskripsi) }}">
                        <img src="{{ $img }}" alt="{{ $item->judul }}">
                        <div class="info">
                            <div class="tanggal">{{ $tgl }}</div>
                            <h4>{{ $item->judul }}</h4>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 120) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="berita-card">
                        <img src="{{ asset('images/coming-soon.webp') }}" alt="Berita">
                        <div class="info">
                            <div class="tanggal">Belum ada berita</div>
                            <h4>-</h4>
                            <p>-</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Modal Berita -->
<div class="berita-modal" id="beritaModal" aria-hidden="true">
    <div class="berita-modal__overlay"></div>
    <div class="berita-modal__dialog" role="dialog" aria-modal="true">
        <button class="berita-modal__close" type="button" aria-label="Tutup">x</button>
        <div class="berita-modal__image">
            <img src="" alt="" id="modalBeritaImg">
        </div>
        <div class="berita-modal__body">
            <div class="tanggal" id="modalBeritaDate"></div>
            <h4 id="modalBeritaTitle"></h4>
            <p id="modalBeritaDesc"></p>
        </div>
    </div>
</div>
<!-- Modal Rekomendasi -->
<div class="rekom-modal" id="rekomModal" aria-hidden="true">
    <div class="rekom-modal__overlay"></div>
    <div class="rekom-modal__dialog" role="dialog" aria-modal="true">
        <button class="rekom-modal__close" type="button" aria-label="Tutup">x</button>
        <div class="rekom-modal__image">
            <img src="" alt="" id="modalRekomImg">
        </div>
        <div class="rekom-modal__body">
            <h4 id="modalRekomTitle"></h4>
            <p id="modalRekomDesc"></p>
        </div>
    </div>
</div>
{{-- ===== SCRIPT TOGGLE SUARA & SLIDER ===== --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const video = document.getElementById('heroVideo');
    const btn = document.getElementById('muteBtn');

    // Awal: mulai tanpa suara dulu (agar autoplay pasti berjalan)
    video.muted = true;
    video.play().catch(err => console.warn("Autoplay diblokir:", err));

    btn.addEventListener('click', () => {
        if (video.muted) {
            video.muted = false;
            video.volume = 1.0;
            btn.textContent = '?? Matikan Suara';
            video.play();
        } else {
            video.muted = true;
            btn.textContent = '?? Nyalakan Suara';
        }
    });

    // Slider helper (berita & rekomendasi)
    const initSlider = ({ trackSelector, prevSelector, nextSelector, viewportSelector, visible = 3 }) => {
        const track = document.querySelector(trackSelector);
        if (!track) return;
        const cards = Array.from(track.children);
        const prevBtn = document.querySelector(prevSelector);
        const nextBtn = document.querySelector(nextSelector);
        const viewport = viewportSelector ? document.querySelector(viewportSelector) : track.parentElement;
        let current = 0;
        let slideWidth = 0;

        const goTo = (index, animate = true) => {
            if (!cards.length) return;
            current = Math.max(0, Math.min(index, Math.max(0, cards.length - visible)));
            track.style.transition = animate ? 'transform .6s ease' : 'none';
            track.style.transform = `translateX(-${current * slideWidth}px)`;
        };

        const recalc = () => {
            if (!cards.length) return;
            const style = getComputedStyle(track);
            const gap = parseFloat(style.columnGap || style.gap || 0);
            slideWidth = cards[0].offsetWidth + gap;
            goTo(current, false);
        };

        const next = () => {
            if (!cards.length) return;
            if (current >= Math.max(0, cards.length - visible)) {
                current = 0;
                goTo(current, true);
            } else {
                goTo(current + 1, true);
            }
        };

        const prev = () => {
            if (!cards.length) return;
            if (current <= 0) {
                current = Math.max(0, cards.length - visible);
                goTo(current, true);
            } else {
                goTo(current - 1, true);
            }
        };

        let autoTimer = null;
        const resetAuto = () => {
            if (autoTimer) clearInterval(autoTimer);
            autoTimer = setInterval(next, 3500);
        };

        prevBtn?.addEventListener('click', () => {
            prev();
            if (cards.length > visible) resetAuto();
        });
        nextBtn?.addEventListener('click', () => {
            next();
            if (cards.length > visible) resetAuto();
        });

        // Drag / swipe support
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        const threshold = () => slideWidth * 0.2;

        const onStart = (clientX) => {
            if (!cards.length) return;
            isDragging = true;
            startX = clientX;
            currentX = clientX;
            track.style.transition = 'none';
            if (autoTimer) clearInterval(autoTimer);
        };
        const onMove = (clientX) => {
            if (!isDragging) return;
            currentX = clientX;
            const diff = currentX - startX;
            track.style.transform = `translateX(${-(current * slideWidth) + diff}px)`;
        };
        const onEnd = () => {
            if (!isDragging) return;
            isDragging = false;
            const diff = currentX - startX;
            if (diff > threshold()) {
                prev();
            } else if (diff < -threshold()) {
                next();
            } else {
                goTo(current, true);
            }
            if (cards.length > visible) resetAuto();
        };

        viewport?.addEventListener('mousedown', (e) => onStart(e.clientX));
        viewport?.addEventListener('touchstart', (e) => onStart(e.touches[0].clientX), { passive:true });
        window.addEventListener('mousemove', (e) => onMove(e.clientX));
        window.addEventListener('touchmove', (e) => onMove(e.touches[0].clientX), { passive:true });
        window.addEventListener('mouseup', onEnd);
        window.addEventListener('touchend', onEnd);
        window.addEventListener('mouseleave', onEnd);

        window.addEventListener('resize', recalc);
        recalc();
        if (cards.length > visible) resetAuto();
    };

    initSlider({
        trackSelector: '.berita-track',
        prevSelector: '.berita-prev',
        nextSelector: '.berita-next',
        viewportSelector: '.berita-viewport',
        visible: 3
    });
    initSlider({
        trackSelector: '.rekomendasi-track',
        prevSelector: '.rekomendasi-prev',
        nextSelector: '.rekomendasi-next',
        viewportSelector: '.rekomendasi-viewport',
        visible: 3
    });

    // Modal berita
    const modal = document.getElementById('beritaModal');
    const modalImg = document.getElementById('modalBeritaImg');
    const modalDate = document.getElementById('modalBeritaDate');
    const modalTitle = document.getElementById('modalBeritaTitle');
    const modalDesc = document.getElementById('modalBeritaDesc');
    const closeBtn = document.querySelector('.berita-modal__close');
    const overlay = document.querySelector('.berita-modal__overlay');

    const openModal = (card) => {
        modalImg.src = card.dataset.img || '';
        modalImg.alt = card.dataset.title || '';
        modalDate.textContent = card.dataset.date || '';
        modalTitle.textContent = card.dataset.title || '';
        modalDesc.textContent = card.dataset.desc || '';
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.berita-track .berita-card').forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });

    closeBtn?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    // Modal rekomendasi
    const rekomModal = document.getElementById('rekomModal');
    const rekomImg = document.getElementById('modalRekomImg');
    const rekomTitle = document.getElementById('modalRekomTitle');
    const rekomDesc = document.getElementById('modalRekomDesc');
    const rekomClose = document.querySelector('.rekom-modal__close');
    const rekomOverlay = document.querySelector('.rekom-modal__overlay');

    const openRekom = (card) => {
        if (!rekomModal || !rekomImg || !rekomTitle || !rekomDesc) return;
        rekomImg.src = card.dataset.img || '';
        rekomImg.alt = card.dataset.title || '';
        rekomTitle.textContent = card.dataset.title || '';
        rekomDesc.textContent = card.dataset.desc || '';
        rekomModal.classList.add('show');
        rekomModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const closeRekom = () => {
        if (!rekomModal) return;
        rekomModal.classList.remove('show');
        rekomModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.rekomendasi-track .rekomendasi-card').forEach(card => {
        card.addEventListener('click', () => openRekom(card));
    });

    rekomClose?.addEventListener('click', closeRekom);
    rekomOverlay?.addEventListener('click', closeRekom);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeRekom();
    });
});
</script>
@endpush
@endsection




