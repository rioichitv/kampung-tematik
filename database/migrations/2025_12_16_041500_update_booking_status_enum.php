<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'status')) {
            DB::statement("
                ALTER TABLE bookings
                MODIFY status ENUM('pending','process','success','cancel','cancelled') DEFAULT 'pending'
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'status')) {
            DB::statement("
                ALTER TABLE bookings
                MODIFY status ENUM('pending','process','success','cancelled') DEFAULT 'pending'
            ");
        }
    }
};
