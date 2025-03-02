<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'User Management')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    {{-- <nav class="navbar navbar-dark bg-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('users.index') }}">User Management</a>
            
            <div class="d-flex gap-2">
                <a class="btn btn-primary" href="{{ url('/users') }}">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav> --}}
    



    <nav class="navbar navbar-dark bg-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('users.index') }}">User Management</a>
    
            <div class="d-flex gap-2">
                @if (in_array(Route::currentRouteName(), ['login', 'register']))
                    <a class="btn btn-secondary" href="{{ url('/') }}">Home</a>
                @else
                    <a class="btn btn-primary" href="{{ url('/users') }}">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </nav>
    



   
    
    <div class="container mt-4">
        @yield('content')
    </div>
    {{-- <li><a href="{{ route('suppliers.index') }}" class="nav-link">Suppliers</a></li>
    <li><a href="{{ route('customers.index') }}" class="nav-link">Customers</a></li> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
