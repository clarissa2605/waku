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
Schema::create('kelompok_mitra', function (Blueprint $table) {
    $table->id();
    $table->foreignId('id_kelompok')
          ->constrained('kelompok_kegiatan', 'id_kelompok')
          ->cascadeOnDelete();
    $table->foreignId('id_mitra')
          ->constrained('mitra', 'id_mitra')
          ->cascadeOnDelete();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_mitra');
    }
};
