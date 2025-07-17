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
        Schema::create('pitch_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date');
            $table->string('location');
            $table->enum('event_type', ['virtual', 'in-person', 'hybrid'])->default('virtual');
            $table->integer('capacity')->nullable();
            $table->dateTime('registration_deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->json('featured_startups')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('image_path')->nullable();
            $table->json('agenda')->nullable();
            $table->json('requirements')->nullable();
            $table->json('prizes')->nullable();
            $table->json('tags')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pitch_events');
    }
};
