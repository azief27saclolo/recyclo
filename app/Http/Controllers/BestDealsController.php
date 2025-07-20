<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BestDealsController extends Controller
{
    /**
     * Display the best deals page
     */
    public function index(Request $request)
    {
        $query = Post::bestDeals()->with(['user', 'category']);
        
        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        if ($request->filled('min_discount')) {
            $query->where('discount_percentage', '>=', $request->min_discount);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting options
        $sortBy = $request->get('sort', 'deal_score');
        switch ($sortBy) {
            case 'discount':
                $query->orderBy('discount_percentage', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'ending_soon':
                $query->whereNotNull('deal_expires_at')
                      ->orderBy('deal_expires_at', 'asc');
                break;
            default:
                $query->orderBy('deal_score', 'desc');
                break;
        }
        
        $deals = $query->paginate(12)->withQueryString();
        
        // Get categories for filter
        $categories = Category::all();
        
        // Get featured deals for hero section
        $featuredDeals = Post::featuredDeals()
                           ->with(['user', 'category'])
                           ->limit(3)
                           ->get();
        
        // Get statistics
        $stats = [
            'total_deals' => Post::deals()->count(),
            'avg_discount' => Post::deals()->avg('discount_percentage'),
            'max_discount' => Post::deals()->max('discount_percentage'),
            'total_savings' => Post::deals()->sum(DB::raw('original_price - price'))
        ];
        
        return view('deals.index', compact('deals', 'featuredDeals', 'categories', 'stats'));
    }
    
    /**
     * Get deals for homepage section
     */
    public function getHomepageDeals()
    {
        $deals = Post::bestDeals()
                   ->with(['user', 'category'])
                   ->limit(6)
                   ->get();
                   
        return $deals;
    }
    
    /**
     * Auto-detect and create deals
     */
    public function autoDetectDeals()
    {
        $posts = Post::where('status', 'approved')
                   ->where('quantity', '>', 0)
                   ->whereNotNull('original_price')
                   ->where('original_price', '>', 0)
                   ->get();
        
        $dealsCreated = 0;
        
        foreach ($posts as $post) {
            if ($post->autoDetectDeal()) {
                $dealsCreated++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "$dealsCreated deals detected and created.",
            'deals_created' => $dealsCreated
        ]);
    }
    
    /**
     * Auto-promote deals to featured status based on order count
     */
    public function autoPromoteToFeatured()
    {
        // Get posts with 3+ orders that need promotion
        $postsToPromote = Post::where('orders_count', '>=', 3)
                            ->where(function($query) {
                                $query->where('is_deal', false)
                                      ->orWhere('is_featured_deal', false);
                            })
                            ->get();
        
        $promotedCount = 0;
        
        foreach ($postsToPromote as $post) {
            $updates = [];
            
            if (!$post->is_deal) {
                $updates['is_deal'] = true;
            }
            
            if (!$post->is_featured_deal) {
                $updates['is_featured_deal'] = true;
            }
            
            if (!empty($updates)) {
                $post->update($updates);
                $promotedCount++;
            }
        }
        
        // Log the batch promotion
        \Log::info('Batch auto-promotion to deals and featured deals', [
            'promoted_count' => $promotedCount,
            'criteria' => 'orders_count >= 3'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => "$promotedCount posts promoted to deal and featured status.",
            'promoted_count' => $promotedCount
        ]);
    }
    
    /**
     * Toggle featured status for a deal
     */
    public function toggleFeatured(Post $post)
    {
        if (!$post->is_deal) {
            return response()->json([
                'success' => false,
                'message' => 'This post is not a deal.'
            ], 400);
        }
        
        $post->update([
            'is_featured_deal' => !$post->is_featured_deal
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Featured status updated successfully.',
            'is_featured' => $post->is_featured_deal
        ]);
    }
}
