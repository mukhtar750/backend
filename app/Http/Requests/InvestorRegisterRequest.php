<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestorRegisterRequest extends FormRequest
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
            'phone' => 'required|string|max:20',
            'type_of_investor' => 'required|string|max:255',
            'interest_areas' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'investor_linkedin' => 'nullable|url|max:255',
            'password' => 'required|string|confirmed|min:8',
        ];
    }
} 