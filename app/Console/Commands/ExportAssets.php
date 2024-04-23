<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports assets from the assets folder in the active theme.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        exportAssets();
    }
}
