<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
// use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleMiddleware;

// Public routes (accessible without authentication)
Route::get('/', function () {
    return view('welcome');
});

// City & State routes
// Route::get('cities/{state_id}', [CityController::class, 'getCities']);
Route::get('cities/{state_id}', [CityController::class, 'getCities'])->middleware('allow.registration');
Route::get('states', [StateController::class, 'index'])->middleware('allow.registration');
Route::get('/get-cities', [UserController::class, 'getCities'])->name('get.cities')->middleware('allow.registration');


// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (only accessible by authenticated users)
Route::middleware(['auth'])->group(function () {

    // User Management
    Route::resource('users', UserController::class);
    Route::get('/users/export/csv', [UserController::class, 'exportCsv'])->name('users.export.csv');
    Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('/api/users', [UserController::class, 'getUsers'])->name('api.users');


    // Role Management    
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('/user-roles', [UserRoleController::class, 'index'])->name('user.roles');
        Route::post('/user-roles/{user}/assign', [UserRoleController::class, 'assignRole'])->name('user.assignRole');
        Route::delete('/user-roles/{user}/remove', [UserRoleController::class, 'removeRole'])->name('user.removeRole');

        Route::post('/roles/{role}/assign-permission', [UserRoleController::class, 'assignPermission'])->name('role.assignPermission');
        Route::delete('/roles/{role}/remove-permission', [UserRoleController::class, 'removePermission'])->name('role.removePermission');
    });






    // Supplier Management (restricted with 'manage-suppliers' permission)
    // Route::middleware(['can:manage-suppliers'])->group(function () {
        // Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware(['auth', 'permission:manage-suppliers']);
        // Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        // Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        // Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        // Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        // Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    // });
    Route::middleware('permission:manage-suppliers')->group(function () {
        Route::resource('suppliers', SupplierController::class);
    });

    // Customer Management
    Route::middleware('permission:manage-customers')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});
