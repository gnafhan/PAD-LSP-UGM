<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tuk', function (Blueprint $table) {
            $table->increments('id_tuk');
            $table->string('kode_tuk', 20);
            $table->string('nama_tuk', 60);
            $table->string('alamat', 255);
            $table->integer('id_penanggung_jawab');
            $table->string('no_lisensi_skkn', 200);
            $table->timestamps();

            $table->foreign('id_penanggung_jawab')->references('id_penanggung_jawab')->on('penanggung_jawab');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tuk');
    }

};
