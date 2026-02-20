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
        Schema::table('kelompok_mitra_detail', function (Blueprint $table) {

            // Tambahkan unique composite index
            $table->unique(
                ['mitra_id', 'kelompok_id'],
                'kelompok_mitra_detail_mitra_kelompok_unique'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelompok_mitra_detail', function (Blueprint $table) {

            $table->dropUnique(
                'kelompok_mitra_detail_mitra_kelompok_unique'
            );

        });
    }
};