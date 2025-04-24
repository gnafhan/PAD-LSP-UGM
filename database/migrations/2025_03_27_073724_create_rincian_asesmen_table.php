<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rincian_asesmen', function (Blueprint $table) {
            $table->id('id_princian_asesmen');
            $table->string('id_asesi', 20);
            $table->string('id_event', 20);
            $table->string('id_asesor', 20);
            $table->timestamps();
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi');
            $table->foreign('id_event')->references('id_event')->on('event');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_asesmen');
    }
};