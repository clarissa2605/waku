<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencairan_dana_mitra', function (Blueprint $table) {
            $table->unsignedBigInteger('kelompok_id')
                  ->nullable()
                  ->after('mitra_id');

            $table->index('kelompok_id');

            // Optional: tambahkan foreign key (disarankan)
            $table->foreign('kelompok_id')
                  ->references('id_kelompok')
                  ->on('kelompok_mitra')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pencairan_dana_mitra', function (Blueprint $table) {
            $table->dropForeign(['kelompok_id']);
            $table->dropIndex(['kelompok_id']);
            $table->dropColumn('kelompok_id');
        });
    }
};