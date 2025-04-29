<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\InventoryHistoryController;

// Landing page route
Route::get('/', function () {
    return view('landingpage.landingpage');
})->name('landingpage');

Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');

// Guest routes (for non-authenticated users)
Route::middleware('guest')->group(function() {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Reset Password Routes
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});

// Admin login route
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

// Routes that require authentication
Route::middleware('auth')->group(function() {
    // Email verification routes
    Route::get('/email/verify', [AuthController::class, 'verifyEmailNotice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])
        ->middleware(['signed'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Basic routes available to all authenticated users
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::get('/search', [PostController::class, 'search'])->name('search');
    
    // Admin Routes
    Route::group(['prefix' => 'admin', 'middleware' => [AdminMiddleware::class]], function() {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::post('/orders/{orderId}/approve', [AdminController::class, 'approveOrder'])->name('admin.orders.approve');
        Route::post('/orders/{orderId}/reject', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');
        Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::put('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.update-status');
        Route::get('/shops', [AdminController::class, 'shops'])->name('admin.shops');
        Route::put('/shops/{shop}/status', [AdminController::class, 'updateShopStatus'])->name('admin.shops.update-status');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
    
    // Routes for verified users
    Route::middleware('verified')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Posts routes
        Route::get('/sell-item', [PostController::class, 'create'])->name('sell.item');
        Route::resource('posts', PostController::class)->except(['index', 'create']);
        
        // Profile routes
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
        
        // Orders routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Favorites
        Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');
        Route::post('/favorites/{post}', [FavoritesController::class, 'add'])->name('favorites.add');
        Route::delete('/favorites/{post}', [FavoritesController::class, 'remove'])->name('favorites.remove');
        
        // Shop routes
        Route::get('/shop/register', [ShopController::class, 'create'])->name('shop.register');
        Route::post('/shop/register', [ShopController::class, 'store'])->name('shop.store');
        Route::get('/shop/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');
        Route::put('/shop/update', [ShopController::class, 'update'])->name('shop.update');
        Route::get('/shop/orders', [ShopController::class, 'getOrders'])->name('shop.orders');
        Route::get('/shop/orders/{order}', [ShopController::class, 'getOrderDetails'])->name('shop.orders.details');
        
        // Cart routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
        Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity']);
        Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
        Route::delete('/cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty');
        Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('checkout');
        
        // Buy request routes
        Route::get('/buy-requests', [BuyController::class, 'index'])->name('buy.index');
        Route::get('/search-buy-requests', [BuyController::class, 'search'])->name('search.buy.requests');
        
        // Inventory management
        Route::get('/user-products', [PostController::class, 'getUserProducts'])->name('user.products');
        Route::put('/posts/{post}/update-stock', [PostController::class, 'updateStock'])->name('posts.update-stock');
        Route::put('/posts/{post}/update-price', [PostController::class, 'updatePrice'])->name('posts.update-price');
        Route::post('/posts/batch-update', [PostController::class, 'batchUpdate'])->name('posts.batch-update');
        Route::get('/inventory-history', [InventoryHistoryController::class, 'getHistory'])->name('inventory.history');
        Route::post('/inventory-export', [InventoryHistoryController::class, 'exportInventory'])->name('inventory.export');
    });
});

// Miscellaneous routes
Route::get('/order-success', function () {
    return view('orders.success');
})->name('order.success');
