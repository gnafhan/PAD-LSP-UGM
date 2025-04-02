<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periode_asesmen', function (Blueprint $table) {
            $table->id('id_periode_asesmen');
            $table->string('id_asesi', 20);
            $table->integer('periode');
            $table->integer('tahun');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_asesmen');
    }
};