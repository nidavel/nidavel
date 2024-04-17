<?php

namespace App\Listeners;

use App\Events\PagePublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\ExportController;

class ExportPagePublished
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
    public function handle(PagePublished $event): void
    {
        $exportController = new ExportController();
        $exportController->exportPage($event->post);
    }
}
