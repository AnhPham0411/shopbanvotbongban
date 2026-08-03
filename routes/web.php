<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/help-center', [HomeController::class, 'helpCenter'])->name('help_center');
Route::get('/shopping-guide', [HomeController::class, 'shoppingGuide'])->name('shopping_guide');
Route::get('/auth-guide', [HomeController::class, 'authGuide'])->name('auth_guide');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/careers', [HomeController::class, 'careers'])->name('careers');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/remove-multiple', [CartController::class, 'removeMultiple'])->name('cart.remove_multiple');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/order-success', [CartController::class, 'success'])->name('checkout.success');
    Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');

    // Profile and Orders
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/orders', [AuthController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/confirm-received', [AuthController::class, 'confirmReceived'])->name('orders.confirm_received');
    
    // Review
    Route::post('/product/{id}/review', [\App\Http\Controllers\ProductController::class, 'storeReview'])->name('product.review');

    // Favorites
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/toggle/{id}', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Addresses
    Route::get('/addresses', [\App\Http\Controllers\UserAddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [\App\Http\Controllers\UserAddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{id}', [\App\Http\Controllers\UserAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [\App\Http\Controllers\UserAddressController::class, 'destroy'])->name('addresses.destroy');
    Route::put('/addresses/{id}/default', [\App\Http\Controllers\UserAddressController::class, 'setDefault'])->name('addresses.set_default');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [\App\Http\Controllers\AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('products.delete');
    
    // Orders
    Route::get('/orders', [\App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('orders.update_status');
    
    // Users & Categories
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [\App\Http\Controllers\AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [\App\Http\Controllers\AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [\App\Http\Controllers\AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [\App\Http\Controllers\AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\AdminController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\AdminController::class, 'deleteReview'])->name('reviews.delete');

    // Coupons
    Route::get('/coupons', [\App\Http\Controllers\AdminController::class, 'coupons'])->name('coupons');
    Route::get('/coupons/create', [\App\Http\Controllers\AdminController::class, 'createCoupon'])->name('coupons.create');
    Route::post('/coupons', [\App\Http\Controllers\AdminController::class, 'storeCoupon'])->name('coupons.store');
    Route::get('/coupons/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editCoupon'])->name('coupons.edit');
    Route::put('/coupons/{id}', [\App\Http\Controllers\AdminController::class, 'updateCoupon'])->name('coupons.update');
    Route::delete('/coupons/{id}', [\App\Http\Controllers\AdminController::class, 'deleteCoupon'])->name('coupons.delete');
});
