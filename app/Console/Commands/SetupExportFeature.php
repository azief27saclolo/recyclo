<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupExportFeature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:export-feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install required dependencies for export functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up export functionality...');
        
        // Run composer require
        $this->info('Installing dompdf library...');
        $this->comment('This may take a few minutes.');
        
        // Execute the composer command
        $process = new \Symfony\Component\Process\Process(['composer', 'require', 'dompdf/dompdf']);
        $process->setTimeout(null);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
        
        if (!$process->isSuccessful()) {
            $this->error('Failed to install dompdf. Please run "composer require dompdf/dompdf" manually.');
            return 1;
        }
        
        $this->info('Export functionality setup complete!');
        $this->info('You can now export inventory data to CSV, Excel, or PDF formats.');
        
        return 0;
    }
}
