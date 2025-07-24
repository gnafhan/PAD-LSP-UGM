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
        Schema::create('ak03_umpan_balik_items', function (Blueprint $table) {
            $table->id();

            // Foreign key to the main ak03 table
            $table->foreignId('ak03_id')->constrained('ak03')->onDelete('cascade');

            // Feedback data
            $table->unsignedInteger('komponen_id'); // To store the question number (1-10)
            $table->enum('hasil', ['ya', 'tidak'])->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ak03_umpan_balik_items');
    }
};
