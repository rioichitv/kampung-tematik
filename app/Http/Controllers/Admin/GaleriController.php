<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GaleriController extends Controller
{
    public function index()
    {
        $items = Galeri::latest()->paginate(10);

        return view('admin.galeri', compact('items'));
    }

    public function storeEvent(Request $request)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'max:3072'],
            'judul' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $path = $this->storeMedia($request->file('image'));

        Galeri::create([
            'id_kampung' => 0,
            'jenis' => 'foto',
            'media_path' => $path,
            'tipe' => 'event',
            'judul' => $data['judul'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'tanggal_upload' => now()->toDateString(),
        ]);

        return back()->with('success', 'Event berhasil disimpan.');
    }

    public function storeGaleri(Request $request)
    {
        $data = $request->validate([
            'media' => ['required', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-matroska'],
            'judul' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'tipe' => ['required', 'in:event,galeri'],
            'kategori' => ['required', 'string', 'in:kampung-1000-topeng,glintung-go-green,warna-warni-jodipan,biru-arema'],
        ]);

        $file = $request->file('media');
        $mime = $file->getClientMimeType();
        $jenis = str_starts_with($mime, 'video') ? 'video' : 'foto';

        $path = $this->storeMedia($file);

        Galeri::create([
            'id_kampung' => 0,
            'jenis' => $jenis,
            'media_path' => $path,
            'tipe' => $data['tipe'],
            'kategori' => $data['kategori'],
            'judul' => $data['judul'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'tanggal_upload' => now()->toDateString(),
        ]);

        return back()->with('success', 'Galeri berhasil disimpan.');
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'media' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-matroska'],
            'judul' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'tipe' => ['required', 'in:event,galeri'],
            'kategori' => ['required', 'string', 'in:kampung-1000-topeng,glintung-go-green,warna-warni-jodipan,biru-arema'],
        ]);

        $update = [
            'judul' => $data['judul'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'tipe' => $data['tipe'],
            'kategori' => $data['kategori'],
        ];

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mime = $file->getClientMimeType();
            $jenis = str_starts_with($mime, 'video') ? 'video' : 'foto';
            $path = $this->storeMedia($file);
            $this->deleteMedia($galeri->media_path);
            $update['media_path'] = $path;
            $update['jenis'] = $jenis;
        }

        $galeri->update($update);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $this->deleteMedia($galeri->media_path);
        $galeri->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    protected function storeMedia($file): string
    {
        $dir = public_path('images/galeri');
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'images/galeri/' . $filename;
    }

    protected function deleteMedia(?string $path): void
    {
        if (! $path) {
            return;
        }
        $full = public_path($path);
        if (File::exists($full)) {
            File::delete($full);
        }
    }
}
