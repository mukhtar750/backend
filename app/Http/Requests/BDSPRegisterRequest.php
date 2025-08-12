<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BDSPRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'services_provided' => [
                'required',
                'array',
                'min:1'
            ],
            'services_provided.*' => [
                'required',
                'string',
                'in:business_model_review,financial_forecasting,valuation_support,pitch_deck_development,investor_pitch_coaching,capital_raising_strategy,term_sheets,due_diligence_preparation,legal_regulatory_advice,market_sizing,investor_identification,esg_impact_readiness,governance_board_structuring,mentoring_experienced_founders,investor_networks_demo_days,exit_strategy_planning,ip_asset_protection,growth_strategy_post_investment,storytelling_vision_alignment,one_on_one_coaching'
            ],
            'years_of_experience' => [
                'required',
                'integer',
                'min:0',
                'max:50'
            ],
            'organization' => [
                'nullable',
                'string',
                'max:255'
            ],
            'certifications' => [
                'nullable',
                'string',
                'max:255'
            ],
            'bdsp_linkedin' => [
                'nullable',
                'url',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:6',
                'max:255'
            ],
        ];
    }

    public function messages()
    {
        return [
            'years_of_experience.max' => 'Years of experience cannot exceed 50 years.',
        ];
    }

    protected function prepareForValidation()
    {
        // Simple sanitization
        $this->merge([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'services_provided' => array_map('trim', $this->services_provided),
            'organization' => $this->organization ? trim($this->organization) : null,
            'certifications' => $this->certifications ? trim($this->certifications) : null,
            'bdsp_linkedin' => $this->bdsp_linkedin ? trim($this->bdsp_linkedin) : null,
        ]);
    }
} 