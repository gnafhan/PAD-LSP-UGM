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
        Schema::create('ia02_proses_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ia02_id');
            $table->integer('nomor_proses'); // 1, 2, 3, 4, 5, 6
            $table->string('judul_proses');
            $table->text('deskripsi_proses')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('ia02_id')->references('id')->on('ia02')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02_proses_assessments');
    }
};
