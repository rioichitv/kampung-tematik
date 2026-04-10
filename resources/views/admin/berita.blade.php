@php
    use Illuminate\Support\Str;
@endphp
@extends('admin.layout-admin')

@section('title', 'Konfigurasi Berita')

@section('content')
<div class="admin-shell">
    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Setelan Berita</h3>
            <span class="muted">Konfigurasi / Berita</span>
        </div>
        @if(session('success'))
            <div style="padding:10px 14px; background:#ecfdf3; border:1px solid #bbf7d0; border-radius:8px; color:#166534; margin-bottom:12px;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="padding:10px 14px; background:#fef2f2; border:1px solid #fecdd3; border-radius:8px; color:#b91c1c; margin-bottom:12px;">
                <strong>Periksa kembali:</strong>
                <ul style="margin:6px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel" style="display:grid; gap:16px;">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:14px;">
                @csrf
                <div>
                    <label for="gambar" class="label">Pilih Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px;">
                </div>
                <div>
                    <label for="judul" class="label">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px;">
                </div>
                <div>
                    <label for="deskripsi" class="label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px;">{{ old('deskripsi') }}</textarea>
                    <small style="color:#6b7280;">*Wajib diisi</small>
                </div>
                <div>
                    <label for="tipe" class="label">Tipe</label>
                    <select name="tipe" id="tipe" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px; background:#fff;">
                        <option value="berita" {{ old('tipe', 'berita') === 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="rekomendasi" {{ old('tipe') === 'rekomendasi' ? 'selected' : '' }}>Rekomendasi Desa Wisata</option>
                    </select>
                    <small style="color:#6b7280;">Pilih jenis konten yang akan muncul di halaman utama.</small>
                </div>
                <div>
                    <button type="submit" style="padding:10px 16px; background:#3f51d7; color:#fff; border:none; border-radius:8px; cursor:pointer;">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Semua Berita</h3>
        </div>
        <div class="panel" style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="text-align:left; border-bottom:1px solid #e5e7eb;">
                        <th style="padding:10px;">#</th>
                        <th style="padding:10px;">Gambar</th>
                        <th style="padding:10px;">Judul & Deskripsi</th>
                        <th style="padding:10px;">Tipe</th>
                        <th style="padding:10px;">Tanggal</th>
                        <th style="padding:10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px;">{{ $item->id }}</td>
                            <td style="padding:10px;">
                                @if($item->gambar)
                                    <img src="{{ asset($item->gambar) }}" alt="Gambar" style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                                @else
                                    <span class="muted">-</span>
                                @endif
                            </td>
                            <td style="padding:10px;">
                                <strong>{{ $item->judul }}</strong><br>
                                <span style="color:#4b5563;">{{ Str::limit(strip_tags($item->deskripsi), 120) }}</span>
                            </td>
                            <td style="padding:10px;">{{ $item->tipe === 'rekomendasi' ? 'Rekomendasi Desa Wisata' : ucfirst($item->tipe) }}</td>
                            <td style="padding:10px;">{{ $item->created_at ? $item->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('Y-m-d H:i') : '-' }}</td>
                            <td style="padding:10px;">
                                <div style="display:flex; gap:8px; align-items:center;">
                                    <button type="button"
                                        class="btn-edit-berita"
                                        data-action="{{ route('admin.berita.update', $item) }}"
                                        data-judul="{{ $item->judul }}"
                                        data-deskripsi="{{ e($item->deskripsi) }}"
                                        data-tipe="{{ $item->tipe }}"
                                        data-img="{{ $item->gambar ? asset($item->gambar) : '' }}"
                                        style="padding:8px 12px; background:#0ea5e9; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding:8px 12px; background:#ef4444; color:#fff; border:none; border-radius:6px; cursor:pointer;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:12px; text-align:center; color:#6b7280;">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<style>
    .modal-edit {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }
    .modal-edit.show { display: flex; }
    .modal-edit__overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.45);
        backdrop-filter: blur(2px);
    }
    .modal-edit__dialog {
        position: relative;
        background: #fff;
        border-radius: 14px;
        padding: 16px 18px 18px;
        width: 760px;
        max-width: 96%;
        box-shadow: 0 16px 32px rgba(0,0,0,0.16);
        z-index: 1;
    }
    .modal-edit__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .modal-edit__close {
        border: none;
        background: #f3f4f6;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        font-weight: 700;
    }
    .modal-edit form { display: grid; gap: 12px; }
    .modal-edit .form-row { display: grid; gap: 6px; }
    .modal-edit label { font-weight: 600; color: #111827; }
    .modal-edit input[type="text"],
    .modal-edit select,
    .modal-edit textarea {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 12px;
    }
    .modal-edit img.preview {
        width: 160px;
        height: 110px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    @media (max-width: 640px) {
        .modal-edit__dialog { max-height: 92vh; overflow-y: auto; }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalEditBerita');
    const overlay = modal?.querySelector('.modal-edit__overlay');
    const closeBtns = modal ? Array.from(modal.querySelectorAll('.modal-edit__close')) : [];
    const form = modal?.querySelector('form');
    const judulInput = modal?.querySelector('input[name="judul"]');
    const deskripsiInput = modal?.querySelector('textarea[name="deskripsi"]');
    const tipeSelect = modal?.querySelector('select[name="tipe"]');
    const previewImg = modal?.querySelector('img.preview');

    const openModal = (data) => {
        if (!modal || !form || !judulInput || !deskripsiInput || !tipeSelect) return;
        form.action = data.action || '#';
        judulInput.value = data.judul || '';
        deskripsiInput.value = data.deskripsi || '';
        tipeSelect.value = data.tipe || 'berita';
        if (previewImg) {
            if (data.img) {
                previewImg.src = data.img;
                previewImg.style.display = 'block';
            } else {
                previewImg.style.display = 'none';
            }
        }
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        if (!modal) return;
        modal.classList.remove('show');
        document.body.style.overflow = '';
        if (form) form.reset();
    };

    document.querySelectorAll('.btn-edit-berita').forEach(btn => {
        btn.addEventListener('click', () => {
            openModal({
                action: btn.dataset.action,
                judul: btn.dataset.judul,
                deskripsi: btn.dataset.deskripsi,
                tipe: btn.dataset.tipe,
                img: btn.dataset.img
            });
        });
    });

    overlay?.addEventListener('click', closeModal);
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
});
</script>
@endpush

<div class="modal-edit" id="modalEditBerita" aria-hidden="true">
    <div class="modal-edit__overlay"></div>
    <div class="modal-edit__dialog">
        <div class="modal-edit__header">
            <div>
                <h3 style="margin:0; font-size:18px;">Edit Berita</h3>
                <span class="muted" style="font-size:13px;">Perbarui konten berita atau rekomendasi</span>
            </div>
            <button type="button" class="modal-edit__close" aria-label="Tutup">×</button>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <label for="edit-gambar" class="label">Gambar (opsional)</label>
                <input type="file" name="gambar" id="edit-gambar" accept="image/*" style="width:100%;">
                <div style="margin-top:8px;">
                    <span class="muted" style="display:block; margin-bottom:6px;">Pratinjau saat ini:</span>
                    <img class="preview" src="" alt="Pratinjau gambar" style="display:none;">
                </div>
            </div>
            <div class="form-row">
                <label for="edit-judul" class="label">Judul</label>
                <input type="text" name="judul" id="edit-judul" required style="width:97%;">
            </div>
            <div class="form-row">
                <label for="edit-deskripsi" class="label">Deskripsi</label>
                <textarea name="deskripsi" id="edit-deskripsi" rows="6" required style="width:97%;"></textarea>
            </div>
            <div class="form-row">
                <label for="edit-tipe" class="label">Tipe</label>
                <select name="tipe" id="edit-tipe" required style="width:100%; background:#fff;">
                    <option value="berita">Berita</option>
                    <option value="rekomendasi">Rekomendasi Desa Wisata</option>
                </select>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <button type="submit" style="padding:10px 16px; background:#3f51d7; color:#fff; border:none; border-radius:8px; cursor:pointer;">Simpan Perubahan</button>
                <button type="button" class="modal-edit__close" style="padding:10px 16px; min-width:96px; text-align:center; background:#9ca3af; color:#fff; border-radius:8px; border:none; cursor:pointer;">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection
