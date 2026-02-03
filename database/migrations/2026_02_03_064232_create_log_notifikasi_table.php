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
Schema::create('log_notifikasi', function (Blueprint $table) {
    $table->id('id_log');
    $table->foreignId('id_pencairan')
          ->constrained('pencairan_dana', 'id_pencairan')
          ->cascadeOnDelete();
    $table->timestamp('waktu_kirim')->nullable();
    $table->enum('status_kirim', ['berhasil', 'gagal']);
    $table->text('respon_api')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_notifikasi');
    }
};
