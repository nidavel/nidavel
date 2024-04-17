<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BlastServe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nidavel:serve {--dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the development server(s) for Blasta.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $server1    = false;
        $server2    = false;
        $front      = false;

        $server1 = popen('php artisan serve --port=8000', 'r');
        if ($server1) {
            $this->info('Server started on localhost port 8000');
        } else {
            $this->error('Something went wrong. Please check that port 8000 is not already running.');
        }

        $server2 = popen('php artisan serve --port=8001', 'r');
        if ($server2) {
            $this->info('Server started on localhost port 8001');
        } else {
            $this->error('Something went wrong. Please check that port 8001 is not already running.');
        }

        if ($this->option('dev')) {
            $front = popen('npm run dev', 'r');
            if ($front) {
                $this->info('Vite running');
            } else {
                $this->error('Something went wrong while running vite');
            }
        }

        if ($server1 && $server2 && $front) {
            $this->info('ctrl + c to terminate dev servers');
        }
        else if ($server1 && $server2) {
            $this->info('ctrl + c to terminate servers');
        } else {
            $this->info('Something went wrong while starting up servers');
        }
    }
}
