<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create mapa01_configs table.
 * Stores scheme-specific configuration for MAPA01 assessment planning.
 * 
 * Requirements: 4.1, 4.2
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mapa01_configs', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema');
            $table->json('config_data')->nullable();
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
        Schema::dropIfExists('mapa01_configs');
    }
};
