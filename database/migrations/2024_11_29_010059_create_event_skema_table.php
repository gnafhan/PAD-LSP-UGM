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
        Schema::create('event_skema', function (Blueprint $table) {
            $table->string('id_event', 20);
            $table->string('id_skema', 20);
            $table->primary(['id_event', 'id_skema']);

            $table->foreign('id_event')->references('id_event')->on('event')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_skema');
    }
};
