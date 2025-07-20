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
use App\Http\Controllers\InventoryHistoryController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\ReviewController;

// Landing page route
Route::redirect('/', 'landingpage');

// Define post edit routes with auth and verified middleware
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('posts.edit');

Route::put('/posts/{post}', [PostController::class, 'update'])
    ->middleware(['auth', 'verified'])
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

// Best Deals routes
Route::get('/best-deals', [App\Http\Controllers\BestDealsController::class, 'index'])->name('deals.index');
Route::post('/best-deals/auto-detect', [App\Http\Controllers\BestDealsController::class, 'autoDetectDeals'])->name('deals.auto-detect');
Route::post('/best-deals/auto-promote', [App\Http\Controllers\BestDealsController::class, 'autoPromoteToFeatured'])->name('deals.auto-promote');
Route::post('/best-deals/{post}/toggle-featured', [App\Http\Controllers\BestDealsController::class, 'toggleFeatured'])->name('deals.toggle-featured');

// Add dedicated admin login route
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

// Admin Routes using full class path
Route::group(['prefix' => 'admin', 'middleware' => [AdminMiddleware::class]], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    
    // Fix approve/reject routes to use consistent naming
    Route::post('/orders/{orderId}/approve', [AdminController::class, 'approveOrder'])->name('admin.orders.approve');
    Route::post('/orders/{orderId}/reject', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    
    // Add order items management routes
    Route::get('/orders/{order}/items', [AdminController::class, 'orderItems'])->name('admin.orders.items');
    Route::get('/orders/{order}/details', [AdminController::class, 'orderDetails'])->name('admin.orders.details');
    
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.update-status');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/users/{user}', [AdminController::class, 'getUser'])->name('admin.users.get'); // Add this line for getting user details
    Route::put('/users/{user}/edit', [AdminController::class, 'updateUser'])->name('admin.users.update'); // Add this line for updating user
    Route::get('/users/{user}/show', [AdminController::class, 'showUser'])->name('admin.users.show'); // Add this line for showing user details
    
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
    Route::get('/reports/chart-data', [AdminController::class, 'getTransactionChartData']);
    Route::get('/reports/{id}', [AdminController::class, 'getReportDetails'])->name('admin.reports.details');
    
    // Ensure the post-request endpoint is correctly defined 
    // and placed BEFORE the more generic products/{id} route to avoid route conflicts
    Route::get('/post-request/{id}', [AdminController::class, 'getPostRequestDetails'])->name('admin.post.request.details');
    
    // Products routes
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/post-requests', [AdminController::class, 'postRequests'])->name('admin.post.requests');
    // Fix: Update the route to use a more specific endpoint to avoid conflicts with Laravel's route resolution
    Route::get('/products/{id}/details', [AdminController::class, 'getProductDetails'])->name('admin.products.details');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::put('/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    
    // Add this route for retrieving product details in the admin product view
    Route::get('/admin/products/{id}/details', [App\Http\Controllers\AdminController::class, 'getProductDetails'])->name('admin.products.details');
    
    // Fix: Add explicit route for fetching pending post details with a different name to avoid conflicts
    Route::get('/post-request/{id}', [AdminController::class, 'getPostRequestDetails'])->name('admin.post.request.details');
    
    // Add post request management routes
    Route::post('/post-requests/{id}/approve', [AdminController::class, 'approvePost'])->name('admin.post.approve');
    Route::post('/post-requests/{id}/reject', [AdminController::class, 'rejectPost'])->name('admin.post.reject');
    
    // Category management routes
    Route::get('/categories', [AdminController::class, 'getCategories'])->name('admin.categories');
    Route::post('/categories/add', [AdminController::class, 'addCategory'])->name('admin.categories.add');
    Route::delete('/categories/remove', [AdminController::class, 'removeCategory'])->name('admin.categories.remove');
    
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Add correctly defined delete order route
    Route::get('/orders/{orderId}/delete', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');

    // User management routes
    Route::post('/users/{user}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
    Route::post('/shops/{shop}/activate', [AdminController::class, 'activateShop'])->name('admin.shops.activate');

    // Price Guide Management Routes
    Route::get('/price-guides/{category}', [App\Http\Controllers\AdminController::class, 'getPriceGuides']);
    Route::get('/price-guides/item/{id}', [App\Http\Controllers\AdminController::class, 'getPriceGuideItem']);
    Route::post('/price-guides/save', [App\Http\Controllers\AdminController::class, 'savePriceGuide']);
    Route::delete('/price-guides/delete/{id}', [App\Http\Controllers\AdminController::class, 'deletePriceGuide']);
    Route::delete('/price-guides/clear-all', [App\Http\Controllers\AdminController::class, 'clearAllPriceGuides']);

    // User management routes
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}/restrict', [AdminController::class, 'restrictUser'])->name('admin.users.restrict');
    Route::post('/users/{id}/unrestrict', [AdminController::class, 'unrestrictUser'])->name('admin.users.unrestrict');
});

// Define the cancel user order route outside the admin group but still with the admin controller
Route::post('/orders/{order}/cancel-user-order', [OrderController::class, 'cancelOrder'])
    ->name('orders.cancel-user')
    ->middleware('web');

// Product Routes
Route::get('/products', [App\Http\Controllers\PostController::class, 'index'])->name('products.index');

// Email Verification Routes
Route::get('/email/verify', [AuthController::class, 'verifyEmailNotice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Routes for authenticated users
Route::middleware(['auth', 'verified'])->group(function() {
    // Add the 'verified' middleware to the dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Privacy Settings Routes
    Route::get('/privacy-settings', [PrivacyController::class, 'index'])->name('privacy.settings');
    Route::put('/privacy-settings', [PrivacyController::class, 'update'])->name('privacy.settings.update');
    
    // Update logout route to accept both GET and POST methods
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    // Add new route for cancelling orders
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');

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
    Route::put('/shop/products/{id}', [ShopController::class, 'updateProduct'])->name('shop.products.update');

    // Add new routes for shop orders
    Route::get('/shop/orders', [ShopController::class, 'getOrders'])->name('shop.orders');
    Route::get('/shop/orders/{order}', [ShopController::class, 'getOrderDetails'])->name('shop.orders.details');

    // Cart Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
        Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
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
    
    // Add a dedicated route for direct product checkout
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');

    // Products API Routes
    Route::get('/api/products', [App\Http\Controllers\ShopController::class, 'getProducts']);
    Route::post('/api/products/update-stock', [App\Http\Controllers\ShopController::class, 'updateStock']);
    Route::post('/api/products/batch-update', [App\Http\Controllers\ShopController::class, 'batchUpdateStock']);
    Route::get('/api/products/history', [App\Http\Controllers\ShopController::class, 'getInventoryHistory']);
    Route::get('/api/products/export', [App\Http\Controllers\ShopController::class, 'exportInventory']);
    Route::get('/api/products/history/export', [App\Http\Controllers\ShopController::class, 'exportInventoryHistory']);
    Route::get('/api/products/{id}', [App\Http\Controllers\ShopController::class, 'getProduct']);
    Route::post('/api/products/{id}', [App\Http\Controllers\ShopController::class, 'updateProduct']);

    // User Reports routes
    Route::post('/reports', [UserReportController::class, 'store'])->name('reports.store');

    // Review routes
    Route::post('/posts/{post}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/posts/{post}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
});

// Routes for guests users
Route::middleware('guest')->group(function() {
    // Use dedicated route for registration form 
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    // Keep the post route for registration
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
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

// Inventory Management Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/api/inventory', [ShopController::class, 'getInventory'])->name('api.inventory');
    Route::post('/api/inventory/update-stock', [ShopController::class, 'updateStock'])->name('api.inventory.update');
    Route::post('/api/inventory/batch-update', [ShopController::class, 'batchUpdateStock'])->name('api.inventory.batch-update');
    Route::get('/api/inventory/history', [InventoryHistoryController::class, 'getHistory'])->name('api.inventory.history');
    Route::get('/api/inventory/export', [InventoryHistoryController::class, 'exportInventory'])->name('api.inventory.export');
    Route::get('/api/inventory/history/export', [InventoryHistoryController::class, 'exportInventoryHistory'])->name('api.inventory.history.export');
});

Route::get('/orders/export/{format}', [OrderController::class, 'export'])->name('orders.export');

// Add a web route version of the price guides endpoint for fallback support
Route::get('/api/price-guides/{category}', [App\Http\Controllers\AdminController::class, 'getPriceGuides']);

// Fallback route to ensure API routes are properly accessible
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Route not found'
    ], 404);
});

Route::get('/account/restricted', [AuthController::class, 'showRestrictedAccount'])->name('account.restricted');