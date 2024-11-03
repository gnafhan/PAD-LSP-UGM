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
        Schema::create('asesi_muk', function (Blueprint $table) {
            $table->string('id_asesiMUK', 20)->primary();
            $table->string('id_asesi', 20);
            $table->string('id_muk', 20);
            $table->binary('file_jawabanMUK');
            $table->string('id_asesor', 20);
            $table->string('id_ujian', 20);
            $table->timestamps();

            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('restrict');
            $table->foreign('id_ujian')->references('id_ujian')->on('ujian_muk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesi_muk');
    }
};
