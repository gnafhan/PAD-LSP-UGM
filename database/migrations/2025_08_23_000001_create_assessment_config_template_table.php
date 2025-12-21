<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for assessment_config_template table
 * 
 * Stores template configurations that can be applied to schemes.
 * Templates allow admins to quickly set up new schemes with predefined
 * assessment tool configurations.
 * 
 * Requirements: 7.2
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessment_config_template', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->json('config_data'); // Stores assessment_type => is_enabled pairs
            $table->string('created_by')->nullable(); // id_user of creator
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            // Foreign key to users table (nullable for system templates)
            $table->foreign('created_by')
                ->references('id_user')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_config_template');
    }
};
