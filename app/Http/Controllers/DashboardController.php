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

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();
        // $totalOrders = \DB::table('orders')->count(); 
        $activities = Activity::with('user')->latest()->take(10)->get();
        // Fetch recent activities (latest 5)
        $recentActivities = Activity::latest()->take(5)->get();
        // $users = User::with('roles')->latest()->take(10)->get(); // Fetch users with roles
        // $users = User::with(['roles', 'state', 'city'])->latest()->take(1)->get();
        $users = User::with(['roles', 'state', 'city'])->latest()->limit(5)->get();

        // Debugging: Check if data is being fetched
        // if ($users->isEmpty()) {
        //     // This will log the message instead of stopping execution.
        // }

        // Debugging: Check the structure of fetched data
        // dd($users);


        $suppliers = Supplier::select(
            'id',
            'name',
            'company_name',
            'contact_person',
            'contact_number',
            'email',
            'gst_number',
            'address',
            // 'state',
            // 'city',
            'status',
            'created_at'
        )
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', compact('totalUsers', 'totalCustomers', 'totalSuppliers', 'recentActivities', 'activities', 'users', 'suppliers'));
        // return view('dashboard', compact('totalUsers', 'totalCustomers', 'totalSuppliers', 'recentActivities','activities','users'));
    }



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
