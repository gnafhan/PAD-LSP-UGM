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
        Schema::create('hasil_asesmen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rincian_asesmen');
            $table->foreign('id_rincian_asesmen')->references('id_rincian_asesmen')->on('rincian_asesmen')->onDelete('cascade');
            $table->enum('status', ['kompeten', 'tidak_kompeten']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_asesmen');
    }
};
