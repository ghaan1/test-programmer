<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('product.index');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/product', [ProductController::class, 'index']);

Route::prefix('get')->group(function () {
    Route::get('data-product', [ProductController::class, 'getData']);
    Route::get('data-product-category', [DataController::class, 'getDataCategory']);
});
