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
        Schema::create('ujian_muk', function (Blueprint $table) {
            $table->string('id_ujian', 20)->primary();
            $table->string('id_asesi', 20);
            $table->string('id_asesor', 20);
            $table->dateTime('tgl_ujian');
            $table->string('status_ujian', 10);
            $table->integer('nilai_kompetensi')->default(0);
            $table->string('id_tuk', 20);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('id_muk', 20);
            $table->string('tipe_ujian', 10);
            $table->timestamps();

            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('restrict');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_tuk')->references('id_tuk')->on('tuk')->onDelete('restrict');
            $table->foreign('id_muk')->references('id_muk')->on('muk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_muk');
    }
};
