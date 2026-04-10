<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));

        $usersQuery = User::query()->where('role', 'admin');

        if ($search !== '') {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $users = $usersQuery->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:50', 'regex:/^[0-9]+$/'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'admin',
            'password' => Hash::make($validated['password']),
            'registered_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna admin berhasil dibuat.');
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:50', 'regex:/^[0-9]+$/'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna admin berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'admin') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna admin dihapus.');
    }
}
