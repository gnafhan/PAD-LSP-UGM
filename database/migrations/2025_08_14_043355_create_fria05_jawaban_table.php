<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fria05_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fria05_id');
            $table->foreign('fria05_id')->references('id')->on('fria05')->onDelete('cascade');

            $table->string('kode_soal'); // FK to soal table
            $table->foreign('kode_soal')->references('kode_soal')->on('soal')->onDelete('cascade');

            $table->enum('jawaban', ['a','b','c','d','e']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fria05_jawaban');
    }
};
