<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MerchantController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Admin Only
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories/store', [CategoryController::class, 'store']);
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/categories/update/{id}', [CategoryController::class, 'update']);

    // Merchant Management (Admin Only)
    Route::get('/merchants', [MerchantController::class, 'index']);
    Route::get('/merchants/pending', [MerchantController::class, 'pending']);
    Route::get('/merchants/suspended', [MerchantController::class, 'suspended']);
    Route::get('/merchants/history', [MerchantController::class, 'history']);
    Route::post('/merchants/approve/{id}', [MerchantController::class, 'approve']);
    Route::post('/merchants/reject/{id}', [MerchantController::class, 'reject']);
    Route::post('/merchants/suspend/{id}', [MerchantController::class, 'suspend']);
    Route::post('/merchants/reactivate/{id}', [MerchantController::class, 'reactivate']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::get('/products/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/products/update/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Merchant Order & Cart
    Route::get('/orders/create', [OrderController::class, 'create']);
    Route::get('/my-stock', [OrderController::class, 'myStock']);
    Route::get('/my-orders', [OrderController::class, 'myHistory']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/store', [CartController::class, 'store']);
    Route::post('/cart/update/{id}', [CartController::class, 'update']);
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    
    // Admin Order Management
    Route::get('/orders/admin', [OrderController::class, 'adminIndex']);
    Route::get('/orders/history', [OrderController::class, 'adminHistory']);
    Route::post('/orders/approve/{id}', [OrderController::class, 'approve']);

});
