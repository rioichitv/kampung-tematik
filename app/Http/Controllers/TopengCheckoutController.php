<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopengCheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:200'],
            'product_price' => ['required', 'integer', 'min:0'],
            'payment_method' => ['required', 'string', 'max:50'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $orderId = 'INV' . strtoupper(Str::random(10));
        $today = now()->toDateString();
        $qty = (int) $data['quantity'];
        $adminFee = 500;
        $subtotal = $data['product_price'] * $qty;
        $grandTotal = $subtotal + $adminFee;

        $booking = Booking::create([
            'order_id' => $orderId,
            'contact_name' => $data['name'],
            'contact_email' => $data['email'],
            'contact_phone' => $data['phone'],
            'package_name' => $data['product_name'],
            'layanan' => $data['product_name'],
            'visit_date' => $today, // tanggal pesan
            'visit_time' => $today, // tidak ada tanggal kunjungan khusus
            'guests' => $qty,
            'ticket_count' => $qty,
            'price' => $subtotal,
            'admin_fee' => $adminFee,
            'status' => 'pending',
            'total_amount' => $grandTotal,
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'notes' => $data['address'] ?? null,
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => $orderId,
            'pid' => null,
            'harga' => $subtotal,
            'fee' => $adminFee,
            'total_harga' => $grandTotal,
            'no_pembayaran' => $orderId,
            'no_pembeli' => $data['phone'],
            'status' => 'pending',
            'metode' => $data['payment_method'],
            'metode_tipe' => null,
            'reference' => null,
            'type' => 'booking',
            'log' => [],
        ]);

        return redirect()->route('booking.invoice', $orderId);
    }
}
