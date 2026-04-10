<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;
use Midtrans\Transaction;

class BookingController extends Controller
{
    public function show()
    {
        return view('booking');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|string|max:150',
                'email' => 'required|email|max:150',
                'phone' => 'required|string|max:50',
                'booking_date' => 'required|date',
                'visit_date' => 'required|date|after_or_equal:today',
                'visit_time' => 'nullable|string|max:50',
                'ticket_count' => 'required|integer|min:1|max:100',
                'payment_method' => 'required|string|max:50',
                'package_name' => 'required|string|in:1000 Topeng,Glintung Go-Green,Warna-Warni Jodipan,Biru Arema',
            ],
            [
                'visit_date.after_or_equal' => 'Tidak bisa memilih tanggal tersebut dikarenakan waktu telah berlalu!',
            ]
        );

        $ticketPrice = 10000;
        $adminFee = 500;
        $orderId = 'INV' . strtoupper(Str::random(10));
        $bookingDate = now()->toDateString();
        $visitDate = $data['visit_date'];

        $booking = Booking::create([
            'order_id' => $orderId,
            'contact_name' => $data['name'],
            'contact_email' => $data['email'],
            'contact_phone' => $data['phone'],
            'package_name' => $data['package_name'],
            'layanan' => $data['package_name'],
            'visit_date' => $bookingDate, // tanggal pesan
            'visit_time' => $visitDate, // tanggal kunjungan
            'guests' => $data['ticket_count'],
            'ticket_count' => $data['ticket_count'],
            'price' => $ticketPrice,
            'admin_fee' => $adminFee,
            'status' => 'pending',
            'total_amount' => (($ticketPrice * $data['ticket_count']) + $adminFee),
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'notes' => null,
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => $orderId,
            'pid' => null,
            'harga' => $ticketPrice * $data['ticket_count'],
            'fee' => $adminFee,
            'total_harga' => ($ticketPrice * $data['ticket_count']) + $adminFee,
            'no_pembayaran' => $orderId,
            'no_pembeli' => $data['phone'],
            'status' => 'pending',
            'metode' => $data['payment_method'],
            'metode_tipe' => null,
            'snap_token' => null,
            'reference' => null,
            'type' => 'booking',
            'log' => [],
        ]);

        $midtrans = $this->prepareMidtransConfig();
        $snapToken = null;
        $redirectUrl = null;

        if ($midtrans) {
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $payment->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $booking->contact_name,
                    'email' => $booking->contact_email,
                    'phone' => $booking->contact_phone,
                ],
                'item_details' => [
                    [
                        'id' => 'ticket',
                        'price' => $ticketPrice,
                        'quantity' => $data['ticket_count'],
                        'name' => 'Tiket Kunjungan',
                    ],
                    [
                        'id' => 'admin_fee',
                        'price' => $adminFee,
                        'quantity' => 1,
                        'name' => 'Biaya Admin',
                    ],
                ],
                'callbacks' => [
                    'finish' => route('booking.invoice', $payment->order_id),
                ],
            ];

            try {
                $snapResponse = Snap::createTransaction($params);
                $snapToken = $snapResponse->token ?? null;
                $redirectUrl = $snapResponse->redirect_url ?? null;
                $log = $payment->log ?? [];
                $log['snap'] = $snapResponse;
                $payment->update([
                    'reference' => $snapToken,
                    'snap_token' => $snapToken,
                    'log' => $log,
                ]);
                $payment->refresh();
                $this->autoMarkPaidInSandbox($payment);
            } catch (\Throwable $e) {
                // log silently; continue with normal flow
                \Log::error('Midtrans error: '.$e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'booking_code' => $booking->order_id,
            'order_id' => $payment->order_id,
            'invoice_url' => $redirectUrl ?: route('booking.invoice', $payment->order_id),
            'summary' => [
                'package_name' => $booking->package_name,
                'method' => $payment->metode,
                'tickets' => $booking->ticket_count,
                'admin_fee' => $booking->admin_fee,
                'total' => $payment->total_harga,
            ],
            'snap_token' => $snapToken,
            'snap_redirect_url' => $redirectUrl,
        ]);
    }

    public function invoice(string $order)
    {
        $payment = Payment::where('order_id', $order)->with('booking')->firstOrFail();

        // If Midtrans redirected back with status params, honor them immediately
        if ($status = request()->input('transaction_status')) {
            $this->updatePaymentStatus(
                $payment,
                $status,
                request()->input('transaction_id'),
                request()->all()
            );
        }

        $this->refreshMidtransStatus($payment);
        $payment->refresh()->load('booking');
        if ($payment->booking) {
            $this->ensureVisitCode($payment->booking, $payment);
        }

        return view('invoice', [
            'payment' => $payment,
            'booking' => $payment->booking,
        ]);
    }

    public function history()
    {
        $recentBookings = Booking::with('payments')
            ->latest()
            ->take(5)
            ->get();

        return view('riwayat', [
            'recentBookings' => $recentBookings,
        ]);
    }

    public function searchInvoice(Request $request)
    {
        $data = $request->validate([
            'invoice_code' => ['required', 'string', 'max:100'],
        ]);

        $invoice = trim($data['invoice_code']);
        $payment = Payment::where('order_id', $invoice)->with('booking')->first();

        if (! $payment) {
            return back()->with('invoice_not_found', true)->withInput();
        }

        return redirect()->route('booking.invoice', $payment->order_id);
    }

    protected function prepareMidtransConfig(): bool
    {
        $gateway = Gateway::first();
        $serverKey = $gateway?->server_key;
        $clientKey = $gateway?->client_key;

        if (! $serverKey || ! $clientKey) {
            return false;
        }

        MidtransConfig::$serverKey = $serverKey;
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production', false);
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        return true;
    }

    /**
     * Dalam mode sandbox, begitu snap_token tersimpan kita anggap pembayaran lunas
     * agar alur testing lebih cepat tanpa menunggu callback Midtrans.
     */
    protected function autoMarkPaidInSandbox(Payment $payment): void
    {
        if (config('midtrans.is_production')) {
            return;
        }

        if (! $payment->snap_token) {
            return;
        }

        $currentStatus = strtolower($payment->status ?? '');
        if (in_array($currentStatus, ['paid', 'settlement', 'lunas', 'success'], true)) {
            return;
        }

        $log = $payment->log ?? [];
        $log['sandbox_auto_paid'] = [
            'reason' => 'snap_token tersimpan di mode sandbox',
            'at' => now()->toDateTimeString(),
        ];

        $payment->update([
            'status' => 'paid',
            'reference' => $payment->reference ?: $payment->snap_token,
            'log' => $log,
        ]);

        if ($payment->booking) {
            $payment->booking->update([
                'payment_status' => 'paid',
                'status' => 'success',
            ]);
            $this->ensureVisitCode($payment->booking, $payment);
        }
    }

    protected function refreshMidtransStatus(Payment $payment): void
    {
        $this->autoMarkPaidInSandbox($payment);

        if ($payment->status === 'paid' || $payment->status === 'success') {
            return;
        }

        // If we already stored a successful log (e.g., Snap redirect) use it first
        if ($logStatus = $this->transactionStatusFromLog($payment)) {
            $this->updatePaymentStatus($payment, $logStatus['status'], $logStatus['id'], $payment->log ?? []);
            if ($payment->status === 'paid') {
                return;
            }
        }

        if (! $this->prepareMidtransConfig()) {
            return;
        }

        try {
            $status = \Midtrans\Transaction::status($payment->order_id);
            $this->updatePaymentStatus(
                $payment,
                $status['transaction_status'] ?? null,
                $status['transaction_id'] ?? null,
                $status
            );
        } catch (\Throwable $e) {
            \Log::warning('Midtrans status check failed: '.$e->getMessage());
        }
    }

    public function midtransNotification(Request $request)
    {
        // Log the complete JSON payload for debugging
        $fullJson = $request->all();
        \Log::info('Midtrans notification received - FULL JSON', [
            'full_payload' => $fullJson,
            'order_id' => $request->input('order_id'),
            'transaction_status' => $request->input('transaction_status'),
            'transaction_id' => $request->input('transaction_id'),
            'status_code' => $request->input('status_code'),
            'status_message' => $request->input('status_message'),
        ]);

        if (! $this->prepareMidtransConfig()) {
            \Log::error('Midtrans notification failed: Midtrans key missing');
            return response()->json(['message' => 'Midtrans key missing'], 400);
        }

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $transactionStatus = $request->input('transaction_status');

        $serverKey = MidtransConfig::$serverKey;
        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);
        if (! $signatureKey || $signatureKey !== $expectedSignature) {
            \Log::warning('Midtrans notification failed: Invalid signature', [
                'order_id' => $orderId,
                'provided_signature' => $signatureKey,
                'expected_signature' => $expectedSignature,
            ]);
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $payment = Payment::where('order_id', $orderId)->with('booking')->first();
        if (! $payment) {
            \Log::warning('Midtrans notification failed: Order not found', [
                'order_id' => $orderId,
            ]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        \Log::info('Processing Midtrans notification for payment update', [
            'order_id' => $orderId,
            'current_payment_status' => $payment->status,
            'new_transaction_status' => $transactionStatus,
        ]);

        $this->updatePaymentStatus(
            $payment,
            $transactionStatus,
            $request->input('transaction_id'),
            $request->all()
        );

        \Log::info('Midtrans notification processed successfully', [
            'order_id' => $orderId,
            'updated_payment_status' => $payment->fresh()->status,
        ]);

        return response()->json(['message' => 'ok']);
    }

    protected function updatePaymentStatus(Payment $payment, ?string $transactionStatus, ?string $transactionId, $rawLog = null): void
    {
        $log = $payment->log ?? [];
        $log['snap'] = $rawLog;
        $log['last_checked_at'] = now()->toDateTimeString();

        // Check if rawLog is an array or object and extract status-message
        $statusMessage = null;
        if (is_array($rawLog)) {
            $statusMessage = $rawLog['status_message'] ?? null;
        } elseif (is_object($rawLog)) {
            $statusMessage = $rawLog->status_message ?? null;
        }

        // If transaction_status is "capture" AND status-message is "success", force to paid
        if ($transactionStatus === 'capture' && $statusMessage === 'success') {
            \Log::info('Payment auto-updated to paid based on capture + success status', [
                'order_id' => $payment->order_id,
                'transaction_status' => $transactionStatus,
                'status_message' => $statusMessage,
            ]);
            $payment->update([
                'status' => 'paid',
                'reference' => $transactionId ?? $payment->reference,
                'log' => $log,
            ]);
            if ($payment->booking) {
                $payment->booking->update([
                    'payment_status' => 'paid',
                    'status' => 'success',
                ]);
            }
            return;
        }

        // Fallback to original logic if no status-message success
        if (! $transactionStatus) {
            return;
        }

        $isSuccess = in_array($transactionStatus, ['capture', 'settlement']);
        $isCancel = in_array($transactionStatus, ['cancel', 'expire', 'deny']);
        $isPending = $transactionStatus === 'pending';
        $isChallenge = $transactionStatus === 'capture' && (($rawLog['fraud_status'] ?? $rawLog->fraud_status ?? null) === 'challenge');

        if ($isSuccess && ! $isChallenge) {
            $payment->update([
                'status' => 'paid',
                'reference' => $transactionId ?? $payment->reference,
                'log' => $log,
            ]);
            if ($payment->booking) {
                $payment->booking->update([
                    'payment_status' => 'paid',
                    'status' => 'success',
                ]);
                $this->ensureVisitCode($payment->booking, $payment);
            }
        } elseif ($isCancel) {
            $payment->update([
                'status' => 'cancel',
                'reference' => $transactionId ?? $payment->reference,
                'log' => $log,
            ]);
            if ($payment->booking) {
                $payment->booking->update([
                    'payment_status' => 'cancel',
                    'status' => 'cancel',
                ]);
                $this->ensureVisitCode($payment->booking, $payment);
            }
        } elseif ($isPending || $isChallenge) {
            $payment->update([
                'status' => 'pending',
                'reference' => $transactionId ?? $payment->reference,
                'log' => $log,
            ]);
            if ($payment->booking) {
                $payment->booking->update([
                    'payment_status' => 'pending',
                    'status' => $payment->booking->status === 'success' ? 'success' : 'process',
                ]);
                $this->ensureVisitCode($payment->booking, $payment);
            }
        }
    }

    protected function transactionStatusFromLog(Payment $payment): ?array
    {
        $log = $payment->log ?? null;
        if (! $log || ! is_array($log)) {
            return null;
        }
        $snap = $log['snap'] ?? null;
        if (! $snap) {
            return null;
        }

        // Normalize to array
        if (is_object($snap)) {
            $snap = (array) $snap;
        }

        $status = $snap['transaction_status'] ?? null;
        $tid = $snap['transaction_id'] ?? null;

        // Some payloads put status under nested keys or include status_code only
        if (! $status && isset($snap['status_code']) && ($snap['status_code'] === '200' || $snap['status_code'] === 200)) {
            $status = $snap['fraud_status'] === 'challenge' ? 'pending' : 'settlement';
        }
        if (!$tid && isset($snap['order_id'])) {
            $tid = $snap['order_id'];
        }

        if (! $status) {
            return null;
        }

        return ['status' => $status, 'id' => $tid];
    }

    protected function ensureVisitCode(Booking $booking, ?Payment $payment = null): void
    {
        $paidStatuses = ['paid', 'settlement', 'lunas', 'success'];
        $processStatuses = ['process', 'processing', 'on_process', 'onprocess', 'success'];

        $paymentState = strtolower($booking->payment_status ?? '');
        $statusState = strtolower($booking->status ?? '');

        $eligible = in_array($paymentState, $paidStatuses, true) && in_array($statusState, $processStatuses, true);

        // Gunakan visit_code yang sudah ada, prioritaskan milik booking lalu payment
        $visitCode = $booking->visit_code ?: ($payment?->visit_code);

        // Jika memenuhi syarat tapi belum ada kode, buat baru
        if ($eligible && ! $visitCode) {
            $visitCode = 'KPTEMATIK' . strtoupper(Str::random(8));
        }

        // Jika tidak memenuhi syarat, kosongkan kode
        if (! $eligible) {
            $visitCode = null;
        }

        // Simpan perubahan ke booking bila diperlukan
        if ($booking->visit_code !== $visitCode) {
            $booking->visit_code = $visitCode;
            $booking->save();
        }

        // Sinkronkan ke payment (jika ada)
        if ($payment && $payment->visit_code !== $visitCode) {
            $payment->visit_code = $visitCode;
            $payment->save();
        }
    }
}
