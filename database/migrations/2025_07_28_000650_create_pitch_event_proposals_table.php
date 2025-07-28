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
        Schema::create('pitch_event_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('event_type'); // pitch_competition, networking, demo_day, workshop
            $table->string('target_sector')->nullable(); // fintech, healthtech, edtech, etc.
            $table->string('target_stage')->nullable(); // seed, series_a, series_b, etc.
            $table->text('target_criteria')->nullable(); // specific criteria for startups
            $table->integer('max_participants')->nullable();
            $table->decimal('min_funding_needed', 10, 2)->nullable();
            $table->decimal('max_funding_needed', 10, 2)->nullable();
            $table->text('expected_outcomes');
            $table->text('success_metrics')->nullable();
            $table->text('proposed_format')->nullable(); // detailed format description
            $table->text('supporting_rationale')->nullable(); // why this event is needed
            $table->date('proposed_date')->nullable();
            $table->time('proposed_time')->nullable();
            $table->integer('proposed_duration')->nullable(); // in minutes
            $table->string('proposed_location')->nullable();
            $table->boolean('is_virtual')->default(false);
            $table->text('virtual_platform')->nullable();
            $table->text('additional_requirements')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'requested_changes'])->default('pending');
            $table->text('admin_feedback')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('approved_event_id')->nullable()->constrained('pitch_events')->onDelete('set null');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status', 'created_at']);
            $table->index(['investor_id', 'status']);
            $table->index(['target_sector', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pitch_event_proposals');
    }
};
