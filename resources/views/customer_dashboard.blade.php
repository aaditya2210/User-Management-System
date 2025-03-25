<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Manager Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #f4f6f9;
        }
        
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background-color: #2c3e50;
            color: #ecf0f1;
            transition: all 0.3s;
        }
        
        #sidebar.active {
            margin-left: -250px;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background-color: #34495e;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul li a {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover,
        #sidebar ul li a.active {
            color: #ffffff;
            background-color: #3498db;
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
        }
        
        .dashboard-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #3498db;
        }
        
        .status-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 class="fs-5">Customer Manager Dashboard</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('customers.index') }}">
                        <i class="fas fa-user-tie"></i> Manage Customers
                    </a>
                </li>
                <li>
                    <a href="{{ route('customers.create') }}">
                        <i class="fas fa-user-plus"></i> Add New Customer
                    </a>
                </li>
                <li>
                    <a href="/customer-segments">
                        <i class="fas fa-layer-group"></i> Customer Segments
                    </a>
                </li>
                <li>
                    <a href="/customer-feedback">
                        <i class="fas fa-comment-dots"></i> Customer Feedback
                    </a>
                </li>
                <li>
                    <a href="/customer-reports">
                        <i class="fas fa-chart-pie"></i> Customer Reports
                    </a>
                </li>
                <li>
                    <a href="/support-tickets">
                        <i class="fas fa-ticket-alt"></i> Support Tickets
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content" class="w-100">
            <!-- Topbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-primary">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                <div class="bg-primary rounded-circle text-white d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                                    <span>{{ Auth::user()->first_name[0] ?? 'U' }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium me-2">{{ Auth::user()->first_name ?? 'User' }}</span>
                                    <span class="badge bg-warning text-dark rounded-pill px-2">Customer Manager</span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <div class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col">
                        <h2>Customer Management Dashboard</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Customer Metrics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-primary text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="card-title">Total Customers</h5>
                                <h3>{{ $totalCustomers }}</h3>
                                <p class="card-text"><small>Registered Customers</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-success text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <h5 class="card-title">New Customers</h5>
                                <h3>{{ $newCustomersThisMonth }}</h3>
                                <p class="card-text"><small>This Month</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-warning text-dark h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h5 class="card-title">At-Risk Customers</h5>
                                <h3>{{ $atRiskCustomers }}</h3>
                                <p class="card-text"><small>Potential Churn</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-info text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5 class="card-title">Customer Growth</h5>
                                <h3>{{ number_format($customerGrowthRate, 1) }}%</h3>
                                <p class="card-text"><small>Month-over-Month</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Activities & Quick Actions -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Customer Activities</h5>
                                <a href="/customer-activities" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Activity</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customerActivities as $activity)
                                                <tr>
                                                    <td>{{ $activity->customer->first_name }} {{ $activity->customer->last_name }}</td>
                                                    <td>{{ $activity->description }}</td>
                                                    <td>
                                                        <span class="badge status-badge {{ $activity->status == 'completed' ? 'bg-success' : ($activity->status == 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                                                            {{ ucfirst($activity->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="{{ route('customers.create') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-user-plus me-2 text-success"></i> Add New Customer
                                    </a>
                                    <a href="/customer-segments" class="list-group-item list-group-item-action">
                                        <i class="fas fa-layer-group me-2 text-primary"></i> Manage Customer Segments
                                    </a>
                                    <a href="/support-tickets" class="list-group-item list-group-item-action">
                                        <i class="fas fa-ticket-alt me-2 text-warning"></i> Manage Support Tickets
                                    </a>
                                    <a href="/customer-feedback" class="list-group-item list-group-item-action">
                                        <i class="fas fa-comment-dots me-2 text-info"></i> Review Customer Feedback
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer List -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Customers</h5>
                                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Registration Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentCustomers as $customer)
                                                <tr>
                                                    {{-- <td>{{ $customer->first_name }} {{ $customer->last_name }}</td> --}}
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->contact_number }}</td>
                                                    <td>{{ $customer->state }}, {{ $customer->city }}</td>
                                                    <td>
                                                        <span class="badge status-badge {{ $customer->status == 'active' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ ucfirst($customer->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Auto collapse sidebar on mobile
            function checkWidth() {
                if ($(window).width() < 768) {
                    $('#sidebar').addClass('active');
                } else {
                    $('#sidebar').removeClass('active');
                }
            }
            
            // Check width on page load
            checkWidth();
            
            // Check width on window resize
            $(window).resize(checkWidth);
        });
    </script>
</body>
</html>