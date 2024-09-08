<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id(); //Primary key
            $table->string('name'); //Nama pelatihan
            $table->text('description')->nullable(); 
            //Deskripsi pelatihan
            $table->date('start_date'); //Tanggal mulai
            $table->date('end_date'); //Tanggal selesai
            $table->integer('capacity'); //Kapasitas peserta
            $table->foreignId('instructor_id') //FK utk instruktur
            ->constrained('instructors') 
            //Referensi ke tabel instructors
            ->onDelete('cascade'); 
            //Jika instruktur dihapus, pelatihan akan dihapus
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
}


