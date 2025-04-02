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
        Schema::create('elemen_uk', function (Blueprint $table) {
            $table->id('id_elemen_uk');
            $table->string('id_uk', 20);
            $table->string('nama_elemen', 100);
            $table->foreign('id_uk')->references('id_uk')->on('uk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elemen_uk');
    }
};
