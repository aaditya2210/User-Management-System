<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true if all users can update suppliers
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier->id,
            'contact_number' => 'required|string|max:10',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:75',
            'gst_number' => 'nullable|string|max:50|unique:suppliers,gst_number,' . $this->supplier->id,
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'state_id' => 'required|exists:states,id', // Ensure state exists in the database
            'city_id' => 'required|exists:cities,id', // Ensure city exists in the database
            'postal_code' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => [
                'nullable', 'date',
                function ($attribute, $value, $fail) {
                    if (request()->contract_start_date && $value < request()->contract_start_date) {
                        $fail('The contract end date must be after or equal to the start date.');
                    }
                }
            ],        ];
    }
}
