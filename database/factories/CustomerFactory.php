<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(), // 100 characters max
            'email' => $this->faker->unique()->safeEmail(), // 150 characters max
            'contact_number' => $this->faker->numerify('##########'), // 10-digit phone number for consistency
            'address' => $this->faker->text(200), // Truncated to fit within 255 characters
            'company_name' => $this->faker->company(), // 100 characters max
            'job_title' => $this->faker->jobTitle(), // 80 characters max
            'gender' => $this->faker->randomElement(['male', 'female', 'other']), // Matching DB enum case
            'date_of_birth' => $this->faker->date(),
            'nationality' => $this->faker->country(), // 40 characters max
            'customer_type' => $this->faker->randomElement(['Regular', 'VIP', 'Corporate', 'Enterprise']), // Matching DB enum
            'notes' => $this->faker->text(500), // Limited length for reasonable notes
            'preferred_contact_method' => $this->faker->randomElement(['Email', 'Phone', 'SMS', 'WhatsApp']), // Matching DB enum
            'newsletter_subscription' => $this->faker->boolean(),
            'account_balance' => $this->faker->randomFloat(2, 0, 999999.99), // Matches decimal(12,2)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
