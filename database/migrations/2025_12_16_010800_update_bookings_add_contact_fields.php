<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bookings')) {
            return;
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'order_id')) {
                $table->foreignId('order_id')->nullable()->change();
            }
            if (!Schema::hasColumn('bookings', 'contact_name')) {
                $table->string('contact_name')->nullable()->after('code');
                $table->string('contact_email')->nullable()->after('contact_name');
                $table->string('contact_phone')->nullable()->after('contact_email');
            }
            if (!Schema::hasColumn('bookings', 'visit_time')) {
                $table->string('visit_time')->nullable()->after('visit_date');
            }
            if (!Schema::hasColumn('bookings', 'ticket_count')) {
                $table->unsignedInteger('ticket_count')->default(1)->after('guests');
            }
            if (!Schema::hasColumn('bookings', 'price')) {
                $table->unsignedBigInteger('price')->default(0)->after('ticket_count');
                $table->unsignedBigInteger('admin_fee')->default(0)->after('price');
            }
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('total_amount');
                $table->string('payment_status')->default('pending')->after('payment_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'payment_status')) {
                $table->dropColumn(['payment_status', 'payment_method']);
            }
            if (Schema::hasColumn('bookings', 'admin_fee')) {
                $table->dropColumn(['admin_fee', 'price', 'ticket_count']);
            }
            if (Schema::hasColumn('bookings', 'visit_time')) {
                $table->dropColumn('visit_time');
            }
            if (Schema::hasColumn('bookings', 'contact_name')) {
                $table->dropColumn(['contact_name', 'contact_email', 'contact_phone']);
            }
            if (Schema::hasColumn('bookings', 'order_id')) {
                $table->foreignId('order_id')->nullable(false)->change();
            }
        });
    }
};
