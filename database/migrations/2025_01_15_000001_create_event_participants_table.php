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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->string('id_event');
            $table->string('id_skema');
            $table->string('email')->index();
            $table->enum('invitation_status', ['pending', 'sent', 'registered'])->default('pending');
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();
            
            $table->foreign('id_event')->references('id_event')->on('event')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema')->onDelete('cascade');
            
            // Unique constraint: one email per event across entire system
            $table->unique('email', 'unique_email_per_system');
            
            // Composite index for queries
            $table->index(['id_event', 'id_skema']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
