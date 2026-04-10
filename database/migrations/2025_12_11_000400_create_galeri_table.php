<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id('id_galeri');
            $table->unsignedBigInteger('id_kampung');
            $table->enum('jenis', ['foto', 'video']);
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->date('tanggal_upload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
