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
    Schema::create('log_pencairan', function (Blueprint $table) {
        $table->id('id_log');
        $table->unsignedBigInteger('id_pencairan');
        $table->unsignedBigInteger('pegawai_id');

        $table->string('aksi'); // dibuat / terkirim / gagal
        $table->text('deskripsi')->nullable();

        $table->timestamps();

        $table->foreign('id_pencairan')
              ->references('id_pencairan')
              ->on('pencairan_dana')
              ->onDelete('cascade');

        $table->foreign('pegawai_id')
              ->references('id_pegawai')
              ->on('pegawai')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_pencairan');
    }
};
