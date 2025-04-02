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
            $table->string('kode_registrasi', 30);
            $table->string('nama_asesor', 100);
            $table->string('no_sertifikat', 30);
            $table->string('no_hp', 20);
            $table->string('email', 100);
            $table->longText('alamat')->nullable();
            $table->string('status_asesor', 10);
            $table->longText('foto_asesor')->nullable();
            $table->string('no_ktp', 20);
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('pendidikan_terakhir', 30)->nullable();
            $table->string('tempat_lahir', 20)->nullable();
            $table->dateTime('tanggal_lahir')->nullable();
            $table->string('kebangsaan', 30)->nullable();
            $table->string('no_lisensi', 30)->nullable();
            $table->dateTime('masa_berlaku');
            $table->string('institusi_asal', 100)->nullable();
            $table->string('no_telp_institusi_asal', 20)->nullable();
            $table->string('fax_institusi_asal', 20)->nullable();
            $table->string('email_institusi_asal', 100)->nullable();
            $table->longText('file_sertifikat_asesor')->nullable();
            $table->json('daftar_bidang_kompetensi')->nullable(); //json
            $table->timestamps();
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
