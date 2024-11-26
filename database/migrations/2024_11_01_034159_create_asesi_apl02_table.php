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
        Schema::create('asesi_apl02', function (Blueprint $table) {
            $table->string('id_asesiAPL02', 20)->primary();
            $table->string('id_asesi', 20);
            $table->string('id_asesiUK', 20);
            $table->string('id_apl02', 20);
            $table->json('file_portofolio');
            $table->timestamps();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesiUK')->references('id_asesiUK')->on('asesi_uk')->onDelete('restrict');
            $table->foreign('id_apl02')->references('id_apl02')->on('apl02')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesi_apl02');
    }
};
