<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;

Route::get('/', function () {
    return view('landingpage.landingpage'); // Ensure this matches the correct view file path
})->name('landingpage');

Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');

<<<<<<< Updated upstream
Route::middleware('auth')->group(function() {
=======
Route::get('/posts', [PostController::class, 'index'])->name('posts');

// Search route
Route::get('/search', [PostController::class, 'search'])->name('search');

// Buy requests search route
Route::get('/search-buy-requests', [BuyController::class, 'search'])->name('search.buy.requests');

// Add dedicated admin login route
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

// Admin Routes using full class path
Route::group(['prefix' => 'admin', 'middleware' => [AdminMiddleware::class]], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    
    // Fix approve/reject routes to use consistent naming
    Route::post('/orders/{orderId}/approve', [AdminController::class, 'approveOrder'])->name('admin.orders.approve');
    Route::post('/orders/{orderId}/reject', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.update-status');
    Route::get('/shops', [AdminController::class, 'shops'])->name('admin.shops');
    Route::put('/shops/{shop}/status', [AdminController::class, 'updateShopStatus'])->name('admin.shops.update-status');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// Product Routes
Route::get('/products', [App\Http\Controllers\PostController::class, 'index'])->name('products.index');

// Routes for authenticated users
Route::middleware(['auth', 'verified'])->group(function() {
>>>>>>> Stashed changes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('posts', PostController::class);

    Route::get('/posts', [PostController::class, 'index'])->name('posts');
});

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

Route::get('/order-success', function () {
    return view('orders.success');
})->name('order.success');
