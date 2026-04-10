<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::where('tipe', 'berita')->latest()->take(6)->get();
        $rekomendasi = Berita::where('tipe', 'rekomendasi')->latest()->take(6)->get();

        return view('home', compact('berita', 'rekomendasi'));
    }
}
