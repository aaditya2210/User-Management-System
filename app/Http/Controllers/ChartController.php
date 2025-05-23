<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        return view('charts'); // Only load view, data will be fetched via AJAX
    }

    public function getChartData()
    {
        // Get total counts
        $totalUsers = DB::table('users')->count();
        $totalSuppliers = DB::table('suppliers')->count();
        $totalCustomers = DB::table('customers')->count();

        // Supplier status breakdown
        $supplierStatusData = [
            'active' => Supplier::where('status', 'active')->count(),
            'inactive' => Supplier::where('status', 'inactive')->count(),
        ];

        // Fetch suppliers grouped by state name
        $supplierStateData = DB::table('suppliers')
            ->join('states', 'suppliers.state_id', '=', 'states.id')
            ->select('states.name as state_name', DB::raw('COUNT(suppliers.id) as count'))
            ->groupBy('states.name')
            ->get();

        // Fetch suppliers grouped by city name
        $supplierCityData = DB::table('suppliers')
            ->join('cities', 'suppliers.city_id', '=', 'cities.id')
            ->select('cities.name as city_name', DB::raw('COUNT(suppliers.id) as count'))
            ->groupBy('cities.name')
            ->get();


        $activityData = Activity::selectRaw("DATE(created_at) as date, status, COUNT(*) as count")
            ->groupBy('date', 'status')
            ->orderBy('date', 'ASC')
            ->get();



        // Customer breakdown by type
        $customerTypeData = DB::table('customers')
            ->select('customer_type', DB::raw('COUNT(id) as count'))
            ->groupBy('customer_type')
            ->get();

        // Customer distribution by gender
        $customerGenderData = DB::table('customers')
            ->select('gender', DB::raw('COUNT(id) as count'))
            ->groupBy('gender')
            ->get();

        // Customers grouped by preferred contact method
        $customerContactMethodData = DB::table('customers')
            ->select('preferred_contact_method', DB::raw('COUNT(id) as count'))
            ->groupBy('preferred_contact_method')
            ->get();

        // Customers grouped by nationality
        $customerNationalityData = DB::table('customers')
            ->select('nationality', DB::raw('COUNT(id) as count'))
            ->groupBy('nationality')
            ->orderBy('count', 'DESC')
            ->get();

        // Fetch customer balance range distribution
        $customerBalanceData = [
            'Low (0 - 1,000)' => Customer::whereBetween('account_balance', [0, 1000])->count(),
            'Medium (1,001 - 10,000)' => Customer::whereBetween('account_balance', [1001, 10000])->count(),
            'High (10,001+)' => Customer::where('account_balance', '>', 10000)->count(),
        ];

        // // Fetch activity logs grouped by date and status
        // $activityData = Activity::selectRaw("DATE(created_at) as date, status, COUNT(*) as count")
        //  ->groupBy('date', 'status')
        //  ->orderBy('date', 'ASC')
        //  ->get();


        return response()->json([
            'totalUsers' => $totalUsers,
            'totalSuppliers' => $totalSuppliers,
            'totalCustomers' => $totalCustomers,
            'supplierStatusData' => $supplierStatusData,
            'supplierStateData' => $supplierStateData,
            'supplierCityData' => $supplierCityData,
            'customerTypeData' => $customerTypeData,
            'customerGenderData' => $customerGenderData,
            'customerContactMethodData' => $customerContactMethodData,
            'customerNationalityData' => $customerNationalityData,
            'customerBalanceData' => $customerBalanceData,
            'activityData' => $activityData,
        ]);
    }






    public function getUsersLocationData()
{
    try {
        $users = User::with(['city', 'state'])->get(['id', 'first_name', 'last_name', 'state_id', 'city_id']);

        // Prepare data for Google Charts
        $locationData = [];
        foreach ($users as $user) {
            if ($user->state && $user->city) {
                $locationData[] = [
                    'location' => $user->state->name, // Google Charts recognizes state names
                    'city' => $user->city->name,
                    'user' => $user->first_name . ' ' . $user->last_name
                ];
            }
        }

        return response()->json(['success' => true, 'data' => $locationData]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error fetching data!']);
    }
}




public function getSuppliersLocationData()
{
    try {
        $suppliers = Supplier::with(['city', 'state'])->get(['id', 'name', 'state_id', 'city_id']);

        // Prepare data for Google Charts
        $locationData = [];
        foreach ($suppliers as $supplier) {
            if ($supplier->state && $supplier->city) {
                $locationData[] = [
                    'location' => $supplier->state->name, // Google Charts recognizes state names
                    'city' => $supplier->city->name,
                    'supplier' => $supplier->name
                ];
            }
        }

        return response()->json(['success' => true, 'data' => $locationData]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error fetching supplier data!']);
    }
}


public function getCustomersLocationData()
{
    try {
        $customers = Customer::get(['id', 'name', 'nationality']);

        // Prepare data for Google Charts
        $locationData = [];
        foreach ($customers as $customer) {
            if (!empty($customer->nationality)) {
                $locationData[] = [
                    'location' => $customer->nationality, // Google Charts recognizes country names
                    'customer' => $customer->name
                ];
            }
        }

        return response()->json(['success' => true, 'data' => $locationData]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error fetching customer data!']);
    }
}

}
