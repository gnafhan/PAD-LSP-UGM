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
        Schema::create('ak07_seeder_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->text('deskripsi');
            $table->timestamps();
        });

        // Tabel untuk menyimpan opsi penyesuaian untuk setiap kategori
        Schema::create('opsi_penyesuaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ak07_seeder_a_s_id')->constrained()->onDelete('cascade');
            $table->text('deskripsi_opsi');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ak07_seeder_a_s');
        Schema::dropIfExists('opsi_penyesuaian');
    }
};
