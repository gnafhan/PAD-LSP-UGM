<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fria01', function (Blueprint $table) {
            $table->string('id_fria01', 36)->primary();
            $table->string('id_asesi', 20);
            $table->string('id_asesor', 20);
            $table->string('id_skema', 20);
            $table->string('id_event', 20)->nullable();
            $table->unsignedBigInteger('id_rincian_asesmen')->nullable();
            $table->json('data_tambahan')->nullable(); 
            $table->timestamps();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
            $table->foreign('id_event')->references('id_event')->on('event')->onDelete('set null');
            $table->foreign('id_rincian_asesmen')->references('id_rincian_asesmen')->on('rincian_asesmen')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fria01');
    }
};
