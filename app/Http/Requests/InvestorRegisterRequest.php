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
                'min:2'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'phone' => [
                'required',
                'string',
                'max:20'
            ],
            'type_of_investor' => [
                'required',
                'string',
                'max:255',
                Rule::in(['angel', 'venture_capital', 'private_equity', 'corporate', 'government', 'other'])
            ],
            'interest_areas' => [
                'required',
                'string',
                'max:255'
            ],
            'company' => [
                'nullable',
                'string',
                'max:255'
            ],
            'investor_linkedin' => [
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
            'type_of_investor.in' => 'Please select a valid investor type.',
        ];
    }

    protected function prepareForValidation()
    {
        // Simple sanitization
        $this->merge([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'phone' => trim($this->phone),
            'interest_areas' => trim($this->interest_areas),
            'company' => $this->company ? trim($this->company) : null,
            'investor_linkedin' => $this->investor_linkedin ? trim($this->investor_linkedin) : null,
        ]);
    }
} 