<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'contact_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'company_name' => $this->faker->company,
            'gst_number' => $this->faker->regexify('[0-9]{15}'),
            'website' => $this->faker->url,
            'country' => $this->faker->country,
            'state' => $this->faker->state,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'contact_person' => $this->faker->name,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'contract_start_date' => $this->faker->date(),
            'contract_end_date' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
