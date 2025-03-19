<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\ShowPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\BuyMarketplaceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Middleware\AdminMiddleware;

// Landing page route
Route::redirect('/', 'landingpage');

// Define post edit routes with only plain auth middleware
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->middleware('auth')
    ->name('posts.edit');

Route::put('/posts/{post}', [PostController::class, 'update'])
    ->middleware('auth')
    ->name('posts.update');

// Posts route
Route::resource('posts', PostController::class)->except(['edit', 'update']);

// Landing page route
Route::view('/landingpage', 'landingpage.landingpage')->name('landingpage');
Route::get('/landingpage', [LandingPageController::class, 'index'])->name('landingpage');

// User posts route
Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');
// Route::get('/{user}/posts', [DashboardController::class, 'index'])->name('posts.user');

Route::get('/posts', [PostController::class, 'index'])->name('posts');

// Search route
Route::get('/search', [PostController::class, 'search'])->name('search');

// Buy requests search route
Route::get('/search-buy-requests', [BuyController::class, 'search'])->name('search.buy.requests');

// Add dedicated admin login route
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

// Admin Routes using full class path
Route::group(['middleware' => [AdminMiddleware::class]], function() {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::put('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    
    // Fix the approve/reject route definitions with explicit parameter names
    Route::post('/admin/orders/{orderId}/approve', [AdminController::class, 'approveOrder'])->name('admin.orders.approve');
    Route::post('/admin/orders/{orderId}/reject', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');
    
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/admin/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.update-status');
    Route::get('/admin/shops', [AdminController::class, 'shops'])->name('admin.shops');
    Route::put('/admin/shops/{shop}/status', [AdminController::class, 'updateShopStatus'])->name('admin.shops.update-status');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// Product Routes
Route::get('/products', [App\Http\Controllers\PostController::class, 'index'])->name('products.index');

// Routes for authenticated users
Route::middleware('auth')->group(function() {
    // Remove the 'verified' middleware from the dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Update logout route to accept both GET and POST methods
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Notice route
    Route::get('/email/verify', [AuthController::class, 'verifyEmailNotice'])->name('verification.notice');

    // Email Verification Handler route
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])->middleware('signed')->name('verification.verify');

    // Resending the Verification Email route
    Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');
    Route::post('/favorites/{post}', [FavoritesController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/{post}', [FavoritesController::class, 'remove'])->name('favorites.remove');
    
    // Shop Registration Routes
    Route::get('/shop/register', [ShopController::class, 'create'])->name('shop.register');
    Route::post('/shop/register', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/shop/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');

    // Cart Routes
    Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/cart/empty', [App\Http\Controllers\CartController::class, 'emptyCart'])->name('cart.empty');
    });
});

// Routes for guests users
Route::middleware('guest')->group(function() {
    // The view route isn't needed anymore since we're using login.blade.php for both
    // Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
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

Route::get('/buy', [BuyController::class, 'create'])->name('buy.create');
Route::post('/buy', [BuyController::class, 'store'])->name('buy.store');
Route::get('/buy-requests', [BuyController::class, 'index'])->name('buy.index');
Route::get('/buy-marketplace', [BuyMarketplaceController::class, 'index'])->name('buy.marketplace');
Route::put('/buy/{id}', [App\Http\Controllers\BuyController::class, 'update'])->name('buy.update');
Route::delete('/buy/{id}', [App\Http\Controllers\BuyController::class, 'destroy'])->name('buy.destroy');

// Add this new route for shops
Route::get('/shops', [ShopsController::class, 'index'])->name('shops');
Route::get('/shops/{user}', [ShopsController::class, 'show'])->name('shops.show');