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
                'regex:/^[a-zA-Z\s\-\.]+$/', // Only letters, spaces, hyphens, and dots
                'min:2'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Strict email format
            ],
            'business_name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-Z0-9\s\-\.&]+$/' // Alphanumeric, spaces, hyphens, dots, ampersands
            ],
            'sector' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-]+$/' // Only letters, spaces, hyphens
            ],
            'cac_number' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Z0-9\-]+$/', // Only uppercase letters, numbers, hyphens
                'unique:users,cac_number'
            ],
            'funding_stage' => [
                'required',
                'string',
                'max:255',
                Rule::in(['idea', 'startup', 'growth', 'scale', 'mature']) // Predefined values
            ],
            'website' => [
                'nullable',
                'url',
                'max:255',
                'regex:/^https?:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}/' // Valid URL format
            ],
            'entrepreneur_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/' // International phone format
            ],
            'entrepreneur_linkedin' => [
                'nullable',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?linkedin\.com\/in\/[a-zA-Z0-9\-_]{3,100}$/' // LinkedIn URL format
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/' // Strong password: lowercase, uppercase, number, special char
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Name can only contain letters, spaces, hyphens, and dots.',
            'email.regex' => 'Please enter a valid email address.',
            'business_name.regex' => 'Business name can only contain letters, numbers, spaces, hyphens, dots, and ampersands.',
            'sector.regex' => 'Sector can only contain letters, spaces, and hyphens.',
            'cac_number.regex' => 'CAC number can only contain uppercase letters, numbers, and hyphens.',
            'cac_number.unique' => 'This CAC number is already registered.',
            'funding_stage.in' => 'Please select a valid funding stage.',
            'website.regex' => 'Please enter a valid website URL.',
            'entrepreneur_phone.regex' => 'Please enter a valid phone number.',
            'entrepreneur_linkedin.regex' => 'Please enter a valid LinkedIn profile URL.',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ];
    }

    protected function prepareForValidation()
    {
        // Sanitize inputs
        $this->merge([
            'name' => strip_tags(trim($this->name)),
            'email' => strtolower(trim($this->email)),
            'business_name' => strip_tags(trim($this->business_name)),
            'sector' => strip_tags(trim($this->sector)),
            'cac_number' => strtoupper(trim($this->cac_number)),
            'website' => $this->website ? trim($this->website) : null,
            'entrepreneur_phone' => trim($this->entrepreneur_phone),
            'entrepreneur_linkedin' => $this->entrepreneur_linkedin ? trim($this->entrepreneur_linkedin) : null,
        ]);
    }
} 