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
            $table->string('alamat', 200);
            $table->string('bidang', 100); //gausah po ya?
            $table->string('status_asesor', 10);
            $table->string('foto_asesor', 100);
            $table->string('gelar_depan', 60)->nullable();
            $table->string('gelar_belakang', 60)->nullable();
            $table->string('no_ktp', 20);
            $table->string('jenis_kelamin', 10);
            $table->string('pendidikan_terakhir', 30);
            $table->string('keahlian', 100);
            $table->string('tempat_lahir', 20);
            $table->dateTime('tanggal_lahir');
            $table->string('kebangsaan', 30);
            $table->string('no_lisensi', 30);
            $table->dateTime('masa_berlaku');
            $table->string('institusi_asal', 100);
            $table->string('no_telp_institusi_asal', 20);
            $table->string('fax_institusi_asal', 20);
            $table->string('email_institusi_asal', 100);
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
