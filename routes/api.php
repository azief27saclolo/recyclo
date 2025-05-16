<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\PriceGuide;
use App\Http\Controllers\UserReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Price guide routes - Move outside any middleware groups to be publicly accessible
Route::get('/price-guides/{category}', function ($category) {
    try {
        $validCategories = ['plastic', 'paper', 'metal', 'batteries', 'glass', 'ewaste'];
        
        if (!in_array($category, $validCategories)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid category'
            ], 400);
        }
        
        $priceGuides = PriceGuide::where('category', $category)
            ->orderBy('type')
            ->get();
            
        return response()->json([
            'success' => true,
            'priceGuides' => $priceGuides
        ]);
    } catch (\Exception $e) {
        \Log::error('Error fetching price guides', [
            'category' => $category,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to load price guides: ' . $e->getMessage()
        ], 500);
    }
});

// Add this route to get products for the user's "View My Products" modal
Route::get('/products', [PostController::class, 'getUserProducts'])
    ->middleware(['auth:sanctum']);

// User Reports routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reports', [UserReportController::class, 'store']);
});
