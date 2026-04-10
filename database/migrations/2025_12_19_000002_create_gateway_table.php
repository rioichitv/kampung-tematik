<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('methodpayment', function (Blueprint $table) {
            if (Schema::hasColumn('methodpayment', 'merchant_id')) {
                $table->dropColumn('merchant_id');
            }
            if (Schema::hasColumn('methodpayment', 'client_key')) {
                $table->dropColumn('client_key');
            }
            if (Schema::hasColumn('methodpayment', 'server_key')) {
                $table->dropColumn('server_key');
            }
        });

        Schema::create('gateway', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id')->nullable();
            $table->string('client_key')->nullable();
            $table->string('server_key')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gateway');

        Schema::table('methodpayment', function (Blueprint $table) {
            if (! Schema::hasColumn('methodpayment', 'merchant_id')) {
                $table->string('merchant_id')->nullable()->after('image_path');
            }
            if (! Schema::hasColumn('methodpayment', 'client_key')) {
                $table->string('client_key')->nullable()->after('merchant_id');
            }
            if (! Schema::hasColumn('methodpayment', 'server_key')) {
                $table->string('server_key')->nullable()->after('client_key');
            }
        });
    }
};
