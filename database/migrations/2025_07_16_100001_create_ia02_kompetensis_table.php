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
        Schema::create('ia02_kompetensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ia02_id');
            $table->string('id_uk'); // UK (Unit Kompetensi) ID
            $table->string('kode_uk');
            $table->string('nama_uk');
            $table->text('deskripsi_kompetensi')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('ia02_id')->references('id')->on('ia02')->onDelete('cascade');
            $table->foreign('id_uk')->references('id_uk')->on('uk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02_kompetensis');
    }
};
