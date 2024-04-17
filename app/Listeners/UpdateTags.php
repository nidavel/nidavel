<?php

namespace App\Listeners;

use App\Events\PostPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTags implements ShouldQueue
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
        $keywordString = $event->post->keywords;
        updateTags($keywordString);
    }
}
