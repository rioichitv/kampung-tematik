<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone', 50)->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('pin')->nullable();
                $table->string('role', 50)->default('user');
                $table->decimal('balance', 12, 2)->default(0);
                $table->timestamp('registered_at')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
