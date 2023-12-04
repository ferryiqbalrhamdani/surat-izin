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
        Schema::create('tb_cuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('keperluan_cuti');
            $table->timestamp('tanggal_cuti')->nullable();
            $table->timestamp('sampai_tanggal')->nullable();
            $table->string('lama_cuti')->nullable();
            $table->text('keterangan_cuti')->nullable()->default('text');
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
        Schema::dropIfExists('tb_cuti');
    }
};
