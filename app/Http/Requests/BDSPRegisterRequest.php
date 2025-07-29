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
            'services_provided' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-,]+$/' // Only letters, spaces, commas, hyphens
            ],
            'years_of_experience' => [
                'required',
                'integer',
                'min:0',
                'max:50' // Reasonable maximum
            ],
            'organization' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\.&]+$/' // Alphanumeric, spaces, hyphens, dots, ampersands
            ],
            'certifications' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-,\.]+$/' // Alphanumeric, spaces, commas, hyphens, dots
            ],
            'bdsp_linkedin' => [
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
            'services_provided.regex' => 'Services can only contain letters, spaces, commas, and hyphens.',
            'years_of_experience.max' => 'Years of experience cannot exceed 50 years.',
            'organization.regex' => 'Organization name can only contain letters, numbers, spaces, hyphens, dots, and ampersands.',
            'certifications.regex' => 'Certifications can only contain letters, numbers, spaces, commas, hyphens, and dots.',
            'bdsp_linkedin.regex' => 'Please enter a valid LinkedIn profile URL.',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ];
    }

    protected function prepareForValidation()
    {
        // Sanitize inputs
        $this->merge([
            'name' => strip_tags(trim($this->name)),
            'email' => strtolower(trim($this->email)),
            'services_provided' => strip_tags(trim($this->services_provided)),
            'organization' => $this->organization ? strip_tags(trim($this->organization)) : null,
            'certifications' => $this->certifications ? strip_tags(trim($this->certifications)) : null,
            'bdsp_linkedin' => $this->bdsp_linkedin ? trim($this->bdsp_linkedin) : null,
        ]);
    }
} 