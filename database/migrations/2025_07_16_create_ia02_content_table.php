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
        Schema::create('ia02_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ia02_id'); // Match the bigint unsigned type
            $table->string('content_type')->default('instruksi_kerja'); // Type of content
            $table->longText('html_content'); // Raw HTML from Quill.js
            $table->longText('delta_content')->nullable(); // Quill Delta format (optional)
            $table->text('text_content')->nullable(); // Plain text version
            $table->json('media_files')->nullable(); // Array of uploaded media files
            $table->timestamps();
            
            $table->foreign('ia02_id')->references('id')->on('ia02')->onDelete('cascade');
            $table->index(['ia02_id', 'content_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02_content');
    }
};
