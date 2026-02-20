<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_mitra', function (Blueprint $table) {
            $table->bigIncrements('id_kelompok');

            $table->string('nama_kelompok');
            $table->string('nama_kegiatan');
            $table->year('tahun');
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_mitra');
    }
};