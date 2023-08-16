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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kelas')->nullable();
            $table->integer('id_rombel')->nullable();
            $table->string('nik')->nullable();
            $table->string('no_peserta')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nama')->nullable();
            $table->enum('gender', ['l', 'p'])->default('l');
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('desa')->nullable();
            $table->string('kec')->nullable();
            $table->string('kab')->nullable();
            $table->string('prov')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
