<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuppliersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // return Supplier::select([
        //     'name', 'email', 'contact_number', 'address', 'company_name',
        //     'gst_number', 'website', 'state_id', 'city_id', 
        //     'postal_code', 'contact_person', 'status', 'contract_start_date', 
        //     'contract_end_date'
        // ])->paginate(10);  // Apply pagination

        return Supplier::all();
    }

    public function headings(): array
    {
        return [
            'id','name', 'email', 'contact_number','gst_number', 'company_name',
            'address', 'website', 'state_id', 'city_id', 
            'postal_code', 'contact_person', 'status', 'contract_start_date', 
            'contract_end_date'
        ];
    }
}
