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
        Schema::create('apl02', function (Blueprint $table) {
            $table->string('id_apl02', 20)->primary();
            $table->string('id_uk', 20);
            $table->timestamps();

            // $table->string('id_skema', 20);
            // $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('restrict');
            $table->foreign('id_uk')->references('id_uk')->on('uk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apl02');
    }
};
