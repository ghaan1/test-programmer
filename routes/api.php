<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ProfileController;

Route::group(['middleware' => ['web']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(
    [
        'middleware' => 'api',
    ],
    function () {
        Route::prefix('get')->group(function () {
            Route::get('data-product', [ProductController::class, 'getData']);
            Route::get('data-product-category', [DataController::class, 'getDataCategory']);
        });

        Route::prefix('product')->group(function () {
            Route::get('{id}', [ProductController::class, 'show']);
            Route::post('store', [ProductController::class, 'store']);
            Route::post('update/{id}', [ProductController::class, 'update']);
            Route::delete('destroy/{id}', [ProductController::class, 'destroy']);
        });


        Route::get('/profile', [ProfileController::class, 'getData']);
        Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    }
);