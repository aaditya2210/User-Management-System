<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/user', [AuthController::class, 'user']);

// Protected API Routes
Route::middleware('auth:api')->group(function () {
    // User Routes
    Route::apiResource('users', UserController::class);
    Route::get('/users/export/csv', [UserController::class, 'exportCsv']);
    Route::get('/users/export/excel', [UserController::class, 'exportExcel']);
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf']);

    // Supplier Routes
    Route::apiResource('suppliers', SupplierController::class);
    Route::get('/suppliers/export/csv', [SupplierController::class, 'exportCSV']);
    Route::get('/suppliers/export/excel', [SupplierController::class, 'exportExcel']);
    Route::get('/suppliers/export/pdf', [SupplierController::class, 'exportPDF']);

    // Customer Routes
    Route::apiResource('customers', CustomerController::class);
    Route::get('/customers/export/csv', [CustomerController::class, 'exportCSV']);
    Route::get('/customers/export/excel', [CustomerController::class, 'exportExcel']);
    Route::get('/customers/export/pdf', [CustomerController::class, 'exportPDF']);
});
