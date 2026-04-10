@extends('admin.layout-admin')

@section('title', 'Edit Berita')

@section('content')
<div class="admin-shell">
    <div class="section">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h3 class="section-title">Edit Berita</h3>
                <span class="muted">Konfigurasi / Berita / Edit</span>
            </div>
            <a href="{{ route('admin.berita.index') }}" style="padding:8px 12px; background:#e5e7eb; border-radius:8px; color:#111827; text-decoration:none;">Kembali</a>
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
            <form action="{{ route('admin.berita.update', $item) }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:14px;">
                @csrf
                @method('PUT')
                <div>
                    <label for="gambar" class="label">Gambar (opsional)</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px;">
                    @if($item->gambar)
                        <div style="margin-top:8px;">
                            <span class="muted" style="display:block; margin-bottom:6px;">Pratinjau saat ini:</span>
                            <img src="{{ asset($item->gambar) }}" alt="Gambar saat ini" style="width:180px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #e5e7eb;">
                        </div>
                    @endif
                </div>
                <div>
                    <label for="judul" class="label">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $item->judul) }}" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px;">
                </div>
                <div>
                    <label for="deskripsi" class="label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="6" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px;">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                </div>
                <div>
                    <label for="tipe" class="label">Tipe</label>
                    <select name="tipe" id="tipe" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px; background:#fff;">
                        <option value="berita" {{ old('tipe', $item->tipe) === 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="rekomendasi" {{ old('tipe', $item->tipe) === 'rekomendasi' ? 'selected' : '' }}>Rekomendasi Desa Wisata</option>
                    </select>
                    <small style="color:#6b7280;">Tentukan posisi konten di halaman utama.</small>
                </div>
                <div style="display:flex; gap:10px; align-items:center;">
                    <button type="submit" style="padding:10px 16px; background:#3f51d7; color:#fff; border:none; border-radius:8px; cursor:pointer;">Simpan Perubahan</button>
                    <a href="{{ route('admin.berita.index') }}" style="padding:10px 14px; background:#e5e7eb; color:#111827; border-radius:8px; text-decoration:none;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
