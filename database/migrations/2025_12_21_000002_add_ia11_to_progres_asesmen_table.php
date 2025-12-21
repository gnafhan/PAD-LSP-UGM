<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds ia11 column to progres_asesmen table for tracking IA11 (Ceklis Meninjau Instrumen Asesmen) progress.
     */
    public function up(): void
    {
        Schema::table('progres_asesmen', function (Blueprint $table) {
            $table->json('ia11')->nullable()->after('ia05');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_asesmen', function (Blueprint $table) {
            $table->dropColumn('ia11');
        });
    }
};
