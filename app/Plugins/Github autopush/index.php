<?php

use Nidavel\GithubAutopush\Classes\GithubAutopush;

require_once 'vendor/autoload.php';
require_once plugin_path('Github autopush/routes/index.php');

registerSettingsForm('GitHub autopush', 'github_autopush', plugin_path('Github autopush/pages/settings.php'));

function pushPublishedPost($post)
{
    $ghAp = GithubAutopush::getInstance();
    $ghAp::push($post->title);
}

runOnPostPublish('pushPublishedPost');
