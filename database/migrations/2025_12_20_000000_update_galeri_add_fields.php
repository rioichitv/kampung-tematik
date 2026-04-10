<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            if (! Schema::hasColumn('galeri', 'media_path')) {
                $table->string('media_path', 255)->nullable()->after('jenis');
            }
            if (! Schema::hasColumn('galeri', 'tipe')) {
                $table->enum('tipe', ['event', 'galeri'])->default('event')->after('media_path');
            }
            if (! Schema::hasColumn('galeri', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            if (Schema::hasColumn('galeri', 'tipe')) {
                $table->dropColumn('tipe');
            }
            if (Schema::hasColumn('galeri', 'media_path')) {
                $table->dropColumn('media_path');
            }
            if (Schema::hasColumn('galeri', 'created_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
