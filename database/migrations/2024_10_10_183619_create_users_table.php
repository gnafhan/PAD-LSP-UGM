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
            $table->string('id_user', 20)->primary();
            $table->string('email', 200)->unique();
            $table->string('name', 200)->nullable();
            $table->longText('password');
            $table->string('no_hp', 20);
            $table->string('level', 10);
            $table->string('gauth_id')->nullable(); // Tambahkan kolom gauth_id
            $table->string('gauth_type')->nullable(); // Tambahkan kolom gauth_type
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
