<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gateway', function (Blueprint $table) {
            if (Schema::hasColumn('gateway', 'methodpayment_id')) {
                // Drop FK if it exists, then drop the column
                try {
                    $table->dropForeign(['methodpayment_id']);
                } catch (\Throwable $e) {
                    // ignore if FK name differs or doesn't exist
                }
                $table->dropColumn('methodpayment_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gateway', function (Blueprint $table) {
            if (! Schema::hasColumn('gateway', 'methodpayment_id')) {
                $table->unsignedBigInteger('methodpayment_id')->nullable()->after('id');
            }
        });
    }
};
