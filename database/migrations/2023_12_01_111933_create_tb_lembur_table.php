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
        Schema::create('tb_lembur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('tanggal_lembur')->nullable();
            $table->time('jam_mulai')->format('H:i');
            $table->time('jam_akhir')->format('H:i');
            $table->time('lama_lembur')->format('H:i');
            $table->integer('upah_lembur_perjam')->nullable();
            $table->integer('uang_makan')->nullable();
            $table->integer('upah_lembur')->nullable();
            $table->text('keterangan_lembur')->nullable()->default('text');
            $table->integer('status')->default(0);
            $table->integer('status_hrd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lembur');
    }
};
