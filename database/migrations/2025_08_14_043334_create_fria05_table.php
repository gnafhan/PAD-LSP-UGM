<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fria05', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->string('id_asesi');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');

            $table->string('id_asesor');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');

            // Optional metadata or extra fields
            $table->timestamp('waktu_tanda_tangan_asesor')->nullable();
            $table->timestamp('waktu_tanda_tangan_asesi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fria05');
    }
};
