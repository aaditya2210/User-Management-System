<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return response()->json(Customer::paginate(4));
            }
            return view('customers.index');
        } catch (\Exception $e) {
            Log::error('Error fetching customers:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to fetch customers'], 500);
        }
    }

    public function create()
    {
        try {
            return view('customers.create');
        } catch (\Exception $e) {
            Log::error('Error loading create customer page:', ['error' => $e->getMessage()]);
            return redirect()->route('customers.index')->with('error', 'Failed to load create customer page.');
        }
    }

    // public function store(Request $request)
    // {
        
    //     try {
    //         // $request->validate([
    //         //     'name' => 'required|string|max:255',
    //         //     'email' => 'required|email|unique:customers|max:255',
    //         //     'contact_number' => 'required|string|max:20',
    //         //     'address' => 'nullable|string|max:500',
    //         //     'company_name' => 'nullable|string|max:255',
    //         //     'job_title' => 'nullable|string|max:255',
    //         //     'gender' => 'nullable|in:Male,Female,Other',
    //         //     'date_of_birth' => 'nullable|date',
    //         //     'nationality' => 'nullable|string|max:100',
    //         //     'customer_type' => 'nullable|in:Regular,VIP,Enterprise',
    //         //     'notes' => 'nullable|string|max:1000',
    //         //     'preferred_contact_method' => 'nullable|in:Email,Phone,WhatsApp',
    //         //     'newsletter_subscription' => 'boolean',
    //         //     'account_balance' => 'nullable|numeric|min:0',
    //         // ]);


    //         $validatedData = $request->validated();
    //     Customer::create($validatedData);
    //         Customer::create($request->all());

    //         return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    //     } catch (\Exception $e) {
    //         Log::error('Error creating customer:', ['error' => $e->getMessage()]);
    //         return redirect()->back()->with('error', 'Failed to create customer.');
    //     }
    // }


    public function store(StoreCustomerRequest $request)
    {
        try {
            // Log incoming request data for debugging
            Log::info('Customer Form Data:', $request->all());

            // Validate request data
            $validatedData = $request->validated();

            // Create a new customer record
            Customer::create($validatedData);

            return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating customer:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create customer.');
        }
    }



    public function edit(Customer $customer)
    {
        try {
            return view('customers.edit', compact('customer'));
        } catch (\Exception $e) {
            Log::error('Error loading edit customer page:', ['error' => $e->getMessage()]);
            return redirect()->route('customers.index')->with('error', 'Failed to load edit customer page.');
        }
    }

    // public function update(Request $request, Customer $customer)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:customers,email,' . $customer->id . '|max:255',
    //             'contact_number' => 'required|string|max:20',
    //             'address' => 'nullable|string|max:500',
    //             'company_name' => 'nullable|string|max:255',
    //             'job_title' => 'nullable|string|max:255',
    //             'gender' => 'nullable|in:Male,Female,Other',
    //             'date_of_birth' => 'nullable|date',
    //             'nationality' => 'nullable|string|max:100',
    //             'customer_type' => 'nullable|in:Regular,VIP,Enterprise',
    //             'notes' => 'nullable|string|max:1000',
    //             'preferred_contact_method' => 'nullable|in:Email,Phone,WhatsApp',
    //             'newsletter_subscription' => 'boolean',
    //             'account_balance' => 'nullable|numeric|min:0',
    //         ]);

    //         $customer->update($request->all());

    //         return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    //     } catch (\Exception $e) {
    //         Log::error('Error updating customer:', ['error' => $e->getMessage(), 'customer_id' => $customer->id]);
    //         return redirect()->back()->with('error', 'Failed to update customer.');
    //     }
    // }


    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            Log::info('Update Request Data:', $request->validated());
    
            $customer->update($request->validated());
    
            Log::info('Customer Updated Successfully:', ['id' => $customer->id]);
    
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating customer:', ['error' => $e->getMessage(), 'customer_id' => $customer->id]);
            return redirect()->back()->with('error', 'Failed to update customer.');
        }
    }
    
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting customer:', ['error' => $e->getMessage(), 'customer_id' => $customer->id]);
            return redirect()->route('customers.index')->with('error', 'Failed to delete customer.');
        }
    }

    // CSV Export
    public function exportCSV()
    {
        try {
            return Excel::download(new CustomersExport, 'customers.csv');
        } catch (\Exception $e) {
            Log::error('Error exporting customers to CSV:', ['error' => $e->getMessage()]);
            return redirect()->route('customers.index')->with('error', 'Failed to export customers to CSV.');
        }
    }

    // Excel Export
    public function exportExcel()
    {
        try {
            return Excel::download(new CustomersExport, 'customers.xlsx');
        } catch (\Exception $e) {
            Log::error('Error exporting customers to Excel:', ['error' => $e->getMessage()]);
            return redirect()->route('customers.index')->with('error', 'Failed to export customers to Excel.');
        }
    }

    // PDF Export
    public function exportPDF()
    {
        try {
            $customers = Customer::all();
            $pdf = Pdf::loadView('exports.customers_pdf', compact('customers'));
            return $pdf->download('customers.pdf');
        } catch (\Exception $e) {
            Log::error('Error exporting customers to PDF:', ['error' => $e->getMessage()]);
            return redirect()->route('customers.index')->with('error', 'Failed to export customers to PDF.');
        }
    }
}
