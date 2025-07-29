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
            // Add missing entrepreneur fields - add at the end to avoid dependency issues
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'sector')) {
                $table->string('sector')->nullable();
            }
            if (!Schema::hasColumn('users', 'cac_number')) {
                $table->string('cac_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'funding_stage')) {
                $table->string('funding_stage')->nullable();
            }
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable();
            }
            if (!Schema::hasColumn('users', 'entrepreneur_phone')) {
                $table->string('entrepreneur_phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'entrepreneur_linkedin')) {
                $table->string('entrepreneur_linkedin')->nullable();
            }
            
            // Add missing BDSP fields
            if (!Schema::hasColumn('users', 'services_provided')) {
                $table->string('services_provided')->nullable();
            }
            if (!Schema::hasColumn('users', 'years_of_experience')) {
                $table->integer('years_of_experience')->nullable();
            }
            if (!Schema::hasColumn('users', 'organization')) {
                $table->string('organization')->nullable();
            }
            if (!Schema::hasColumn('users', 'certifications')) {
                $table->string('certifications')->nullable();
            }
            if (!Schema::hasColumn('users', 'bdsp_linkedin')) {
                $table->string('bdsp_linkedin')->nullable();
            }
            
            // Add missing investor fields
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'type_of_investor')) {
                $table->string('type_of_investor')->nullable();
            }
            if (!Schema::hasColumn('users', 'interest_areas')) {
                $table->string('interest_areas')->nullable();
            }
            if (!Schema::hasColumn('users', 'company')) {
                $table->string('company')->nullable();
            }
            if (!Schema::hasColumn('users', 'investor_linkedin')) {
                $table->string('investor_linkedin')->nullable();
            }
            
            // Add missing role and approval fields
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_approved')) {
                $table->boolean('is_approved')->default(false);
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'sector', 
                'cac_number',
                'funding_stage',
                'website',
                'entrepreneur_phone',
                'entrepreneur_linkedin',
                'services_provided',
                'years_of_experience',
                'organization',
                'certifications',
                'bdsp_linkedin',
                'phone',
                'type_of_investor',
                'interest_areas',
                'company',
                'investor_linkedin',
                'role',
                'is_approved',
                'status'
            ]);
        });
    }
};
