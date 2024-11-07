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
        Schema::create('skema', function (Blueprint $table) {
            $table->string('id_skema', 20)->primary();
            $table->string('nomor_skema', 100);
            $table->string('nama_skema', 100);
            $table->string('dokumen_skkni', 100);
            $table->json('daftar_id_uk');
            $table->longText('persyaratan_skema');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema');
    }

};
