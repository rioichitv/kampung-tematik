<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'booking_id')) {
                if (Schema::hasTable('bookings')) {
                    $table->foreignId('booking_id')->nullable()->after('id')->constrained('bookings')->nullOnDelete();
                } else {
                    $table->unsignedBigInteger('booking_id')->nullable()->after('id');
                    // FK akan ditambahkan manual jika tabel bookings sudah ada
                }
            }
            if (!Schema::hasColumn('payments', 'log')) {
                $table->json('log')->nullable()->after('type');
            }
            if (!Schema::hasColumn('payments', 'pid')) {
                $table->string('pid')->nullable()->after('order_id');
            }
        });

        if (Schema::hasTable('payments') && Schema::hasTable('bookings') && Schema::hasColumn('payments', 'booking_id')) {
            // foreign key already applied via constrained() above
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'booking_id')) {
                $table->dropForeign(['booking_id']);
                $table->dropColumn('booking_id');
            }
            if (Schema::hasColumn('payments', 'log')) {
                $table->dropColumn('log');
            }
            if (Schema::hasColumn('payments', 'pid')) {
                $table->dropColumn('pid');
            }
        });
    }
};
