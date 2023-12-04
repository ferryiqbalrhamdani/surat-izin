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
        Schema::table('tb_cuti', function (Blueprint $table) {
            $table->string('durasi')->nullable()->after('pilihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_cuti', function (Blueprint $table) {
            $table->dropColumn('durasi');
        });
    }
};
