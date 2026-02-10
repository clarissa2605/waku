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
        $table->decimal('potongan', 15, 2)
              ->default(0)
              ->after('nominal');

        $table->decimal('nominal_bersih', 15, 2)
              ->after('potongan');
    });
    }

    public function down(): void
{
    Schema::table('pencairan_dana', function (Blueprint $table) {
        $table->dropColumn(['potongan', 'nominal_bersih']);
    });
}

};
