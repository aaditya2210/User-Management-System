<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 2px; text-align: left; }
        th { background-color: #f4f4f4; }
        .page-break { page-break-after: always; }
        th, td { word-wrap: break-word; }
    </style>
</head>
<body>
    <h2>Customer List</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Name</th>
                <th style="width: 15%;">Email</th>
                <th style="width: 10%;">Contact Number</th>
                <th style="width: 10%;">Company Name</th>
                <th style="width: 10%;">Job Title</th>
                <th style="width: 5%;">Gender</th>
                <th style="width: 10%;">Date of Birth</th>
                <th style="width: 10%;">Nationality</th>
                <th style="width: 10%;">Customer Type</th>
                <th style="width: 10%;">Preferred Contact Method</th>
                <th style="width: 10%;">Newsletter Subscription</th>
                <th style="width: 10%;">Account Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $index => $customer)
                @if ($index > 0 && $index % 25 == 0)
                    </tbody>
                </table>
                <div class="page-break"></div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%;">Name</th>
                            <th style="width: 15%;">Email</th>
                            <th style="width: 10%;">Contact Number</th>
                            <th style="width: 10%;">Company Name</th>
                            <th style="width: 10%;">Job Title</th>
                            <th style="width: 5%;">Gender</th>
                            <th style="width: 10%;">Date of Birth</th>
                            <th style="width: 10%;">Nationality</th>
                            <th style="width: 10%;">Customer Type</th>
                            <th style="width: 10%;">Preferred Contact Method</th>
                            <th style="width: 10%;">Newsletter Subscription</th>
                            <th style="width: 10%;">Account Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                @endif
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->contact_number }}</td>
                    <td>{{ $customer->company_name }}</td>
                    <td>{{ $customer->job_title }}</td>
                    <td>{{ $customer->gender }}</td>
                    <td>{{ $customer->date_of_birth }}</td>
                    <td>{{ $customer->nationality }}</td>
                    <td>{{ $customer->customer_type }}</td>
                    <td>{{ $customer->preferred_contact_method }}</td>
                    <td>{{ $customer->newsletter_subscription ? 'Yes' : 'No' }}</td>
                    <td>{{ $customer->account_balance }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>