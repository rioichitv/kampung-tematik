<?php

use Illuminate\Support\Facades\DB;

// Ambil kredensial langsung dari tabel gateway (fallback null jika belum ada/tabel belum siap)
$gateway = null;
try {
    $gateway = DB::table('gateway')->first();
} catch (\Throwable $e) {
    $gateway = null;
}

return [
    'is_production' => env('MIDTRANS_PRODUCTION', false),
    'server_key' => $gateway->server_key ?? null,
    'client_key' => $gateway->client_key ?? null,
    'merchant_id' => $gateway->merchant_id ?? null,
    'is_sanitized' => true,
    'is_3ds' => true,
];
