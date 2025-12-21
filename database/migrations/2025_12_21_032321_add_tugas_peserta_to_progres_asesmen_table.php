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
        Schema::table('progres_asesmen', function (Blueprint $table) {
            $table->json('tugas_peserta')->nullable()->after('ia02');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progres_asesmen', function (Blueprint $table) {
            $table->dropColumn('tugas_peserta');
        });
    }
};
