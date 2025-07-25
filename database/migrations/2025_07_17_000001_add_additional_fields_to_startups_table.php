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
        Schema::table('startups', function (Blueprint $table) {
            $table->string('tagline')->nullable()->after('name');
            $table->string('business_model')->nullable()->after('funding_stage');
            $table->string('headquarters_location')->nullable()->after('business_model');
            $table->string('operating_regions')->nullable()->after('headquarters_location');
            $table->string('linkedin_url')->nullable()->after('website');
            $table->text('problem_statement')->nullable()->after('team_size');
            $table->text('solution')->nullable()->after('problem_statement');
            $table->text('innovation_differentiator')->nullable()->after('solution');
            $table->string('target_market_size')->nullable()->after('innovation_differentiator');
            $table->string('current_customers')->nullable()->after('target_market_size');
            $table->string('monthly_revenue')->nullable()->after('current_customers');
            $table->text('key_metrics')->nullable()->after('monthly_revenue');
            $table->text('partnerships')->nullable()->after('key_metrics');
            $table->text('achievements')->nullable()->after('partnerships');
            $table->text('technology_stack')->nullable()->after('achievements');
            $table->text('operational_model')->nullable()->after('technology_stack');
            $table->text('ip_patents')->nullable()->after('operational_model');
            $table->boolean('has_raised_funds')->nullable()->after('ip_patents');
            $table->string('amount_raised')->nullable()->after('has_raised_funds');
            $table->string('monthly_burn_rate')->nullable()->after('amount_raised');
            $table->string('funding_needed')->nullable()->after('monthly_burn_rate');
            $table->text('funding_use')->nullable()->after('funding_needed');
            $table->string('pitch_deck')->nullable()->after('funding_use');
            $table->string('demo_video')->nullable()->after('pitch_deck');
            $table->string('company_registration')->nullable()->after('demo_video');
            $table->text('current_challenges')->nullable()->after('company_registration');
            $table->text('support_needed')->nullable()->after('current_challenges');
            $table->text('future_vision')->nullable()->after('support_needed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startups', function (Blueprint $table) {
            $table->dropColumn([
                'tagline',
                'business_model',
                'headquarters_location',
                'operating_regions',
                'linkedin_url',
                'problem_statement',
                'solution',
                'innovation_differentiator',
                'target_market_size',
                'current_customers',
                'monthly_revenue',
                'key_metrics',
                'partnerships',
                'achievements',
                'technology_stack',
                'operational_model',
                'ip_patents',
                'has_raised_funds',
                'amount_raised',
                'monthly_burn_rate',
                'funding_needed',
                'funding_use',
                'pitch_deck',
                'demo_video',
                'company_registration',
                'current_challenges',
                'support_needed',
                'future_vision'
            ]);
        });
    }
};