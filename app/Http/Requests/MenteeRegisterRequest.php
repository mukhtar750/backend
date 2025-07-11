<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenteeRegisterRequest extends FormRequest
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
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'required|string|max:1000',
            'interests' => 'required|string|max:255',
            'goals' => 'required|string|max:1000',
            'linkedin' => 'nullable|url',
        ];
    }
} 