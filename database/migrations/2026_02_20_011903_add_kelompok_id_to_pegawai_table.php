<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            $table->unsignedBigInteger('kelompok_id')
                  ->nullable()
                  ->after('mitra_id');

            $table->foreign('kelompok_id')
                  ->references('id_kelompok')
                  ->on('kelompok_mitra')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            $table->dropForeign(['kelompok_id']);
            $table->dropColumn('kelompok_id');
        });
    }
};