<?php

namespace App\Listeners;

use App\Events\PageDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\ExportController;

class DeleteExportedPageDeleted
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
    public function handle(PageDeleted $event): void
    {
        $exportController = new ExportController();
        $exportController->deletePage($event->post);
    }
}
