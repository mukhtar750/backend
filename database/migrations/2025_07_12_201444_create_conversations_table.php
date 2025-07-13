<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_one_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_two_id')->constrained('users')->onDelete('cascade');
            $table->string('conversation_type')->default('direct'); // direct, group
            $table->string('title')->nullable(); // For group conversations
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            
            // Ensure unique conversations between users
            $table->unique(['user_one_id', 'user_two_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
