<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; // ✅ Import controller admin pesanan

// ========== AUTH ==========

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// ========== USER ROUTES ==========

Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/add-to-cart/{id}', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'cart']);
// (opsional) Untuk halaman checkout, kalau kamu punya
Route::get('/checkout', [ProductController::class, 'showCheckout'])->middleware('auth');

// Untuk proses checkout simpan ke database
Route::post('/checkout', [ProductController::class, 'checkout'])->middleware('auth');



// ========== ADMIN ROUTES ==========

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    // Produk
    Route::get('/products', [ProductController::class, 'adminIndex']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::post('/orders/{id}/confirm', [AdminOrderController::class, 'confirm']);
    Route::post('/orders/{id}/cancel', [AdminOrderController::class, 'cancel']); // ← INI WAJIB ADA
    Route::get('/admin/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');

});

