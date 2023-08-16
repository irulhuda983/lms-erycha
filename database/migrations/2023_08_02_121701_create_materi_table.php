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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kelas')->nullable();
            $table->integer('id_rombel')->nullable();
            $table->integer('id_mapel')->nullable();
            $table->integer('id_guru')->nullable();
            $table->text('judul')->nullable();
            $table->text('slug')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->string('media_image')->nullable();
            $table->string('media_file')->nullable();
            $table->string('media_video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
