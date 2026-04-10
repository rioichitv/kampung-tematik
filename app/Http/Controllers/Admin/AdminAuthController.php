<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (request()->session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = User::where('email', $credentials['email'])
            ->where('role', 'admin')
            ->first();

        $isValid = false;

        if ($admin) {
            try {
                $isValid = Hash::check($credentials['password'], $admin->password);
            } catch (\RuntimeException $e) {
                // Hash tidak valid (kemungkinan tersimpan sebagai plaintext); coba samakan lalu rehash
                if ($admin->password === $credentials['password']) {
                    $admin->update(['password' => Hash::make($credentials['password'])]);
                    $isValid = true;
                }
            }
        }

        if (! $admin || ! $isValid) {
            return back()->withErrors(['email' => 'Email atau password tidak valid untuk admin.'])->withInput();
        }

        $request->session()->put('admin_pending_id', $admin->id);
        $request->session()->forget('admin_id');

        return redirect()->route('admin.pin');
    }

    public function showPin(Request $request)
    {
        if (! $request->session()->has('admin_pending_id')) {
            return redirect()->route('admin.login');
        }

        $adminId = $request->session()->get('admin_pending_id');
        $admin = User::where('id', $adminId)->where('role', 'admin')->first();

        if (! $admin) {
            return redirect()->route('admin.login');
        }

        // Jika admin belum memiliki PIN, arahkan ke halaman buat PIN lebih dulu
        if (! $admin->pin) {
            return redirect()->route('admin.pin.create');
        }

        return view('admin.pin');
    }

    public function showCreatePin(Request $request)
    {
        if (! $request->session()->has('admin_pending_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.pin-create');
    }

    public function storePin(Request $request): RedirectResponse
    {
        if (! $request->session()->has('admin_pending_id')) {
            return redirect()->route('admin.login');
        }

        $data = $request->validate([
            'pin' => ['required', 'digits_between:6,10', 'confirmed'],
        ]);

        $admin = User::where('id', $request->session()->get('admin_pending_id'))
            ->where('role', 'admin')
            ->first();

        if (! $admin) {
            return redirect()->route('admin.login');
        }

        $admin->pin = Hash::make($data['pin']);
        $admin->save();

        return redirect()->route('admin.pin')->with('success', 'PIN berhasil dibuat, silakan verifikasi PIN.');
    }

    public function verifyPin(Request $request): RedirectResponse
    {
        $request->validate([
            'pin' => ['required', 'digits_between:6,10'],
        ]);

        $adminId = $request->session()->get('admin_pending_id');

        if (! $adminId) {
            return redirect()->route('admin.login');
        }

        $admin = User::where('id', $adminId)->where('role', 'admin')->first();

        $pinValid = false;

        if ($admin) {
            try {
                $pinValid = Hash::check($request->pin, $admin->pin ?? '');
            } catch (\RuntimeException $e) {
                if (($admin->pin ?? '') === $request->pin) {
                    $admin->update(['pin' => Hash::make($request->pin)]);
                    $pinValid = true;
                }
            }
        }

        if (! $admin || ! $pinValid) {
            return back()->withErrors(['pin' => 'PIN tidak valid.']);
        }

        $request->session()->forget('admin_pending_id');
        $request->session()->put('admin_id', $admin->id);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_id');
        $request->session()->forget('admin_pending_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
