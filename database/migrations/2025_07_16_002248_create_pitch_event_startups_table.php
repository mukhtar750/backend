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
        Schema::create('pitch_event_startups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pitch_event_id')->constrained('pitch_events')->onDelete('cascade');
            $table->foreignId('startup_id')->constrained('startups')->onDelete('cascade'); // If startups are users, change to user_id
            $table->enum('status', ['applied', 'confirmed', 'rejected'])->default('applied');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pitch_event_startups');
    }
};
