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
        Schema::create('module_weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('training_modules')->onDelete('cascade');
            $table->integer('week_number');
            $table->string('title');
            $table->text('topics');
            $table->integer('hours_required');
            $table->text('learning_materials')->nullable();
            $table->text('week_objectives')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            
            // Ensure unique week numbers per module
            $table->unique(['module_id', 'week_number']);
            
            // Indexes for performance
            $table->index(['module_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_weeks');
    }
};
