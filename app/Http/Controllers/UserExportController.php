<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Log;

class UserExportController extends Controller
{
    public function exportCSV()
    {
        try {
            return Excel::download(new UsersExport, 'users.csv');
        } catch (\Exception $e) {
            Log::error("❌ Error exporting CSV: " . $e->getMessage());
            return response()->json(['error' => 'Failed to export CSV.'], 500);
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new UsersExport, 'users.xlsx');
        } catch (\Exception $e) {
            Log::error("❌ Error exporting Excel: " . $e->getMessage());
            return response()->json(['error' => 'Failed to export Excel.'], 500);
        }
    }

    public function exportPDF()
    {
        try {
            $users = User::all();
            $pdf = Pdf::loadView('exports.users', compact('users'));
            return $pdf->download('users.pdf');
        } catch (\Exception $e) {
            Log::error("❌ Error exporting PDF: " . $e->getMessage());
            return response()->json(['error' => 'Failed to export PDF.'], 500);
        }
    }
}
