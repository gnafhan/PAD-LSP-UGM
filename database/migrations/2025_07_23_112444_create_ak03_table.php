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
        Schema::create('ak03', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->string('id_asesi');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');

            $table->string('id_asesor');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');

            // Waktu tanda tangan asesi
            $table->timestamp('waktu_tanda_tangan_asesi')->nullable();

            $table->timestamps();

            // Unique constraint to ensure one record per asesi-asesor pair
            $table->unique(['id_asesi', 'id_asesor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ak03');
    }
};