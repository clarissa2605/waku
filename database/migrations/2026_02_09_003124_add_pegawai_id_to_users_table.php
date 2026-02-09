<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('pegawai_id')->nullable()->after('id');
        $table->foreign('pegawai_id')
              ->references('id_pegawai')
              ->on('pegawai')
              ->nullOnDelete();
    });
    }

    public function down()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['pegawai_id']);
        $table->dropColumn('pegawai_id');
    });
    }
};
