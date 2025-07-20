<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoDetectDeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deals:auto-detect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-detect deals based on price comparison and set deal flags';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-detection of deals...');
        
        // Get all approved posts with original prices
        $posts = Post::where('status', 'approved')
                   ->where('quantity', '>', 0)
                   ->whereNotNull('original_price')
                   ->where('original_price', '>', 0)
                   ->get();

        $dealsCreated = 0;
        $dealsUpdated = 0;

        foreach ($posts as $post) {
            $wasAlreadyDeal = $post->is_deal;
            
            if ($post->autoDetectDeal()) {
                if ($wasAlreadyDeal) {
                    $dealsUpdated++;
                    $this->line("Updated deal: {$post->title} - {$post->discount_percentage}% off");
                } else {
                    $dealsCreated++;
                    $this->line("New deal detected: {$post->title} - {$post->discount_percentage}% off");
                }
            }
        }

        $this->info("Auto-detection completed!");
        $this->info("New deals created: {$dealsCreated}");
        $this->info("Existing deals updated: {$dealsUpdated}");
        $this->info("Total posts processed: {$posts->count()}");

        Log::info('Auto-detect deals command completed', [
            'deals_created' => $dealsCreated,
            'deals_updated' => $dealsUpdated,
            'total_processed' => $posts->count()
        ]);

        return Command::SUCCESS;
    }
}
