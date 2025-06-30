<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrepreneurRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'business_name' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'cac_number' => 'required|string|max:255',
            'funding_stage' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'entrepreneur_phone' => 'required|string|max:20',
            'entrepreneur_linkedin' => 'nullable|url|max:255',
            'password' => 'required|string|confirmed|min:8',
        ];
    }
} 