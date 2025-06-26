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
            $table->string('id_tuk', 20)->primary();
            $table->string('kode_tuk', 20);
            $table->string('nama_tuk', 60);
            $table->string('alamat', 255);
            $table->string('id_penanggung_jawab', 20)->nullable();
            $table->string('no_lisensi_skkn', 200);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('tuk');
    }
};
