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
        Schema::create('tb_izin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('keperluan_izin');
            $table->string('lama_izin');
            $table->date('tanggal_izin')->nullable();
            $table->date('sampai_tanggal')->nullable();
            $table->time('jam_masuk')->format('H:i')->nullable();
            $table->time('jam_keluar')->format('H:i')->nullable();
            $table->text('keterangan_izin')->nullable()->default('text');
            $table->integer('status')->unsigned()->default(0);
            $table->integer('status_hrd')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_izin');
    }
};
