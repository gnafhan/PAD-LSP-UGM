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
        Schema::create('mapa01', function (Blueprint $table) {
            $table->id();
            $table->string('id_asesi');
            $table->string('id_asesor');
            $table->text('pendekatan_asesmen_asesi');
            $table->text('tujuan_asesmen');
            $table->string('lingkungan');
            $table->string('peluang_untuk_mengumpulkan_bukti');
            $table->text('hubungan_antara_standar_kompetensi');
            $table->text('pelaksana_asesmen');
            $table->text('pihak_yang_relevan_untuk_dikonfirmasi');
            $table->text('tolak_ukur_asesmen');
            $table->timestamp('waktu_tanda_tangan_asesor')->nullable();
            $table->timestamps();
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapa01');
    }
};