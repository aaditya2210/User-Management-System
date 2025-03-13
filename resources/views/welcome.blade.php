<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    {{-- <nav class="bg-white shadow-md p-4"> --}}
    <nav class="bg-gray-900 shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            {{-- <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800">User Management System</a> --}}
            <a href="{{ url('/') }}" class="text-xl font-semibold text-white">User Management System</a>
            <div>
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-4">Login</a>
                {{-- <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-4">Login</a> --}}
                <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="h-screen flex flex-col justify-center items-center text-center px-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to User Management System</h1>
        <p class="text-gray-600 text-lg mb-6">Manage users efficiently with secure authentication and role-based access.</p>
        <div>
            <a href="{{ route('register') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-blue-600">Get Started</a>
        </div>
    </section>

</body>
</html>
