<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class UploadsSymLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploads:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a symbolic link for the my_export/uploads folder in the public/uploads folder.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = base_path('/public/my_exports/uploads');
        $target = str_replace('\\', '/', $target);
        $link = base_path('/public/uploads');
        $link = str_replace('\\', '/', $link);
        symlink($target, $link);
    }
}
