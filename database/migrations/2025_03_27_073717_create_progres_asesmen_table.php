<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progres_asesmen', function (Blueprint $table) {
            $table->id('id_progres_asesmen');
            $table->string('id_asesi', 20);
            $table->boolean('apl02')->default(false);
            $table->boolean('ak01')->default(false);
            $table->boolean('konsultasi_pra_uji')->default(false);
            $table->boolean('ia01')->default(false);
            $table->boolean('ia02')->default(false);
            $table->boolean('ia07')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_asesmen');
    }
};