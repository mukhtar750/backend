<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup_access_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('startup_id')->constrained('startups')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('response_message')->nullable();
            $table->timestamps();
            
            // Ensure an investor can only have one active request per startup
            $table->unique(['investor_id', 'startup_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('startup_access_requests');
    }
};