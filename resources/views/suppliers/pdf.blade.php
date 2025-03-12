<!DOCTYPE html>
<html>
<head>
    <title>Suppliers List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .table-container { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { 
            border: 1px solid black; 
            padding: 8px; 
            text-align: left; 
            word-wrap: break-word; 
            font-size: 10px; /* Adjusted for PDF readability */
        }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Suppliers List</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Name</th>
                    <th style="width: 12%;">Email</th>
                    <th style="width: 10%;">Contact Number</th>
                    <th style="width: 15%;">Address</th>
                    <th style="width: 10%;">Company Name</th>
                    <th style="width: 10%;">GST Number</th>
                    <th style="width: 10%;">Website</th>
                    {{-- <th style="width: 8%;">Country</th> --}}
                    <th style="width: 8%;">State</th>
                    <th style="width: 8%;">City</th>
                    <th style="width: 8%;">Postal Code</th>
                    <th style="width: 12%;">Contact Person</th>
                    <th style="width: 6%;">Status</th>
                    <th style="width: 10%;">Contract Start Date</th>
                    <th style="width: 10%;">Contract End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->contact_number }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->company_name }}</td>
                        <td>{{ $supplier->gst_number }}</td>
                        <td>{{ $supplier->website }}</td>
                        {{-- <td>{{ $supplier->country }}</td> --}}
                        <td>{{ $supplier->state }}</td>
                        <td>{{ $supplier->city }}</td>
                        <td>{{ $supplier->postal_code }}</td>
                        <td>{{ $supplier->contact_person }}</td>
                        <td>{{ ucfirst($supplier->status) }}</td>
                        <td>{{ $supplier->contract_start_date }}</td>
                        <td>{{ $supplier->contract_end_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
