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

            // =================================================================
            // KOLOM BARU UNTUK UMPAN BALIK ASESOR
            // =================================================================
            // Kolom ini untuk bagian "Umpan balik kepada asesi"
            $table->text('umpan_balik_pencapaian')->nullable()->comment('Umpan balik terhadap pencapaian unjuk kerja');
            $table->text('saran_tindak_lanjut')->nullable()->comment('Saran tindak lanjut hasil asesmen');
            $table->text('catatan_pencapaian_kompetensi')->nullable()->comment('Catatan pencapaian seluruh elemen/KUK');
            
            // Kolom ini untuk "Catatan / Umpan Balik Lainnya (dari Asesor)"
            // Di controller, ini disebut 'general_feedback'.
            $table->text('general_feedback')->nullable()->comment('Catatan atau umpan balik lainnya dari asesor');
            // =================================================================

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