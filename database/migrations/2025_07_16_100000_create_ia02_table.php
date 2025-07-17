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
        Schema::create('ia02', function (Blueprint $table) {
            $table->id();
            $table->string('id_asesi');
            $table->string('id_asesor');
            $table->string('id_skema');
            
            // Header information
            $table->string('judul_sertifikasi')->nullable();
            $table->string('nomor_sertifikasi')->nullable();
            $table->string('nama_peserta')->nullable();
            $table->string('nama_asesor')->nullable();
            $table->string('tuk')->nullable();
            
            // Instruction work content (from rich text editor)
            $table->longText('instruksi_kerja')->nullable();
            
            // Signatures
            $table->dateTime('waktu_tanda_tangan_asesor')->nullable();
            $table->dateTime('waktu_tanda_tangan_asesi')->nullable();
            $table->text('ttd_asesor')->nullable(); // Digital signature
            $table->text('ttd_asesi')->nullable(); // Digital signature
            
            // Status tracking
            $table->enum('status', ['draft', 'submitted', 'approved', 'completed'])->default('draft');
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02');
    }
};
