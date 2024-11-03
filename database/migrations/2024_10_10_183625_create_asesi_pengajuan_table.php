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
            $table->string('nama_user', 100);
            $table->string('id_skema', 20);
            $table->string('sumber_anggaran', 50);
            $table->string('nik', 20);
            $table->string('jenis_kelamin', 20);
            $table->string('tempat_lahir', 60);
            $table->dateTime('tgl_lahir');
            $table->string('alamat', 200);
            $table->string('kode_pos', 20);
            $table->string('email', 200);
            $table->string('nim', 20);
            $table->string('no_telp_pribadi', 20);
            $table->string('kewarganegaraan', 20);
            $table->json('file_portofolio_pengajuan')->nullable();
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
