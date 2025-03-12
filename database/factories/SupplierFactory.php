<?php

namespace Database\Factories;

use App\Models\State;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        // Retrieve a random state and a corresponding city
        $state = State::inRandomOrder()->first();
        $city = $state ? City::where('state_id', $state->id)->inRandomOrder()->first() : null;

        return [
            'name' => $this->faker->text(100), // Limiting to 100 characters
            'email' => $this->faker->unique()->safeEmail, // Usually within 191 characters
            'contact_number' => $this->faker->numerify('##########'), // 10-digit format
            'address' => $this->faker->text(200), // Limiting address length
            'company_name' => $this->faker->company, // Usually within 100 characters
            'gst_number' => $this->faker->optional()->regexify('[0-9A-Z]{15}'), // GST format (15 chars)
            'website' => substr($this->faker->url, 0, 150), // Limiting to 150 characters
            'state_id' => $state ? $state->id : null, // Assigning a random state
            'city_id' => $city ? $city->id : null, // Assigning a city linked to the state
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
