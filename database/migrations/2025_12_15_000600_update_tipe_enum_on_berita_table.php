<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('berita')) {
            return;
        }

        // Normalisasi data yang ada agar sesuai dengan ENUM baru.
        DB::statement("UPDATE berita SET tipe = LOWER(TRIM(tipe)) WHERE tipe IS NOT NULL");
        DB::table('berita')->whereNull('tipe')->update(['tipe' => 'berita']);

        // Gunakan ENUM supaya hanya menerima 'berita' atau 'rekomendasi'.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE berita MODIFY tipe ENUM('berita','rekomendasi') NOT NULL DEFAULT 'berita'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('berita')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE berita MODIFY tipe VARCHAR(50) NOT NULL DEFAULT 'berita'");
        }
    }
};
