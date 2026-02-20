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
            // DATA IDENTITAS
            // ==========================

            $table->string('nik', 20)
                  ->unique()
                  ->after('id_mitra');

            $table->string('no_whatsapp', 20)
                  ->after('nama_mitra');

            $table->text('alamat')
                  ->nullable()
                  ->after('no_whatsapp');

            // ==========================
            // DATA REKENING
            // ==========================

            $table->string('nama_bank', 100)
                  ->nullable()
                  ->after('alamat');

            $table->string('nama_rekening', 100)
                  ->nullable()
                  ->after('nama_bank');

            $table->string('no_rekening', 30)
                  ->nullable()
                  ->after('nama_rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {

            $table->dropColumn([
                'nik',
                'no_whatsapp',
                'alamat',
                'nama_bank',
                'nama_rekening',
                'no_rekening'
            ]);
        });
    }
};