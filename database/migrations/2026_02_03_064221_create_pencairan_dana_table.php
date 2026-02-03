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
Schema::create('pencairan_dana', function (Blueprint $table) {
    $table->id('id_pencairan');
    $table->foreignId('pegawai_id')
          ->constrained('pegawai', 'id_pegawai')
          ->restrictOnDelete();
    $table->string('jenis_dana');
    $table->decimal('nominal', 15, 2);
    $table->date('tanggal');
    $table->text('keterangan')->nullable();
    $table->enum('status_notifikasi', ['belum', 'terkirim', 'gagal'])->default('belum');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencairan_dana');
    }
};
