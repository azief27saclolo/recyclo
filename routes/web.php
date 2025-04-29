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

<<<<<<< Updated upstream
    Route::resource('posts', PostController::class);

    Route::get('/posts', [PostController::class, 'index'])->name('posts');
=======
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

    // Add the missing sell.item route
    Route::get('/sell-item', [PostController::class, 'create'])->name('sell.item');
});

// Email verification routes should be outside the verified middleware group
Route::middleware('auth')->group(function() {
    // Email Verification Notice route
    Route::get('/email/verify', [AuthController::class, 'verifyEmailNotice'])
        ->name('verification.notice');

    // Email Verification Handler route
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])
        ->middleware(['signed'])
        ->name('verification.verify');

    // Resending the Verification Email route
    Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
>>>>>>> Stashed changes
});

Route::middleware('guest')->group(function() {
<<<<<<< Updated upstream
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
=======
    // Add this route if it's missing - for displaying the registration form
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register.form');

    // Make sure this route exists for processing the registration
    Route::post('/register', [AuthController::class, 'register'])->name('register');
>>>>>>> Stashed changes
    
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
