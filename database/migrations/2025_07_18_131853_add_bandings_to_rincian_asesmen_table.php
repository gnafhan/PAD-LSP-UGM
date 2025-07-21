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
        Schema::table('rincian_asesmen', function (Blueprint $table) {
            // banding_date and banding_reason
            $table->date('banding_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rincian_asesmen', function (Blueprint $table) {
            $table->dropColumn('banding_date');
        });
    }
};
