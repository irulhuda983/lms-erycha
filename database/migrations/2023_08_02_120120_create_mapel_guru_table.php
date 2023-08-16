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
        Schema::create('mapel_guru', function (Blueprint $table) {
            $table->id();
            $table->integer('id_guru');
            $table->integer('id_mapel');
            $table->integer('id_kelas')->nullable();
            $table->integer('id_rombel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel_guru');
    }
};
