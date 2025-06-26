<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progres_asesmen', function (Blueprint $table) {
            $table->id('id_progres_asesmen');
            $table->string('id_asesi', 20);

            // JSON columns cannot have a default value in some MySQL/MariaDB versions.
            // Default values will be handled by the ProgresAsesmen model's 'creating' event.
            $table->json('apl01')->nullable(); // Made nullable, model will populate
            $table->json('apl02')->nullable();
            $table->json('ak01')->nullable();
            $table->json('konsultasi_pra_uji')->nullable();
            $table->json('mapa01')->nullable();
            $table->json('mapa02')->nullable();
            $table->json('pernyataan_ketidak_berpihakan')->nullable();
            $table->json('ak07')->nullable();
            $table->json('ia01')->nullable();
            $table->json('ia02')->nullable();
            $table->json('hasil_asesmen')->nullable();
            $table->json('ak02')->nullable();
            $table->json('umpan_balik')->nullable();
            $table->json('ak04')->nullable();
            
            $table->timestamps(); // This adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_asesmen');
    }
};