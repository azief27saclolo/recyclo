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
    
    // Add new routes for shop editing
    Route::get('/shops/{id}', [AdminController::class, 'getShopDetails']);
    Route::put('/shops/{id}/edit', [AdminController::class, 'editShop'])->name('admin.shops.edit');
    Route::delete('/shops/{id}/delete', [AdminController::class, 'deleteShop'])->name('admin.shops.delete');
    
    // Add new reports routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
    Route::get('/reports/seller/{id}', [AdminController::class, 'getSellerDetails']);
    Route::get('/reports/transaction/{id}', [AdminController::class, 'getTransactionDetails']);
    
    // Products routes
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/{id}', [AdminController::class, 'getProductDetails']);
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::put('/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    
    // Category management routes
    Route::get('/categories', [AdminController::class, 'getCategories'])->name('admin.categories');
    Route::post('/categories/add', [AdminController::class, 'addCategory'])->name('admin.categories.add');
    Route::delete('/categories/remove', [AdminController::class, 'removeCategory'])->name('admin.categories.remove');
    
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
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
    
    // Sell Item Route
    Route::get('/sell-item', [App\Http\Controllers\SellController::class, 'showItemForm'])->name('sell.item');
});

// Routes for guests users
Route::middleware('guest')->group(function() {
    // Use dedicated route for registration form 
    Route::view('/register', 'auth.login')->name('register.form');
    // Keep the post route for registration
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

// Buy request marketplace routes
Route::get('/buy-marketplace', [App\Http\Controllers\BuyMarketplaceController::class, 'index'])->name('buy.marketplace');
Route::post('/buy-marketplace/notify', [App\Http\Controllers\BuyMarketplaceController::class, 'notifyBuyer'])->name('marketplace.notify')->middleware('auth');

// Buy response routes
Route::post('/buy-responses/{id}/mark-read', [App\Http\Controllers\BuyController::class, 'markResponseAsRead'])->name('buy.responses.mark-read')->middleware('auth');