<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrepreneur_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name')->nullable();
            $table->string('sector')->nullable();
            $table->string('cac_number')->nullable();
            $table->string('funding_stage')->nullable();
            $table->string('website')->nullable();
            $table->string('entrepreneur_phone')->nullable();
            $table->string('entrepreneur_linkedin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrepreneur_profiles');
    }
}; 