<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create ia07_questions table.
 * Stores scheme-specific oral questions for IA07 per unit kompetensi and elemen.
 * 
 * Requirements: 3.1, 3.2
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ia07_questions', function (Blueprint $table) {
            $table->id();
            $table->string('id_skema');
            $table->string('id_uk');
            $table->unsignedBigInteger('id_elemen_uk');
            $table->text('pertanyaan');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema')
                ->onDelete('cascade');

            $table->foreign('id_uk')
                ->references('id_uk')
                ->on('uk')
                ->onDelete('cascade');

            $table->foreign('id_elemen_uk')
                ->references('id_elemen_uk')
                ->on('elemen_uk')
                ->onDelete('cascade');

            $table->index(['id_skema', 'id_uk', 'id_elemen_uk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia07_questions');
    }
};
