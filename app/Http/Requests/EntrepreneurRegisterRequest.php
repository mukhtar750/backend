<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntrepreneurRegisterRequest extends FormRequest
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
            'business_name' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
            'sector' => [
                'required',
                'string',
                'max:255'
            ],
            'cac_number' => [
                'required',
                'string',
                'max:255',
                'unique:users,cac_number'
            ],
            'funding_stage' => [
                'required',
                'string',
                'max:255',
                Rule::in(['idea', 'startup', 'growth', 'scale', 'mature'])
            ],
            'website' => [
                'nullable',
                'url',
                'max:255'
            ],
            'entrepreneur_phone' => [
                'required',
                'string',
                'max:20'
            ],
            'entrepreneur_linkedin' => [
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
            'cac_number.unique' => 'This CAC number is already registered.',
            'funding_stage.in' => 'Please select a valid funding stage.',
        ];
    }

    protected function prepareForValidation()
    {
        // Simple sanitization
        $this->merge([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'business_name' => trim($this->business_name),
            'sector' => trim($this->sector),
            'cac_number' => strtoupper(trim($this->cac_number)),
            'website' => $this->website ? trim($this->website) : null,
            'entrepreneur_phone' => trim($this->entrepreneur_phone),
            'entrepreneur_linkedin' => $this->entrepreneur_linkedin ? trim($this->entrepreneur_linkedin) : null,
        ]);
    }
} 