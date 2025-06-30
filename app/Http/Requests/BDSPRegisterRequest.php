<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BDSPRegisterRequest extends FormRequest
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
            'services_provided' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'organization' => 'nullable|string|max:255',
            'certifications' => 'nullable|string|max:255',
            'bdsp_linkedin' => 'nullable|url|max:255',
            'password' => 'required|string|confirmed|min:8',
        ];
    }
} 