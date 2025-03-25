<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        
        #sidebar.active {
            margin-left: -250px;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background-color: #212529;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }
        
        #sidebar ul li a {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover,
        #sidebar ul li a.active {
            color: #fff;
            background-color: #495057;
            border-left: 4px solid #0d6efd;
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
        }
        
        #content {
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .dashboard-card {
            transition: transform 0.3s;
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #sidebarCollapse span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar">
            @role('admin')
            <div class="sidebar-header">
                <h3 class="fs-5">Admin Dashboard</h3>
            </div>
            @endrole
            @role('supplier_manager')
            <div class="sidebar-header">
                <h3 class="fs-5">Supplier Dashboard</h3>
            </div>
            @endrole
            @role('customer_manager')
            <div class="sidebar-header">
                <h3 class="fs-5">Customer Dashboard</h3>
            </div>
            @endrole

            <ul class="list-unstyled components">
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    @can(abilities: 'create-users')
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    @endcan
        
                </li>
                <li>
                    @can(abilities: 'create-customers')
                    <a href="{{ route('customers.index') }}" class="nav-link">
                        <i class="fas fa-user-tie"></i> Manage Customers
                    </a>
                    @endcan
                </li>
                <li>
                    @can(abilities: 'create-suppliers')
                    <a href="{{ route('suppliers.index') }}" class="nav-link">
                        <i class="fas fa-truck"></i> Manage Suppliers
                    </a>
                    @endcan
                    <ul class="collapse list-unstyled ps-4" id="supplierSubmenu">
                        <li>
                            <a href="#"><i class="fas fa-plus-circle"></i> Add Supplier</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-edit"></i> Edit Supplier</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-trash-alt"></i> Delete Supplier</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('/user-roles') }}">
                        {{-- <i class="fas fa-shopping-cart"></i> Manage User Roles --}}
                        <i class="fas fa-user-shield"></i> Access Control Panel
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">
                        {{-- <i class="fas fa-box"></i> Define Roles --}}
                        <i class="fas fa-users-cog"></i> Define User Roles
                    </a>
                </li>
                <li>
                    <a href="#">
                        {{-- <i class="fas fa-box"></i> Supplier Hub --}}
                        <i class="fas fa-boxes"></i> Supplier Hub
                    </a>
                </li>
                <li>
                    <a href="/products">
                        <i class="fas fa-box-open"></i> Product Explorer
                    </a>
                </li>
                <li>
                    @can('watch-analytics')
                    <a href="/charts">
                        <i class="fas fa-chart-bar"></i> Analytics
                    </a>
                    @endcan
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex">
                        <div class="dropdown">
                            {{-- <button class="btn position-relative me-4" type="button">
                                <i class="fas fa-bell fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </button> --}}
                        </div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                <div class="bg-primary rounded-circle text-white d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                                    <span>{{ Auth::user()->first_name[0] ?? 'U' }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium me-2">{{ Auth::user()->first_name ?? 'User' }}</span>
                                    @if(Auth::user()->getRoleNames()->isNotEmpty())
                                        @php
                                            $roleName = Auth::user()->getRoleNames()->first();
                                            $roleColorClass = match(strtolower($roleName)) {
                                                'admin' => 'bg-danger',
                                                'customer_manager' => 'bg-warning text-dark',
                                                'supplier_manager' => 'bg-info',
                                                'editor' => 'bg-success',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $roleColorClass }} rounded-pill px-2 d-inline-flex align-items-center" style="font-size: 0.7rem; line-height: 1.2;">
                                            <i class="fas fa-user-shield me-1" style="font-size: 0.65rem;"></i>
                                            {{ $roleName }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary rounded-pill px-2 d-inline-flex align-items-center" style="font-size: 0.7rem; line-height: 1.2;">
                                            <i class="fas fa-user me-1" style="font-size: 0.65rem;"></i>
                                            User
                                        </span>
                                    @endif
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                                {{-- <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <div class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col">
                        <h2>Dashboard Overview</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                {{-- <!-- Stat Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-primary text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="card-title">Total Users</h5>
                                <h3>1,250</h3>
                                <p class="card-text"><small>+12% from last month</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-success text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h5 class="card-title">Customers</h5>
                                <h3>857</h3>
                                <p class="card-text"><small>+5% from last month</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-warning text-dark h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h5 class="card-title">Suppliers</h5>
                                <h3>54</h3>
                                <p class="card-text"><small>+2 new this month</small></p>
                            </div>
                        </div>
                    </div> --}}





<!-- Stat Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card dashboard-card bg-primary text-white h-100">
            <div class="card-body text-center">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="card-title">Total Users</h5>
                <h3>{{ $totalUsers }}</h3>
                {{-- <p class="card-text"><small>Live Data</small></p> --}}
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card dashboard-card bg-success text-white h-100">
            <div class="card-body text-center">
                <div class="card-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h5 class="card-title">Customers</h5>
                <h3>{{ $totalCustomers }}</h3>
                {{-- <p class="card-text"><small>Live Data</small></p> --}}
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card dashboard-card bg-warning text-dark h-100">
            <div class="card-body text-center">
                <div class="card-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h5 class="card-title">Suppliers</h5>
                <h3>{{ $totalSuppliers }}</h3>
                {{-- <p class="card-text"><small>Live Data</small></p> --}}
            </div>
        </div>
    </div>





                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-info text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <h5 class="card-title">New Orders</h5>
                                <h3>129</h3>
                                <p class="card-text"><small>+18% from last week</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <!-- Recent Activity & Quick Access -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Activity</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Smith</td>
                                                <td>Added new customer</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>Today, 10:30 AM</td>
                                            </tr>
                                            <tr>
                                                <td>Sarah Johnson</td>
                                                <td>Updated supplier contact</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>Today, 9:15 AM</td>
                                            </tr>
                                            <tr>
                                                <td>Mike Brown</td>
                                                <td>Processed order #38291</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>Yesterday, 4:30 PM</td>
                                            </tr>
                                            <tr>
                                                <td>Lisa Wong</td>
                                                <td>Added new product</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>Yesterday, 2:14 PM</td>
                                            </tr>
                                            <tr>
                                                <td>David Miller</td>
                                                <td>Updated inventory</td>
                                                <td><span class="badge bg-danger">Failed</span></td>
                                                <td>Mar 12, 11:30 AM</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}








<!-- Recent Activity -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Activity</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @foreach ($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity->user->first_name }} {{ $activity->user->last_name }}</td>
                                    <td>{{ $activity->activity }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $activity->status == 'Completed' ? 'bg-success' : ($activity->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $activity->status }}
                                        </span>
                                    </td>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody> --}}


                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    {{-- <td>{{ $activity->user->first_name }} {{ $activity->user->last_name }}</td> --}}
                                    <td>{{ $activity->user->first_name ?? 'Unknown' }} {{ $activity->user->last_name ?? 'User' }}</td>
                                    <td>{{ $activity->activity }}</td>
                                    <td><span class="badge bg-{{ $activity->status == 'Completed' ? 'success' : ($activity->status == 'Pending' ? 'warning' : 'danger') }}">{{ $activity->status }}</span></td>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        


                    </table>
                    @if ($recentActivities->isEmpty())
                        <p class="text-center text-muted">No recent activity.</p>
                    @endif
                </div>
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
                                    <a href="{{ route('users.create') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-user-plus me-2 text-primary"></i> Add New User
                                    </a>
                                    <a href="{{ route('customers.create') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-user-tie me-2 text-success"></i> Add New Customer
                                    </a>
                                    <a href="{{ route('suppliers.create') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-truck me-2 text-warning"></i> Add New Supplier
                                    </a>
                                    {{-- <a href="#" class="list-group-item list-group-item-action">
                                        <i class="fas fa-box me-2 text-info"></i> Add New Product
                                    </a> --}}
                                    {{-- <a href="#" class="list-group-item list-group-item-action">
                                        <i class="fas fa-file-invoice me-2 text-danger"></i> Create Invoice
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users & Suppliers Overview -->
                {{-- <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Users Overview</h5>
                                <a href="#" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>Admin</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>Manager</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mike Johnson</td>
                                                <td>Staff</td>
                                                <td><span class="badge bg-secondary">Inactive</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}



                    <div class="row">
                        {{-- <div class="col-md-6 mb-4">
                            <div class="card dashboard-card h-100">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Users Overview</h5>
                                    <a href="') }}" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>{{ route('users.index
                                                    <th>Contact Number</th>
                                                    <th>Location</th>
                                                    <th>Role</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="usersTable">
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->contact_number }}</td>
                                                        <td>{{ optional($user->state)->name }}, {{ optional($user->city)->name }}</td>
                                                        <td>
                                                            @foreach ($user->roles as $role)
                                                                <span class="badge bg-info">{{ $role->name }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                            <button class="btn btn-sm btn-outline-danger deleteUser" data-id="{{ $user->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     --}}

                     <div class="col-md-12 mb-4"> <!-- Increased column width -->
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Users Overview</h5>
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered w-100"> <!-- Removed .table-responsive -->
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            <th>Location</th>
                                            <th>Role</th>
                                            <th>Created At</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="usersTable">
                                        {{-- @php dd($users[0]->first_name); @endphp --}}
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->contact_number }}</td>
                                                <td>{{ optional($user->state)->name }}, {{ optional($user->city)->name }}</td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge bg-info">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                                {{-- <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger deleteUser" data-id="{{ $user->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-md-12 mb-4"> 
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Suppliers</h5>
                                <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Contact Person</th>
                                                <th>Contact Number</th>
                                                <th>Email</th>
                                                <th>GST Number</th>
                                                <th>Address</th>
                                                {{-- <th>State</th>
                                                <th>City</th> --}}
                                                <th>Status</th>
                                                <th>Created At</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($suppliers as $supplier)
                                                <tr>
                                                    <td>{{ $supplier->name }}</td>
                                                    <td>{{ $supplier->company_name }}</td>
                                                    <td>{{ $supplier->contact_person }}</td>
                                                    <td>{{ $supplier->contact_number }}</td>
                                                    <td>{{ $supplier->email }}</td>
                                                    <td>{{ $supplier->gst_number ?? 'N/A' }}</td>
                                                    <td>{{ $supplier->address }}</td>
                                                    {{-- <td>{{ $supplier->state }}</td> --}}
                                                    {{-- <td>{{ $supplier->city }}</td> --}}
                                                    <td>
                                                        <span class="badge {{ $supplier->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ ucfirst($supplier->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($supplier->created_at)->format('d M Y') }}</td>
                                                    {{-- <td>
                                                        <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>                    
    <!-- Bootstrap & jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JS -->
    <script>


// ---------------------------------------------

    function loadRecentActivity() {
        $.ajax({
            url: "{{ route('dashboard.activity') }}", // Define the route
            method: "GET",
            success: function(data) {
                $('tbody').html(data);
            }
        });
    }

    // Auto-refresh every 10 seconds
    setInterval(loadRecentActivity, 10000);





    // function fetchUsers() {
    //     $.ajax({
    //         url: "{{ route('users.list') }}",
    //         type: "GET",
    //         success: function(response) {
    //             let usersTable = '';
    //             response.users.forEach(user => {
    //                 let roleBadges = user.roles.map(role => `<span class="badge bg-info">${role}</span>`).join(' ');

    //                 usersTable += `
    //                     <tr>
    //                         <td>${user.first_name} ${user.last_name}</td>
    //                         <td>${user.email}</td>
    //                         <td>${user.contact_number}</td>
    //                         <td>${user.state ? user.state.name : ''}, ${user.city ? user.city.name : ''}</td>
    //                         <td>${roleBadges}</td>
    //                         <td>${new Date(user.created_at).toLocaleDateString()}</td>
    //                         <td>
    //                             <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
    //                             <button class="btn btn-sm btn-outline-danger deleteUser" data-id="${user.id}">
    //                                 <i class="fas fa-trash"></i>
    //                             </button>
    //                         </td>
    //                     </tr>
    //                 `;
    //             });
    //             $('#usersTable').html(usersTable);
    //         }
    //     });
    // }

    // setInterval(fetchUsers, 5000);
    // $(document).ready(fetchUsers);



    function fetchUsers() {
    $.ajax({
        url: @json(route('users.list')),
        type: "GET",
        success: function(response) {
            if (!response.users || response.users.length === 0) {
                $('#usersTable').html('<tr><td colspan="7" class="text-center">No users found</td></tr>');
                return;
            }

            let usersTable = '';
            response.users.forEach(user => {
                let roleBadges = user.roles.map(role => `<span class="badge bg-info">${role.name}</span>`).join(' ');

                const formattedDate = new Intl.DateTimeFormat('en-US', {
                    day: '2-digit', month: 'short', year: 'numeric'
                }).format(new Date(user.created_at));

                usersTable += `
                    <tr>
                        <td>${user.first_name} ${user.last_name}</td>
                        <td>${user.email}</td>
                        <td>${user.contact_number}</td>
                        <td>${user.state ? user.state.name : ''}, ${user.city ? user.city.name : ''}</td>
                        <td>${roleBadges}</td>
                        <td>${formattedDate}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger deleteUser" data-id="${user.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#usersTable').html(usersTable);
        },
        error: function(xhr) {
            console.error("Error fetching users:", xhr.responseText);
        }
    });
}

// Only refresh when page is active
setInterval(() => {
    if (document.visibilityState === 'visible') {
        fetchUsers();
    }
}, 5000);

$(document).ready(fetchUsers);

// ---------------------------------------------








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