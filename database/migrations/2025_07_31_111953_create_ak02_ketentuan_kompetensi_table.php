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
        Schema::create('ak02_ketentuan_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ak02_id');
            $table->foreign('ak02_id')->references('id')->on('ak02')->onDelete('cascade');
            $table->string('item');
            $table->integer('bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ak02_ketentuan_kompetensi');
    }
};
