<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Booking::with('payments')->latest()->paginate(10);
        return view('admin.pesanan', compact('orders'));
    }

    public function updateStatus(Booking $order)
    {
        $status = strtolower(request()->input('status', ''));
        $allowed = ['success', 'pending', 'process', 'cancel'];
        if (! in_array($status, $allowed, true)) {
            return back()->with('error', 'Status tidak valid.');
        }

        $bookingStatus = $status === 'cancel' ? 'cancel' : $status;

        $order->status = $bookingStatus;
        if ($status === 'cancel') {
            $order->payment_status = 'cancel';
        }
        $order->save();
        $this->syncVisitCode($order);

        $payment = $order->payments()->latest()->first();
        if ($payment) {
            // Hanya set cancel; status paid/unpaid diatur dari dropdown pembayaran
            if ($status === 'cancel') {
                $payment->status = 'cancel';
            }
            $payment->save();
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function updatePaymentStatus(Booking $order)
    {
        $status = strtolower(request()->input('payment_status', ''));
        $allowed = ['paid', 'unpaid'];
        if (! in_array($status, $allowed, true)) {
            return back()->with('error', 'Status pembayaran tidak valid.');
        }

        $order->payment_status = $status;
        $order->save();
        $this->syncVisitCode($order);

        $payment = $order->payments()->latest()->first();
        if ($payment) {
            $payment->status = $status;
            $payment->save();
        }

        return back()->with('success', 'Status pembayaran diperbarui.');
    }

    public function destroy(Booking $order)
    {
        $order->payments()->delete();
        $order->delete();

        return redirect()
            ->route('admin.pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    protected function syncVisitCode(Booking $booking): void
    {
        $paidStatuses = ['paid', 'settlement', 'lunas', 'success'];
        $processStatuses = ['process', 'processing', 'on_process', 'onprocess'];

        $paymentState = strtolower($booking->payment_status ?? '');
        $statusState = strtolower($booking->status ?? '');

        $isPaid = in_array($paymentState, $paidStatuses, true);
        $isSuccessOrProcess = $statusState === 'success' || in_array($statusState, $processStatuses, true);

        if ($isPaid && $isSuccessOrProcess) {
            if (! $booking->visit_code) {
                $booking->visit_code = 'KPTEMATIK' . strtoupper(Str::random(8));
                $booking->save();
            }
        } else {
            if ($booking->visit_code) {
                $booking->visit_code = null;
                $booking->save();
            }
        }

        // Sinkronkan ke payment terbaru
        $payment = $booking->payments()->latest()->first();
        if ($payment) {
            if ($booking->visit_code && $payment->visit_code !== $booking->visit_code) {
                $payment->visit_code = $booking->visit_code;
                $payment->save();
            }
            if (! $booking->visit_code && $payment->visit_code) {
                $payment->visit_code = null;
                $payment->save();
            }
        }
    }
}
