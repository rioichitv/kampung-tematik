<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // best-effort drop FK if exists
        try {
            DB::statement('ALTER TABLE bookings DROP FOREIGN KEY bookings_order_id_foreign');
        } catch (\Throwable $e) {
            // ignore
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'order_id')) {
                $table->dropColumn('order_id');
            }

            if (Schema::hasColumn('bookings', 'code')) {
                try { $table->dropUnique('bookings_code_unique'); } catch (\Throwable $e) {}
                $table->dropColumn('code');
            }

            $table->string('order_id', 50)->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'order_id')) {
                try { $table->dropUnique(['order_id']); } catch (\Throwable $e) {}
                $table->dropColumn('order_id');
            }
            if (! Schema::hasColumn('bookings', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('bookings', 'code')) {
                $table->string('code')->unique()->after('order_id');
            }
        });
    }
};
