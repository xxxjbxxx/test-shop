<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Главная страница (только для гостей)
Route::get('/', function () {
    if (Auth::check()) {  
        return redirect()->route('main');
    }
    return redirect()->route('login');
})->name('home');

// Маршруты аутентификации
require __DIR__.'/auth.php';

// Защищенные маршруты
Route::middleware('auth')->group(function () {
    
    Route::get('/main', [IndexController::class, 'index'])->name('main');

    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    
    Route::patch('orders/{order}/complete', [OrderController::class, 'complete'])
         ->name('orders.complete');
});