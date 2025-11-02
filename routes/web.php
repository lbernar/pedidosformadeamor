<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
    Route::get('/category/{id}/{type}', [ProductController::class, 'category'])->name('category');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::post('/{id}/rate', [ProductController::class, 'rate'])->name('rate')
        ->middleware('auth:customer');
});

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cartKey}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartKey}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout Routes (Require Authentication)
Route::middleware(['auth:customer'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
});

// Customer Dashboard Routes (Require Authentication)
Route::middleware(['auth:customer'])->prefix('customer')->name('customer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    
    // Orders
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [CustomerController::class, 'orderDetail'])->name('orders.show');
    
    // Profile
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    
    // Billing Address
    Route::get('/billing-address', [CustomerController::class, 'billingAddress'])->name('billing-address');
    Route::put('/billing-address', [CustomerController::class, 'updateBillingAddress'])->name('billing-address.update');
    
    // Shipping Address
    Route::get('/shipping-address', [CustomerController::class, 'shippingAddress'])->name('shipping-address');
    Route::put('/shipping-address', [CustomerController::class, 'updateShippingAddress'])->name('shipping-address.update');
    
    // Password
    Route::get('/change-password', [CustomerController::class, 'passwordForm'])->name('password');
    Route::put('/change-password', [CustomerController::class, 'updatePassword'])->name('password.update');
});

// Default Breeze Routes for Admin/Staff (if needed later)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
