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
            $table->increments('id_skema');
            $table->string('nomor_skema', 10);
            $table->string('nama_skema', 100);
            $table->binary('dokumen_skema');
            $table->string('persyaratan_skema', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema');
    }

};
