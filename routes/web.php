<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\LabaController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Pembeli\ProductController as PembeliProductController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Pembeli\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to products page
Route::get('/', function () {
    return redirect()->route('pembeli.products');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================
// PEMBELI ROUTES
// ============================================
Route::prefix('produk')->name('pembeli.')->group(function () {
    Route::get('/', [PembeliProductController::class, 'index'])->name('products');
    Route::get('/search', [PembeliProductController::class, 'search'])->name('products.search');
    Route::get('/{product}', [PembeliProductController::class, 'show'])->name('products.show');
});

// Static Pages
Route::name('pembeli.')->group(function () {
    Route::view('/collection', 'pembeli.collection')->name('collection');
    Route::view('/about', 'pembeli.about')->name('about');
});

Route::middleware('auth')->prefix('pembeli')->name('pembeli.')->group(function () {
    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/{order}/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// ============================================
// ADMIN (PENJUAL) ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Produk
    Route::get('/produk-preview', function () {
        return redirect()->route('pembeli.products');
    })->name('produk-preview');
    Route::get('products/{product}/edit-data', [AdminProductController::class, 'getEditData'])->name('products.edit-data');
    Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.destroyImage');
    Route::resource('products', AdminProductController::class)->except(['show', 'create', 'edit']);

    // Kelola Kategori
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Rekap Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders-export-pdf', [OrderController::class, 'exportPdf'])->name('orders.exportPdf');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Rekap Laba
    Route::get('/laba', [LabaController::class, 'index'])->name('laba.index');

    // Kasir
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir', [KasirController::class, 'process'])->name('kasir.process');
    Route::get('/kasir/{order}/receipt', [KasirController::class, 'receipt'])->name('kasir.receipt');
});
