<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the skema_assessment_config table to store which assessment tools
     * are enabled for each certification scheme.
     * 
     * Requirements: 1.1, 1.2 - Admin can configure assessment tools per scheme
     */
    public function up(): void
    {
        Schema::create('skema_assessment_config', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema', 20);
            $table->string('assessment_type', 50)->comment('Assessment type: APL01, APL02, AK01, AK02, AK04, AK07, IA01, IA02, IA05, IA07, IA11, MAPA01, MAPA02, etc.');
            $table->boolean('is_enabled')->default(true);
            $table->integer('display_order')->default(0);
            $table->json('config_data')->nullable()->comment('Additional configuration settings in JSON format');
            $table->timestamps();

            // Foreign key constraint to skema table
            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema')
                ->onDelete('cascade');

            // Unique constraint to prevent duplicate assessment type per scheme
            $table->unique(['id_skema', 'assessment_type'], 'skema_assessment_unique');
            
            // Index for faster lookups
            $table->index(['id_skema', 'is_enabled'], 'skema_enabled_assessments_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skema_assessment_config');
    }
};
