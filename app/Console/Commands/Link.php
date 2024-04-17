<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Link extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nidavel:link
                            {target : The path to the directory to be linked from}
                            {link : The path where the symbolic link will be created}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a symbolic link between two directories';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'target' => 'Please specify the target to be linked. ',
            'link' => 'Please specify the path where link should be created. ',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = $this->argument('target');
        $target = str_replace('\\', '/', $target);
        $link   = $this->argument('link');
        $link   = str_replace('\\', '/', $link);
        symlink($target, $link);
    }
}
