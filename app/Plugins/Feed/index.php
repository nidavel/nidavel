<?php

use Nidavel\Feed\Classes\FeedType;

require_once 'vendor/autoload.php';
require_once plugin_path('Feed/routes/index.php');

registerSettingsForm('Feed', 'feed', plugin_path('Feed/pages/settings.php'));

function generateFeed()
{
    $feed = FeedType::getInstance();
    $feed::generate();
}

runOnPostPublish('generateFeed');
