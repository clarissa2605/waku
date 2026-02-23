<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pencairan_dana_mitra', function (Blueprint $table) {

            $table->bigIncrements('id_pencairan');

            // 🔗 Relasi ke mitra
            $table->unsignedBigInteger('mitra_id');

            // 🔥 Data pencairan
            $table->string('jenis_dana', 100);

            $table->decimal('nominal', 15, 2);
            $table->decimal('potongan', 15, 2)->default(0);
            $table->decimal('nominal_bersih', 15, 2);

            $table->date('tanggal');

            $table->text('keterangan')->nullable();

            $table->enum('status_notifikasi', ['belum', 'terkirim'])
                  ->default('belum');

            $table->timestamps();

            // 🔐 FOREIGN KEY
            $table->foreign('mitra_id')
                  ->references('id_mitra')
                  ->on('mitra')
                  ->onDelete('cascade');

            // 🔥 INDEX biar cepat query
            $table->index('mitra_id');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencairan_dana_mitra');
    }
};