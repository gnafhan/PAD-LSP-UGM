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
        Schema::table('asesi_pengajuan', function (Blueprint $table) {
            $table->string('id_fakultas', 20)->nullable()->after('pendidikan_terakhir');
            $table->string('id_program_studi', 20)->nullable()->after('id_fakultas');

            $table->foreign('id_fakultas')
                  ->references('id_fakultas')
                  ->on('fakultas')
                  ->onDelete('set null');

            $table->foreign('id_program_studi')
                  ->references('id_program_studi')
                  ->on('program_studi')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesi_pengajuan', function (Blueprint $table) {
            $table->dropForeign(['id_fakultas']);
            $table->dropForeign(['id_program_studi']);
            $table->dropColumn(['id_fakultas', 'id_program_studi']);
        });
    }
};
