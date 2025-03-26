<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use App\Models\Supplier;
// use App\Models\Customer;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         // Fetch counts from the database
//         $totalUsers = User::count();
//         $totalCustomers = Customer::count();
//         $totalSuppliers = Supplier::count();

//         // Example: Fetch new orders from an 'orders' table (if exists)
//         // $totalOrders = DB::table('orders')->count(); 

//         return view('dashboard', compact('totalUsers', 'totalCustomers', 'totalSuppliers'));
//     }
// }






// <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // public function index()
    // {
    //     $totalUsers = User::count();
    //     $totalCustomers = Customer::count();
    //     $totalSuppliers = Supplier::count();
    //     // $totalOrders = \DB::table('orders')->count(); 
    //     $activities = Activity::with('user')->latest()->take(10)->get();
    //     // Fetch recent activities (latest 5)
    //     $recentActivities = Activity::latest()->take(5)->get();
    //     // $users = User::with('roles')->latest()->take(10)->get(); // Fetch users with roles
    //     // $users = User::with(['roles', 'state', 'city'])->latest()->take(1)->get();
    //     $users = User::with(['roles', 'state', 'city'])->latest()->limit(5)->get();

    //     // Debugging: Check if data is being fetched
    //     // if ($users->isEmpty()) {
    //     //     // This will log the message instead of stopping execution.
    //     // }

    //     // Debugging: Check the structure of fetched data
    //     // dd($users);


    //     $suppliers = Supplier::select(
    //         'id',
    //         'name',
    //         'company_name',
    //         'contact_person',
    //         'contact_number',
    //         'email',
    //         'gst_number',
    //         'address',
    //         // 'state',
    //         // 'city',
    //         'status',
    //         'created_at'
    //     )
    //         ->latest()
    //         ->take(3)
    //         ->get();

    //     return view('dashboard', compact('totalUsers', 'totalCustomers', 'totalSuppliers', 'recentActivities', 'activities', 'users', 'suppliers'));
    //     // return view('dashboard', compact('totalUsers', 'totalCustomers', 'totalSuppliers', 'recentActivities','activities','users'));
    // }

    // ---------------------------------------------------------------------------------------------------
//     public function index()
// {
//     $totalUsers = User::count();
//     $totalCustomers = Customer::count();
//     $totalSuppliers = Supplier::count();
    
//     // Ensure dummy customer data exists if no customers are found
//     // if ($totalCustomers == 0) {
//     //     $this->generateDummyCustomerData();
//     //     $totalCustomers = Customer::count(); // Recount after generating data
//     // }

//     // Fetch Customer Dashboard Metrics
//     $newCustomersThisMonth = Customer::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
//     $atRiskCustomers = $this->calculateAtRiskCustomers();
//     $customerGrowthRate = $this->calculateCustomerGrowthRate();
//     $customerActivities = $this->getRecentCustomerActivities();
//     $recentCustomers = Customer::orderBy('created_at', 'desc')->take(10)->get();

//     // Fetch general dashboard data
//     $activities = Activity::with('user')->latest()->take(10)->get();
//     $recentActivities = Activity::latest()->take(5)->get();
//     $users = User::with(['roles', 'state', 'city'])->latest()->limit(5)->get();

//     $suppliers = Supplier::select(
//         'id',
//         'name',
//         'company_name',
//         'contact_person',
//         'contact_number',
//         'email',
//         'gst_number',
//         'address',
//         'status',
//         'created_at'
//     )->latest()->take(3)->get();

//     return view('dashboard', compact(
//         'totalUsers',
//         'totalCustomers',
//         'totalSuppliers',
//         'recentActivities',
//         'activities',
//         'users',
//         'suppliers',
//         'newCustomersThisMonth',
//         'atRiskCustomers',
//         'customerGrowthRate',
//         'customerActivities',
//         'recentCustomers'
//     ));
// }
// ---------------------------------------------------------------------------------------------------
public function index()
{
    $totalUsers = User::count();
    $totalCustomers = Customer::count();
    $totalSuppliers = Supplier::count();

    // Fetch Customer Dashboard Metrics
    $newCustomersThisMonth = Customer::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
    $atRiskCustomers = $this->calculateAtRiskCustomers();
    $customerGrowthRate = $this->calculateCustomerGrowthRate();
    $customerActivities = $this->getRecentCustomerActivities();
    $recentCustomers = Customer::orderBy('created_at', 'desc')->take(10)->get();

    // Fetch Supplier Dashboard Metrics
    $newSuppliersThisMonth = Supplier::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();
    
    $expiringContracts = Supplier::whereBetween('contract_end_date', [
        now(), 
        now()->addDays(30)
    ])->count();

    $supplierGrowthRate = $this->calculateSupplierGrowthRate();
    $statusDistribution = $this->getSupplierStatusDistribution();
    $recentSuppliers = Supplier::orderBy('created_at', 'desc')->take(5)->get();
    $suppliersByState = $this->getSuppliersByState();

    // Fetch general dashboard data
    $activities = Activity::with('user')->latest()->take(10)->get();
    $recentActivities = Activity::latest()->take(5)->get();
    $users = User::with(['roles', 'state', 'city'])->latest()->limit(5)->get();

    $suppliers = Supplier::select(
        'id',
        'name',
        'company_name',
        'contact_person',
        'contact_number',
        'email',
        'gst_number',
        'address',
        'status',
        'created_at'
    )->latest()->take(3)->get();

    return view('dashboard', compact(
        'totalUsers',
        'totalCustomers',
        'totalSuppliers',
        'newCustomersThisMonth',
        'atRiskCustomers',
        'customerGrowthRate',
        'customerActivities',
        'recentCustomers',
        'newSuppliersThisMonth',
        'expiringContracts',
        'supplierGrowthRate',
        'statusDistribution',
        'recentSuppliers',
        'suppliersByState',
        'recentActivities',
        'activities',
        'users',
        'suppliers'
    ));
}

// ---------------------------------------------------------------------------------------------------


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




    private function calculateSupplierGrowthRate()
    {
        // Get suppliers count for current and previous month
        $currentMonthSuppliers = Supplier::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $previousMonthSuppliers = Supplier::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // Prevent division by zero
        if ($previousMonthSuppliers == 0) {
            return $currentMonthSuppliers > 0 ? 100 : 0;
        }

        // Calculate growth rate
        return (($currentMonthSuppliers - $previousMonthSuppliers) / $previousMonthSuppliers) * 100;
    }

    /**
     * Get supplier status distribution.
     *
     * @return array
     */
    private function getSupplierStatusDistribution()
    {
        return Supplier::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            })
            ->toArray();
    }

    /**
     * Get top 5 suppliers by state.
     *
     * @return array
     */
    private function getSuppliersByState()
    {
        return Supplier::select('state_id', DB::raw('COUNT(*) as supplier_count'))
            ->whereNotNull('state_id')
            ->groupBy('state_id')
            ->orderBy('supplier_count', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get supplier contract analytics.
     *
     * @return array
     */
    public function getContractAnalytics()
    {
        $currentDate = now();

        $contractAnalytics = [
            'total_contracts' => Supplier::whereNotNull('contract_start_date')->count(),
            'active_contracts' => Supplier::where('status', 'active')
                ->where('contract_start_date', '<=', $currentDate)
                ->where('contract_end_date', '>=', $currentDate)
                ->count(),
            'expired_contracts' => Supplier::where('contract_end_date', '<', $currentDate)->count(),
            'upcoming_contracts' => Supplier::where('contract_start_date', '>', $currentDate)->count(),
        ];

        return $contractAnalytics;
    }

    /**
     * Get supplier performance metrics.
     *
     * @return array
     */
    public function getSupplierPerformanceMetrics()
    {
        // This is a placeholder. In a real-world scenario, 
        // you'd integrate with purchase or performance tracking systems
        return [
            'total_suppliers' => Supplier::count(),
            'active_suppliers' => Supplier::where('status', 'active')->count(),
            'average_contract_duration' => Supplier::avg(
                DB::raw('DATEDIFF(contract_end_date, contract_start_date)')
            ),
        ];
    }
    // ---------------------------------------------------------------------------------------------------


    public function fetchRecentActivity()
    {
        $recentActivities = Activity::latest()->take(5)->get();

        return view('partials.recent_activity', compact('recentActivities'));
    }




    public function dashboard()
    {
        return view('dashboard', [
            'activities' => Activity::with('user')->latest()->take(10)->get(), // Fetch latest 10 activities
        ]);
    }
    
}
