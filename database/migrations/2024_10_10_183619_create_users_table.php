<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 10)->primary();
            $table->string('email', 50)->unique();
            $table->string('password', 20);
            $table->string('no_hp', 20);
            $table->string('id_asesi', 10)->nullable();
            $table->string('id_asesor', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }

};
