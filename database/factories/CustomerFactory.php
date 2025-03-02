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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'company_name' => $this->faker->company(),
            'job_title' => $this->faker->jobTitle(),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'date_of_birth' => $this->faker->date(),
            'nationality' => $this->faker->country(),
            'customer_type' => $this->faker->randomElement(['Regular', 'VIP', 'Enterprise']),
            'notes' => $this->faker->paragraph(),
            'preferred_contact_method' => $this->faker->randomElement(['Email', 'Phone', 'WhatsApp']),
            'newsletter_subscription' => $this->faker->boolean(),
            'account_balance' => $this->faker->randomFloat(2, 0, 10000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
