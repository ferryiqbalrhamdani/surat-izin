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
        Schema::table('tb_lembur', function (Blueprint $table) {
            $table->string('hari_libur')->nullable()->default('Tidak')->after('tanggal_lembur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_lembur', function (Blueprint $table) {
            $table->dropColumn('hari_libur');
        });
    }
};
