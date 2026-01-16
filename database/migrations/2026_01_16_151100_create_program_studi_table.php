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
        Schema::create('program_studi', function (Blueprint $table) {
            $table->string('id_program_studi', 20)->primary();
            $table->string('id_fakultas', 20);
            $table->string('nama_program_studi', 255);
            $table->timestamps();

            $table->foreign('id_fakultas')
                  ->references('id_fakultas')
                  ->on('fakultas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
