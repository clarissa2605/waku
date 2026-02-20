<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_mitra_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('kelompok_id');

            $table->timestamps();

            $table->foreign('mitra_id')
                  ->references('id_mitra')
                  ->on('mitra')
                  ->onDelete('cascade');

            $table->foreign('kelompok_id')
                  ->references('id_kelompok')
                  ->on('kelompok_mitra')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_mitra_detail');
    }
};