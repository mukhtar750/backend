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
        Schema::create('training_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bdsp_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('duration_weeks');
            $table->integer('total_hours');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('target_audience')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('learning_objectives')->nullable();
            $table->boolean('admin_reviewed')->default(false);
            $table->timestamp('admin_reviewed_at')->nullable();
            $table->unsignedBigInteger('admin_reviewed_by')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['bdsp_id', 'status']);
            $table->index(['status', 'admin_reviewed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_modules');
    }
};
