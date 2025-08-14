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
        Schema::create('week_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('training_modules')->onDelete('cascade');
            $table->foreignId('entrepreneur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('week_id')->constrained('module_weeks')->onDelete('cascade');
            $table->integer('completion_percentage')->default(0);
            $table->integer('time_spent')->default(0); // in minutes
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->text('notes')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Ensure unique progress per entrepreneur per week
            $table->unique(['module_id', 'entrepreneur_id', 'week_id']);
            
            // Indexes for performance
            $table->index(['entrepreneur_id', 'module_id']);
            $table->index(['week_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_progress');
    }
};
