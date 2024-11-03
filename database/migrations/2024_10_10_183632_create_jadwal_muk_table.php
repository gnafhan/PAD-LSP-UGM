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
        Schema::create('jadwal_muk', function (Blueprint $table) {
            $table->string('id_jadwal', 20)->primary();
            $table->string('id_ujian', 20);
            $table->string('id_asesi', 20);
            $table->dateTime('waktu_jadwal');
            $table->string('id_asesor', 20);
            $table->timestamps();

            $table->foreign('id_ujian')->references('id_ujian')->on('ujian_muk')->onDelete('restrict');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_muk');
    }
};
