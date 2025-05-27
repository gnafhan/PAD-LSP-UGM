<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apl02', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema');
            $table->string('id_asesi');
            $table->string('id_asesor');
            $table->dateTime('waktu_tanda_tangan_asesi')->nullable();
            $table->dateTime('waktu_tanda_tangan_asesor')->nullable();
            $table->text('rekomendasi');
            $table->string('metode_uji');
            $table->timestamps();
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apl02');
    }
};