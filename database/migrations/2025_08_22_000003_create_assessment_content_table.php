<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the assessment_content table to store dynamic assessment content
     * (questions, tasks) that are specific to each certification scheme.
     * 
     * Requirements: 4.1, 4.2 - Admin/Asesor can create dynamic content per scheme
     */
    public function up(): void
    {
        Schema::create('assessment_content', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema', 20);
            $table->string('assessment_type', 50)->comment('Assessment type: IA02, IA05, IA07, etc.');
            $table->string('content_type', 50)->comment('Content type: multiple_choice, essay, practical_task, checklist, document_upload, observation');
            $table->json('content_data')->comment('JSON containing the actual content (questions, options, instructions, etc.)');
            $table->string('created_by', 20)->comment('id_user of the creator');
            $table->integer('display_order')->default(0);
            $table->timestamps();

            // Foreign key constraint to skema table
            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema')
                ->onDelete('cascade');

            // Foreign key constraint to users table (created_by)
            $table->foreign('created_by')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            // Index for faster lookups by scheme and assessment type
            $table->index(['id_skema', 'assessment_type'], 'skema_assessment_content_idx');
            
            // Index for ordering
            $table->index(['id_skema', 'assessment_type', 'display_order'], 'content_order_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_content');
    }
};
