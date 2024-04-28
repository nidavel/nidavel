<?php

use Nidavel\Sitemap\Classes\Sitemap;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap/ignore-url', function () {
    $sitemap = Sitemap::getInstance();
    $sitemap::ignore(request('url'));
    return redirect()->back();
});

Route::get('/sitemap/unignore-url', function () {
    $sitemap = Sitemap::getInstance();
    $sitemap::unignore(request('url'));
    return redirect()->back();
});

Route::get('/sitemap/generate', function () {
    $sitemap = Sitemap::getInstance();
    $sitemap::generate();
    return redirect()->back();
});
