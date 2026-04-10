<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected array $options = [
        'kampung-1000-topeng',
        'glintung-go-green',
        'warna-warni-jodipan',
        'biru-arema',
    ];

    public function up(): void
    {
        $enum = implode("','", $this->options);
        // Pastikan nilai lama aman sebelum diubah ke enum
        DB::table('galeri')
            ->whereNull('kategori')
            ->orWhereNotIn('kategori', $this->options)
            ->update(['kategori' => 'kampung-1000-topeng']);

        DB::statement("ALTER TABLE galeri MODIFY kategori ENUM('{$enum}') NOT NULL DEFAULT 'kampung-1000-topeng'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE galeri MODIFY kategori VARCHAR(100) NOT NULL DEFAULT 'kampung-1000-topeng'");
    }
};
