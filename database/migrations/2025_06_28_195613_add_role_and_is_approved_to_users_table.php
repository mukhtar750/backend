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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['entrepreneur', 'investor', 'bdsp'])->default('entrepreneur');
            $table->boolean('is_approved')->default(false);
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            
            // Investor specific fields
            $table->string('phone')->nullable();
            $table->enum('type_of_investor', ['angel', 'vc', 'institutional', 'other'])->nullable();
            $table->json('interest_areas')->nullable();
            $table->string('company')->nullable();
            $table->string('investor_linkedin')->nullable();
            
            // BDSP specific fields
            $table->json('services_provided')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('organization')->nullable();
            $table->json('certifications')->nullable();
            $table->string('bdsp_linkedin')->nullable();
            
            // Entrepreneur specific fields
            $table->string('business_name')->nullable();
            $table->string('sector')->nullable();
            $table->string('cac_number')->nullable();
            $table->enum('funding_stage', ['idea', 'prototype', 'mvp', 'early_revenue', 'growth'])->nullable();
            $table->string('website')->nullable();
            $table->string('entrepreneur_phone')->nullable();
            $table->string('entrepreneur_linkedin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_approved', 'status', 'phone', 'type_of_investor', 'interest_areas', 'company', 'investor_linkedin', 'services_provided', 'years_of_experience', 'organization', 'certifications', 'bdsp_linkedin', 'business_name', 'sector', 'cac_number', 'funding_stage', 'website', 'entrepreneur_phone', 'entrepreneur_linkedin']);
        });
    }
};
