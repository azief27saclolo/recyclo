<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShowPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\OrderController;

// Landing page route
Route::redirect('/', 'landingpage');

// Posts route
Route::resource('posts', PostController::class);

// Landing page route
Route::view('/landingpage', 'landingpage.landingpage')->name('landingpage');
Route::get('/landingpage', [LandingPageController::class, 'index'])->name('landingpage');

// User posts route
Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');
// Route::get('/{user}/posts', [DashboardController::class, 'index'])->name('posts.user');

Route::get('/posts', [PostController::class, 'index'])->name('posts');

// Routes for authenticated users
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Notice route
    Route::get('/email/verify', [AuthController::class, 'verifyEmailNotice'])->name('verification.notice');

    // Email Verification Handler route
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])->middleware('signed')->name('verification.verify');

    // Resending the Verification Email route
    Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
});

// Routes for guests users
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
