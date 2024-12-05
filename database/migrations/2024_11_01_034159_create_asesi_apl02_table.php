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
            $table->json('daftar_id_asesiUK');
            $table->json('file_portofolio');
            $table->timestamps();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
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
