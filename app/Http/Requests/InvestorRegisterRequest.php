<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvestorRegisterRequest extends FormRequest
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
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/' // International phone format
            ],
            'type_of_investor' => [
                'required',
                'string',
                'max:255',
                Rule::in(['angel', 'venture_capital', 'private_equity', 'corporate', 'government', 'other']) // Predefined values
            ],
            'interest_areas' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-,]+$/' // Only letters, spaces, commas, hyphens
            ],
            'company' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\.&]+$/' // Alphanumeric, spaces, hyphens, dots, ampersands
            ],
            'investor_linkedin' => [
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
            'phone.regex' => 'Please enter a valid phone number.',
            'type_of_investor.in' => 'Please select a valid investor type.',
            'interest_areas.regex' => 'Interest areas can only contain letters, spaces, commas, and hyphens.',
            'company.regex' => 'Company name can only contain letters, numbers, spaces, hyphens, dots, and ampersands.',
            'investor_linkedin.regex' => 'Please enter a valid LinkedIn profile URL.',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ];
    }

    protected function prepareForValidation()
    {
        // Sanitize inputs
        $this->merge([
            'name' => strip_tags(trim($this->name)),
            'email' => strtolower(trim($this->email)),
            'phone' => trim($this->phone),
            'interest_areas' => strip_tags(trim($this->interest_areas)),
            'company' => $this->company ? strip_tags(trim($this->company)) : null,
            'investor_linkedin' => $this->investor_linkedin ? trim($this->investor_linkedin) : null,
        ]);
    }
} 