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
        Schema::create('asesi_pengajuan', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->string('id_asesi', 10);
            $table->string('id_skema', 10);
            $table->string('nama_skema', 100);
            $table->string('id_ujian', 10)->nullable();
            $table->dateTime('tgl_ujian')->nullable();
            $table->string('sumber_anggaran', 50)->nullable();
            $table->string('nik', 20);
            $table->string('nama_asesi', 60);
            $table->string('jenis_kelamin', 20);
            $table->string('tempat_tanggal_lahir', 200);
            $table->string('alamat_sesuai_ktp', 200);
            $table->string('kode_pos', 20);
            $table->string('email', 20);
            $table->integer('nim')->length(10);
            $table->string('no_telp');
            $table->integer('kewarganegaraan')->length(10);
            $table->json('dokumen')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesi_pengajuan');
    }
};
