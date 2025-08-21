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
            // Ubah tipe data id_bidang_kompetensi dari varchar ke bigint unsigned
            $table->unsignedBigInteger('id_bidang_kompetensi')->nullable()->change();
            $table->foreign('id_bidang_kompetensi')->references('id_bidang_kompetensi')->on('bidang_kompetensi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompetensi_teknis', function (Blueprint $table) {
            $table->dropForeign(['id_bidang_kompetensi']);
            $table->unsignedBigInteger('id_bidang_kompetensi')->nullable()->change();
        });
    }
};
