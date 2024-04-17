<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Http\Controllers\ExportController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExportPostsPublished implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $exportController = new ExportController;

        if (!empty(settings('r', 'general.update_exports_on_post_publish'))) {
            $exportController->exportPosts();
        }
    }
}
