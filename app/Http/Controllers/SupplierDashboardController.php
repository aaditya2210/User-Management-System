<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierDashboardController extends Controller
{
    /**
     * Display the supplier dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Total Suppliers
        $totalSuppliers = Supplier::count();

        // New Suppliers This Month
        $newSuppliersThisMonth = Supplier::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Expiring Contracts in Next 30 Days
        $expiringContracts = Supplier::whereBetween('contract_end_date', [
            now(), 
            now()->addDays(30)
        ])->count();

        // Supplier Growth Rate
        $supplierGrowthRate = $this->calculateSupplierGrowthRate();

        // Status Distribution
        $statusDistribution = $this->getSupplierStatusDistribution();

        // Recent Suppliers
        $recentSuppliers = Supplier::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Suppliers by State (Top 5)
        $suppliersByState = $this->getSuppliersByState();

        return view('supplier_dashboard', compact(
            'totalSuppliers', 
            'newSuppliersThisMonth', 
            'expiringContracts', 
            'supplierGrowthRate', 
            'statusDistribution',
            'recentSuppliers',
            'suppliersByState'
        ));
    }

    /**
     * Calculate month-over-month supplier growth rate.
     *
     * @return float
     */
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
}