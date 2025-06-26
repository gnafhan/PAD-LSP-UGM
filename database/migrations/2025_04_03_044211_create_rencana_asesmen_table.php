<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rencana_asesmen', function (Blueprint $table) {
            $table->id('id_rencana_asesmen'); // Primary Key
            $table->string('id_skema', 20); // Foreign Key 
            $table->string('id_uk', 20); // Foreign Key 
            $table->string('elemen', 2000);
            $table->string('bukti_bukti', 2000);
            $table->string('jenis_bukti', 5);
            $table->string('metode_dan_perangkat_asesmen', 5);
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
            $table->foreign('id_uk')->references('id_uk')->on('uk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_asesmen');
    }
};

