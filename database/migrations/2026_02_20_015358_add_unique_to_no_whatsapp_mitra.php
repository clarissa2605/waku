<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->unique('no_whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->dropUnique(['no_whatsapp']);
        });
    }
};