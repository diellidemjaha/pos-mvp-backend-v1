<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CategoryController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::get('/categories', [CategoryController::class, 'index']);
     Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
     Route::post('/products', [ProductController::class, 'store']);

});

Route::middleware('auth:sanctum')->get('/orders', function () {
    return \App\Models\Order::with('items.product')
        ->latest()
        ->get();
});

