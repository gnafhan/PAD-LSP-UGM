<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create ia11_checklists table.
 * Stores scheme-specific portfolio verification checklist items for IA11.
 * 
 * Requirements: 6.1, 6.2
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ia11_checklists', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema');
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->text('verification_criteria')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema')
                ->onDelete('cascade');

            $table->index(['id_skema', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia11_checklists');
    }
};
