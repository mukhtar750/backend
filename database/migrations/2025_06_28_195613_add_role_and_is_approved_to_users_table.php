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
            $table->string('role')->nullable()->after('email');
            $table->boolean('is_approved')->default(false)->after('role');
            $table->string('status')->default('active')->after('is_approved');
            // Investor fields
            $table->string('phone')->nullable()->after('is_approved');
            $table->string('type_of_investor')->nullable()->after('phone');
            $table->string('interest_areas')->nullable()->after('type_of_investor');
            $table->string('company')->nullable()->after('interest_areas');
            $table->string('investor_linkedin')->nullable()->after('company');
            // BDSP fields
            $table->string('services_provided')->nullable()->after('investor_linkedin');
            $table->integer('years_of_experience')->nullable()->after('services_provided');
            $table->string('organization')->nullable()->after('years_of_experience');
            $table->string('certifications')->nullable()->after('organization');
            $table->string('bdsp_linkedin')->nullable()->after('certifications');
            // Entrepreneur fields
            $table->string('business_name')->nullable()->after('bdsp_linkedin');
            $table->string('sector')->nullable()->after('business_name');
            $table->string('cac_number')->nullable()->after('sector');
            $table->string('funding_stage')->nullable()->after('cac_number');
            $table->string('website')->nullable()->after('funding_stage');
            $table->string('entrepreneur_phone')->nullable()->after('website');
            $table->string('entrepreneur_linkedin')->nullable()->after('entrepreneur_phone');
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
