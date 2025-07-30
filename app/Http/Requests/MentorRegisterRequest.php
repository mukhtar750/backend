<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'bio' => 'required|string|max:1000',
            'expertise' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'linkedin' => 'nullable|url',
        ];
    }
} 