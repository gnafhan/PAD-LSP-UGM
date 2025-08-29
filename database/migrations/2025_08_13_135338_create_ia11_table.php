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
        Schema::create('ia11', function (Blueprint $table) {
            $table->id();
            $table->string('id_asesi');
            $table->string('id_asesor');
            $table->string('id_skema');
            $table->string('judul_sertifikasi')->nullable();
            $table->string('nomor_sertifikasi')->nullable();
            $table->string('nama_peserta')->nullable();
            $table->string('nama_asesor')->nullable();
            $table->string('tuk')->nullable();
            $table->text('kegiatan_data')->nullable(); // JSON data for assessment items
            $table->text('komentar_all')->nullable(); // General comments
            $table->timestamp('waktu_tanda_tangan_asesor')->nullable();
            $table->timestamp('waktu_tanda_tangan_asesi')->nullable();
            $table->string('ttd_asesor')->nullable(); // Signature file name
            $table->string('ttd_asesi')->nullable(); // Signature file name
            $table->enum('status', ['draft', 'submitted', 'approved', 'completed'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');

            // Unique constraint
            $table->unique(['id_asesi', 'id_asesor', 'id_skema']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia11');
    }
};
