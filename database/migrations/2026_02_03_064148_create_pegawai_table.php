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
Schema::create('pegawai', function (Blueprint $table) {
    $table->id('id_pegawai');
    $table->string('nip')->unique();
    $table->string('nama');
    $table->string('unit_kerja');
    $table->string('no_whatsapp');
    $table->foreignId('mitra_id')
          ->constrained('mitra', 'id_mitra')
          ->restrictOnDelete();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
