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
        Schema::create('module_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('training_modules')->onDelete('cascade');
            $table->foreignId('entrepreneur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bdsp_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->integer('current_week')->default(1);
            $table->integer('progress_percentage')->default(0);
            $table->text('completion_notes')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Ensure one completion record per entrepreneur per module
            $table->unique(['module_id', 'entrepreneur_id']);
            
            // Indexes for performance
            $table->index(['bdsp_id', 'module_id']);
            $table->index(['entrepreneur_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_completions');
    }
};
