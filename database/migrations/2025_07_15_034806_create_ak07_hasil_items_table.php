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
        Schema::create('ak07_hasil_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ak07_id');
            $table->foreign('ak07_id')->references('id')->on('ak07')->onDelete('cascade');
            $table->string('hasil_item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ak07_hasil_items');
    }
};
