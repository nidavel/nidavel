<?php

use Nidavel\Feed\Classes\FeedType;
use Nidavel\Feed\Classes\Rss;
use Nidavel\Feed\Classes\Feed;
use Nidavel\Feed\Classes\Atom;
use Illuminate\Support\Facades\Route;

Route::get('/feed', function() {
    return htmlentities(file_get_contents(public_path('my_exports/feed.xml')));
});

Route::get('/feed/generate', function() {
    $feed = FeedType::getInstance();
    $feed::generate();
    return redirect()->back();
});

Route::get('/feed/view', function() {
    return htmlentities(file_get_contents(public_path('my_exports/feed.xml')));
});
