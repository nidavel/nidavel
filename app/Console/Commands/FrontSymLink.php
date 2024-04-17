<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class FrontSymLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'front:link {resource : The resource to be linked from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a symbolic link for the front view folder in the public folder.';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'resource' => 'Please specify the resource to be linked. ',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = base_path('/resources/views/front/' . $this->argument('resource'));
        $target = str_replace('\\', '/', $target);
        $link   = base_path('/public/' . $this->argument('resource'));
        $link   = str_replace('\\', '/', $link);
        symlink($target, $link);
    }
}
