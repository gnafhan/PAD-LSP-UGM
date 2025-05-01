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
            $table->string('id_pengajuan', 20)->primary();
            $table->string('id_user', 20);
            $table->string('id_skema', 20);
            $table->string('nama_user', 150);
            $table->string('nik', 20);
            $table->string('nim', 20);
            $table->string('kota_domisili', 100);
            $table->string('tempat_tanggal_lahir', 200);
            $table->string('jenis_kelamin', 20);
            $table->string('kebangsaan', 20);
            $table->string('alamat_rumah', 200);
            $table->string('no_telp', 20);
            $table->string('pendidikan_terakhir', 100);
            $table->string('skema_sertifikasi', 50);
            $table->string('nama_skema', 100); //skemaDropdown
            $table->string('nomor_skema', 100); //nomorSkemaInput
            $table->string('tujuan_asesmen', 100);
            $table->string('sumber_anggaran', 50)->nullable();
            $table->string('email', 200)->nullable();
            $table->json('file_kelengkapan_pemohon')->nullable();
            $table->longText('ttd_pemohon');
            $table->string('status_rekomendasi', 20)->nullable();
            $table->string('status_pekerjaan', 20)->nullable();
            $table->string('nama_perusahaan', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->longText('alamat_perusahaan')->nullable();
            $table->string('no_telp_perusahaan', 20)->nullable();
            $table->longText('waktu_tanda_tangan')->nullable();
            $table->longText('alasan_penolakan')->nullable();
            $table->string('id_admin', 20)->nullable();
            $table->timestamps();


            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('restrict');
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
