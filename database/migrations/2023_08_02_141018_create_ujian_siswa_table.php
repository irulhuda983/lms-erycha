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
        Schema::create('ujian_siswa', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ujian')->nullable();
            $table->integer('id_siswa')->nullable();
            $table->datetime('w_mulai')->nullable();
            $table->datetime('w_selesai')->nullable();
            $table->string('jml_pg_benar')->nullable();
            $table->string('jml_pg_salah')->nullable();
            $table->string('skor_pg')->nullable();
            $table->string('skor_essay')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_siswa');
    }
};
