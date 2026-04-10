<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // unique id you send to Midtrans
            $table->unsignedBigInteger('harga'); // base price in smallest currency unit
            $table->unsignedBigInteger('fee')->default(0); // platform/pg fee
            $table->unsignedBigInteger('total_harga'); // final amount charged
            $table->string('no_pembayaran')->unique(); // internal payment number/invoice
            $table->string('no_pembeli'); // customer identifier (phone/email/user code)
            $table->string('status')->default('pending'); // pending|settlement|deny|cancel|expire|refund
            $table->string('metode')->nullable(); // qris|va|ewallet|cc etc.
            $table->string('metode_tipe')->nullable(); // bca|bni|gopay|shopeepay etc.
            $table->string('reference')->nullable(); // Midtrans transaction_id / reference id
            $table->string('type')->nullable(); // booking/deposit/other use-case tag
            $table->timestamps();

            $table->index(['status', 'metode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
