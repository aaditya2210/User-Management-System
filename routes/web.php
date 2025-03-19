<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\View;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// City & State routes
Route::middleware('allow.registration')->group(function () {
    Route::get('cities/{state_id}', [CityController::class, 'getCities']);
    Route::get('states', [StateController::class, 'index']);
    Route::get('/get-cities', [UserController::class, 'getCities'])->name('get.cities');
    Route::get('/get-cities/{state_id}', [SupplierController::class, 'getCities']);
});

// Protected routes (only for authenticated users)
// Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    // User Management
    Route::resource('users', UserController::class);
    Route::get('/users/export/csv', [UserController::class, 'exportCsv'])->name('users.export.csv');
    Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('/api/users', [UserController::class, 'getUsers'])->name('api.users');

    // Role Management (Only Admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('/user-roles', [UserRoleController::class, 'index'])->name('user.roles');
        Route::post('/user-roles/{user}/assign', [UserRoleController::class, 'assignRole'])->name('user.assignRole');
        Route::delete('/user-roles/{user}/remove', [UserRoleController::class, 'removeRole'])->name('user.removeRole');

        Route::post('/roles/{role}/assign-permission', [UserRoleController::class, 'assignPermission'])->name('role.assignPermission');
        Route::delete('/roles/{role}/remove-permission', [UserRoleController::class, 'removePermission'])->name('role.removePermission');
    

        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        
        
        
        Route::put('/roles/{role}/permissions', [UserRoleController::class, 'updatePermissions'])->name('role.updatePermissions');

    
    
    });

    // Supplier Management (Only users with permission)
    // Route::middleware('permission:manage-suppliers')->group(function () {
    //     Route::resource('suppliers', SupplierController::class);
    // });


    Route::middleware('auth')->group(function () {
        Route::get('suppliers', [SupplierController::class, 'index'])->middleware('permission:read-suppliers')->name('suppliers.index');
        Route::get('suppliers/create', [SupplierController::class, 'create'])->middleware('permission:create-suppliers')->name('suppliers.create');
        Route::post('suppliers', [SupplierController::class, 'store'])->middleware('permission:create-suppliers')->name('suppliers.store');
        Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->middleware('permission:read-suppliers')->name('suppliers.show');
        Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->middleware('permission:update-suppliers')->name('suppliers.edit');
        Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->middleware('permission:update-suppliers')->name('suppliers.update');
        Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->middleware('permission:delete-suppliers')->name('suppliers.destroy');
    });
    

    // Customer Management
  
    Route::middleware('auth')->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->middleware('permission:read-customers')->name('customers.index');
        Route::get('customers/create', [CustomerController::class, 'create'])->middleware('permission:create-customers')->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->middleware('permission:create-customers')->name('customers.store');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->middleware('permission:read-customers')->name('customers.show');
        Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->middleware('permission:update-customers')->name('customers.edit');
        Route::put('customers/{customer}', [CustomerController::class, 'update'])->middleware('permission:update-customers')->name('customers.update');
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->middleware('permission:delete-customers')->name('customers.destroy');
    });
    
});



// Route::view('/dashboard', 'dashboard');
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/activity', [DashboardController::class, 'fetchRecentActivity'])->name('dashboard.activity');
Route::get('/users/list', [UserController::class, 'listUsers'])->name('users.list');
// Route::get('/dashboard', [SupplierController::class, 'fetchSupplier'])->name('dashboard');


use App\Http\Controllers\ChartController;

Route::get('/charts', [ChartController::class, 'index'])->name('charts');
Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('chart.data');

// Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('chart.data'); // API for live data


