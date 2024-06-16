<?php

use Illuminate\Support\Facades\Route;
use Nidavel\GithubAutopush\Classes\GithubAutopush;

Route::get('/github-autopush/init', function () {
    $ghAp = GithubAutopush::getInstance();

    if ($ghAp !== null) {
        $ghAp::init();
    }
    
    return redirect()->back();
});

Route::get('/github-autopush/push', function () {
    $ghAp = GithubAutopush::getInstance();

    if ($ghAp !== null) {
        $ghAp::push('Direct push from settings');
    }

    return redirect()->back();
});
