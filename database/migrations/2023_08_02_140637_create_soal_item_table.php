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
        Schema::create('soal_item', function (Blueprint $table) {
            $table->id();
            $table->integer('id_soal');
            $table->enum('jenis_soal', ['pg', 'essay'])->default('pg');
            $table->string('no_urut')->nullable();
            $table->longText('text_soal')->nullable();
            $table->longText('pil_a')->nullable();
            $table->longText('pil_b')->nullable();
            $table->longText('pil_c')->nullable();
            $table->longText('pil_d')->nullable();
            $table->longText('pil_e')->nullable();
            $table->text('file_soal')->nullable();
            $table->text('file_pila')->nullable();
            $table->text('file_pilb')->nullable();
            $table->text('file_pilc')->nullable();
            $table->text('file_pild')->nullable();
            $table->text('file_pile')->nullable();
            $table->string('kunci_jawaban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_item');
    }
};
