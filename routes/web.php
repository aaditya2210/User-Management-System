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
use Illuminate\Support\Facades\Gate;

// Public routes (accessible without authentication)
Route::get('/', function () {
    return view('welcome');
});

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

    // City & State routes (now require authentication)
    Route::get('cities/{state_id}', [CityController::class, 'getCities']);
    Route::get('states', [StateController::class, 'index']);
    Route::get('/get-cities', [UserController::class, 'getCities'])->name('get.cities');

    // Role Management
    Route::resource('roles', RoleController::class);
    Route::post('/users/{user}/assign-role', [RoleController::class, 'assignRole'])->name('users.assignRole');
    Route::delete('/users/{user}/roles/{role}', [RoleController::class, 'removeRole'])->name('users.removeRole');
    Route::get('/roles/manage/{id}', [RoleController::class, 'manageRoles'])->name('roles.manage');
    Route::post('/roles/assign/{id}', [RoleController::class, 'assignRole'])->name('roles.assign');
    Route::post('/roles/remove/{id}', [RoleController::class, 'removeRole'])->name('roles.remove');

    // User Role Management
    Route::get('user-roles', [UserRoleController::class, 'index'])->name('user.roles.index');
    Route::post('user-roles/{user}/attach', [UserRoleController::class, 'attachRole'])->name('user.roles.attach');
    Route::delete('user-roles/{user}/{role}', [UserRoleController::class, 'detachRole'])->name('user.roles.detach');

    // Supplier Management (restricted with 'manage-suppliers' permission)
    Route::middleware(['can:manage-suppliers'])->group(function () {
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    });

    // Customer Management
    Route::resource('customers', CustomerController::class);
});
