<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->string('kode_soal', 20)->primary();
            $table->string('id_skema', 20);
            $table->longText('pertanyaan');
            $table->longText('jawaban_a')->nullable();
            $table->longText('jawaban_b')->nullable();
            $table->longText('jawaban_c')->nullable();
            $table->longText('jawaban_d')->nullable();
            $table->longText('jawaban_e')->nullable();
            $table->timestamps();

            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('soal');
    }
};
