<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('skema', function (Blueprint $table) {
            if (!Schema::hasColumn('skema', 'id_bidang_kompetensi')) {
                $table->unsignedBigInteger('id_bidang_kompetensi')->nullable()->after('nama_skema');
                $table->foreign('id_bidang_kompetensi')
                    ->references('id_bidang_kompetensi')
                    ->on('bidang_kompetensi')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
            }
        });
    }

    public function down(): void
    {
        Schema::table('skema', function (Blueprint $table) {
            if (Schema::hasColumn('skema', 'id_bidang_kompetensi')) {
                $table->dropForeign(['id_bidang_kompetensi']);
                $table->dropColumn('id_bidang_kompetensi');
            }
        });
    }
};



