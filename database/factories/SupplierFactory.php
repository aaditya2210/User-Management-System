<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(100), // Limiting to 100 characters
            'email' => $this->faker->unique()->safeEmail, // Usually within 191 characters
            'contact_number' => $this->faker->numerify('##########'), // 10-digit format
            'address' => $this->faker->text(200), // Limiting address length
            'company_name' => $this->faker->company, // Usually within 100 characters
            'gst_number' => $this->faker->optional()->regexify('[0-9A-Z]{15}'), // GST format (15 chars)
            'website' => substr($this->faker->url, 0, 150), // Limiting to 150 characters
            'country' => substr($this->faker->country, 0, 50), // Limiting to 50 characters
            'state' => substr($this->faker->state, 0, 50), // Limiting to 50 characters
            'city' => substr($this->faker->city, 0, 50), // Limiting to 50 characters
            'postal_code' => substr($this->faker->postcode, 0, 10), // Ensuring it fits
            'contact_person' => $this->faker->name, // Usually within 100 characters
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'contract_start_date' => $this->faker->optional()->date(),
            'contract_end_date' => $this->faker->optional()->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
