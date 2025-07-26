<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Startup extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'description',
        'logo',
        'sector',
        'funding_stage',
        'business_model',
        'headquarters_location',
        'operating_regions',
        'founder_id',
        'website',
        'linkedin_url',
        'year_founded',
        'team_size',
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
        'future_vision',
        'status'
    ];
    
    /**
     * Get the founder (entrepreneur) that owns the startup.
     */
    public function founder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'founder_id');
    }

    /**
     * Get all info requests for this startup
     */
    public function infoRequests()
    {
        return $this->hasMany(StartupInfoRequest::class);
    }

    /**
     * Get approved info requests for this startup
     */
    public function approvedInfoRequests()
    {
        return $this->hasMany(StartupInfoRequest::class)->where('status', 'approved');
    }

    /**
     * Check if a specific investor has access to this startup
     */
    public function hasInvestorAccess($investorId)
    {
        return $this->infoRequests()
            ->where('investor_id', $investorId)
            ->where('status', 'approved')
            ->exists();
    }
}
