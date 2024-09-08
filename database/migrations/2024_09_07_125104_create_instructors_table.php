<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id(); //Primary key
            $table->string('name'); //Nama instruktur
            $table->string('email')->unique(); //Email instruktur
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('instructors');
    }
}


