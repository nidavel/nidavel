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

$feedType = !empty(settings('r', 'feed.feed_type'))
    ? settings('r', 'feed.feed_type')
    : 'Feed';

$node = '';

switch ($feedType) {
    case 'Rss':
        $node = '<link rel="feed alternate" type="application/rss+xml" href="/feed" title="'.settings('r', 'general.name').' Articles">';
        break;
    case 'Atom':
        $node = '<link rel="feed alternate" type="application/atom+xml" href="/feed" title="'.settings('r', 'general.name').' Articles">';
        break;
    default:
        $node = '<link rel="feed alternate" type="application/rss+xml" href="/feed" title="'.settings('r', 'general.name').' Articles">';
}

appendToHead($node);
