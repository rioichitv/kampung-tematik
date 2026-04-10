<?php

namespace Database\Seeders;

use App\Models\MethodPayment;
use Illuminate\Database\Seeder;

class MethodPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // QRIS
            ['name' => 'QRIS', 'code' => 'QRIS', 'description' => 'QRIS', 'type' => 'qris', 'image_path' => 'images/payment/qris.webp'],

            // E-Wallet
            ['name' => 'LinkAja', 'code' => 'LinkAja', 'description' => 'LinkAja', 'type' => 'e-wallet', 'image_path' => 'images/payment/linkaja-payment.webp'],
            ['name' => 'DANA', 'code' => 'DANA', 'description' => 'DANA', 'type' => 'e-wallet', 'image_path' => 'images/payment/dana.webp'],
            ['name' => 'OVO', 'code' => 'OVO', 'description' => 'OVO', 'type' => 'e-wallet', 'image_path' => 'images/payment/ovo.webp'],
            ['name' => 'Gopay', 'code' => 'Gopay', 'description' => 'Gopay', 'type' => 'e-wallet', 'image_path' => 'images/payment/Gopay.webp'],

            // Transfer Bank
            ['name' => 'BSI Transfer', 'code' => 'BSI Transfer', 'description' => 'BSI Transfer', 'type' => 'transfer-bank', 'image_path' => 'images/payment/bsi.webp'],
            ['name' => 'CIMB Niaga Transfer', 'code' => 'CIMB Niaga Transfer', 'description' => 'CIMB Niaga Transfer', 'type' => 'transfer-bank', 'image_path' => 'images/payment/cimb.webp'],
            ['name' => 'BNI Transfer', 'code' => 'BNI Transfer', 'description' => 'BNI Transfer', 'type' => 'transfer-bank', 'image_path' => 'images/payment/bni.webp'],
            ['name' => 'Mandiri Transfer', 'code' => 'Mandiri Transfer', 'description' => 'Mandiri Transfer', 'type' => 'transfer-bank', 'image_path' => 'images/payment/mandiri.webp'],
            ['name' => 'Permata Transfer', 'code' => 'Permata Transfer', 'description' => 'Permata Transfer', 'type' => 'transfer-bank', 'image_path' => 'images/payment/permata.webp'],
            ['name' => 'BCA Transfer', 'code' => 'BCA Transfer', 'description' => 'BCA Transfer', 'type' => 'transfer-bank', 'image_path' => 'images/payment/bca.webp'],

            // Virtual Account
            ['name' => 'Mandiri VA', 'code' => 'Mandiri VA', 'description' => 'Mandiri VA', 'type' => 'virtual-account', 'image_path' => 'images/payment/mandiri.webp'],
            ['name' => 'Permata VA', 'code' => 'Permata VA', 'description' => 'Permata VA', 'type' => 'virtual-account', 'image_path' => 'images/payment/permata.webp'],
            ['name' => 'CIMB VA', 'code' => 'CIMB VA', 'description' => 'CIMB VA', 'type' => 'virtual-account', 'image_path' => 'images/payment/cimb.webp'],
            ['name' => 'BNI VA', 'code' => 'BNI VA', 'description' => 'BNI VA', 'type' => 'virtual-account', 'image_path' => 'images/payment/bni.webp'],
            ['name' => 'BSI VA', 'code' => 'BSI VA', 'description' => 'BSI VA', 'type' => 'virtual-account', 'image_path' => 'images/payment/bsi.webp'],
            ['name' => 'BCA VA', 'code' => 'BCA VA', 'description' => 'BCA VA', 'type' => 'virtual-account', 'image_path' => 'images/payment/bca.webp'],

            // Convenience Store
            ['name' => 'Alfamart', 'code' => 'Alfamart', 'description' => 'Alfamart', 'type' => 'convenience-store', 'image_path' => 'images/payment/alfamart.webp'],
        ];

        foreach ($items as $item) {
            MethodPayment::updateOrCreate(
                ['code' => $item['code']],
                $item
            );
        }
    }
}
