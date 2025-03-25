<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'User Management')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS -->
    
    <style>
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            overflow-y: auto;
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
            margin-left: 250px; /* Same as sidebar width */
        }
        
        #content.active {
            margin-left: 0;
        }
        
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 250px; /* Same as sidebar width */
            z-index: 998;
            transition: all 0.3s;
        }
        
        .topbar.active {
            left: 0;
        }
        
        .main-content {
            padding-top: 70px; /* Height of topbar plus some spacing */
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
            #content {
                margin-left: 0;
            }
            #content.active {
                margin-left: 250px;
            }
            .topbar {
                left: 0;
            }
            .topbar.active {
                left: 250px;
            }
            #sidebarCollapse span {
                display: none;
            }
        }

        body {
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
        }
    </style>
</head>
<body>
    @auth
    <!-- Only show this content if user is authenticated -->
    <div class="wrapper">
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
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
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
                    <a href="{{ url('/user-roles') }}" class="{{ request()->is('user-roles') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i> Access Control Panel
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i> Define User Roles
                    </a>
                </li>
                <li>
                    <a href="#" class="{{ request()->is('supplier-hub*') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i> Supplier Hub
                    </a>
                </li>
                <li>
                    <a href="#" class="{{ request()->is('products*') ? 'active' : '' }}">
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
                    <a href="#" class="{{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm topbar">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex">
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
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container main-content">
                @yield('content')
            </div>
        </div>
    </div>
    @else
    <!-- Only show this content if user is NOT authenticated (login/register pages) -->
    <div>
        <!-- Simple Navbar for Login/Register -->
        <nav class="bg-gray-900 shadow-md px-2 py-2 fixed top-0 left-0 right-0 z-50">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-xl font-semibold text-white">User Management System</a>

                <div class="flex items-center space-x-5">
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-base font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-500 text-white text-base font-medium px-4 py-2 rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                        Register
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content for Login/Register Pages -->
        <div class="container mt-20">
            @yield('content')
        </div>
    </div>
    @endauth

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
                $('.topbar').toggleClass('active');
            });
        });
    </script>
</body>
</html>