<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create ia02_templates table.
 * Stores scheme-specific work instruction templates for IA02.
 * 
 * Requirements: 2.1, 2.2
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ia02_templates', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema');
            $table->longText('instruksi_kerja');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema')
                ->onDelete('cascade');

            $table->unique('id_skema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia02_templates');
    }
};
