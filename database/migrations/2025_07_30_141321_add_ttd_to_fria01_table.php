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
        Schema::table('fria01', function (Blueprint $table) {
            $table->date('waktu_tanda_tangan_asesor')->nullable();
            $table->date('waktu_tanda_tangan_asesi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fria01', function (Blueprint $table) {
            $table->dropColumn('waktu_tanda_tangan_asesor');
            $table->dropColumn('waktu_tanda_tangan_asesi');
        });
    }
};
