<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminId = $request->session()->get('admin_id');

        if (! $adminId || ! User::where('id', $adminId)->where('role', 'admin')->exists()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
