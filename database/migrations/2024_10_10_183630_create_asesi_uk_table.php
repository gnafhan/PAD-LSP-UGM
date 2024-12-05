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
        Schema::create('asesi_uk', function (Blueprint $table) {
            $table->string('id_asesiUK', 20)->primary();
            $table->string('id_asesi', 20);
            $table->string('id_uk', 20);
            $table->longText('elemen_uk');
            $table->longText('jawaban_elemen_uk');
            $table->json('file_bukti')->nullable();
            $table->timestamps();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_uk')->references('id_uk')->on('uk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesi_uk');
    }
};
