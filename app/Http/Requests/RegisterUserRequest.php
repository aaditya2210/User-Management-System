<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you have authorization logic
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|numeric|digits:10',
            'postcode' => 'required|numeric|digits:6',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female,other',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'hobbies' => 'nullable|array',
            'uploaded_files' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
            'roles.*.exists' => 'Invalid role selected.',
        ];
    }
}
