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
        Schema::create('uk', function (Blueprint $table) {
            $table->string('id_uk', 20)->primary();
            $table->string('nama_uk', 100);
            $table->string('id_bidang', 20)->nullable();
            $table->timestamps();

            $table->foreign('id_bidang')->references('id_bidang')->on('uk_bidang')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uk');
    }
};
