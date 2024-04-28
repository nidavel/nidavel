<?php

use Nidavel\Sitemap\Classes\Sitemap;

require_once 'vendor/autoload.php';
require_once plugin_path('Sitemap/routes/index.php');

registerSettingsForm('Sitemap', 'sitemap', plugin_path('Sitemap/pages/settings.php'));

function generateSitemap()
{
    $sitemap = Sitemap::getInstance();
    $sitemap::generate();
}

runOnPostPublish('generateSitemap');
