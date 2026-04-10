<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class BeritaController extends Controller
{
    public function index()
    {
        $items = Berita::latest()->get();
        return view('admin.berita', compact('items'));
    }

    public function edit(Berita $beritum)
    {
        return view('admin.berita-edit', ['item' => $beritum]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe' => 'required|in:berita,rekomendasi',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $dir = public_path('images/berita');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $ext = $request->file('gambar')->getClientOriginalExtension();
            $filename = Str::uuid()->toString() . '.' . $ext;
            $request->file('gambar')->move($dir, $filename);
            $validated['gambar'] = 'images/berita/' . $filename;
        }

        $now = Carbon::now('Asia/Jakarta');
        Berita::create(array_merge($validated, [
            'created_at' => $now,
            'updated_at' => $now,
        ]));

        return back()->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, Berita $beritum)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe' => 'required|in:berita,rekomendasi',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $dir = public_path('images/berita');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $ext = $request->file('gambar')->getClientOriginalExtension();
            $filename = Str::uuid()->toString() . '.' . $ext;
            $request->file('gambar')->move($dir, $filename);
            $validated['gambar'] = 'images/berita/' . $filename;

            if ($beritum->gambar) {
                $oldPath = public_path($beritum->gambar);
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $validated['updated_at'] = Carbon::now('Asia/Jakarta');
        $beritum->update($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum)
    {
        if ($beritum->gambar) {
            $path = public_path($beritum->gambar);
            if (is_file($path)) {
                @unlink($path);
            }
        }
        $beritum->delete();

        return back()->with('success', 'Berita dihapus.');
    }
}
