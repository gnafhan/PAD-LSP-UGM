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
        Schema::create('ia02_instruksi_kerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proses_assessment_id');
            $table->integer('nomor_urut');
            $table->text('instruksi_kerja');
            $table->string('standar_alat_media')->nullable();
            $table->text('output_yang_diharapkan')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('proses_assessment_id')->references('id')->on('ia02_proses_assessments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02_instruksi_kerjas');
    }
};
