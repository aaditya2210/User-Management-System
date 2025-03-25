<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerDashboardController extends Controller
{
    public function dashboard()
    {
        // Check if there are any customers in the database
        $customerCount = Customer::count();

        if ($customerCount == 0) {
            // Generate dummy data if no customers exist
            $this->generateDummyCustomerData();
        }

        // Fetch Dashboard Metrics
        $totalCustomers = Customer::count();
        $newCustomersThisMonth = Customer::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $atRiskCustomers = $this->calculateAtRiskCustomers();
        $customerGrowthRate = $this->calculateCustomerGrowthRate();

        // Fetch Recent Customer Activities (simplified)
        $customerActivities = $this->getRecentCustomerActivities();

        // Fetch Recent Customers
        $recentCustomers = Customer::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Return view with all data
        return view('customer_dashboard', [
            'totalCustomers' => $totalCustomers,
            'newCustomersThisMonth' => $newCustomersThisMonth,
            'atRiskCustomers' => $atRiskCustomers,
            'customerGrowthRate' => $customerGrowthRate,
            'customerActivities' => $customerActivities,
            'recentCustomers' => $recentCustomers
        ]);
    }

    protected function calculateAtRiskCustomers()
    {
        // Since no specific 'status' column exists, 
        // we'll consider customers at risk based on customer type or other criteria
        return Customer::where('customer_type', 'Regular')->count(); // Example placeholder
    }

    protected function calculateCustomerGrowthRate()
    {
        // Calculate month-over-month customer growth rate
        $currentMonthCustomers = Customer::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $previousMonthCustomers = Customer::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();

        if ($previousMonthCustomers == 0) {
            return 0;
        }

        return (($currentMonthCustomers - $previousMonthCustomers) / $previousMonthCustomers) * 100;
    }

    protected function getRecentCustomerActivities()
    {
        // Dummy activities since no specific activities table exists
        return collect([
            (object)[
                'customer' => (object)[
                    'first_name' => 'John',
                    'last_name' => 'Doe'
                ],
                'description' => 'Profile Updated',
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(2)
            ],
            (object)[
                'customer' => (object)[
                    'first_name' => 'Jane',
                    'last_name' => 'Smith'
                ],
                'description' => 'Support Ticket Opened',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDay()
            ]
        ]);
    }

    protected function generateDummyCustomerData()
    {
        // Generate 50 dummy customers
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Customer::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'contact_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'company_name' => $faker->company,
                'job_title' => $faker->jobTitle,
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'date_of_birth' => $faker->date(),
                'nationality' => $faker->country,
                'customer_type' => $faker->randomElement(['Regular', 'VIP', 'Corporate', 'Enterprise']),
                'notes' => $faker->optional()->paragraph,
                'preferred_contact_method' => $faker->randomElement(['Phone', 'Email', 'SMS', 'WhatsApp']),
                'newsletter_subscription' => $faker->boolean,
                'account_balance' => $faker->randomFloat(2, 0, 10000)
            ]);
        }
    }
}