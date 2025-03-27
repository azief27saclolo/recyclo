<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::redirect('/', 'landingpage');

Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('posts', PostController::class);

<<<<<<< Updated upstream
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
=======
    // Email Verification Handler route
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])->middleware('signed')->name('verification.verify');

    // Resending the Verification Email route
    Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Profile routes
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile')->middleware('auth');
    Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');
    Route::post('/favorites/{post}', [FavoritesController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/{post}', [FavoritesController::class, 'remove'])->name('favorites.remove');
    
    // Shop Registration Routes
    Route::get('/shop/register', [ShopController::class, 'create'])->name('shop.register');
    Route::post('/shop/register', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/shop/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');
    Route::put('/shop/update', [ShopController::class, 'update'])->name('shop.update');

    // Add new routes for shop orders
    Route::get('/shop/orders', [ShopController::class, 'getOrders'])->name('shop.orders');
    Route::get('/shop/orders/{order}', [ShopController::class, 'getOrderDetails'])->name('shop.orders.details');

    // Cart Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
        Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'updateQuantity']);
        Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove');
        Route::delete('/cart/empty', [App\Http\Controllers\CartController::class, 'emptyCart'])->name('cart.empty');
        Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout'); // Update the checkout route
    });

    // Add new route for updating order status
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Route for getting all user products
    Route::get('/posts/get-user-products', [PostController::class, 'getUserProducts']);
    
    // Route for getting all user products - use specific naming to avoid conflicts
    Route::get('/user-products', [PostController::class, 'getUserProducts'])->name('user.products');

    // Add new route for updating stock
    Route::put('/posts/{post}/update-stock', [PostController::class, 'updateStock'])->name('posts.update-stock');
    
    // Add new route for updating price
    Route::put('/posts/{post}/update-price', [PostController::class, 'updatePrice'])->name('posts.update-price');

    // Add the batch update route
    Route::post('/posts/batch-update', [PostController::class, 'batchUpdate'])->name('posts.batch-update')->middleware('auth');

    // Add route for inventory history with a specific implementation
    Route::get('/inventory-history', [App\Http\Controllers\InventoryHistoryController::class, 'getHistory'])
        ->name('inventory.history')
        ->middleware('auth');

    // Add route for inventory export
    Route::post('/inventory-export', [App\Http\Controllers\InventoryHistoryController::class, 'exportInventory'])
        ->name('inventory.export')
        ->middleware('auth');
>>>>>>> Stashed changes
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
