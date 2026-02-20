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
        Schema::table('mitra', function (Blueprint $table) {

            // ==========================
            // PERIODE KONTRAK
            // ==========================

            $table->date('tanggal_mulai_kontrak')
                  ->nullable()
                  ->after('jenis_mitra');

            $table->date('tanggal_selesai_kontrak')
                  ->nullable()
                  ->after('tanggal_mulai_kontrak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {

            $table->dropColumn([
                'tanggal_mulai_kontrak',
                'tanggal_selesai_kontrak'
            ]);
        });
    }
};