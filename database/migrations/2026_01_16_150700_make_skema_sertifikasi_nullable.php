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
        Schema::table('asesi_pengajuan', function (Blueprint $table) {
            $table->string('skema_sertifikasi', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesi_pengajuan', function (Blueprint $table) {
            $table->string('skema_sertifikasi', 50)->nullable(false)->change();
        });
    }
};
