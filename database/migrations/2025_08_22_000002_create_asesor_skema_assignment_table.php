<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the asesor_skema_assignment table to store which schemes
     * are assigned to each asesor for access control.
     * 
     * Requirements: 3.1, 3.2 - Admin can assign schemes to asesors
     */
    public function up(): void
    {
        Schema::create('asesor_skema_assignment', function (Blueprint $table) {
            $table->id();
            $table->string('id_asesor', 20);
            $table->string('id_skema', 20);
            $table->string('assigned_by', 20)->comment('id_user of admin who made the assignment');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();

            // Foreign key constraint to asesor table
            $table->foreign('id_asesor')
                ->references('id_asesor')
                ->on('asesor')
                ->onDelete('cascade');

            // Foreign key constraint to skema table
            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema')
                ->onDelete('cascade');

            // Foreign key constraint to users table (assigned_by)
            $table->foreign('assigned_by')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            // Unique constraint to prevent duplicate assignments
            $table->unique(['id_asesor', 'id_skema'], 'asesor_skema_unique');
            
            // Index for faster lookups by asesor
            $table->index('id_asesor', 'asesor_assignments_idx');
            
            // Index for faster lookups by skema
            $table->index('id_skema', 'skema_asesors_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor_skema_assignment');
    }
};
