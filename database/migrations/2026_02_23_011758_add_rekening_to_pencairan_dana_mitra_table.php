<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencairan_dana_mitra', function (Blueprint $table) {
            $table->string('nama_bank', 100)->after('tanggal');
            $table->string('nama_rekening', 100)->after('nama_bank');
            $table->string('no_rekening', 30)->after('nama_rekening');
        });
    }

    public function down(): void
    {
        Schema::table('pencairan_dana_mitra', function (Blueprint $table) {
            $table->dropColumn([
                'nama_bank',
                'nama_rekening',
                'no_rekening'
            ]);
        });
    }
};