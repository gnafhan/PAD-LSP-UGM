<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldsToAsesiPengajuanTable extends Migration
{
    public function up()
    {
        Schema::table('asesi_pengajuan', function (Blueprint $table) {
            $table->string('status')->default('draft');
            $table->text('revision_notes')->nullable();
            $table->integer('steps_completed')->default(0);
            $table->json('sections_to_revise')->nullable();
            $table->timestamp('submitted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('asesi_pengajuan', function (Blueprint $table) {
            $table->dropColumn(['status', 'revision_notes', 'steps_completed', 'sections_to_revise', 'submitted_at']);
        });
    }
}
