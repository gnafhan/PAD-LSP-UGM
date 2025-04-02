<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bidang_kompetensi', function (Blueprint $table) {
            $table->id('id_bidang_kompetensi'); // Primary Key
            $table->string('nama_bidang', 60);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang_kompetensi');
    }
};

