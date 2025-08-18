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
        Schema::create('ia02_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('id_asesi');
            $table->string('id_asesor')->nullable();
            $table->string('id_skema')->nullable();
            
            // Task information
            $table->string('judul_tugas');
            $table->enum('jenis_evidence', ['1', '2', '3']); // 1=Teks Jawaban, 2=Link Eksternal, 3=Upload File
            
            // Evidence content based on type
            $table->longText('teks_jawaban')->nullable(); // For rich text answers
            $table->string('link_eksternal')->nullable(); // For external links
            $table->string('file_path')->nullable(); // For uploaded files
            $table->string('file_name')->nullable(); // Original file name
            $table->string('file_type')->nullable(); // File mime type
            $table->bigInteger('file_size')->nullable(); // File size in bytes
            
            // Submission tracking
            $table->dateTime('waktu_submit')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->text('catatan_asesor')->nullable(); // Asesor feedback
            $table->decimal('nilai', 5, 2)->nullable(); // Score if applicable
            
            // Metadata
            $table->json('metadata')->nullable(); // Additional data like file hash, etc.
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['id_asesi', 'status']);
            $table->index('waktu_submit');
            $table->index('jenis_evidence');
            
            // Foreign key constraints
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('set null');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02_tugas');
    }
};
