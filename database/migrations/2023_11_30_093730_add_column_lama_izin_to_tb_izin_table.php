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
        Schema::table('tb_izin', function (Blueprint $table) {
            $table->string('durasi_izin')->nullable()->after('sampai_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_izin', function (Blueprint $table) {
            $table->dropColumn('durasi_izin');
        });
    }
};
