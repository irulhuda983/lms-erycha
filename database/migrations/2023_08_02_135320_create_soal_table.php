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
        Schema::create('soal', function (Blueprint $table) {
            $table->id();
            $table->integer('id_mapel')->nullable();
            $table->integer('id_guru')->nullable();
            $table->integer('id_kelas')->nullable();
            $table->integer('id_rombel')->nullabel();
            $table->string('kode')->nullable();
            $table->string('tipe_mapel_soal')->nullable();
            $table->enum('tipe_soal', ['pg_essay', 'pg', 'essay'])->default('pg_essay');
            $table->string('nama')->nullable();
            $table->string('jml_pg')->nullable();
            $table->string('jml_essay')->nullable();
            $table->string('bobot_pg')->nullable();
            $table->string('bobot_essay')->nullable();
            $table->string('jml_pil_pg')->nullable();
            $table->string('kkm')->nullable();
            $table->integer('is_agama')->default(0);
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
