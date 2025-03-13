<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'User Management')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS -->
</head>
<body>
{{-- 
    {{-- <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800">User Management System</a>

            <div>
                @guest
                    <!-- Show Login & Register buttons for guests -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-4">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</a>
                @else
                    <!-- Show Dashboard & Logout for authenticated users -->
                    <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900 px-4">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav> --}}
 

    <!-- Navbar -->
{{-- <nav class="bg-white shadow-md px-6 py-3">
    <nav class="bg-white shadow-md p-2">
    <div class="container mx-auto flex justify-between items-center">
        <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800">User Management System</a>

        <div class="flex items-center space-x-5">
            @guest
                <!-- Guest: Login & Register -->
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-base font-medium">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-500 text-white text-base font-medium px-4 py-2 rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                    Register
                </a>
            @else
                <!-- Authenticated: Dashboard & Logout -->
                <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900 text-base font-medium">Dashboard</a>
                {{-- <div class="btn-group float-md-end"> --}}
                    {{-- <a href="{{ route('suppliers.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-box me-1"></i> Suppliers
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-users me-1"></i> Customers
                    </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white text-base font-medium px-4 py-2 rounded-md hover:bg-red-600 transition duration-150 ease-in-out">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav> --}}
 


<nav class="bg-gray-900 shadow-md px-2 py-2">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/users') }}" class="text-xl font-semibold text-white">User Management System</a>

        <div class="flex items-center space-x-5">
            @guest
                <!-- Guest: Login & Register -->
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-base font-medium">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-500 text-white text-base font-medium px-4 py-2 rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                    Register
                </a>
            @else
                <!-- Authenticated: Dashboard, Suppliers, Customers & Logout -->
                <a href="{{ route('users.index') }}" class="text-gray-300 hover:text-white text-base font-medium">Dashboard</a>

                <a href="{{ route('suppliers.index') }}" class="border border-blue-500 text-blue-400 hover:bg-blue-500 hover:text-white text-base font-medium px-4 py-2 rounded-md transition duration-150 ease-in-out">
                    <i class="fas fa-box me-1"></i> Suppliers
                </a>
                
                <a href="{{ route('customers.index') }}" class="border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white text-base font-medium px-4 py-2 rounded-md transition duration-150 ease-in-out">
                    <i class="fas fa-users me-1"></i> Customers
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white text-base font-medium px-4 py-2 rounded-md hover:bg-red-600 transition duration-150 ease-in-out">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>


    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
