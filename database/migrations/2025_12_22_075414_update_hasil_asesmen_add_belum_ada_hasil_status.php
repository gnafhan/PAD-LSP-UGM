<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the enum to include 'belum_ada_hasil' and set it as default
        DB::statement("ALTER TABLE hasil_asesmen MODIFY COLUMN status ENUM('kompeten', 'tidak_kompeten', 'belum_ada_hasil') DEFAULT 'belum_ada_hasil'");
        
        // Update existing NULL values to 'belum_ada_hasil'
        DB::table('hasil_asesmen')->whereNull('status')->update(['status' => 'belum_ada_hasil']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum without default
        DB::statement("ALTER TABLE hasil_asesmen MODIFY COLUMN status ENUM('kompeten', 'tidak_kompeten') NULL");
    }
};
