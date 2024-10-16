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
            $table->string('id_asesi', 10)->primary();
            $table->string('nama_asesi', 100);//
            $table->string('tempat_lahir', 60);
            $table->date('tgl_lahir');
            $table->string('jenis_kelamin', 10);
            $table->string('warganegara', 20);
            $table->string('alamat', 255);
            $table->string('kode_pos', 20);
            $table->string('no_hp', 20);
            $table->string('no_telp_rumah', 20)->nullable();
            $table->string('email', 50);
            $table->string('nim', 20);
            $table->string('id_user', 10);
            $table->binary('file_sertifikat')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesi');
    }

};
