<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kompetensi_teknis', function (Blueprint $table) {
            $table->id('id_kompetensi_teknis');
            $table->string('id_asesor', 20);
            $table->string('lembaga_sertifikasi', 60);
            $table->string('skema_kompetensi', 60);
            $table->dateTime('masa_berlaku');
            $table->longText('file_sertifikat');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kompetensi_teknis');
    }
};
