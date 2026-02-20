<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('log_notifikasi', function (Blueprint $table) {

        // Drop foreign key dulu
        $table->dropForeign(['id_pencairan']);

        // Baru drop kolom lama
        $table->dropColumn([
            'id_pencairan',
            'waktu_kirim',
            'status_kirim',
            'respon_api'
        ]);

        // Tambah kolom baru
        $table->string('recipient_type')->after('id_log');
        $table->unsignedBigInteger('recipient_id')->after('recipient_type');
        $table->string('no_whatsapp')->nullable();
        $table->text('pesan');
        $table->string('status')->default('pending');
        $table->text('response')->nullable();

        $table->timestamps();
    });
}
    public function down()
    {
        //
    }
};