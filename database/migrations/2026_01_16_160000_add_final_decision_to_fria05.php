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
        Schema::table('fria05', function (Blueprint $table) {
            $table->enum('final_decision', ['Kompeten', 'Tidak Kompeten'])->nullable()->after('waktu_tanda_tangan_asesor');
            $table->text('catatan_asesor')->nullable()->after('final_decision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fria05', function (Blueprint $table) {
            $table->dropColumn(['final_decision', 'catatan_asesor']);
        });
    }
};
