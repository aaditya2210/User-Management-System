<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Change to false if authorization logic is required
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:customers|max:50',
            'contact_number' => 'required|digits:10',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:50',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'customer_type' => 'nullable|in:Regular,VIP,Corporate,Enterprise',
            'notes' => 'nullable|string|max:1000',
            'preferred_contact_method' => 'nullable|in:Email,Phone,WhatsApp',
            'newsletter_subscription' => 'boolean',
            'account_balance' => 'nullable|numeric|min:0',
        ];
    }
}
