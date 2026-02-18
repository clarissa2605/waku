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
    Schema::table('pencairan_dana', function (Blueprint $table) {
        $table->string('nama_rekening')->nullable()->after('pegawai_id');
        $table->string('no_rekening')->nullable()->after('nama_rekening');
    });
}


public function down(): void
{
    Schema::table('pencairan_dana', function (Blueprint $table) {
        $table->dropColumn(['nama_rekening', 'no_rekening']);
    });
}
};
