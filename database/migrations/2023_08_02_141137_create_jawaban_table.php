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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ujian_siswa')->nullable();
            $table->integer('id_siswa')->nullable();
            $table->integer('id_mapel')->nullable();
            $table->integer('id_soal')->nullable();
            $table->integer('id_soal_item')->nullable();
            $table->enum('jenis', ['pg', 'essay']);
            $table->longText('jawaban')->nullable();
            $table->string('kunci')->nullable();
            $table->string('nilai_essay')->nullable();
            $table->integer('is_ragu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
