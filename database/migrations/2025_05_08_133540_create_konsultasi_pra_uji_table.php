<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsultasiPraUjiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsultasi_pra_uji', function (Blueprint $table) {
            $table->id();
            $table->string('id_asesi');
            $table->string('id_asesor');
            $table->date('tanggal_konsultasi')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->string('tempat_uji')->nullable();
            $table->json('jawaban_checklist')->nullable();
            $table->date('waktu_tanda_tangan_asesor');
            $table->timestamps();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konsultasi_pra_uji');
    }
}