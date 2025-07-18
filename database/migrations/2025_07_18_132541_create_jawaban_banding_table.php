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
        Schema::create('jawaban_banding', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pertanyaan_banding');
            $table->unsignedBigInteger('id_rincian_asesmen');
            $table->foreign('id_pertanyaan_banding')->references('id')->on('pertanyaan_banding')->onDelete('cascade');
            $table->foreign('id_rincian_asesmen')->references('id_rincian_asesmen')->on('rincian_asesmen')->onDelete('cascade');
            $table->string('jawaban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_banding');
    }
};
