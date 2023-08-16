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
        Schema::create('ujian', function (Blueprint $table) {
            $table->id();
            $table->integer('id_soal');
            $table->integer('id_kelas');
            $table->integer('id_jenis_ujian');
            $table->integer('id_materi')->nullable();
            $table->integer('id_guru')->nullable();
            $table->integer('id_rombel')->nullable();
            $table->string('kode')->nullable();
            $table->string('nama')->nullable();
            $table->string('lama_ujian')->nullable();
            $table->datetime('waktu_mulai')->nullable();
            $table->datetime('w_akhir')->nullable();
            $table->string('last_token')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('is_hasil')->default(0);
            $table->integer('is_acak')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian');
    }
};
