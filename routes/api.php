<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DataController;

Route::post('login', [AuthController::class, 'login']);

Route::group(
    [
        'middleware' => 'api',
    ],
    function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::prefix('get')->group(function () {
            Route::get('data-product', [ProductController::class, 'getData']);
            Route::get('data-product-category', [DataController::class, 'getDataCategory']);
        });

        Route::prefix('product')->group(function () {
            Route::post('store', [ProductController::class, 'store']);
            // Route::post('update', [ProductController::class, 'update']);
            // Route::post('delete', [ProductController::class, 'delete']);
        });
    }
);