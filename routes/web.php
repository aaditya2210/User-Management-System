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
});

// Protected routes (only for authenticated users)
Route::middleware('auth')->group(function () {
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
    });

    // Supplier Management (Only users with permission)
    Route::middleware('permission:manage-suppliers')->group(function () {
        Route::resource('suppliers', SupplierController::class);
    });

    // Customer Management
    Route::resource('customers', CustomerController::class);
});
