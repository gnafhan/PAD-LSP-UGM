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
        Schema::create('mapa02', function (Blueprint $table) {
            $table->id(); // Kolom primary key (bigIncrements)
            
            // Foreign keys
            $table->string('id_asesi'); 
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            
            $table->string('id_asesor');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');

            // Materi Uji Kompetensi (MUK) - tipe data Integer
            // Nama kolom disesuaikan agar lebih deskriptif dan menggunakan snake_case
            $table->integer('muk_ceklis_observasi');
            $table->integer('muk_tugas_praktik_demonstrasi');
            $table->integer('muk_pertanyaan_tertulis_esai');
            $table->integer('muk_pertanyaan_lisan');
            $table->integer('muk_ceklis_verifikasi_portfolio');
            $table->integer('muk_ceklis_meninjau_materi_uji');

            // Waktu tanda tangan asesor
            $table->timestamp('waktu_tanda_tangan_asesor');
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapa02');
    }
};