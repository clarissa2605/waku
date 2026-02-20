<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            if (Schema::hasColumn('pegawai', 'kelompok_id')) {
                $table->dropForeign(['kelompok_id']);
                $table->dropColumn('kelompok_id');
            }

            if (Schema::hasColumn('pegawai', 'mitra_id')) {
                $table->dropForeign(['mitra_id']);
                $table->dropColumn('mitra_id');
            }
        });
    }

    public function down(): void
    {
        // kosong saja (tidak perlu restore)
    }
};