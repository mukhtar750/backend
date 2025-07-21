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
        Schema::create('mentorship_forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_type'); // e.g., 'mentorship_agreement', 'growth_area', etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // For ordering forms in the journey
            $table->enum('phase', ['first_meeting', 'ongoing_meetings', 'feedback_resources']); // Group forms by phase
            $table->enum('completion_by', ['mentor', 'mentee', 'both']); // Who should complete this form
            $table->boolean('requires_signature')->default(false); // Whether digital signature is required
            $table->boolean('active')->default(true); // Whether this form is active in the system
            $table->timestamps();
        });

        Schema::create('mentorship_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentorship_form_id')->constrained()->onDelete('cascade');
            $table->string('field_type'); // text, textarea, select, checkbox, radio, date, etc.
            $table->string('label');
            $table->text('description')->nullable();
            $table->text('options')->nullable(); // JSON for select, checkbox, radio options
            $table->boolean('required')->default(false);
            $table->integer('order')->default(0); // For ordering fields within a form
            $table->timestamps();
        });

        Schema::create('mentorship_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pairing_id')->constrained()->onDelete('cascade'); // The mentor-mentee pairing
            $table->foreignId('mentorship_form_id')->constrained()->onDelete('cascade');
            $table->foreignId('submitted_by')->constrained('users'); // Who submitted this form
            $table->foreignId('mentorship_session_id')->nullable()->constrained()->onDelete('set null'); // Optional link to a specific session
            $table->json('form_data'); // JSON data of all form fields and values
            $table->boolean('is_draft')->default(true); // Whether this is a draft or final submission
            $table->boolean('is_signed')->default(false); // Whether this form has been digitally signed
            $table->timestamp('signed_at')->nullable(); // When the form was signed
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved'])->default('draft');
            $table->timestamps();
        });

        Schema::create('mentorship_form_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentorship_form_submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewed_by')->constrained('users'); // Who reviewed this submission
            $table->text('comments')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentorship_form_reviews');
        Schema::dropIfExists('mentorship_form_submissions');
        Schema::dropIfExists('mentorship_form_fields');
        Schema::dropIfExists('mentorship_forms');
    }
};