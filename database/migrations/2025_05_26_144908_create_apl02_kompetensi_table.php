<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apl02_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_apl02')->constrained('apl02')->onDelete('cascade');
            $table->string('id_uk');
            $table->string('kode_uk');
            $table->string('nama_uk');
            $table->string('nama_elemen');
            $table->boolean('kompeten')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apl02_kompetensi');
    }
};