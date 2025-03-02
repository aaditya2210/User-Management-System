<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuppliersExport;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return response()->json(Supplier::paginate(4));
            }
            return view('suppliers.index');
        } catch (\Exception $e) {
            Log::error('Error fetching suppliers: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load suppliers.'], 500);
        }
    }

    public function create()
    {
        try {
            return view('suppliers.create');
        } catch (\Exception $e) {
            Log::error('Error loading supplier creation page: ' . $e->getMessage());
            return redirect()->route('suppliers.index')->with('error', 'Something went wrong.');
        }
    }

    
    public function store(StoreSupplierRequest $request)
{
    try {
        Supplier::create($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    } catch (\Exception $e) {
        Log::error('Error adding supplier: ' . $e->getMessage());
        return redirect()->route('suppliers.index')->with('error', 'Failed to add supplier.');
    }
}


    public function edit(Supplier $supplier)
    {
        try {
            return view('suppliers.edit', compact('supplier'));
        } catch (\Exception $e) {
            Log::error('Error loading supplier edit page: ' . $e->getMessage());
            return redirect()->route('suppliers.index')->with('error', 'Something went wrong.');
        }
    }

    // public function update(Request $request, Supplier $supplier)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
    //             'contact_number' => 'required|string|max:15',
    //             'address' => 'nullable|string|max:500',
    //             'company_name' => 'nullable|string|max:255',
    //             'gst_number' => 'nullable|string|max:50|unique:suppliers,gst_number,' . $supplier->id,
    //             'website' => 'nullable|url|max:255',
    //             'country' => 'nullable|string|max:100',
    //             'state' => 'nullable|string|max:100',
    //             'city' => 'nullable|string|max:100',
    //             'postal_code' => 'nullable|string|max:20',
    //             'contact_person' => 'nullable|string|max:255',
    //             'status' => 'required|in:active,inactive',
    //             'contract_start_date' => 'nullable|date',
    //             'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
    //         ]);

    //         $supplier->update($request->all());

    //         return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
    //     } catch (\Exception $e) {
    //         Log::error('Error updating supplier: ' . $e->getMessage());
    //         return redirect()->route('suppliers.index')->with('error', 'Failed to update supplier.');
    //     }
    // }



    public function update(UpdateSupplierRequest $request, Supplier $supplier)
{
    try {
        $supplier->update($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
    } catch (\Exception $e) {
        Log::error('Error updating supplier: ' . $e->getMessage());
        return redirect()->route('suppliers.index')->with('error', 'Failed to update supplier.');
    }
}


    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting supplier: ' . $e->getMessage());
            return redirect()->route('suppliers.index')->with('error', 'Failed to delete supplier.');
        }
    }

    public function exportCSV()
    {
        try {
            return Excel::download(new SuppliersExport, 'suppliers.csv');
        } catch (\Exception $e) {
            Log::error('Error exporting suppliers as CSV: ' . $e->getMessage());
            return redirect()->route('suppliers.index')->with('error', 'Failed to export suppliers as CSV.');
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new SuppliersExport, 'suppliers.xlsx');
        } catch (\Exception $e) {
            Log::error('Error exporting suppliers as Excel: ' . $e->getMessage());
            return redirect()->route('suppliers.index')->with('error', 'Failed to export suppliers as Excel.');
        }
    }

    public function exportPDF()
    {
        try {
            $suppliers = Supplier::all();
            $pdf = Pdf::loadView('suppliers.pdf', compact('suppliers'));
            return $pdf->download('suppliers.pdf');
        } catch (\Exception $e) {
            Log::error('Error exporting suppliers as PDF: ' . $e->getMessage());
            return redirect()->route('suppliers.index')->with('error', 'Failed to export suppliers as PDF.');
        }
    }
}
