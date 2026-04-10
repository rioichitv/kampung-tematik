<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\MethodPaymentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomeController;
use App\Models\Galeri;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah semua route untuk aplikasi Kampung Tematik Malang.
| Halaman utama: beranda
| Sub-halaman: detail kampung (1000 Topeng, Glintung Go-Green, Warna-Warni Jodipan, Biru Arema)
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin auth + dashboard
Route::get('/admin', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/pin', [AdminAuthController::class, 'showPin'])->name('admin.pin');
Route::post('/admin/pin', [AdminAuthController::class, 'verifyPin'])->name('admin.pin.verify');
Route::get('/admin/pin/create', [AdminAuthController::class, 'showCreatePin'])->name('admin.pin.create');
Route::post('/admin/pin/create', [AdminAuthController::class, 'storePin'])->name('admin.pin.store');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('admin.auth')
    ->name('admin.dashboard');

Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('/berita', [BeritaController::class, 'index'])->name('admin.berita.index');
    Route::post('/berita', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('/berita/{beritum}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
    Route::put('/berita/{beritum}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('/berita/{beritum}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');

    Route::get('/method-payments', [MethodPaymentController::class, 'index'])->name('admin.methodpayments.index');
    Route::post('/method-payments', [MethodPaymentController::class, 'store'])->name('admin.methodpayments.store');
    Route::put('/method-payments/{methodpayment}', [MethodPaymentController::class, 'update'])->name('admin.methodpayments.update');
    Route::delete('/method-payments/{methodpayment}', [MethodPaymentController::class, 'destroy'])->name('admin.methodpayments.destroy');
    Route::post('/method-payments/credentials', [MethodPaymentController::class, 'updateCredentials'])->name('admin.methodpayments.credentials');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('admin.pesanan.index');
    Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
    Route::patch('/pesanan/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('admin.pesanan.updatePaymentStatus');
    Route::delete('/pesanan/{order}', [OrderController::class, 'destroy'])->name('admin.pesanan.destroy');

    // Konfigurasi Event & Galeri
    Route::get('/galeri', [GaleriController::class, 'index'])->name('admin.galeri.index');
    Route::post('/galeri/event', [GaleriController::class, 'storeEvent'])->name('admin.galeri.event.store');
    Route::post('/galeri', [GaleriController::class, 'storeGaleri'])->name('admin.galeri.store');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])->name('admin.galeri.update');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');
    // Konfigurasi pengguna (admin only)
    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/pengguna', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/pengguna/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/booking', [\App\Http\Controllers\BookingController::class, 'show'])->name('booking');
Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
Route::get('/invoice/{order}', [\App\Http\Controllers\BookingController::class, 'invoice'])->name('booking.invoice');
Route::get('/riwayat', [\App\Http\Controllers\BookingController::class, 'history'])->name('booking.history');
Route::post('/riwayat/search', [\App\Http\Controllers\BookingController::class, 'searchInvoice'])->name('booking.history.search');
Route::post(
    '/midtrans/notification',
    [\App\Http\Controllers\BookingController::class, 'midtransNotification']
)->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
 ->name('midtrans.notification');

Route::prefix('kampung')->group(function () {
    Route::get('/1000-topeng', function () {
        return view('kampung.topeng');
    })->name('kampung.topeng');

    Route::get('/1000-topeng/event', function () {
        $events = Galeri::where('tipe', 'event')->where('kategori', 'kampung-1000-topeng')->latest()->paginate(4);
        return view('kampung.topeng-event', compact('events'));
    })->name('kampung.topeng.event');

    Route::get('/1000-topeng/galeri', function () {
        $galleries = Galeri::where('tipe', 'galeri')->where('kategori', 'kampung-1000-topeng')->latest()->paginate(12);
        return view('kampung.topeng-galeri', compact('galleries'));
    })->name('kampung.topeng.galeri');

    Route::get('/1000-topeng/produk', function () {
        return view('kampung.topeng-produk');
    })->name('kampung.topeng.produk');

    Route::get('/1000-topeng/produk/checkout', function () {
        return view('topeng-checkout');
    })->name('kampung.topeng.checkout');
    Route::post('/1000-topeng/produk/checkout', [\App\Http\Controllers\TopengCheckoutController::class, 'store'])->name('kampung.topeng.checkout.store');

    Route::get('/glintung', function () {
        return view('kampung.glintung');
    })->name('kampung.glintung');

    Route::get('/glintung/event', function () {
        $events = Galeri::where('tipe', 'event')->where('kategori', 'glintung-go-green')->latest()->paginate(4);
        return view('kampung.glintung-event', compact('events'));
    })->name('kampung.glintung.event');

    Route::get('/glintung/galeri', function () {
        $galleries = Galeri::where('tipe', 'galeri')->where('kategori', 'glintung-go-green')->latest()->paginate(12);
        return view('kampung.glintung-galeri', compact('galleries'));
    })->name('kampung.glintung.galeri');

    Route::get('/warna-warni', function () {
        return view('kampung.warna');
    })->name('kampung.warna');

    Route::get('/warna-warni/event', function () {
        $events = Galeri::where('tipe', 'event')->where('kategori', 'warna-warni-jodipan')->latest()->paginate(4);
        return view('kampung.warna-event', compact('events'));
    })->name('kampung.warna.event');

    Route::get('/warna-warni/galeri', function () {
        $galleries = Galeri::where('tipe', 'galeri')->where('kategori', 'warna-warni-jodipan')->latest()->paginate(12);
        return view('kampung.warna-galeri', compact('galleries'));
    })->name('kampung.warna.galeri');

    Route::get('/biru-arema', function () {
        return view('kampung.biru');
    })->name('kampung.biru');

    Route::get('/biru-arema/event', function () {
        $events = Galeri::where('tipe', 'event')->where('kategori', 'biru-arema')->latest()->paginate(4);
        return view('kampung.biru-event', compact('events'));
    })->name('kampung.biru.event');

    Route::get('/biru-arema/galeri', function () {
        $galleries = Galeri::where('tipe', 'galeri')->where('kategori', 'biru-arema')->latest()->paginate(12);
        return view('kampung.biru-galeri', compact('galleries'));
    })->name('kampung.biru.galeri');
});
