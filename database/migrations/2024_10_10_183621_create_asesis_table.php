<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asesi', function (Blueprint $table) {
            $table->string('id_asesi', 20)->primary();
            $table->string('nama_asesi', 100);
            $table->string('tempat_tanggal_lahir', 255);
            $table->string('jenis_kelamin', 10);
            $table->string('kebangsaan', 20);
            $table->string('alamat_rumah', 255);
            $table->string('kota_domisili', 50);
            $table->string('no_telp', 20);
            $table->string('no_telp_rumah', 20)->nullable();
            $table->string('email', 200);
            $table->string('nim', 20);
            $table->string('id_user', 20);
            $table->longText('file_sertifikat')->nullable();
            $table->string('id_skema', 20);
            $table->string('id_asesor', 20)->nullable();
            $table->json('file_kelengkapan_pemohon');
            $table->longText('ttd_pemohon');
            $table->string('status_pekerjaan', 20);
            $table->string('nama_perusahaan', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->longText('alamat_perusahaan')->nullable();
            $table->string('no_telp_perusahaan', 20)->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('restrict');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesi');
    }

};
