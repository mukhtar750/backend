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
        Schema::create('resource_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('shared_by'); // BDSP who shared
            $table->unsignedBigInteger('shared_with'); // Entrepreneur who receives
            $table->text('message')->nullable(); // Optional message when sharing
            $table->boolean('is_read')->default(false); // Track if mentee has seen it
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->foreign('shared_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_with')->references('id')->on('users')->onDelete('cascade');
            
            // Prevent duplicate shares
            $table->unique(['resource_id', 'shared_with']);
            
            // Index for performance
            $table->index(['shared_with', 'is_read']);
            $table->index(['shared_by', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_shares');
    }
};
