<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class AutoPromoteFeaturedDeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deals:auto-promote {--min-orders=3 : Minimum orders required for promotion}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-promote deals to featured status based on order count';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minOrders = $this->option('min-orders');
        
        $this->info("Starting auto-promotion for posts with {$minOrders}+ orders...");
        
        // Find posts that qualify for promotion (both deal and featured status)
        $eligiblePosts = Post::where('orders_count', '>=', $minOrders)
                           ->where(function($query) {
                               $query->where('is_deal', false)
                                     ->orWhere('is_featured_deal', false);
                           })
                           ->get();
        
        $promotedCount = 0;
        
        foreach ($eligiblePosts as $post) {
            $updates = [];
            $statusChanges = [];
            
            if (!$post->is_deal) {
                $updates['is_deal'] = true;
                $statusChanges[] = 'Deal';
            }
            
            if (!$post->is_featured_deal) {
                $updates['is_featured_deal'] = true;
                $statusChanges[] = 'Featured';
            }
            
            if (!empty($updates)) {
                $post->update($updates);
                $promotedCount++;
                
                $changes = implode(' + ', $statusChanges);
                $this->line("✅ Promoted: {$post->title} ({$post->orders_count} orders) → {$changes}");
            }
        }
        
        if ($promotedCount > 0) {
            $this->info("🎉 Successfully promoted {$promotedCount} posts to deal/featured status!");
            
            // Log the promotion
            \Log::info('Console auto-promotion completed', [
                'promoted_count' => $promotedCount,
                'min_orders' => $minOrders,
                'timestamp' => now()
            ]);
        } else {
            $this->info("📦 No posts found that qualify for promotion.");
        }
        
        return Command::SUCCESS;
    }
}
