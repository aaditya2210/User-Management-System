<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if you want authorization logic
    }

    public function rules()
    {
        $customerId = $this->route('customer')->id; // Get customer ID from route

        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:customers,email,' . $customerId . '|max:255',
            'contact_number' => 'required|string|max:10',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:50',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'customer_type' => 'nullable|in:Regular,VIP,Corporate',
            'notes' => 'nullable|string|max:1000',
            'preferred_contact_method' => 'nullable|in:Email,Phone,WhatsApp',
            'newsletter_subscription' => 'boolean',
            'account_balance' => 'nullable|numeric|min:0',
        ];
    }
}
