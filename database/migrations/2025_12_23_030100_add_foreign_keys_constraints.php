<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // payments.booking_id -> bookings.id (cascade on delete to keep data konsisten)
        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'booking_id')) {
            Schema::table('payments', function (Blueprint $table) {
                if ($this->hasForeign('payments', 'payments_booking_id_foreign')) {
                    $table->dropForeign('payments_booking_id_foreign');
                }
                $table->foreign('booking_id')
                    ->references('id')
                    ->on('bookings')
                    ->onDelete('cascade');
            });
        }

        // sessions.user_id -> users.id (set null agar sesi tetap aman bila user dihapus)
        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            Schema::table('sessions', function (Blueprint $table) {
                if ($this->hasForeign('sessions', 'sessions_user_id_foreign')) {
                    $table->dropForeign('sessions_user_id_foreign');
                }
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'booking_id')) {
            Schema::table('payments', function (Blueprint $table) {
                if ($this->hasForeign('payments', 'payments_booking_id_foreign')) {
                    $table->dropForeign('payments_booking_id_foreign');
                }
            });
        }

        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            Schema::table('sessions', function (Blueprint $table) {
                if ($this->hasForeign('sessions', 'sessions_user_id_foreign')) {
                    $table->dropForeign('sessions_user_id_foreign');
                }
            });
        }
    }

    protected function hasForeign(string $table, string $constraint): bool
    {
        $database = DB::getDatabaseName();
        $exists = DB::selectOne(
            'SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? AND CONSTRAINT_TYPE = \'FOREIGN KEY\'',
            [$database, $table, $constraint]
        );
        return (bool) $exists;
    }
};
