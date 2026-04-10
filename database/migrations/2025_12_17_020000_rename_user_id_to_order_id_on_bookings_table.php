<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bookings')) {
            return;
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'user_id') && ! Schema::hasColumn('bookings', 'order_id')) {
                // Drop FK if exists, then rename column
                try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
                $table->renameColumn('user_id', 'order_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('bookings')) {
            return;
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'order_id') && ! Schema::hasColumn('bookings', 'user_id')) {
                try { $table->dropForeign(['order_id']); } catch (\Throwable $e) {}
                $table->renameColumn('order_id', 'user_id');
            }
        });
    }
};
