<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds ia05 column to progres_asesmen table for tracking IA05 (Pertanyaan Tertulis Pilihan Ganda) progress.
     */
    public function up(): void
    {
        Schema::table('progres_asesmen', function (Blueprint $table) {
            $table->json('ia05')->nullable()->after('ia02');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_asesmen', function (Blueprint $table) {
            $table->dropColumn('ia05');
        });
    }
};
