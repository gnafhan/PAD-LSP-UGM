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
        Schema::create('tanda_tangan_admin', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('id_user'); // id_asesor VARCHAR(255) NOT NULL
            $table->string('file_tanda_tangan'); // file_tanda_tangan VARCHAR(255) NOT NULL
            $table->timestamp('valid_from')->useCurrent(); // default CURRENT_TIMESTAMP
            $table->timestamp('valid_until')->nullable(); // NULLABLE
            $table->timestamps(); // created_at & updated_at nullable by default

            // Foreign key constraint
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanda_tangan_admin');
    }
};
