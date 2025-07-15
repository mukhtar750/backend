<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pairings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_one_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_two_id')->constrained('users')->onDelete('cascade');
            $table->string('pairing_type'); // mentor_mentee, bdsp_entrepreneur, investor_entrepreneur
            $table->timestamps();
            $table->unique(['user_one_id', 'user_two_id', 'pairing_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pairings');
    }
};
