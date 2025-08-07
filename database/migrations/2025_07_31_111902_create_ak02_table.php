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
        Schema::create('ak02', function (Blueprint $table) {
            $table->id(); // Kolom primary key (bigIncrements)
            
            // Foreign keys
            $table->string('id_asesi'); 
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            
            $table->string('id_asesor');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');

            // Waktu tanda tangan asesor
            $table->timestamp('waktu_tanda_tangan_asesor')->nullable();
            // Tanda tangan asesi
            $table->timestamp('waktu_tanda_tangan_asesi')->nullable();

            $table->text('instruksi_kerja');
            $table->boolean('rekomendasi_hasil');
            $table->text('tindak_lanjut');
            $table->text('komentar_observasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ak02');
    }
};
