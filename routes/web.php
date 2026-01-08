<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// PUBLIC SHOP
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/costumes/{costume:slug}', [ShopController::class, 'show'])->name('shop.show');

// CART (public view, checkout must login)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{costume}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{costumeId}', [CartController::class, 'remove'])->name('cart.remove');
Route::middleware('auth')->post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// USER ORDERS
Route::middleware('auth')->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
});

// ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('costumes', CostumeController::class);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});

require __DIR__ . '/auth.php';
