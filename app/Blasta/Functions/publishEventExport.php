<?php

use App\Http\Controllers\ExportController;

function exportHomepage()
{
    if (!empty(settings('r', 'general.export_homepage_on_post_publish'))) {
        $exportController = new ExportController;
        $exportController->exportHomepage();
    }
}

runOnPostPublish('exportHomepage');
