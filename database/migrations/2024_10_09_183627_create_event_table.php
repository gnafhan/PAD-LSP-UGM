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
            $table->string('id_tuk', 20);
            $table->string('nama_event', 100);
            $table->dateTime('tanggal_mulai_event');
            $table->dateTime('tanggal_berakhir_event');
            $table->string('tipe_event', 50);
            $table->string('periode_pelaksanaan', 1);
            $table->string('tahun_pelaksanaan', 4);
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
