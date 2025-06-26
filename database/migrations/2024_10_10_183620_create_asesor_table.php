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
        Schema::create('asesor', function (Blueprint $table) {
            $table->string('id_asesor', 20)->primary();
            $table->string('id_user', 20);
            $table->string('kode_registrasi', 30)->nullable();
            $table->string('nama_asesor', 100);
            $table->string('no_sertifikat', 30)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('no_met', 100)->nullable();
            $table->string('email', 100);
            $table->longText('alamat')->nullable();
            $table->string('status_asesor', 10);
            $table->longText('foto_asesor')->nullable();
            $table->string('no_ktp', 20)->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('kebangsaan', 100)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kabupaten_kota', 100)->nullable();
            $table->string('kode_pos', 30)->nullable();
            $table->dateTime('masa_berlaku');
            $table->longText('file_sertifikat_asesor')->nullable();
            $table->json('daftar_bidang_kompetensi')->nullable(); //json
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor');
    }
};
