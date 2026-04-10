<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('code')->unique();
                $table->string('contact_name')->nullable();
                $table->string('contact_email')->nullable();
                $table->string('contact_phone')->nullable();
                $table->string('package_name')->default('Kunjungan Kampung Tematik');
                $table->date('visit_date');
                $table->string('visit_time')->nullable();
                $table->unsignedInteger('guests')->default(1);
                $table->unsignedInteger('ticket_count')->default(1);
                $table->unsignedBigInteger('price')->default(0);
                $table->unsignedBigInteger('admin_fee')->default(0);
                $table->enum('status', ['pending', 'process', 'success', 'cancelled'])->default('pending');
                $table->decimal('total_amount', 12, 2)->default(0);
                $table->string('payment_method')->nullable();
                $table->string('payment_status')->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
