<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kompetensi_teknis', function (Blueprint $table) {
            // Tambah kolom id_bidang_kompetensi baru
            $table->unsignedBigInteger('id_bidang_kompetensi')->nullable()->after('id_asesor');
        });
        
        // Tambah foreign key constraint
        Schema::table('kompetensi_teknis', function (Blueprint $table) {
            $table->foreign('id_bidang_kompetensi')
                  ->references('id_bidang_kompetensi')
                  ->on('bidang_kompetensi')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompetensi_teknis', function (Blueprint $table) {
            // Drop foreign key constraint dulu
            $table->dropForeign(['id_bidang_kompetensi']);
        });
        
        Schema::table('kompetensi_teknis', function (Blueprint $table) {
            // Drop kolom id_bidang_kompetensi
            $table->dropColumn('id_bidang_kompetensi');
        });
    }
};
