@extends('admin.layout-admin')

@section('title', 'Konfigurasi Event & Galeri')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-galeri.css') }}">
@endpush

@section('content')
<div class="admin-section galeri-wrap">
    <div class="section-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
        <div>
            <h2 style="margin:0; font-size:20px;">Konfigurasi Event & Galeri</h2>
        </div>
        <div style="color:#9ca3af;">/Event & Galeri</div>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="galeri-card">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="galeri-form-grid">
                <label for="galeri-media">Pilih Foto/Video</label>
                <div class="file-wrap">
                    <input id="galeri-media" type="file" name="media" accept="image/*,video/*" required>
                </div>

                <label for="galeri-judul">Judul</label>
                <input id="galeri-judul" type="text" name="judul" value="{{ old('judul') }}">
                <div class="galeri-help">Tidak perlu diisi jika upload galeri.</div>

                <label for="galeri-deskripsi">Deskripsi</label>
                <textarea id="galeri-deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                <div class="galeri-help">Tidak perlu diisi jika upload galeri.</div>

                <label for="galeri-tipe">Tipe</label>
                <select id="galeri-tipe" name="tipe" required>
                    <option value="">Pilih tipe</option>
                    <option value="event" @selected(old('tipe')==='event')>Event</option>
                    <option value="galeri" @selected(old('tipe')==='galeri')>Galeri</option>
                </select>
                <div class="galeri-help">Pilih jenis konten yang akan muncul.</div>

                <label for="galeri-kategori">Kategori Tipe</label>
                <select id="galeri-kategori" name="kategori" required>
                    <option value="">Pilih kategori</option>
                    <option value="kampung-1000-topeng" @selected(old('kategori')==='kampung-1000-topeng')>Kampung 1000 Topeng</option>
                    <option value="glintung-go-green" @selected(old('kategori')==='glintung-go-green')>Glintung Go-Green</option>
                    <option value="warna-warni-jodipan" @selected(old('kategori')==='warna-warni-jodipan')>Warna Warni Jodipan</option>
                    <option value="biru-arema" @selected(old('kategori')==='biru-arema')>Biru Arema</option>
                </select>
                <div class="galeri-help">Kategori kampung untuk konten ini.</div>

                <div class="galeri-actions">
                    <button type="submit" class="btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <div class="galeri-card">
        <h3 style="margin-top:0; margin-bottom:12px;">Daftar Event &amp; Galeri</h3>
        <div style="overflow-x:auto;">
            <table class="galeri-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Media</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Deskripsi</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id_galeri }}</td>
                            <td>
                                @if($item->media_path)
                                    @if($item->jenis === 'foto')
                                        <a href="{{ asset($item->media_path) }}" target="_blank" rel="noopener">
                                            <img class="media-thumb" src="{{ asset($item->media_path) }}" alt="{{ $item->judul ?? 'media' }}">
                                        </a>
                                    @else
                                        <a class="badge-type" href="{{ asset($item->media_path) }}" target="_blank" rel="noopener">Lihat video</a>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->judul ?? '-' }}</td>
                            <td><span class="badge-type">{{ $item->jenis }}</span></td>
                            <td>{{ $item->deskripsi ? \Illuminate\Support\Str::limit($item->deskripsi, 80) : '-' }}</td>
                            <td><span class="badge-type">{{ $item->tipe }}</span></td>
                            <td><span class="badge-type">{{ $item->kategori ?? '-' }}</span></td>
                            <td>{{ $item->tanggal_upload }}</td>
                            <td>
                                <div class="aksi-col">
                                    <button type="button" class="btn-pay secondary"
                                        data-edit
                                        data-id="{{ $item->id_galeri }}"
                                        data-judul="{{ $item->judul }}"
                                        data-deskripsi="{{ $item->deskripsi }}"
                                        data-tipe="{{ $item->tipe }}"
                                        data-kategori="{{ $item->kategori }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus konten ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-pay danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center; color:#9ca3af;">Belum ada konten.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="galeri-table-footer">
            <div class="table-meta">Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} entries</div>
            <div class="table-pagination">
                {{ $items->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop" data-modal>
    <div class="modal-card">
        <div class="modal-head">
            <h4 style="margin:0;">Edit Event/Galeri</h4>
            <button type="button" class="modal-close" aria-label="Tutup" data-close>&times;</button>
        </div>
        <form id="editGaleriForm" method="POST" data-action="{{ route('admin.galeri.update', ['galeri' => '__ID__']) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="galeri-form-grid">
                    <label for="edit-media">Ganti Foto/Video</label>
                    <div class="file-wrap">
                        <input id="edit-media" type="file" name="media" accept="image/*,video/*">
                    </div>

                    <label for="edit-judul">Judul</label>
                    <input id="edit-judul" type="text" name="judul">

                    <label for="edit-deskripsi">Deskripsi</label>
                    <textarea id="edit-deskripsi" name="deskripsi"></textarea>
                    <div class="galeri-help">Tidak perlu diisi jika upload galeri.</div>

                    <label for="edit-tipe">Tipe</label>
                    <select id="edit-tipe" name="tipe" required>
                        <option value="event">Event</option>
                        <option value="galeri">Galeri</option>
                    </select>

                    <label for="edit-kategori">Kategori Tipe</label>
                    <select id="edit-kategori" name="kategori" required>
                        <option value="kampung-1000-topeng">Kampung 1000 Topeng</option>
                        <option value="glintung-go-green">Glintung Go-Green</option>
                        <option value="warna-warni-jodipan">Warna Warni Jodipan</option>
                        <option value="biru-arema">Biru Arema</option>
                    </select>
                </div>
            </div>
                <div class="modal-actions">
                    <button type="button" class="btn-pay secondary" data-close>Tutup</button>
                    <button type="submit" class="btn-pay primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const backdrop = document.querySelector('[data-modal]');
    const form = document.getElementById('editGaleriForm');
    const actionTemplate = form?.dataset.action || '';
    const uploadForms = document.querySelectorAll('form[enctype="multipart/form-data"]');
    const showLoader = () => {
        let el = document.getElementById('uploadLoader');
        if (!el) {
            el = document.createElement('div');
            el.id = 'uploadLoader';
            el.style.position = 'fixed';
            el.style.inset = '0';
            el.style.background = 'rgba(0,0,0,0.35)';
            el.style.display = 'grid';
            el.style.placeItems = 'center';
            el.style.zIndex = '120';
            el.innerHTML = '<div style="padding:14px 18px; background:#fff; border-radius:10px; box-shadow:0 12px 30px rgba(0,0,0,.18); font-weight:700;">Mengunggah... mohon tunggu.</div>';
            document.body.appendChild(el);
        }
        el.style.display = 'grid';
    };
    const hideLoader = () => {
        const el = document.getElementById('uploadLoader');
        if (el) el.style.display = 'none';
    };
    uploadForms.forEach(f => {
        f.addEventListener('submit', () => showLoader());
    });

    const openModal = (data) => {
        if (!backdrop || !form) return;
        form.action = actionTemplate.replace('__ID__', data.id);
        form.querySelector('#edit-judul').value = data.judul || '';
        form.querySelector('#edit-deskripsi').value = data.deskripsi || '';
        form.querySelector('#edit-tipe').value = data.tipe || 'event';
        form.querySelector('#edit-kategori').value = data.kategori || '';
        form.querySelector('#edit-media').value = '';
        backdrop.classList.add('show');
    };

    const closeModal = () => backdrop?.classList.remove('show');

    document.querySelectorAll('[data-edit]').forEach(btn => {
        btn.addEventListener('click', () => {
            openModal({
                id: btn.dataset.id,
                judul: btn.dataset.judul,
                deskripsi: btn.dataset.deskripsi,
                tipe: btn.dataset.tipe,
                kategori: btn.dataset.kategori,
            });
        });
    });

    backdrop?.addEventListener('click', (e) => {
        if (e.target === backdrop || e.target.dataset.close !== undefined) {
            closeModal();
        }
    });
    window.addEventListener('load', hideLoader);
});
</script>
@endpush
@endsection
