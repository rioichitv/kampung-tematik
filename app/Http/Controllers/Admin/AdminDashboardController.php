<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'admins' => User::where('role', 'admin')->count(),
        ];

        $today = Carbon::today();
        $successStatuses = ['settlement', 'capture', 'paid', 'success'];
        $cancelledStatuses = ['cancel', 'deny', 'expire', 'failed'];

        $todayStats = [
            'total' => [
                'amount' => Payment::whereDate('created_at', $today)->sum('total_harga'),
                'count' => Payment::whereDate('created_at', $today)->count(),
            ],
            'success' => [
                'amount' => Payment::whereDate('created_at', $today)->whereIn('status', $successStatuses)->sum('total_harga'),
                'count' => Payment::whereDate('created_at', $today)->whereIn('status', $successStatuses)->count(),
            ],
            'pending' => [
                'amount' => Payment::whereDate('created_at', $today)->where('status', 'pending')->sum('total_harga'),
                'count' => Payment::whereDate('created_at', $today)->where('status', 'pending')->count(),
            ],
            'cancelled' => [
                'amount' => Payment::whereDate('created_at', $today)->whereIn('status', $cancelledStatuses)->sum('total_harga'),
                'count' => Payment::whereDate('created_at', $today)->whereIn('status', $cancelledStatuses)->count(),
            ],
            'deposit' => [
                'amount' => Payment::whereDate('created_at', $today)->where('type', 'deposit')->whereIn('status', $successStatuses)->sum('total_harga'),
                'count' => Payment::whereDate('created_at', $today)->where('type', 'deposit')->whereIn('status', $successStatuses)->count(),
            ],
        ];

        $overallStats = [
            'total' => [
                'amount' => Payment::sum('total_harga'),
                'count' => Payment::count(),
            ],
            'success' => [
                'amount' => Payment::whereIn('status', $successStatuses)->sum('total_harga'),
                'count' => Payment::whereIn('status', $successStatuses)->count(),
            ],
            'pending' => [
                'amount' => Payment::where('status', 'pending')->sum('total_harga'),
                'count' => Payment::where('status', 'pending')->count(),
            ],
            'cancelled' => [
                'amount' => Payment::whereIn('status', $cancelledStatuses)->sum('total_harga'),
                'count' => Payment::whereIn('status', $cancelledStatuses)->count(),
            ],
            'deposit' => [
                'amount' => Payment::where('type', 'deposit')->whereIn('status', $successStatuses)->sum('total_harga'),
                'count' => Payment::where('type', 'deposit')->whereIn('status', $successStatuses)->count(),
            ],
            'profit' => [
                'amount' => Payment::whereIn('status', $successStatuses)->sum('total_harga') - Payment::sum('fee'),
                'count' => Payment::whereIn('status', $successStatuses)->count(),
            ],
        ];

        $orders7d = collect(range(6, 0, -1))->map(function ($i) {
            $date = Carbon::today()->subDays($i);
            return [
                'label' => $date->format('d M'),
                'value' => Payment::whereDate('created_at', $date)->count(),
            ];
        })->values();

        return view('admin.dashboard', [
            'stats' => $stats,
            'todayStats' => $todayStats,
            'overallStats' => $overallStats,
            'orders7d' => $orders7d,
        ]);
    }
}
