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
        Schema::create('event', function (Blueprint $table) {
            $table->string('id_event', 20)->primary();
            $table->string('nama_event', 100);
            $table->dateTime('tanggal_mulai_event');
            $table->dateTime('tanggal_berakhir_event');
            $table->string('tuk', 100);
            $table->string('tipe_event', 50);
            // $table->json('daftar_id_skema');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
