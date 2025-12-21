<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create mapa02_configs table.
 * Stores scheme-specific MUK checklist and default potensi configuration for MAPA02.
 * 
 * Requirements: 5.1, 5.2
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mapa02_configs', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema');
            $table->json('muk_items')->nullable();
            $table->json('default_potensi')->nullable();
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
        Schema::dropIfExists('mapa02_configs');
    }
};
