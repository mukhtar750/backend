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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Who gave the feedback
            $table->string('target_type'); // e.g., 'platform', 'bdsp', 'mentor', 'training', etc.
            $table->unsignedBigInteger('target_id')->nullable(); // ID of the target (nullable for platform)
            $table->string('category')->nullable(); // e.g., session quality, content, support
            $table->unsignedTinyInteger('rating')->nullable(); // 1-5 stars
            $table->text('comments')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
